<?php
//		cls_categorie.php
//		fichier des classe de catégorie

class Categorie {
	private $_mID;
	private $_mNom;
	private $_mTitle;
	private $_mMKey;
	private $_mMDesc;
	private $_mIsUsed;
	//variable permettant de savoir si la catégorie est utilisée par des resto

	public function Categorie() {
	}

	//propriete ID read only
	public function GetCatID() {
		return $this -> _mID;
	}

	//propriete nom
	public function SetCatNom($noms) {
		$result = NULL;
		$nom = stripslashes($noms);
		if ((strlen($nom) < 3) || (strlen($nom) > 30)) {
			$result = 'Le nom de la catégorie doit comprendre entre 3 et 30 caractères';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,30}$/i', $nom)) {
			$result = 'Le nom de la catégorie ne peut comprendre que caractères alpha-numériques';
			return $result;
		}
		if ($this -> CheckCategorieUnique($nom) > 0) {
			$result = 'Cette catégorie existe déja dans la base de données';
			return $result;
		}
		if ($result == NULL) {
			$this -> _mNom = $nom;
		}
		return $result;
	}

	public function GetCatNom() {
		return $this -> _mNom;
	}

	//propriete title
	public function SetCatTitle($titles) {
		$result = NULL;
		$title = stripslashes($titles);
		if ((strlen($title) < 3) || (strlen($title) > 50)) {
			$result = 'Le titre de la catégorie doit comprendre entre 3 et 30 caractères';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,50}$/i', $title)) {
			$result = 'Le titre de la catégorie ne peut comprendre que caractères alpha-numériques, des point et des virgules';
			return $result;
		}
		if ($result == NULL) {
			if ($this -> CheckHasRestonet($title) > 0) {
				$this -> _mTitle = $title;
			} else {
				$this -> _mTitle = $title . ' - RESTOnet';
			}
		}
		return $result;
	}

	public function GetCatTitle() {
		return $this -> _mTitle;
	}

	//propriete IsUsed read only
	public function IsUsed() {
		return $this -> _mIsUsed;
	}

	//propriété meta key
	public function SetMetaKey($key) {
		$result = NULL;
		$key = stripslashes($key);
		if (strlen($key) < 1) {
			$result = 'Vous devez entrer au moins un mot clé';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,100}$/i', $key)) {
			$result = 'Certains caractères ne sont pas admis';
			return $result;
		}
		//vérification espace puis virgule
		if (strpos($key, ' ') == true) {
			//on a des espace donc on assusme qu'il doit y avoir des virgules
			if (strpos($key, ',') == false) {
				$result = 'Vous devez séparer les mots par des virgules';
				return $result;
			}
		}
		if ($result == NULL) {
			if ($this -> CheckHasRestonet($key) > 0) {
				$this -> _mMKey = $key;
			} else {
				$key = $this -> CheckVirguleFin($key);
				$this -> _mMKey = strtolower($key . 'restonet');
			}
		}
		return $result;
	}

	public function GetMetaKey() {
		return $this -> _mMKey;
	}

	//propriété meta description
	public function SetMetaDesc($desc) {
		$desc = stripslashes($desc);
		$result = NULL;
		if (strlen($desc) < 1) {
			$result = 'Vous devez entrer une description';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,250}$/i', $desc)) {
			$result = 'Certains caractères ne sont pas admis';
			return $result;
		}
		if ($result == NULL) {
			$this -> _mMDesc = $desc;
		}
		return $result;
	}

	public function GetMetaDesc() {
		return $this -> _mMDesc;
	}

	//verifier qu'il n'y a pas une autre catégorie avec le meme nom
	private function CheckCategorieUnique($nom) {
		$nom = strtolower($nom);
		//création de la requete
		$sql = 'CALL get_unique_valeur(:tablename,:tablefield,:valeur)';
		$params = array(':tablename' => 'prg_categorie', ':tablefield' => 'categorieNom', ':valeur' => $nom);
		return DatabaseHandler::GetOne($sql, $params);
	}

	//creation d'une categorie
	public function CreateCategorie() {
		$sql = 'CALL add_categorie(:cNom,:cTitle,:cKey,:cDesc)';
		$params = array(':cNom' => $this -> _mNom, ':cTitle' => $this -> _mTitle, ':cKey' => $this -> _mMKey, ':cDesc' => $this -> _mMDesc);
		$this -> _mID = DatabaseHandler::Execute($sql, $params);
	}

	//verifier la vrigule dans metaKey
	private function CheckVirguleFin($string) {
		if (substr($string, -1) != ',') {
			$string .= ',';
		}
		return $string;
	}

	//liste les détails de toutes les categories
	public static function GetCategorieDetail() {
		$sql = 'CALL get_categorie_detail()';
		return DatabaseHandler::GetAll($sql);
	}

	//retrouve et set une catégorie
	public function GetCategorieParID($id) {
		$sql = 'CALL get_categorie_parID(:monID)';
		$param = array(':monID' => $id);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$this -> _mID = $id;
			$this -> _mNom = $row['categorieNom'];
			$this -> _mTitle = $row['categorieTitle'];
			$this -> _mMKey = $row['categorieMetaKey'];
			$this -> _mMDesc = $row['categorieMetaDescription'];
			if ($row['IsUsed'] > 0) {
				$this -> _mIsUsed = 1;
			} else {
				$this -> _mIsUsed = 0;
			}
		}
	}

	//fonction pour détruire une catégorie
	public static function DeleteCategorie($id) {
		$sql = 'CALL del_categorie_parID(:monID)';
		$param = array(':monID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	//fonction pour voir si il y a deja le mot restonet dans le titre ou les meta key
	private function CheckHasRestonet($mot) {
		$result = NULL;
		$val = stristr($mot, 'restonet');
		return strlen($val);
	}

	//fonction pour mettre à jour la base de donnée
	public function UpdateCategorie() {
		$sql = 'CALL upd_categorie_parID(:cID,:cNom,:cTitle,:cKey,:cDesc)';
		$params = array(':cID' => $this -> _mID, ':cNom' => $this -> _mNom, ':cTitle' => $this -> _mTitle, ':cKey' => $this -> _mMKey, ':cDesc' => $this -> _mMDesc);
		DatabaseHandler::Execute($sql, $params);
	}

}
