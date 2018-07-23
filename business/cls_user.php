<?php
	//		cls_user.php
	
	//		classe des utilisateurs du système		
	
	class User
	{
		private $_mPseudo;
		private $_mEmail;
		private $_mNiveau;
		private $_mMDP;
		private $_mPrenom;
		private $_mNom;
		private $_mUserID;
		private $_mLastLogin;
		
		//contructeur de classe
		public function User()
		{
		}
		
		//propriete pseudo
		protected function SetPseudo($pseudo)
		{
			$result = NULL;
			if (trim($pseudo) == '')
			{
				$result='Ce champ ne peut pas être vide';
				return $result;
			}
			if (!preg_match('/^[a-zA-Z0-9 éèàçâêîôûùëïö]{3,25}$/i',trim($pseudo)))
			{
				$result = 'Le pseudonyme ne peut contenir que des caract&egrave;res alpha-num&eacute;riques';
				return $result;
			}
			if ($this->CheckUniquePseudo(trim($pseudo)) > 0)
				$result = 'Le pseudonyme choisi est d&eacute;ja utilis&eacute; par un autre utilisateur';
			if ($result == NULL)
				$this->_mPseudo = trim($pseudo);
			return $result;
		}
		protected function GetPseudo()
		{
			return stripslashes($this->_mPseudo);
		}
		
		//propriete email
		protected function SetEmail($email)
		{
			$result = null;
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
			if ($this->CheckUniqueEmail(trim($email)) >0)
				$result = 'L\'email choisie est d&eacute;ja utilis&eacute;e par un autre utilisateur';
			if ($result == NULL)
				$this->_mEmail = trim($email);
			return $result;
		}
		protected function GetEmail()
		{
			return $this->_mEmail;
		}
		
		//propriete mot de passe Propriete write only
		protected function SetMotDePasse($mdp)
		{
			$result = NULL;
			if ((strlen($mdp) <5) || (strlen($mdp) >20))
			{
				$result = 'Votre mot de passe doit avoir entre 5 et 20 caract&egrave;res';
				return $result;
			}
			if (!preg_match('/^[a-zA-Z0-9]{5,20}$/i',trim($mdp)))
				$result = 'Votre mot de passe ne peut contenir que des lettres (minuscules ou majuscules) et des chiffres';
			if ($result == NULL)
				$this->_mMDP = trim($mdp);
			return $result;
		}
		
		//propriete prenom
		protected function SetPrenom($prenom)
		{
			$result = NULL;
			if (trim($prenom) == '')
			{
				$result='Ce champ ne peut pas être vide';
				return $result;
			}
			$pre=stripslashes($prenom);
			if (strlen($prenom) > 25)
			{
				$result = 'Le pr&eacute;nom ne peut pas faire plus de 25 lettres';
				return $result;
			}
			if (!preg_match('/^[^<>?$_"]{2,25}$/i',trim($prenom)))
				$result = 'Le pr&eacute;nom ne peut contenir que des caract&egrave;res alphab&eacute;tiques';
			if ($result == NULL)
				$this->_mPrenom = trim($prenom);
			return $result;
		}
		protected function GetPrenom()
		{
			return stripslashes($this->_mPrenom);
		}
		
		//propriete nom
		protected function SetNom($nom)
		{
			$result = NULL;
			if (trim($nom) == '')
			{
				$result='Ce champ ne peut pas être vide';
				return $result;
			}
			$nom=stripslashes($nom);
			if (strlen($nom) > 45)
			{
				$result = 'Le nom ne peut pas faire plus de 45 lettres';
				return $result;
			}
			if (!preg_match('/^[^<>?$_"]{2,45}$/i',trim($nom)))
				$result = 'Le nom ne peut contenir que des caract&egrave;res alphab&eacute;tiques';
			if ($result == NULL)
				$this->_mNom = trim($nom);
			return $result;
		}
		protected function GetNom()
		{
			return stripslashes($this->_mNom);
		}
		
		//propriete niveau
		protected function SetNiveau($niveau)
		{
			$this->_mNiveau = $niveau;
		}
		protected function GetNiveau()
		{
			return $this->_mNiveau;
		}
		
		//propriete userID read only
		protected function GetUserID()
		{
			return $this->_mUserID;
		}
		
		//propriete lastLogin
		protected function GetLastLogin()
		{
			return $this->_mLastLogin;
		}
		
		//fonction pour créer un administrateur
		protected function CreateUser()
		{
			//d'abord on crée le user 		*** On oublie pas le hash du mot de passe ***
			$sql1 = 'CALL add_user(:pseudo,:email,:niveau,:mdp,:prenom,:nom)';
			$params1 = array(':pseudo' => $this->_mPseudo,
							':email' => $this->_mEmail,
							':niveau' => $this->_mNiveau,
							':mdp' => MotDePasse::HashMotDePasse($this->_mMDP),
							':prenom' => $this->_mPrenom,
							':nom' => $this->_mNom);
			//excution et renvoie le resultat du nouvel ID
			$this->_mUserID = DatabaseHandler::GetOne($sql1,$params1);
		}
		
		//vérification que le pseudonyme est unique
		private function CheckUniquePseudo($pseudo)
		{
			$pseudo = strtolower($pseudo);
			//création de la requete
			$sql = 'CALL get_unique_valeur(:tablename,:tablefield,:valeur)';
			$params = array(':tablename' => 'prg_user',
							':tablefield' => 'userPseudo',
							':valeur' => $pseudo);
			return DatabaseHandler::GetOne($sql, $params);
		}
		
		//vérification que l'email est unique
		private function CheckUniqueEmail($email)
		{
			$email = strtolower($email);
			//création de la requete
			$sql = 'CALL get_unique_valeur(:tablename,:tablefield,:valeur)';
			$params = array(':tablename' => 'prg_user',
							':tablefield' => 'userEmail',
							':valeur' => $email);
			return DatabaseHandler::GetOne($sql, $params);
		}
		
		//fonction pour retrouver les détails de user par ID
		protected function GetUserParID($id)
		{
			$sql = 'CALL get_user_parID(:monID)';
			$param = array(':monID' => $id);
			$row = array();
			$row = DatabaseHandler::GetRow($sql, $param);
			if (!empty($row))
			{
				$this->_mEmail = $row['userEmail'];
				if ($row['userLastLogin'] == '0000-00-00 00:00:00')
				{
					$this->_mLastLogin = 'Aucun';
				}else{
					$this->_mLastLogin = date('d/m/Y',strtotime($row['userLastLogin']));
				}
				$this->_mNiveau = $row['niveauID'];
				$this->_mNom = $row['userNom'];
				$this->_mPrenom = $row['userPrenom'];
				$this->_mPseudo = $row['userPseudo'];
				$this->_mUserID = $id;
			}
		}
		
		//update l'user par ID 
		protected function UpdateUserParID()
		{
			$sql = 'CALL upd_user_parID(:monID,:mPseudo,:mEmail,:mPrenom,:mNom)';
			$params = array (':monID' => $this->_mUserID,
							':mPseudo' => $this->_mPseudo,
							':mEmail' => $this->_mEmail,
							':mPrenom' => $this->_mPrenom,
							':mNom' => $this->_mNom);
			DatabaseHandler::Execute($sql,$params);
		}
		
		//retrouve le dernier login
		protected function GetUserLastLoginParID($id)
		{
			$sql = 'CALL get_user_lastlog_parID(:monID)';
			$param = array(':monID' => $id);
			return DatabaseHandler::GetRow($sql,$param);
		}
		
		//update le login d'un user
		protected function UpdateUserLoginParID($id)
		{
			$sql = 'CALL upd_user_lastlog_parID(:monID)';
			$param = array(':monID' => $id);
			DatabaseHandler::Execute($sql,$param);
		}
		
		//update le logout d'un user
		protected function UpdateUserLogoutParID($id)
		{
			$sql = 'CALL upd_user_logout_parID(:monID)';
			$param = array(':monID' => $id);
			DatabaseHandler::Execute($sql,$param);
		}
		
		//function pour vérifier mot de passe
		protected function CheckUserMDP($mdp,$id)
		{
			$sql = 'CALL get_mdp_parID(:monID,:mMDEP)';
			$params = array(':monID' => $id,
							':mMDEP' =>  MotDePasse::HashMotDePasse($mdp));
			return DatabaseHandler::GetRow($sql,$params);
		}
		
		//fonction pour mettre à jour le mot de passe
		protected function UpdateUserMDP($mdp,$id)
		{
			$sql = 'CALL upd_user_mdp(:monID,:mMDEP)';
			$params = array(':monID' => $id,
							':mMDEP' =>  MotDePasse::HashMotDePasse($mdp));
			DatabaseHandler::Execute($sql,$params);
		}
	}
	