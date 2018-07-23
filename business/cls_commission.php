<?php
//		cls_commission.php
//		fichier de classe des commission

class Commission {
	private $_mComID;
	private $_mComNom;
	private $_mComTaux;
	private $_mIsUsed;

	public function Commission() {

	}

	//propriété ID readonly
	public function GetCommissionID() {
		return $this -> _mComID;
	}

	//propriété IsUsed read only
	public function IsUsed() {
		return $this -> _mIsUsed;
	}

	//propriété nom
	public function SetCommissionNom($nom) {
		$result = NULL;
		$nom = stripslashes($nom);
		if ($nom == '') {
			$result = 'Ce champs ne doit pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,60}$/i', $nom)) {
			$result = 'Certains caract&egrave;res du nom de la commission sont interdits';
			return $result;
		}
		if ($result == NULL) {
			$this -> _mComNom = $nom;
		}
		return $result;
	}

	public function GetCommissionNom() {
		return $this -> _mComNom;
	}

	//propriete taux
	public function SetCommissionTaux($taux) {
		$result = NULL;
		$taux = trim($taux);
		//verifier qu'il n'y a pas le signe pourcentage
		if (substr_count($taux, '%') > 0) {
			$taux = str_replace('%', '', $taux);
		}
		//on enlève les espaces
		$taux = str_replace(' ', '', $taux);
		$val = $taux;
		if (substr_count($taux, ',') > 0) {
			$val = str_replace(',', '.', $taux);
		}
		if (!is_numeric($val)) {
			$result = 'La valeur du taux n\'est pas numérique';
			return $result;
		}
		if (($val < 0) || ($val > 99)) {
			$result = 'Le taux choisi n\'est pas valide.<br />Il doit être compris entre 1 et 99%';
			return $result;
		}
		if (is_null($result)) {
			//on a une chiffre
			$this -> _mComTaux = (floatval($val));
		}
		return $result;
	}

	public function GetCommissionTaux() {
		return $this -> _mComTaux;
	}

	//ajouter un taux de commission
	public function AddCommission() {
		$sql = 'CALL add_commission(:cNom,:cTaux)';
		$params = array(':cNom' => $this -> _mComNom, ':cTaux' => $this -> _mComTaux);
		$this -> _mComID = DatabaseHandler::GetOne($sql, $params);
	}

	//retrouve la liste des commission
	public static function GetAllCommissionListe() {
		$sql = 'CALL get_all_commission_liste()';
		return DatabaseHandler::GetAll($sql);
	}

	//retrouve les détails d'une commission par ID
	public function GetCommissionParID($id) {
		$sql = 'CALL get_commission_parID(:monID)';
		$param = array(':monID' => $id);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$this -> _mComID = $id;
			$this -> _mComNom = $row['commissionNom'];
			$this -> _mComTaux = $row['commissionTaux'];
			$this -> _mIsUsed = $row['IsUsed'];

		}
	}

	//supprime un taux de commission
	public static function DeleteCommissionParID($id) {
		$sql = 'CALL del_commission_parID(:monID)';
		$param = array(':monID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	//mets à jour la commission
	public function UpdateCommission() {
		$sql = 'CALL upd_commission_parID(:monID,:cNom,:cTaux)';
		$params = array(':monID' => $this -> _mComID, ':cNom' => $this -> _mComNom, ':cTaux' => $this -> _mComTaux);
		DatabaseHandler::Execute($sql, $params);
	}

}
