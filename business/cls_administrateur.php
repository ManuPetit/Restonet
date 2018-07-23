<?php
//		cls_administrateur.php

//		classe des administrateurs

class Administrateur extends User {
	private $_mAdminID;
	private $_mIsSuperAdmin;
	private $_mAdresse1;
	private $_mAdresse2;
	private $_mVilleID;
	private $_mTelephone;
	private $_mPortable;
	private $_mDateCreer;
	private $_mDateModif;
	private $_mActif;
	private $_mCodePostal;
	private $_mVille;

	//retourne le code postal
	public function GetAdminCodePostal() {
		return $this -> _mCodePostal;
	}

	//retourne la ville
	public function GetAdminVille() {
		return $this -> _mVille;
	}

	//propriete User.pseudo
	public function SetAdminPseudo($pseudo) {
		$result = NULL;
		$result = parent::SetPseudo($pseudo);
		return $result;
	}

	public function GetAdminPseudo() {
		return parent::GetPseudo();
	}

	//propriete User.email
	public function SetAdminEmail($email) {
		$result = NULL;
		$result = parent::SetEmail($email);
		return $result;
	}

	public function GetAdminEmail() {
		return parent::GetEmail();
	}

	//propriete User.mdp	write only
	public function SetAdminMotDePasse($mdp) {
		$result = null;
		$result = parent::SetMotDePasse($mdp);
		return $result;
	}

	//propriete User.prenom
	public function SetAdminPrenom($prenom) {
		$result = null;
		$result = parent::SetPrenom($prenom);
		return $result;
	}

	public function GetAdminPrenom() {
		return parent::GetPrenom();
	}

	//propriete User.nom
	public function SetAdminNom($nom) {
		$result = NULL;
		$result = parent::SetNom($nom);
		return $result;
	}

	public function GetAdminNom() {
		return parent::GetNom();
	}

	//propriete User.niveau read only
	public function GetAdminNiveau() {
		return parent::GetNiveau();
	}

	//propriete User.UserID Read only
	public function GetAdminUserID() {
		return parent::GetUserID();
	}

	//propriéte IsSuperAdmin Read only
	public function SetIsSuperAdmin($issuper) {
		$result = NULL;
		if (!is_numeric($issuper)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mIsSuperAdmin = $issuper;
		}
		return $result;
	}

	public function GetIsSuperAdmin() {
		return $this -> _mIsSuperAdmin;
	}

