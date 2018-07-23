<?php
//		cls_plat.php
//		fichier de gestion des plats
class Plat {
	private $_mPlatID;
	private $_mPrestaID;
	private $_mPlatNom;
	private $_mPlatDescription = NULL;
	private $_mPlatPrix;
	private $_mPlatPrixPromo = 0;
	private $_mTvaID;
	private $_mPlatImage = NULL;
	private $_mPlatActif;
	private $_mTypePlatID;
	private $_mIsMenu;
	private $_mMenuPlatID = 0;
	private $_mGroupePlatNom = NULL;
	private $prestaNom;

	//propriete ID read only
	public function GetPlatID() {
		return $this -> _mPlatID;
	}

	//propriete prestaID
	public function SetPrestaID($id) {
		$result = NULL;
		if ((!is_numeric($id)) || ($id < 1)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mPrestaID = $id;
		}
		return $result;
	}

	public function GetPrestaID() {
		return $this -> _mPrestaID;
	}

	//propriete nom
	public function SetPlatNom($nom) {
		$result = NULL;
		$nom = trim(stripslashes($nom));
		if ($nom == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,120}$/i', $nom)) {
			$result = 'Des caractères non valides ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mPlatNom = $nom;
		return $result;
	}

	public function GetPlatNom() {
		return $this -> _mPlatNom;
	}

