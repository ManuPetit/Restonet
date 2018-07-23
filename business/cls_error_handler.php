<?php
	//		cls_error_handler.php
	
	//		classe de gestion des erreurs
	
	class ErrorHandler
	{
		//construcor privé empêche création directe de la classe
		private function __construct()
		{
		}
		
		//definit la méthode de l'error handler
		public static function SetHandler($errTypes = ERROR_TYPES)
		{
			return set_error_handler(array('ErrorHandler', 'Handler'), $errTypes);
		}
		
		//methode Error handler
		public static function Handler($errNo, $errStr, $errFile, $errLine)
		{
			/* les deux premiers éléments du back trace sont inutiles
				- ErrorHandler.GetBacktrace
				- ErrorHandler.Handler */
			$backtrace = ErrorHandler::GetBacktrace(2);
			
			//message d'erreur à afficher, logged ou emailer
			$date = date('Y-m-d H:i:s');
 			$error_message = "   |  Date:  ".$date. " -> ERREUR\r\n";
			$error_message .= "<b>Erreur N° :</b> $errNo\n<b>Texte :</b> $errStr\n<b>Fichier :</b> $errFile, à la ligne $errLine, le " . date('d/m/Y') . " à " . date('H:i:s');
			$error_message .= "\n<b>Backtrace :</b>\n$backtrace\n\n";
			
			//envoyer les détails par email
			if (SEND_ERROR_MAIL == true)
			{
				error_log($error_message, 1, ADMIN_ERROR_MAIL, "From: " . SENDMAIL_FROM . "\r\nTo: " . ADMIN_ERROR_MAIL);
			}
			
			//logger l'erreur si LOG_ERRORS est true
			if (LOG_ERRORS == true)
			{				
				error_log($error_message, 3, LOG_ERROR_FILE);
				
			}
			
			//Ne pas arrêter execution si IS_WARNING_FATAL est false
			//E_NOTICE et E_USER_NOTICE non plus
			if (($errNo == E_WARNING && IS_WARNING_FATAL == false) || ($errNo == E_NOTICE || $errNo == E_USER_NOTICE))
			{
				//erreur non fatal
				//montrer le message si debugging is true
				if (DEBUGGING == true)
				{
					echo '<div class="error_box"><pre>' . $error_message . '</pre></div>';
				}
			}
			else
			{
				//erreur fatale
				//montrer le message d'erreur
				if (DEBUGGING == true)
				{
					echo '<div class="error_box"><pre>' . $error_message . '</pre></div>';
				}
				else
				{
					echo SITE_GENERIC_ERROR_MESSAGE;
				}
				//arreter tous les processus
				exit();
			}
		}
		
		//construction du message de backtracing
		public static function GetBacktrace($entreesInutiles)
		{
			$s = '';
			$MAXSTRLEN = 64;
			$trace_array = debug_backtrace();
			
			for ($i =0; $i < $entreesInutiles; $i++)
			{
				array_shift($trace_array);
			}
			$tabs = sizeof($trace_array)-1;
			
			foreach ($trace_array as $arr)
			{
				$tabs -= 1;
				if (isset($arr['class']))
				{
					$s .= $arr['class'] . '.';
				}
				$args = array();
				
				if (!empty($arr['args']))
				{
					foreach ($arr['args'] as $v)
					{
						if (is_null($v))
							$args[] = 'NULL';
						elseif (is_array($v))
							$args[] = 'Array[' . sizeof($v) . ']';
						elseif (is_object($v))
							$args[] = 'Object: ' . get_class($v);
						elseif (is_bool($v))
							$args[] = $v ? 'true' : 'false';
						else
						{
							$v = (string)@$v;
							$str = htmlspecialchars(substr($v, 0, $MAXSTRLEN));
							if (strlen($v) > $MAXSTRLEN)
								$str .= '...';
							$args[] ='"' .$str . '"';
						}
					}
				}
				
				$s .= $arr['function'] . '(' . implode(', ', $args) . ')';
				$line = (isset($arr['line']) ? $arr['line']: 'inconnue');
				$file = (isset($arr['file']) ? $arr['file']: 'inconnu');
				$s .= sprintf(' # line %4d, file %s', $line, $file);
				$s .= "\n";
			}
			return $s;
		}							
	}