<?php
//		cls_commentaire
//		fichier de gestion des commentaires
class Commentaire {
	private $_mCommentaireID;
	private $_mCommentaireDate;
	private $_mClientID;
	private $_mClientNom;
	private $_mPrestaID;
	private $_mPrestaNom;
	private $_mCommentaireActif;
	private $_mCommentaireLu;
	private $_mCommentaireCourt;
	private $_mCommentaire;

	//propriete
	public function GetCommentaireID() {
		return $this -> _mCommentaireID;
	}

	public function GetCommentaireDate() {
		return $this -> _mCommentaireDate;
	}

	public function SetClientID($id) {
		if (!is_numeric($id)) {
			return 'Valeur transmise invalide';
		}
		$this -> _mClientID = $id;
		$this -> _mClientNom = $this -> GetClientNomParID($id);
	}

	public function GetClientID() {
		return $this -> _mClientID;
	}

	public function GetClientNom() {
		return $this -> _mClientNom;
	}

	public function SetPrestaID($id) {
		if (!is_numeric($id)) {
			return 'Valeur transmise invalide';
		}
		$this -> _mPrestaID;
		$this -> _mPrestaNom = $this -> GetPrestaNomParID($id);
	}

	public function GetPrestaID() {
		return $this -> _mPrestaID;
	}

	public function GetPrestaNom() {
		return $this -> _mPrestaNom;
	}

	public function SetCommentaireActif($id) {
		if (!is_numeric($id)) {
			return 'Valeur transmise invalide';
		}
		$this -> _mCommentaireActif;
	}

	public function GetCommentaireActif() {
		return $this -> _mCommentaireActif;
	}

	public function SetCommentaireLu($id) {
		if (!is_numeric($id)) {
			return 'Valeur transmise invalide';
		}
		$this -> _mCommentaireLu;
	}

	public function GetCommentaireLu() {
		return $this -> _mCommentaireLu;
	}

	public function SetCommentaire($desc) {
		$result = null;
		$desc = stripslashes($desc);
		if ((is_null($desc)) || ($desc == '')) {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,10000}$/u', $desc)) {
			$result = 'Certains caractères dans ce champ sont invalides';
			return $result;
		}
		$this -> _mCommentaire = $desc;
		if (strlen($desc) > 35) {
			$this -> _mCommentaireCourt = substr($desc, 0, 35) . '...';
		} else {
			$this -> _mCommentaireCourt = $desc;
		}
	}

	public function GetCommentaire() {
		return $this -> _mCommentaire;
	}

	public function GetCommentaireCourt() {
		return $this -> _mCommentaireCourt;
	}

	private function GetPrestaNomParID($id) {
		$sql = 'CALL get_presta_nom_parID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	private function GetClientNomParID($id) {
		$sql = 'CALL get_client_nom_parID(:cID)';
		$param = array(':cID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	public static function HasCommentaireInDB() {
		$sql = 'SELECT COUNT(*) FROM prg_commentaire';
		if (DatabaseHandler::GetOne($sql) > 0) {
			return true;
		} else {
			return FALSE;
		}
	}

	public function GetCommentaireParID($id) {
		$sql = 'CALL get_comm_parID(:cID)';
		$param = array(':cID' => $id);
		$row = array();
		$row = DatabaseHandler::GetRow($sql, $param);
		if (!empty($row)) {
			$this -> _mCommentaireID = $row['comteID'];
			$this -> _mCommentaireDate = date("d/m/Y", strtotime($row['comteDate']));
			$this -> _mClientID = $row['clientID'];
			$this -> _mClientNom = $this -> GetClientNomParID($row['clientID']);
			$this -> _mPrestaID = $row['prestaID'];
			$this -> _mPrestaNom = $this -> GetPrestaNomParID($row['prestaID']);
			$this -> _mCommentaire = $row['comteDescription'];
			if (strlen($row['comteDescription']) > 35) {
				$this -> _mCommentaireCourt = substr($row['comteDescription'], 0, 35) . '...';
			} else {
				$this -> _mCommentaireCourt = $row['comteDescription'];
			}
			$this -> _mCommentaireActif = $row['comteActif'];
			$this -> _mCommentaireLu = $row['comteLu'];
		}
	}

	public static function CommentaireSetActif($id) {
		$sql = 'CALL upd_activate_comm(:cID,:cActif)';
		$params=array(':cID'=>$id,':cActif'=>1);
		DatabaseHandler::Execute($sql,$params);
	}

	public static function CommentaireSetNonActif($id) {
		$sql = 'CALL upd_activate_comm(:cID,:cActif)';
		$params=array(':cID'=>$id,':cActif'=>0);
		DatabaseHandler::Execute($sql,$params);
	}
	
	public static function DeleteCommentaire($id){
		$sql = 'CALL del_commentaire(:cID)';
		$param =array(':cID'=>$id);
		DatabaseHandler::Execute($sql,$param);
	}
	
	public static function GetCommentaireNonLu(){
		$sql ='CALL get_comm_nonlu()';
		return DatabaseHandler::GetAll($sql);
	}
	
}
