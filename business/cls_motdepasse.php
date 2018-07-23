<?php
	//		cls_motdepasse.php
	
	//		Classe relative à la génération et au hachage de mot de passe
	
	class MotDePasse
	{
		public static function HashMotDePasse($mdp)
		{
			//initialise la variable de retour
			$result = NULL;	
			$result = hash("sha256", $mdp . MDP_SALT, true);
			return $result;
		}
		
		//fonction pour faire un mot de passe du longueur donnée
		public static function MakePassword($length) {
			$vowels = 'aeiouyAEIUY0123456789';
			$consonants = 'bdghjlmnpqrstvwxzBDGHJLMNPQRSTVWXZ';
			$password = '';
			$alt = time() % 2;
			srand(time());
			for ($i = 0; $i < $length; $i++) {
			 	if ($alt == 1) {
					$password .= $consonants[(rand() % strlen($consonants))];
					$alt = 0;
				} else {
					$password .= $vowels[(rand() % strlen($vowels))];
					$alt = 1;
				}
			}
			return $password;
		}
		
		//fonction pour changer le mot de passe
		public static function CheckEmailRecover($email){
			$result=null;
			//verifier l'email transmise
			if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$result = 'L\'email entr&eacute;e n\'est pas valide';
				return $result;
			}
			if (strlen($email) > 80)
			{
				$result = 'L\'email ne doit pas faire plus de 80 caract&egres';
				return $result;
			}
			$sql = 'CALL get_unique_valeur(:tablename,:tablefield,:valeur)';
			$params = array(':tablename' => 'prg_user',
							':tablefield' => 'userEmail',
							':valeur' => $email);
			if (DatabaseHandler::GetOne($sql, $params) != 1){
				return 'L\'email que vous avez entrée n\'est pas présente dans notre base de données.<br />Vérifiez qu\'il s\'agit bien de l\'email que vous avez utilisé lors de votre inscription.';
			}
		}
	}