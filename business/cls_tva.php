<?php
//		cls_tva.php
//		fichier de classe tva
class Tva {
	private $_mTvaID;
	private $_mTvaNom;
	private $_mTvaTaux;
	private $_mIsUsed;

	public function Tva() {

	}

	//propriete id readonly
	public function GetTvaID() {
		return $this -> _mTvaID;
	}

	//propriete isUsed read only
	public function IsUsed() {
		return $this -> _mIsUsed;
	}

	//propriete nom read only
	public function GetTvaNom() {
		return $this -> _mTvaNom;
	}

	//propriete taux
	public function SetTvaTaux($taux) {
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
		if (($val < 1) || ($val > 99)) {
			$result = 'Le taux choisi n\'est pas valide.<br />Il doit être compris entre 1 et 99%';
			return $result;
		}
		if (is_null($result)) {
			//on a une chiffre
			$this -> _mTvaTaux = (floatval($val));
			if (substr_count($taux, '.') > 0) {
				$taux = str_replace('.', ',', $taux);
			}
			$this -> _mTvaNom = 'TVA au taux de ' . $taux . '%';
		}
		return $result;
	}

	public function GetTvaTaux() {
		return $this -> _mTvaTaux;
	}

	//fonction pour ajouter TVA
	public function AddTva() {
		$sql = 'CALL add_tva(:tNom,:tTaux)';
		$params = array(':tNom' => $this -> _mTvaNom, ':tTaux' => $this -> _mTvaTaux);
		$this -> _mTvaID = DatabaseHandler::GetOne($sql, $params);
	}

	//fonction pour retrouver la liste des TVA
	public static function GetTvaListe() {
		$sql = 'CALL get_all_tva_liste()';
		return DatabaseHandler::GetAll($sql);
	}

	//retrouve info tva par ID
	public function GetTvaParID($id) {
		$sql = 'CALL get_tva_parID(:tID)';
		$param = array(':tID' => $id);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$this -> _mTvaID = $id;
			$this -> _mTvaNom = $row['tvaNom'];
			$this -> _mTvaTaux = $row['tvaTaux'];
			$this -> _mIsUsed = $row['IsUsed'];
		}
	}

	//mets à jour info TVA
	public function UpdateTva() {
		$sql = 'CALL upd_tva_parID(:tID,:tNom,:tTaux)';
		$params = array(':tID' => $this -> _mTvaID, ':tNom' => $this -> _mTvaNom, ':tTaux' => $this -> _mTvaTaux);
		DatabaseHandler::Execute($sql, $params);
	}

	//supprime un taux de TVA
	public static function DeleteTvaParID($id) {
		$sql = 'CALL del_tva_parID(:tID)';
		$param = array(':tID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

}