	//propriété adresse1
	public function SetAdminAdresse1($adre) {
		$adresse=stripslashes($adre);
		$result = NULL;
		if (trim($adresse) == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (strlen($adresse) > 60) {
			$result = 'La premi&egrave;re ligne d\'adresse ne peut pas faire plus de 60 caract&egrave;res';
			return $result;
		}
		if (!preg_match('/^[^<>?$_"]{3,60}$/i', trim($adresse)))
			$result = 'Certains caract&egrave;res de l\'adresse sont interdits';
		if ($result == NULL)
			$this -> _mAdresse1 = trim($adresse);
		return $result;
	}

	public function GetAdminAdresse1() {
		return $this -> _mAdresse1;
	}

	//propriété adresse2
	public function SetAdminAdresse2($adre = NULL) {
		$adresse=stripslashes($adre);
		$result = NULL;
		if (($adresse == NULL) || (trim($adresse) == '')) {
			$this -> _mAdresse2 = NULL;
			return $result;
		}
		if (strlen($adresse) > 60) {
			$result = 'La deuxi&egrave;me ligne d\'adresse ne peut pas faire plus de 60 caract&egrave;res';
			return $result;
		}
		if (!preg_match('/^[^<>?$_"]{3,60}$/i', trim($adresse)))
			$result = 'Certains caract&egrave;res de l\'adresse sont interdits';
		if ($result == NULL)
			$this -> _mAdresse2 = trim($adresse);
		return $result;
	}

	public function GetAdminAdresse2() {
		return $this -> _mAdresse2;
	}

	//propriete ville
	public function SetAdminVilleID($ville) {
		$result = NULL;
		if (!is_numeric($ville)) {
			$result = 'Valeur transmise invalide';
			return $result;
		}
		if ($ville > 0) {
			$this -> _mVilleID = $ville;
		} else {
			$result = 'Invalide ID pour la ville';
		}
		return $result;
	}

	public function GetAdminVilleID() {
		return $this -> _mVilleID;
	}

	//propriete telephone
	public function SetAdminTelephone($telephone) {
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

	public function GetAdminTelephone() {
		return $this -> _mTelephone;
	}

	//propriete telephone portable
	public function SetAdminPortable($portable = NULL) {
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

	public function GetAdminPortable() {
		return $this -> _mPortable;
	}

	//propriete actif
	public function SetAdminActif($actif) {
		$result = NULL;
		if (!is_numeric($actif)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mActif = $actif;
		}
		return $result;
	}

	public function GetAdminActif() {
		return $this -> _mActif;
	}

	//propriete date creer
	public function GetAdminDateCreer() {
		return $this -> _mDateCreer;
	}

	//propriete date modif
	public function GetAdminDateModif() {
		return $this -> _mDateModif;
	}

	public function GetAdminLastLogin() {
		return parent::GetLastLogin();
	}

	//methode pour sauvegarder un administrateur dans la base de données
	public function SaveAdminDetails() {
		//en premier on crée le nouvel utilisateur
		parent::SetNiveau(1);
		parent::CreateUser();
		//puis on crée l'administrateur
		$sql2 = 'CALL add_administrateur(:userid,:issuper,:adresse1,:adresse2,:villeid,:telephone,:portable,:actif)';
		$params2 = array(':userid' => parent::GetUserID(), ':issuper' => $this -> _mIsSuperAdmin, ':adresse1' => $this -> _mAdresse1, ':adresse2' => $this -> _mAdresse2, ':villeid' => $this -> _mVilleID, ':telephone' => $this -> _mTelephone, ':portable' => $this -> _mPortable, ':actif' => $this -> _mActif);
		$this -> _mAdminID = DatabaseHandler::Execute($sql2, $params2);
	}

	//fonction static pour retrouver le nom de l'admin pour le supprimer
	public static function GetNomParId($id) {
		$sql = 'CALL get_admin_nom_parID(:monID)';
		$param = array(':monID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour detruire un administrateur
	public static function DeleteAdmin($id) {
		$sql = 'CALL del_administrateur(:monID)';
		$param = array(':monID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	//fonction pour retrouver la liste de tous les admins et leur ID
	public static function GetAllAdminNomID() {
		$sql = 'CALL get_all_admin_nom()';
		return DatabaseHandler::GetAll($sql);
	}

	//retrouve les details d'un admin par ID
	public function GetAdminParID($id) {
		$sql = 'CALL get_admin_parID(:monID)';
		$param = array(':monID' => $id);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$uID = $row['userID'];
			$this -> _mIsSuperAdmin = $row['isSuperAdmin'];
			$this -> _mAdresse1 = $row['adminAdresse1'];
			$this -> _mAdresse2 = $row['adminAdresse2'];
			$this -> _mVilleID = $row['villeID'];
			$this -> _mCodePostal = $row['villeCP'];
			$this -> _mVille = $row['villeNom'];
			$this -> _mTelephone = $row['adminTelephone'];
			$this -> _mPortable = $row['adminPortable'];
			$this -> _mActif = $row['adminActif'];
			$this -> _mAdminID = $id;
			parent::GetUserParID($uID);
		}
	}

	//update les détails d'un admin
	public function UpdateAdminParID() {
		//on update l'admin
		$sql = 'CALL upd_admin_parID(:monID,:mSuper,:mAdresse1,:mAdresse2,:mVille,:mTelephone,:mPortable,:mActif)';
		$params = array(':monID' => $this -> _mAdminID, ':mSuper' => $this -> _mIsSuperAdmin, ':mAdresse1' => $this -> _mAdresse1, ':mAdresse2' => $this -> _mAdresse2, ':mVille' => $this -> _mVilleID, ':mTelephone' => $this -> _mTelephone, ':mPortable' => $this -> _mPortable, ':mActif' => $this -> _mActif);
		DatabaseHandler::Execute($sql, $params);
		//on update user
		parent::UpdateUserParID();
	}

	//fonction pour rediriger un admin non logge
	public static function CheckLoggedAdmin() {
		if (((!isset($_SESSION['adminid'])) && (!isset($_SESSION['userid']))) || (empty($_SESSION['adminid'])) || (empty($_SESSION['userid']))) {
			
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head>
				<title>Erreur</title>
				<link rel="stylesheet" type="text/css" href="../styles/admin.css" />
				</head>
				<body>
				<h2>Erreur</h2>
				<p>L\'accès à cette page est réservé.</p>
				<p>Cliquez ici pour revenir sur <a href ="../index.php" title="Retour vers la page d\'accueil" class="errpage">la page d\'accueil</a> de RESTOnet.</p>
				</body>
				</html>';
			exit();
		}
	}

	//fonction pour retrouver le dernier login d'un admin
	public static function GetAdminLastLoginParID($id) {
		$row = array();
		$row = parent::GetUserLastLoginParID($id);
		if (!empty($row)) {
			if ($row['userLastLogin'] == '0000-00-00 00:00:00') {
				$row['userLastLogin'] = '<br />C\'est votre première connexion à l\'Interface Administrative de RESTOnet.<br />Nous vous conseillons de changer votre mot de passe.';
			} else {
				$date = strtotime($row['userLastLogin']);
				$jour = get_jour($date);
				$mois = get_mois($date);
				$row['userLastLogin'] = '<br />Dernière connexion : ' . $jour . date(' d ', $date) . $mois . date(' Y ', $date) . 'à ' . date('H:i:s', $date) . '.';
			}
			return $row;
		}
	}

	//fonction pour updater le login de l'admin
	public static function UpdateAdminLoginParID($id) {
		parent::UpdateUserLoginParID($id);
	}

	//fonction pour update le logout de l'admin
	public static function UpdateLogoutAdminParID($id) {
		parent::UpdateUserLogoutParID($id);
	}

	//fonction pour vérifier le mot de passe
	public static function CheckAdminMDP($mdp, $id) {
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

	//change le mot de passe de l'admin
	public static function UpdateAdminMDP($mdp, $id) {
		parent::UpdateUserMDP($mdp, $id);
	}

}
