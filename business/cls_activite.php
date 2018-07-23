<?php
//		cls_activite.php

//		classe des administrateurs

class Activite {
	private $_mDateDebutActivite;
	private $_mDateFinActivite;
	private $_mNbrClient;
	private $_mNbrCde;
	private $_mCAGene;
	private $_mComGene;
	private $_mComAnn;
	private $_mComVal;
	private $_mComPrep;
	private $_mComLiv;
	private $_mComTer;
	private $_mNbrVote;
	private $_mNbrComm;
	private $_mNbrCommAVal;
	private $_mHasActivite;

	//retourne l'activité
	public function HasActivite() {
		return $this -> _mHasActivite;
	}

	//retourne la date de la première commande
	public function GetDatePremiereComde() {
		return $this -> _mDateDebutActivite;
	}

	//retourne la date de la derniere commande
	public function GetDateDerniereComde() {
		return $this -> _mDateFinActivite;
	}

	//retourne le nombre de client
	public function GetNombreClient() {
		return $this -> _mNbrClient;
	}

	//retourne le nombre de commande
	public function GetNombreCommandeTotal() {
		return $this -> _mNbrCde;
	}

	//retourne le nombre de commande annulée
	public function GetNombreCommandeAnnule() {
		return $this -> _mComAnn;
	}

	//retourne le nombre de commande validée
	public function GetNombreCommandeValide() {
		return $this -> _mComVal;
	}

	//retourne le nombre de commande en preparation
	public function GetNombreCommandePreparation() {
		return $this -> _mComPrep;
	}

	//retourne le nombre de commande en livraison
	public function GetNombreCommandeLivraison() {
		return $this -> _mComLiv;
	}

	//retourne le nombre de commande terminée
	public function GetNombreCommandeTermine() {
		return $this -> _mComTer;
	}

	//retourne le CA généré
	public function GetCAGenere() {
		return $this -> _mCAGene;
	}

	//retourne la commission générée
	public function GetCommissionGenere() {
		return $this -> _mComGene;
	}

	//retourne le nombre de vote
	public function GetNombreVote() {
		return $this -> _mNbrVote;
	}

	//retourne le nombre de commentaire
	public function GetNombreCommentaire() {
		return $this -> _mNbrComm;
	}

	//retourne le nombre de commentaire à validé
	public function GetNombreCommentaireAValider() {
		return $this -> _mNbrCommAVal;
	}

	//creation des éléments de la classe
	public function GetActiviteDetails() {
		//on retruve les date de l'activité
		$sql = "CALL get_dates_commande()";
		$row = DatabaseHandler::GetRow($sql);
		$this -> _mDateDebutActivite = $row['mindate'];
		$this -> _mDateFinActivite = $row['maxdate'];
		if (is_null($row['mindate'])) {
			$this -> _mHasActivite = FALSE;
		} else {
			$this -> _mHasActivite = TRUE;
			//retrouve les autres données de base
			$sql = "CALL get_activite_stats()";
			$rows = DatabaseHandler::GetRow($sql);
			$this -> _mNbrClient = $rows['nbrClient'];
			$this -> _mNbrCde = $rows['nbrCde'];
			$this -> _mCAGene = $rows['caGene'];
			$this -> _mComGene = $rows['comGene'];
			$this -> _mComAnn = $rows['comAnn'];
			$this -> _mComVal = $rows['comVal'];
			$this -> _mComPrep = $rows['comPrep'];
			$this -> _mComLiv = $rows['comLiv'];
			$this -> _mComTer = $rows['comTer'];
			$this -> _mNbrVote = $rows['nbrVote'];
			$this -> _mNbrComm = $rows['nbrComm'];
			$this -> _mNbrCommAVal = $rows['nbrCommAVal'];
		}
	}