	//propriete description
	public function SetPlatDesc($desc) {
		$result = null;
		$desc = trim(stripslashes($desc));
		if ((is_null($desc)) || ($desc == '')) {
			$this -> _mPlatDescription = NULL;
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,10000}$/u', $desc)) {
			$result = 'Certains caractères dans ce champ sont invalides';
			return $result;
		}
		$this -> _mPlatDescription = $desc;
		return $result;
	}

	public function GetPlatDescription() {
		return stripslashes($this -> _mPlatDescription);
	}

	//propriete prix
	public function SetPlatPrix($prix) {
		$result = NULL;
		$prix = trim($prix);
		//on enlève les espaces
		$prix = str_replace(' ', '', $prix);
		$val = $prix;
		if (substr_count($prix, ',') > 0) {
			$val = str_replace(',', '.', $prix);
		}
		if (!is_numeric($val)) {
			$result = 'La valeur du prix n\'est pas numérique';
			return $result;
		}
		if (is_null($result)) {
			//on a une chiffre
			$this -> _mPlatPrix = floatval($val);
		}
		return $result;
	}

	public function GetPlatPrix() {
		return $this -> _mPlatPrix;
	}

	//propriete prix promo
	public function SetPlatPrixPromo($prix) {
		$result = NULL;
		$prix = trim($prix);
		if (($prix == '') || ($prix == NULL)) {
			$this -> _mPlatPrixPromo = 0;
			return $result;
		}
		//on enlève les espaces
		$prix = str_replace(' ', '', $prix);
		$val = $prix;
		if (substr_count($prix, ',') > 0) {
			$val = str_replace(',', '.', $prix);
		}
		if (!is_numeric($val)) {
			$result = 'La valeur du prix promotionnel n\'est pas numérique';
			return $result;
		}
		if (is_null($result)) {
			//on a une chiffre
			$this -> _mPlatPrixPromo = floatval($val);
		}
		return $result;
	}

	public function GetPlatPrixPromo() {
		return $this -> _mPlatPrixPromo;
	}

	//propriete tva
	public function SetPlatTVA($tva) {
		$result = NULL;
		if ((!is_numeric($tva)) || ($tva < 1)) {
			$result = 'Valeur transmise invalide';
			return $result;
		}
		$this -> _mTvaID = $tva;
		return $result;
	}

	public function GetTvaID() {
		return $this -> _mTvaID;
	}

	//propriete image
	public function SetPlatImage($image) {
		$image = trim($image);
		if (($image == '') || ($image == NULL)) {
			$this -> _mPlatImage = NULL;
		} else {
			if (stristr($image, '_pre') === FALSE) {
				$vars = explode('.', $image);
				$image = $vars[0] . '_pre.' . $vars[1];
			}
			$this -> _mPlatImage = $image;
		}
	}

	public function GetPlatImage() {
		return $this -> _mPlatImage;
	}

	//propriete actif
	public function SetPlatActif($actif) {
		$result = NULL;
		if (!is_numeric($actif)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mPlatActif = $actif;
		}
		return $result;
	}

	public function GetPlatActif() {
		return $this -> _mPlatActif;
	}

	//propriete type plat
	public function SetTypePlat($id) {
		$result = NULL;
		if ((!is_numeric($id)) || ($id < 1)) {
			$result = 'Valeur transmise invalide';
			return $result;
		}
		if ($id == 4) {
			$this -> _mIsMenu = 1;
		} else {
			$this -> _mIsMenu = 0;
		}
		$this -> _mTypePlatID = $id;
		return $result;
	}

	public function GetTypePlat() {
		return $this -> _mTypePlatID;
	}

	//propriete IsMenu read only
	public function IsMenu() {
		return $this -> _mIsMenu;
	}

	//propriete read only prestanom
	public function GetPrestaNom() {
		return $this -> prestaNom;
	}

	//propriete menuPlatID
	public function SetMenuPlatID($id) {
		if ((!is_numeric($id)) || ($id < 1)) {
			$result = 'Valeur transmise invalide';
			return $result;
		} else {
			$this -> _mMenuPlatID;
		}
		return NULL;
	}

	public function GetMenuPlatID() {
		return $this -> _mMenuPlatID;
	}

	//propriete groupePlatNom
	public function SetGroupePlatNom($nom) {
		$nom = trim(stripslashes($nom));
		if (($nom == '') || ($nom == NULL)) {
			return 'Ce champs ne peut pas être vide';
		}
		if (!preg_match('/^[^<>"]{3,120}$/u', $nom)) {
			return 'Certains caractères sont invalides';
		}
		$this -> _mGroupePlatNom = $nom;
		return NULL;
	}

	//retrouve la liste des prestataires
	public static function GetPrestataireListe() {
		$sql = 'CALL get_all_presta_nom()';
		return DatabaseHandler::GetAll($sql);
	}

	//fonction pour retrouver la liste des TVA
	public static function GetTvaListe() {
		$sql = 'CALL get_all_tva_liste()';
		return DatabaseHandler::GetAll($sql);
	}

	//fonction pour retrouver la liste des types de plats
	public static function GetTypePlatList() {
		$sql = 'CALL get_all_typeplat_liste()';
		return DatabaseHandler::GetAll($sql);
	}

	//fonction pour voir si il y a des plats sur la bdd
	public static function HasPlat() {
		$sql = 'CALL get_plat_presta(:pID)';
		$param = array(':pID' => 0);
		$result = DatabaseHandler::GetOne($sql, $param);
		if ($result > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//retrouve le nombre de plat pour tous ou un prestataire
	public static function GetNumberPlat($id = 0) {
		$sql = 'CALL get_plat_presta(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour verifier qu'un prestataire a des plats
	public static function HasPrestaGotPlat($id) {
		$sql = 'CALL get_plat_presta(:pID)';
		$param = array(':pID' => $id);
		$result = DatabaseHandler::GetOne($sql, $param);
		if ($result > 0) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	//fonction pour retrouver le nom d'un prestataire
	public static function GetPrestaNomParID($id) {
		$sql = 'CALL get_presta_nom_parID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour sauvegarder un plat normal
	public function CreatePlat() {
		try {
			DatabaseHandler::SetBeginTransaction();
			$sql = 'CALL add_plat(:pID,:pNom,:pDesc,:pPrix,:pPromo,:tID,:pImage,:pActif,:typeID,:pMenu,:mID,:pGroupe)';
			$params = array(':pID' => $this -> _mPrestaID, ':pNom' => $this -> _mPlatNom, ':pDesc' => $this -> _mPlatDescription, ':pPrix' => $this -> _mPlatPrix, ':pPromo' => $this -> _mPlatPrixPromo, ':tID' => $this -> _mTvaID, ':pImage' => $this -> _mPlatImage, ':pActif' => $this -> _mPlatActif, ':typeID' => $this -> _mTypePlatID, ':pMenu' => $this -> _mIsMenu, ':mID' => $this -> _mMenuPlatID, ':pGroupe' => $this -> _mGroupePlatNom);
			$this -> _mPlatID = DatabaseHandler::GetOne($sql, $params);
			DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}

	}

	//fonction de mise à jour de plat
	public function UpdatePlat() {
		try {
			DatabaseHandler::SetBeginTransaction();
			$sql = 'CALL upd_plat_parID(:pID,:pNom,:pDesc,:pPrix,:pPromo,:tID,:pImage,:pActif,:tpID,:pIsMenu)';
			$params = array(':pID' => $this -> _mPlatID, ':pNom' => $this -> _mPlatNom, ':pDesc' => $this -> _mPlatDescription, ':pPrix' => $this -> _mPlatPrix, ':pPromo' => $this -> _mPlatPrixPromo, ':tID' => $this -> _mTvaID, ':pImage' => $this -> _mPlatImage, ':pActif' => $this -> _mPlatActif, ':tpID' => $this -> _mTypePlatID, ':pIsMenu' => $this -> _mIsMenu);
			DatabaseHandler::Execute($sql, $params);
			DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}
	}

	//change activite du plat
	public static function SetPlatEstActif($id) {
		$sql = 'CALL upd_plat_actif(:pID,:pActif)';
		$param = array(':pID' => $id, ':pActif' => 1);
		DatabaseHandler::Execute($sql, $param);
	}

	public static function SetPlatEstNonActif($id) {
		$sql = 'CALL upd_plat_actif(:pID,:pActif)';
		$param = array(':pID' => $id, ':pActif' => 0);
		DatabaseHandler::Execute($sql, $param);
	}

	//fonction pour retrouver la liste de plat d'un prestataire
	public static function GetPlatParID($id) {
		$sql = 'CALL get_plat_parID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour suprrimer un plat
	public static function DeletePlatParID($id) {
		$sql = 'CALL del_plat_parID(:pID)';
		$param = array(':pID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	public function GetPlatDetailParID($id) {
		$sql = 'CALL get_plat_detail_parID(:pID)';
		$param = array(':pID' => $id);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$this -> _mPlatID = $id;
			$this -> _mPlatNom = $row['platNom'];
			$this -> prestaNom = $row['prestaNom'];
			$this -> _mPlatDescription = $row['platDescription'];
			$this -> _mPlatPrix = $row['platPrix'];
			$this -> _mPlatPrixPromo = $row['platPrixPromo'];
			$this -> _mTvaID = $row['tvaID'];
			$this -> _mPlatImage = $row['platImage'];
			$this -> _mPlatActif = $row['platActif'];
			$this -> _mTypePlatID = $row['typePlatID'];
			$this -> _mIsMenu = $row['IsMenu'];
		}
	}
	
	//retrouve tous les plats d'un prestataire
	public static function GetPlatParPrestaID($id)
	{
		$sql = 'CALL get_plat_prestaID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetAll($sql,$param);
	}

}
