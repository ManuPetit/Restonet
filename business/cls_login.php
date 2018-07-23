<?php
	//		cls_login.php
	//		fonction pour se connecter
	
	class Login
	{
		//fonction pour se logger
		public static function CheckLogin($pseudo, $mdp)
		{
			$val1 = $pseudo;
			$val2 = MotDePasse::HashMotDePasse($mdp);
			$sql = 'CALL get_login(:mPseudo,:mMDEPass)';
			$params = array(':mPseudo' => $val1,
							':mMDEPass' => $val2);
			$row = array();
			$row = DatabaseHandler::GetRow($sql,$params);
			$nrow = count($row);
			if ($nrow == 1)
			{
				return 'Mauvais identifiants de connexion';
			}
			//procedure pour admini
			if ($row['niveauID'] == 1)
			{
				if ($row['adminActif'] == 0)
				{
					return 'Vous n\'êtes pas autorisé à vous connecter au système.<br />Veuillez contacter le responsable.';
				}
				$_SESSION['userid'] = $row['userID'];
				$_SESSION['adminid'] = $row['adminID'];
				$_SESSION['issuper'] = $row['IsSuperAdmin'];
				return 'admin';
			}
			//procedure pour client
			if ($row['niveauID'] == 2)
			{
				if ($row['clientActif'] == 0)
				{
					return 'Vous n\'êtes pas autorisé à vous connecter au système.<br />Veuillez contacter le responsable.';
				}
				$_SESSION['userid'] = $row['userID'];
				$_SESSION['clientid'] = $row['clientID'];
				//mettre à jour le last login
				$sql = "CALL upd_client_lastlogin(:uID)";
				$param = array(':uID'=>$_SESSION['userid']);
				DatabaseHandler::Execute($sql,$param);
				return 'client';
			}
			//procedure pour prestataire
			if ($row['niveauID'] == 3)
			{
				if ($row['prestaActif'] == 0)
				{
					return 'Vous n\'êtes pas autorisé à vous connecter au système.<br />Veuillez contacter le responsable.';
				}
				$_SESSION['userid'] = $row['userID'];
				$_SESSION['prestaid'] = $row['prestaID'];
				return 'presta';
			}
		}
	}
