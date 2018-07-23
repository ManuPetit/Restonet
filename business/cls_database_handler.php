<?php
	//		cls_database_handler.php
	
	//		fichier de la classe générique pour toutes operations sur la base de données
	
	class DatabaseHandler
	{
		//instance de la classe PDO
		private static $_mHandler;
		
		//contructeur privé de la classe pour eviter création directe
		private function __construct()
		{
		}
		
		//retourne un handler de la base données initialisé
		private static function GetHandler()
		{
			//creation de connection si elle n'existe pas
			if (!isset(self::$_mHandler))
			{
				//execution du code en gerant les erreur
				try
				{
					//nouvelle classe PDO
					self::$_mHandler = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD,array(PDO::ATTR_PERSISTENT => DB_PERSISTENCY));					
					//configure PDO pour reporter les erreurs
					self::$_mHandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				}
				catch(PDOException $e)
				{
					//fermer la connection
					self::Close();
					trigger_error($e->getMessage(), E_USER_ERROR);
				}
			}
			//retourne le handler
			return self::$_mHandler;
		}
		
		//fin de la class PDO
		public static function Close()
		{
			self::$_mHandler = NULL;
		}
		
		//methode pour PDO execute()
		public static function Execute($sqlQuery, $params = NULL)
		{
			//essayer d'exécuter une procedure stockée ou une requete
			try
			{
				//handler de la database
				$database_handler = self::GetHandler();
				//preparer la requete
				$statement_handler = $database_handler->prepare($sqlQuery);
				//executer la requete
				return $statement_handler->execute($params);
				
			}
			catch(PDOException $e)
			{
				trigger_error($e->getMessage(), E_USER_ERROR);
			}
		}
		
		//methode pour PDO fetchAll()
		public static function GetAll($sqlQuery, $params = NULL, $fetchStyle = PDO::FETCH_ASSOC)
		{
			//initialiser valeur de retour
			$result = NULL;
			//essayer d'exécuter une procedure stockée ou une requete
			try
			{
				//handler de la database
				$database_handler = self::GetHandler();
				//preparer la requete
				$statement_handler = $database_handler->prepare($sqlQuery);
				//executer la requete
				$statement_handler->execute($params);
				//recupérer les résultats
				$result = $statement_handler->fetchAll($fetchStyle);
			}
			catch(PDOException $e)
			{
				trigger_error($e->getMessage(), E_USER_ERROR);
			}
			//retourne le resultat
			return $result;
		}
		
		//methode pour PDO fetch()
		public static function GetRow($sqlQuery, $params = NULL, $fetchStyle = PDO::FETCH_ASSOC)
		{
			//initialiser valeur de retour
			$result = NULL;
			//essayer d'exécuter une procedure stockée ou une requete
			try
			{
				//handler de la database
				$database_handler = self::GetHandler();
				//preparer la requete
				$statement_handler = $database_handler->prepare($sqlQuery);
				//executer la requete
				$statement_handler->execute($params);
				//recupérer les résultats
				$result = $statement_handler->fetch($fetchStyle);
			}
			catch(PDOException $e)
			{
				trigger_error($e->getMessage(), E_USER_ERROR);
			}
			//retourne le resultat
			return $result;
		}
		
		//methode pour retrouver un valeur unique
		public static function GetOne($sqlQuery, $params = NULL)
		{
			//initialiser valeur de retour
			$result = NULL;
			//essayer d'exécuter une procedure stockée ou une requete
			try
			{
				//handler de la database
				$database_handler = self::GetHandler();
				//preparer la requete
				$statement_handler = $database_handler->prepare($sqlQuery);
				//executer la requete
				$statement_handler->execute($params);
				//recupérer les résultats
				$result = $statement_handler->fetch(PDO::FETCH_NUM);
				//récupère la première valeur
				$result = $result[0];
			}
			catch(PDOException $e)
			{
				trigger_error($e->getMessage(), E_USER_ERROR);
			}
			//retourne le resultat
			return $result;
		}	
		
		//execute une méthode avec transaction
		public static function SetBeginTransaction()
		{
			$database_handler=self::GetHandler();
			return $database_handler->beginTransaction();
		}
		
		//commit transaction
		public static function CommitTransaction()
		{
			$database_handler=self::GetHandler();
			return $database_handler->commit();
		}
		
		//roll backTransaction
		public static function RoolbackTransaction()
		{
			$database_handler = self::GetHandler();
			return $database_handler->rollBack();
		}
	}