	//retrouve toutes les factures dues aux restataires
	public static function GetFacturesDues($date) {
		$sql = "CALL get_facture_due(:dDate)";
		$param = array('dDate' => $date);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve le header de la facture
	public static function GetFactureHeader($presta, $mois, $an) {
		$sql = "CALL get_factureheader(:pID,:mMonth,:mYear)";
		$params = array(':pID' => $presta, ':mMonth' => $mois, ':mYear' => $an);
		return DatabaseHandler::GetRow($sql, $params);
	}

	//retrouve le détails des commandes
	public static function GetFactureDetail($presta, $mois, $an) {
		$sql = "CALL get_facturedetails(:pID,:mMonth,:mYear)";
		$params = array(':pID' => $presta, ':mMonth' => $mois, ':mYear' => $an);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retouve les détails du prestataire
	public static function GetPrestaDetails($presta) {
		$sql = "CALL get_presta_detail_parID(:pID)";
		$param = array(':pID' => $presta);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//met à jour la facture
	public static function UpdateFactureEditer($presta, $mois, $an) {
		$sql = "CALL upd_facture_fini(:pID,:mMonth,:mYear)";
		$params = array(':pID' => $presta, ':mMonth' => $mois, ':mYear' => $an);
		DatabaseHandler::Execute($sql, $params);
	}

	//retrouve le premier et dernier jour d'activité
	public static function GetDateActivite() {
		$sql = "CALL get_date_activite()";
		$row = DatabaseHandler::GetRow($sql);
		if (is_null($row['minDate'])) {
			return null;
		} else {
			return $row;
		}
	}

	//retroue le detail activite par an
	public static function GetActiviteAnnuelle($pyear) {
		$sql = "CALL get_activite(:yID)";
		$param = array(':yID' => $pyear);
		//creation des mois
		$mois = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
		$data = DatabaseHandler::GetAll($sql, $param);
		for ($d = 0; $d < count($data); $d++) {
			$mois[$data[$d]['cMonth'] - 1] = $data[$d];
		}
		return $mois;
	}

	//prepare le data a afficher
	public static function PrepData($data, $money) {
		if ($data > 0) {
			if ($money == TRUE) {
				return sprintf("%01.2f", $data);
			} else {
				return $data;
			}
		} else {
			return '';
		}
	}

	//calcul de la moyenne par cde
	public static function MoyenneComCde($com, $cde) {
		if (($com != 0) && ($cde != 0)) {
			return sprintf("%01.2f", $com / $cde);
		} else {
			return '';
		}
	}

	//retrouve la liste de tous les prestataires
	public static function GetPrestaListe() {
		$sql = "CALL get_all_presta_nom()";
		return DatabaseHandler::GetAll($sql);
	}

	//retourne timestamp de date au format dd/mm/yyyy
	public static function GetTimestamp($date) {
		$mdte = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
		return strtotime($mdte);
	}

	//format une date pour debut fin de période
	public static function FormatTimeForAct($date, $end) {
		$mdte = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
		if ($end == TRUE) {
			$mdte .= ' 23:59:59';
		} else {
			$mdte .= ' 00:00:00';
		}
		return $mdte;
	}

	//format une heure
	public static function FormatHeure($heure){
		return substr($heure, 0,2).'h'.substr($heure, 3,2);
	}
	
	//retrouve le data d'activité
	public static function GetActivitePeriodePresta($presta, $datein, $dateout, $isday) {
		$sql = "CALL get_presta_drill_detail(:pID,:iDate,:oDate,:byDay)";
		$params = array(':pID' => $presta, ':iDate' => $datein, ':oDate' => $dateout, ':byDay' => $isday);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retrouve le nom d'un prestataire par id
	public static function GetPrestaNomParID($prestaid) {
		$sql = "CALL get_presta_nom_parID(:pID)";
		$param = array(':pID' => $prestaid);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//format heure login
	public static function FormatHeureConnexion($date) {
		if (trim($date) == '') {
			return '';
		}
		$mdate = substr($date, 11, 2) . 'h' . substr($date, 14, 2);
		return $mdate;
	}
	
	//retrouve l'activité du jour
	public static function GetDailyActivite($date){
		$sql = "CALL get_daily_activite(:dDate)";
		$param = array(':dDate'=>$date);
		return DatabaseHandler::GetAll($sql,$param);
	}
	
	//retrouve audit prestataire
	public static function GetPrestaAudit($inDate,$endDate,$presta){
		$sql = "CALL get_all_presta_audit(:iDate,:eDate,:pID)";
		$params=array(':iDate'=>$inDate,':eDate'=>$endDate,':pID'=>$presta);
		return DatabaseHandler::GetAll($sql,$params);
	}

}
