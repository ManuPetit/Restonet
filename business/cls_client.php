<?php
//		cls_client.php

//		classe des clients du système

Class Client extends User {
	private $_mClientID;
	private $_mTelephone;
	private $_mPortable;
	private $_mDateCreer;
	private $_mDateModif;
	private $_mNewsLetter;
	private $_mNbreVote;
	private $_mNbreComm;
	private $_mClientActif;
	private $_mAdresse = array();

	//propriete user.pseudo
	public function SetClientPseudo($pseudo) {
		$result = parent::SetPseudo($pseudo);
		return $result;
	}

	public function GetClientPseudo() {
		return parent::GetPseudo();
	}

	//propriete user.prenom
	public function SetClientPrenom($prenom) {
		$result = parent::SetPrenom($prenom);
		return $result;
	}

	public function GetClientPrenom() {
		return parent::GetPrenom();
	}

	//propriete user;nom
	public function SetClientNom($nom) {
		return parent::SetNom($nom);
	}

	public function GetClientNom() {
		return parent::GetNom();
	}

	//propriete user.email
	public function SetClientEmail($email) {
		return parent::SetEmail($email);
	}

	public function GetEmail() {
		return parent::GetEmail();
	}

	//propriete user.mdp write only
	public function SetClientMotDePasse($mdp) {
		return parent::SetMotDePasse($mdp);
	}

	//propriete user.lastlogin
	public function GetClientLastLogin($date) {
		return parent::GetLastLogin();
	}

	//propriete user.userID
	public function GetClientUserID() {
		return parent::GetUserID();
	}

	//propriete telephone
	public function SetClientTelephone($telephone) {
		$result = NULL;
		if (trim($telephone) == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[0-9]{10}$/i', trim($telephone)))
			$result = 'Le num&eacute;ro ne peut contenir que et seulement 10 chiffres';
		if ($result == NULL)
			$this -> _mTelephone = trim($telephone);
		return $result;
	}

	public function GetClientTelephone() {
		return $this -> _mTelephone;
	}

	//propriete portable
	public function SetClientPortable($portable) {
		$result = NULL;
		if ($portable == NULL) {
			$this -> _mPortable = NULL;
			return $result;
		}
		if (!preg_match('/^[0-9]{10}$/i', trim($portable)))
			$result = 'Le num&eacute;ro ne peut contenir que et seulement 10 chiffres';
		if ($result == NULL)
			$this -> _mPortable = trim($portable);
		return $result;
	}

	public function GetClientPortable() {
		return $this -> _mPortable;
	}

	//propriete ID read only
	public function GetClientID() {
		return $this -> _mClientID;
	}

	//propriete newsletter
	public function SetClientNewsLetter($newsl) {
		if ($newsl == TRUE) {
			$this -> _mNewsLetter = 1;
		} else {
			$this -> _mNewsLetter = 0;
		}
	}

	public function GetClientNewsLetter() {
		if ($this -> _mNewsLetter == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//propriete vote Read only
	public function GetClientNbreVote() {
		return $this -> _mNbreVote;
	}

	//propriete commentaire read only
	public function GetClientBreComm() {
		return $this -> _mNbreComm;
	}

	//propriete clientactif
	public function SetClientActif($actif) {
		if ($actif == TRUE) {
			$this -> _mClientActif = 1;
		} else {
			$this -> _mClientActif = 0;
		}
	}

	//propriete Adresse Ligne 1
	public function SetClientAdresse1($adresse) {
		$adresse=stripslashes($adresse);
		$result = NULL;
		if (trim($adresse) == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (strlen($adresse) > 60) {
			$result = 'La premi&egrave;re ligne d\'adresse ne peut pas faire plus de 60 caract&egrave;res';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,60}$/i', trim($adresse)))
			$result = 'Certains caract&egrave;res de l\'adresse sont interdits';
		if ($result == NULL)
			$this -> _mAdresse['rue1'] = trim($adresse);
		return $result;
	}

	public function GetClientAdresse1() {
		return $this -> _mAdresse['rue1'];
	}

	//propriete Adresse Ligne 2
	public function SetClientAdresse2($adresse = null) {
		$result = NULL;
		if (($adresse == NULL) || (trim($adresse) == '')) {
			$this -> _mAdresse['rue2'] = NULL;
			return $result;
		}
		$adresse=stripslashes($adresse);
		if (strlen($adresse) > 60) {
			$result = 'La deuxi&egrave;me ligne d\'adresse ne peut pas faire plus de 60 caract&egrave;res';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,60}$/i', trim($adresse)))
			$result = 'Certains caract&egrave;res de l\'adresse sont interdits';
		if ($result == NULL)
			$this -> _mAdresse['rue2'] = trim($adresse);
		return $result;
	}

	public function GetClientAdresse2() {
		return $this -> _mAdresse['rue2'];
	}

	//propriete adresse villeID
	public function SetClientVilleID($ville) {
		$result = NULL;
		if (is_null($ville)) {
			$result = 'Entrez votre code postal';
			return $result;
		}
		if (!is_numeric($ville)) {
			$result = 'Valeur transmise invalide';
			return $result;
		}
		if ($ville > 0) {
			$this -> _mAdresse['villeid'] = $ville;
		} else {
			$result = 'Invalide ID pour la ville';
		}
		return $result;
	}

	public function GetClientVilleID() {
		return $this -> _mAdresse['villeid'];
	}

	//retrouver la ville et cp
	public function GetVilleCpParID() {
		$sql = "CALL get_ville_detail_parid(:vID)";
		$param = array(':vID' => $this -> _mAdresse['villeid']);
		$row = DatabaseHandler::GetRow($sql, $param);
		return $row['villeNom'] . ' (' . $row['villeCP'] . ')';
	}

	//function de création d'un client
	public function SaveClientDetails() {
		parent::SetNiveau(2);
		DatabaseHandler::SetBeginTransaction();
		try {
			//creation du user
			parent::CreateUser();
			//creation du client
			$sql = "CALL add_client(:uID,:telF,:telP,:news)";
			$params = array(':uID' => parent::GetUserID(), ':telF' => $this -> _mTelephone, ':telP' => $this -> _mPortable, ':news' => $this -> _mNewsLetter);
			$this -> _mClientID = DatabaseHandler::GetOne($sql, $params);
			//création de l'adresse1
			$sql = "CALL add_adresse(:cID,:adr1,:adr2,:vID,:tel,:def)";
			$params = array(':cID' => $this -> _mClientID, ':adr1' => $this -> _mAdresse['rue1'], ':adr2' => $this -> _mAdresse['rue2'], ':vID' => $this -> _mAdresse['villeid'], ':tel' => $this -> _mTelephone, ':def' => 1);
			DatabaseHandler::Execute($sql, $params);
			DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}
	}

	//propriete téléphone adresse
	public function SetClientTelephoneAdresse($telephone) {
		$result = NULL;
		if ($telephone == NULL) {
			$this -> _mTelephone = NULL;
			return $result;
		}
		if (!preg_match('/^[0-9]{10}$/i', trim($telephone)))
			$result = 'Le num&eacute;ro ne peut contenir que et seulement 10 chiffres';
		if ($result == NULL)
			$this -> _mTelephone = trim($telephone);
		return $result;
	}

	//function pour ajouter une nouvelle adresse
	public function SaveClientAdresse($cID) {
		$sql = "CALL add_adresse(:cID,:adr1,:adr2,:vID,:tel,:def)";
		$params = array(':cID' => $cID, ':adr1' => $this -> _mAdresse['rue1'], ':adr2' => $this -> _mAdresse['rue2'], ':vID' => $this -> _mAdresse['villeid'], ':tel' => $this -> _mTelephone, ':def' => 0);
		DatabaseHandler::Execute($sql, $params);
	}

	//function pour retrouver l'adresse du client par defaut
	public static function GetDefaultAdresse($client) {
		$sql = "CALL get_defAdresse_ClientID(:cID)";
		$param = array(':cID' => $client);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour vérifier le mot de passe
	public static function CheckClientMDP($mdp, $id) {
		$row = array();
		$row = parent::CheckUserMDP($mdp, $id);
		if (empty($row)) {
			//on n'a pas de match
			return false;
		} else {
			//on a un match
			return true;
		}
	}

	//change le mot de passe de client
	public static function UpdateClientMDP($mdp, $id) {
		parent::UpdateUserMDP($mdp, $id);
	}

	//retrouve l'ensemble des commandes validées d'un client
	public static function GetAllValidCommandeClientID($cltID) {
		$sql = "CALL get_allcomde_idClient(:cID)";
		$param = array(':cID' => $cltID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve les détails d'un client
	public function GetClientParID($cltID) {
		$sql = "CALL get_client_parID(:cID)";
		$param = array(':cID' => $cltID);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$uID = $row['userID'];
			$this -> _mClientActif = $row['clientActif'];
			$this -> _mClientID = $cltID;
			$this -> _mDateCreer = $row['clientDateCreer'];
			$this -> _mDateModif = $row['clientDateModif'];
			$this -> _mNbreComm = $row['clientNbreComm'];
			$this -> _mNbreVote = $row['clientNbreVote'];
			$this -> _mNewsLetter = $row['clientNewsletter'];
			$this -> _mPortable = $row['clientPortable'];
			$this -> _mTelephone = $row['clientTelephone'];
			parent::GetUserParID($uID);
			//retrouver l'adresse par defaut du client
			$sql = "CALL get_adresse_clientID(:cID)";
			$add = array();
			$add = DatabaseHandler::GetRow($sql, $param);
			if (!empty($row)) {
				$this -> _mAdresse['rue1'] = $add['adresse1'];
				$this -> _mAdresse['rue2'] = $add['adresse2'];
				$this -> _mAdresse['villeid'] = $add['villeID'];
			}
		}
	}

	//met à jour les détails du client
	public function UpdateClientDetail() {
		DatabaseHandler::SetBeginTransaction();
		try {
			//mise a jour prg_client
			$sql = "CALL upd_client_detail(:cID,:cTel,:cPor,:news)";
			$params = array(':cID' => $this -> _mClientID, ':cTel' => $this -> _mTelephone, ':cPor' => $this -> _mPortable, ':news' => $this -> _mNewsLetter);
			DatabaseHandler::Execute($sql, $params);
			//mise à jour prg_user
			parent::UpdateUserParID();
			//mise à jour de l'adresse
			$sql = "CALL upd_adresse_clientID(:cID,:adr1,:adr2,:vID,:tel)";
			$params = array(':cID' => $this -> _mClientID, ':adr1' => $this -> _mAdresse['rue1'], ':adr2' => $this -> _mAdresse['rue2'], ':vID' => $this -> _mAdresse['villeid'], ':tel' => $this -> _mTelephone);
			DatabaseHandler::Execute($sql, $params);
			DatabaseHandler::CommitTransaction();
			return TRUE;
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
			return FALSE;
		}
	}

	//function pour retrouver la liste des prestataires utilisés par un client
	public static function ReturnPrestaUsedClientID($cltID) {
		$sql = "CALL get_prestaUtilise_ClientID(:cID)";
		$param = array(':cID' => $cltID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//function pour mettre à jour les notes sur la base de données
	public static function PutNoteToPresta($cltID, $prestaID, $note) {
		DatabaseHandler::SetBeginTransaction();
		try {
			$sql = "CALL upd_prestaNote_ClientID(:cID,:pID,:lNote)";
			$params = array(':cID' => $cltID, ':pID' => $prestaID, ':lNote' => $note);
			DatabaseHandler::Execute($sql, $params);
			DatabaseHandler::CommitTransaction();
			return TRUE;
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
			return FALSE;
		}
	}

	//FUNction pour retrouver la liste des commentaires faits par un client
	public static function ReturnPrestaUsedCommCliendID($cltID) {
		$sql = "CALL get_prestaUtiliseCom_ClientID(:cID)";
		$param = array(':cID' => $cltID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//enregistre commentaire description
	public static function InsertPrestaCommentaire($desc, $cltID, $pID) {
		$result = null;
		$desc = 
		$adresse=stripslashes($desc);
		if ((is_null($desc)) || ($desc == '')) {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{6,10000}$/u', $desc)) {
			$result = 'Certains caractères dans ce champ sont invalides';
			return $result;
		}
		$sql = "CALL add_commentaireClient(:cID,:pID,:comm)";
		$params = array(':cID' => $cltID, ':pID' => $pID, ':comm' => $desc);
		DatabaseHandler::Execute($sql, $params);
		return $result;
	}

	//retrouve tous les commentaires d'un client
	public static function GetAllCommenataireClientID($cltID) {
		$sql = "CALL get_commentaire_ClientID(:cID)";
		$param = array(':cID' => $cltID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve un commentaire par ID
	public static function GetCommentaireParID($comID) {
		$sql = "CALL get_commPresta_CommID(:cID)";
		$param = array(':cID' => $comID);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//delete un commentaire
	public static function DeleteCommentaire($cltID, $comID) {
		$sql = "CALL del_commentaireClient(:cID,:comID)";
		$params = array(':cID' => $cltID, ':comID' => $comID);
		DatabaseHandler::Execute($sql, $params);
	}

}
