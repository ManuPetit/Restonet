<?php
//		cls_prestataire.php
//		fichier de classe prestataire

class Prestataire extends User {
	private $_mPrestaID;
	private $_mPrestaNom;
	private $_mPrestaAdresse1;
	private $_mPrestaAdresse2;
	private $_mVilleID;
	private $_mPrestaTelephone;
	private $_mPrestaImage;
	private $_mPrestaDelaiPrep;
	private $_mPrestaDesc;
	private $_mPrestaActif;
	private $_mPrestaNote;
	private $_mPrestaVote;
	private $_mPrestaCongeDebut;
	private $_mPrestaCongeFin;
	private $_mPrestaComdeMaxi;
	private $_mCommissionID;
	private $_mMiseValeurID;
	private $_mCategorieID = array();
	private $_mHoraire = array();
	private $_mTypeLivraison = array();
	private $_mVilleLivraison = array();
	private $m_IsUsed;
	private $_mPrestaCodePostal;
	private $_mPrestaVille;
	private $dateCheck;
	private $HasLivraison = FALSE;
	private $ville;
	private $villeLivraison = array();
	private $flaghoraire = FALSE;

	//propriete User.pseudo
	public function SetPrestaPseudo($pseudo) {
		$result = NULL;
		$result = parent::SetPseudo($pseudo);
		return $result;
	}

	public function GetPrestaPseudo() {
		return parent::GetPseudo();
	}

	//propriete User.email
	public function SetPrestaEmail($email) {
		$result = NULL;
		$result = parent::SetEmail($email);
		return $result;
	}

	public function GetPrestaEmail() {
		return parent::GetEmail();
	}

	//propriete User.mdp	write only
	public function SetPrestaMotDePasse($mdp) {
		$result = null;
		$result = parent::SetMotDePasse($mdp);
		return $result;
	}

	//propriete User.prenom
	public function SetPrestaPrenom($prenom) {
		$result = null;
		$result = parent::SetPrenom($prenom);
		return $result;
	}

	public function GetPrestaPrenom() {
		return parent::GetPrenom();
	}

	//propriete User.nom
	public function SetPrestaNom($nom) {
		$result = NULL;
		$result = parent::SetNom($nom);
		return $result;
	}

	public function GetPrestaNom() {
		return parent::GetNom();
	}

	//propriete User.niveau read only
	public function GetPrestaNiveau() {
		return parent::GetNiveau();
	}

	//propriete User.UserID Read only
	public function GetPrestaUserID() {
		return parent::GetUserID();
	}

	//propriete Code Postal read only
	public function GetPrestaCodePostal() {
		return $this -> _mPrestaCodePostal;
	}

	//propriete ville read only
	public function GetPrestaVille() {
		return $this -> _mPrestaVille;
	}

	//propriete ID read only
	public function GetPrestaID() {
		return $this -> _mPrestaID;
	}

	//propriete Nom
	public function SetPrestaNomCommercial($nom) {
		$result = NULL;
		$nom = trim(stripslashes($nom));
		if ($nom == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,100}$/i', $nom)) {
			$result = 'Des caractères non valides ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mPrestaNom = $nom;
		return $result;
	}

	public function GetPrestaNomCommercial() {
		return stripslashes($this -> _mPrestaNom);
	}

	//propriete Adresse1
	public function SetPrestaAdresse1($adresse1) {
		$result = NULL;
		$adresse1 = trim(stripslashes($adresse1));
		if ($adresse1 == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (strlen($adresse1) > 60) {
			$result = 'L\'adresse ne peut pas faire plus de 60 caractères';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,60}$/i', $adresse1)) {
			$result = 'Des caractères non valides ont été saisis dans l\'adresse';
			return $result;
		}
		$this -> _mPrestaAdresse1 = $adresse1;
		return $result;
	}

	public function GetPrestaAdresse1() {
		return stripslashes($this -> _mPrestaAdresse1);
	}

	//propriete adresse2
	public function SetPrestaAdresse2($adresse2) {
		$result = NULL;
		$adresse2 = trim($adresse2);
		if (($adresse2 == '') || ($adresse2 == NULL)) {
			$this -> _mPrestaAdresse2 = NULL;
			return $result;
		}
		$adresse2=stripslashes($adresse2);
		if (strlen($adresse2) > 60) {
			$result = 'L\'adresse ne peut pas faire plus de 60 caractères';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,60}$/i', $adresse2)) {
			$result = 'Des caractères non valides ont été saisis dans l\'adresse';
			return $result;
		}
		$this -> _mPrestaAdresse2 = $adresse2;
		return $result;
	}

	public function GetPrestaAdresse2() {
		return stripslashes($this -> _mPrestaAdresse2);
	}

	//propriete ville
	public function SetPrestaVilleID($ville) {
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

	public function GetPrestaVilleID() {
		return stripslashes($this -> _mVilleID);
	}

	//propriete read only pour renvoyé la ville
	public function GetPrestaVilleCP() {
		return $this -> ville;
	}

	//propriete telephone
	public function SetPrestaTelephone($telephone) {
		$result = NULL;
		if (trim($telephone) == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[0-9]{10}$/i', trim($telephone)))
			$result = 'Le num&eacute;ro ne peut contenir que et seulement 10 chiffres';
		if ($result == NULL)
			$this -> _mPrestaTelephone = trim($telephone);
		return $result;
	}

	public function GetPrestaTelephone() {
		return $this -> _mPrestaTelephone;
	}

	//Propriete image
	public function SetPrestaImage($image) {
		$image = trim($image);
		if (($image == '') || ($image == NULL)) {
			$this -> _mPrestaImage = NULL;
		} else {
			if (stristr($image, '_pre') === FALSE) {
				$vars = explode('.', $image);
				$image = $vars[0] . '_pre.' . $vars[1];
			}
			$this -> _mPrestaImage = $image;
		}
	}

	public function GetPrestaImage() {
		return $this -> _mPrestaImage;
	}

	//propriete Delai préparation en minutes
	public function SetPrestaDelaiPrep($delai) {
		if (!preg_match('/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/', $delai)) {
			return 'Valeur invalide';
		} else {
			$this -> _mPrestaDelaiPrep = $delai;
		}
	}

	public function GetPrestaDelaiPrep() {
		return $this -> _mPrestaDelaiPrep;
	}

	//propriete description
	public function SetPrestaDescription($desc) {
		$result = null;
		$desc = trim(stripslashes($desc));
		if ((is_null($desc)) || ($desc == '')) {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{6,10000}$/u', $desc)) {
			$result = 'Certains caractères dans ce champ sont invalides';
			return $result;
		}
		$this -> _mPrestaDesc = $desc;
		return $result;
	}

	public function GetPrestaDescription() {
		return stripslashes($this -> _mPrestaDesc);
	}

	//propriete actif
	public function SetPrestaActif($actif) {
		$result = NULL;
		if (!is_numeric($actif)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mPrestaActif = $actif;
		}
		return $result;
	}

	public function GetPrestaActif() {
		return $this -> _mPrestaActif;
	}

	//propriete Note read only
	public function GetPrestaNote() {
		return $this -> _mPrestaNote;
	}

	//propriete Vote read only
	public function GetPrestaVote() {
		return $this -> _mPrestaVote;
	}

	//retourne la note moyenne du prestataire
	public function GetPrestaNoteMoyenne() {
		if (($this -> _mPrestaNote > 0) && ($this -> _mPrestaVote > 0)) {
			return round($this -> _mPrestaNote / $this -> _mPrestaVote);
		} else {
			return 0;
		}
	}

	//propriete horaires
	public function SetHoraire($horaire) {
		//remise à zero de l'array
		$this -> _mHoraire = array();
		$this -> _mHoraire = $horaire;
	}

	public function GetHoraire() {
		return $this -> _mHoraire;
	}

	//propriete congé debut
	public function SetCongeDebut($date) {
		$newdate = $this -> SplitToDate($date, FALSE);
		$this -> dateCheck = $newdate;
		$this -> _mPrestaCongeDebut = date('Y-m-d H:i:s', $newdate);
	}

	public function GetCongeDebut() {
		if (!is_null($this -> _mPrestaCongeDebut)) {
			$ladate = new DateTime($this -> _mPrestaCongeDebut);
			return date_format($ladate, 'd/m/Y');
		} else {
			return '';
		}
	}

	//propriete congé debut
	public function SetCongeFin($date) {
		$result = NULL;
		$newdate = $this -> SplitToDate($date, TRUE);
		//verifier la différence entre les dates
		if ($newdate > $this -> dateCheck) {
			$this -> _mPrestaCongeFin = date('Y-m-d H:i:s', $newdate);
		} else {
			return 'Cette date est antérieure par rapport à la date de début de congé';
		}
		return $result;
	}

	public function GetCongeFin() {
		if (!is_null($this -> _mPrestaCongeFin)) {
			$ladate = new DateTime($this -> _mPrestaCongeFin);
			return date_format($ladate, 'd/m/Y');
		} else {
			return '';
		}
	}

	//fonction pour comparer les horaires passés avec les anciens lors de la modification
	public function CompareHoraires($horaires) {
		$this -> flaghoraire = FALSE;
		for ($i = 0; $i < 14; $i++) {
			if ($this -> _mHoraire[$i]['debut'] != $horaires[$i]['debut']) {
				$this -> _mHoraire[$i]['debut'] = $horaires[$i]['debut'];
				$this -> flaghoraire = TRUE;
			}
			if ($this -> _mHoraire[$i]['fin'] != $horaires[$i]['fin']) {
				$this -> _mHoraire[$i]['fin'] = $horaires[$i]['fin'];
				$this -> flaghoraire = TRUE;
			}
		}
	}

	//propriete commande maxi par plage horaire
	public function SetComdeMaxi($max) {
		$result = null;
		if (!is_numeric($max)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mPrestaComdeMaxi = $max;
		}
		return $result;
	}

	public function GetComdeMaxi() {
		return $this -> _mPrestaComdeMaxi;
	}

	//propriete pour commission
	public function SetPrestaCommissionID($id) {
		$result = NULL;
		if (!is_numeric($id)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mCommissionID = $id;
		}
		return $result;
	}

	public function GetPrestaCommissionID() {
		return $this -> _mCommissionID;
	}

	//propriete pour la mise en valuer
	public function SetPrestaMiseEnValeur($id) {
		$result = null;
		if (!is_numeric($id)) {
			$result = 'Valeur transmise invalide';
		} else {
			$this -> _mMiseValeurID = $id;
		}
		return $result;
	}

	public function GetPrestaMiseEnValeur() {
		return $this -> _mMiseValeurID;
	}

	//propriété categorieID
	public function SetPrestaCategories($params) {
		//remise à zero de l'array
		$this -> _mCategorieID = array();
		$result = NULL;
		foreach ($params as $val) {
			if (!is_numeric($val)) {
				$result = 'Valeur transmise invalide';
				return $result;
			} else {
				$this -> _mCategorieID[] = $val;
			}
		}
		return $result;
	}

	public function GetPrestaCategories() {
		return $this -> _mCategorieID;
	}

	//propriete type livraison
	public function SetPrestaTypeLivraison($params) {
		//remise à zero de l'array
		$this -> _mTypeLivraison = array();
		$result = NULL;
		foreach ($params as $val) {
			if (!is_numeric($val)) {
				$result = 'Valeur transmise invalide';
				return $result;
			} else {
				if ($val == 1) {
					$this -> HasLivraison = TRUE;
				}
				$this -> _mTypeLivraison[] = $val;
			}
		}
		return $result;
	}

	public function GetPrestaTypeLivraison() {
		return $this -> _mTypeLivraison;
	}

	//propriete read only pour retourner la ville et code postale
	public function GetVilleEtCP() {
		return $this -> ville;
	}

	//propriete read only HasLivraison
	public function PrestataireEstLivreur() {
		return $this -> HasLivraison;
	}

	//propriete ville livraison
	public function SetPrestaVilleLivraison($villeid) {
		$result = NULL;
		if (!is_numeric($villeid)) {
			$result = 'Valeur transmise invalide';
			return $result;
		} else {
			$this -> _mVilleLivraison[] = $villeid;
		}
		return $result;
	}

	public function GetPrestaVilleLivraison() {
		return $this -> _mVilleLivraison;
	}

	//propriete retourne lezs nom des villes de livraison
	public function GetVilleLivraisonListe() {
		return $this -> villeLivraison;
	}

	//function pour splitter une date et la transformer en date
	private function SplitToDate($date, $fin) {
		$var = explode('/', $date);
		if ($fin == TRUE) {
			return mktime(23, 59, 59, $var[1], $var[0], $var[2]);
		} else {
			return mktime(0, 0, 0, $var[1], $var[0], $var[2]);
		}
	}

	//public fonction pour sauvegarder prestataire
	public function SavePrestaDetails() {
		parent::SetNiveau(3);
		DatabaseHandler::SetBeginTransaction();
		try {
			//creation du user
			parent::CreateUser();
			//creation du prestataire
			$sql = 'CALL add_prestataire(:uID,:pNom,:pAdresse1,:pAdresse2,:vID,:pTel,:pImage,:pDelai,:pDesc,:pActif,:pConDe,:pConFin,:pComMax,:cID,:valID)';
			$params = array(':uID' => parent::GetUserID(), ':pNom' => $this -> _mPrestaNom, ':pAdresse1' => $this -> _mPrestaAdresse1, ':pAdresse2' => $this -> _mPrestaAdresse2, ':vID' => $this -> _mVilleID, ':pTel' => $this -> _mPrestaTelephone, ':pImage' => $this -> _mPrestaImage, ':pDelai' => $this -> _mPrestaDelaiPrep, ':pDesc' => $this -> _mPrestaDesc, ':pActif' => $this -> _mPrestaActif, ':pConDe' => $this -> _mPrestaCongeDebut, ':pConFin' => $this -> _mPrestaCongeFin, ':pComMax' => $this -> _mPrestaComdeMaxi, ':cID' => $this -> _mCommissionID, ':valID' => $this -> _mMiseValeurID);
			$this -> _mPrestaID = DatabaseHandler::GetOne($sql, $params);
			//enregistrer les categories
			$sql = 'CALL add_cat_prestataire(:cID,:pID)';
			foreach ($this->_mCategorieID as $val) {
				$params = array(':cID' => $val, ':pID' => $this -> _mPrestaID);
				DatabaseHandler::Execute($sql, $params);
			}
			//enregistrer les villes de livraisons
			$sql = 'CALL add_lieu_livraison(:vID,:pID)';
			foreach ($this->_mVilleLivraison as $val) {
				$params = array(':vID' => $val, ':pID' => $this -> _mPrestaID);
				DatabaseHandler::Execute($sql, $params);
			}
			//enregistrer les types de livraisons
			$sql = 'CALL add_presta_livraison(:pID,:lID)';
			foreach ($this->_mTypeLivraison as $val) {
				$params = array(':pID' => $this -> _mPrestaID, ':lID' => $val);
				DatabaseHandler::Execute($sql, $params);
			}
			//ajouter les horaires
			$sql = 'CALL add_horaire(:pID,:jID,:dID,:fID)';
			for ($i = 0; $i < count($this -> _mHoraire); $i++) {
				if (($this -> _mHoraire[$i]['debut'] != 0)) {
					$params = array(':pID' => $this -> _mPrestaID, ':jID' => $this -> _mHoraire[$i]['jour'], ':dID' => $this -> _mHoraire[$i]['debut'], ':fID' => $this -> _mHoraire[$i]['fin']);
					DatabaseHandler::Execute($sql, $params);
				}
			}
			DatabaseHandler::CommitTransaction();
			//vérification d'activation des region/dept
			$sql = 'CALL upd_activation_parvilleid(:ville_id)';
			$param = array(':ville_id' => $this -> _mVilleID);
			DatabaseHandler::Execute($sql, $param);

		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}
	}

	//fonction de mise à jour des prestataires
	public function UpdatePrestataire() {
		DatabaseHandler::SetBeginTransaction();
		try {
			//mise à jour parent
			parent::UpdateUserParID();
			//mise à jour details
			$sql = 'CALL upd_presta_parID(:pID,:pNom,:pAdresse1,:pAdresse2,:vID,:pTel,:pImage,:pDelai,:pDesc,:pActif,:pConDe,:pConFin,:pComMax,:cID,:valID)';
			$params = array(':pID' => $this -> _mPrestaID, ':pNom' => $this -> _mPrestaNom, ':pAdresse1' => $this -> _mPrestaAdresse1, ':pAdresse2' => $this -> _mPrestaAdresse2, ':vID' => $this -> _mVilleID, ':pTel' => $this -> _mPrestaTelephone, ':pImage' => $this -> _mPrestaImage, ':pDelai' => $this -> _mPrestaDelaiPrep, ':pDesc' => $this -> _mPrestaDesc, ':pActif' => $this -> _mPrestaActif, ':pConDe' => $this -> _mPrestaCongeDebut, ':pConFin' => $this -> _mPrestaCongeFin, ':pComMax' => $this -> _mPrestaComdeMaxi, ':cID' => $this -> _mCommissionID, ':valID' => $this -> _mMiseValeurID);
			DatabaseHandler::Execute($sql, $params);
			//misaj categorie d'abord on les enlèves toutes
			$sql = 'CALL del_cat_prestataire(:pID)';
			$params = array(':pID' => $this -> _mPrestaID);
			DatabaseHandler::Execute($sql, $params);
			//enregistrer les categories
			$sql = 'CALL add_cat_prestataire(:cID,:pID)';
			foreach ($this->_mCategorieID as $val) {
				$params = array(':cID' => $val, ':pID' => $this -> _mPrestaID);
				DatabaseHandler::Execute($sql, $params);
			}
			//misaj ville livraisons on les enleves
			$sql = 'CALL del_lieu_livraison(:pID)';
			$params = array(':pID' => $this -> _mPrestaID);
			DatabaseHandler::Execute($sql, $params);
			//enregistrer les villes de livraisons
			$sql = 'CALL add_lieu_livraison(:vID,:pID)';
			foreach ($this->_mVilleLivraison as $val) {
				$params = array(':vID' => $val, ':pID' => $this -> _mPrestaID);
				DatabaseHandler::Execute($sql, $params);
			}
			//misaj type livraison on eleve tout
			$sql = 'CALL del_presta_livraison(:pID)';
			$params = array(':pID' => $this -> _mPrestaID);
			DatabaseHandler::Execute($sql, $params);
			//enregistrer les types de livraisons
			$sql = 'CALL add_presta_livraison(:pID,:lID)';
			foreach ($this->_mTypeLivraison as $val) {
				$params = array(':pID' => $this -> _mPrestaID, ':lID' => $val);
				DatabaseHandler::Execute($sql, $params);
			}
			//misaj horaire on eleve tout
			$sql = 'CALL del_horaire(:pID)';
			$params = array(':pID' => $this -> _mPrestaID);
			DatabaseHandler::Execute($sql, $params);
			//ajouter les horaires
			$sql = 'CALL add_horaire(:pID,:jID,:dID,:fID)';
			for ($i = 0; $i < count($this -> _mHoraire); $i++) {
				if (($this -> _mHoraire[$i]['debut'] != 0)) {
					$params = array(':pID' => $this -> _mPrestaID, ':jID' => $this -> _mHoraire[$i]['jour'], ':dID' => $this -> _mHoraire[$i]['debut'], ':fID' => $this -> _mHoraire[$i]['fin']);
					DatabaseHandler::Execute($sql, $params);
				}
			}

			DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}

	}

	//fonction pour retourner les listes d'horaire formatée
	public function RetourneListeHoraire($presta = null) {
		$heures = array(1 => 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
		$sql = 'CALL get_presta_horaire_formater(:pID)';
		$param = array(':pID' => $this -> _mPrestaID);
		$result = array();
		$result = DatabaseHandler::GetAll($sql, $param);
		if (!empty($result)) {
			for ($i = 0; $i < count($result); $i++) {
				switch ($result[$i]['jourID']) {
					case 1 :
						if ($heures[1] == 'Lundi') {
							$heures[1] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[1] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					case 2 :
						if ($heures[2] == 'Mardi') {
							$heures[2] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[2] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					case 3 :
						if ($heures[3] == 'Mercredi') {
							$heures[3] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[3] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					case 4 :
						if ($heures[4] == 'Jeudi') {
							$heures[4] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[4] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					case 5 :
						if ($heures[5] == 'Vendredi') {
							$heures[5] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[5] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					case 6 :
						if ($heures[6] == 'Samedi') {
							$heures[6] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[6] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					case 7 :
						if ($heures[7] == 'Dimanche') {
							$heures[7] .= ' : de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						} else {
							$heures[7] .= ' et de ' . $result[$i]['plageDebut'] . ' à ' . $result[$i]['plageFin'];
						}
						break;
					default :
						break;
				}
			}
			if ($heures[1] == 'Lundi') {
				$heures[1] .= ' : Fermé';
			}
			if ($heures[2] == 'Mardi') {
				$heures[2] .= ' : Fermé';
			}
			if ($heures[3] == 'Mercredi') {
				$heures[3] .= ' : Fermé';
			}
			if ($heures[4] == 'Jeudi') {
				$heures[4] .= ' : Fermé';
			}
			if ($heures[5] == 'Vendredi') {
				$heures[5] .= ' : Fermé';
			}
			if ($heures[6] == 'Samedi') {
				$heures[6] .= ' : Fermé';
			}
			if ($heures[7] == 'Dimanche') {
				$heures[7] .= ' : Fermé';
			}
			return $heures;
		}
		return NULL;
	}

	//fonction pour retrouver la liste des prestataires
	public static function GetAllPrestaNomID() {
		$sql = 'CALL get_all_presta_nom()';
		return DatabaseHandler::GetAll($sql);
	}

	//change activite du prestataire
	public static function SetPrestaEstActif($id) {
		$sql = 'CALL upd_presta_actif(:pID,:pActif)';
		$param = array(':pID' => $id, ':pActif' => 1);
		DatabaseHandler::Execute($sql, $param);
	}

	public static function SetPrestaEstNonActif($id) {
		$sql = 'CALL upd_presta_actif(:pID,:pActif)';
		$param = array(':pID' => $id, ':pActif' => 0);
		DatabaseHandler::Execute($sql, $param);
	}

	//renvoi le nom d'une ensiegne selon ID
	public static function GetNomParID($id) {
		$sql = 'CALL get_presta_nom_parID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour retrouver les détails d'un prestataire
	public function GetPrestaParID($id) {
		//retrouver les détails du prestataire
		$sql = 'CALL get_presta_detail_parID(:pID)';
		$param = array(':pID' => $id);
		$rows = array();
		$rows = DatabaseHandler::GetRow($sql, $param);
		if (!empty($rows)) {
			$uID = $rows['userID'];
			$this -> _mPrestaNom = $rows['prestaNom'];
			$this -> _mPrestaAdresse1 = $rows['prestaAdresse1'];
			$this -> _mPrestaAdresse2 = $rows['prestaAdresse2'];
			$this -> _mVilleID = $rows['villeID'];
			$this -> ville = $rows['villeNom'] . ' - (' . $rows['villeCP'] . ')';
			$this -> _mPrestaVille = $rows['villeNom'];
			$this -> _mPrestaCodePostal = $rows['villeCP'];
			$this -> _mPrestaTelephone = $rows['prestaTelephone'];
			$this -> _mPrestaActif = $rows['prestaActif'];
			$this -> _mPrestaImage = $rows['prestaImage'];
			$this -> _mPrestaDelaiPrep = $rows['prestaDelaiPrep'];
			$this -> _mPrestaDesc = $rows['prestaDescription'];
			$this -> _mPrestaCongeDebut = $rows['prestaCongeDebut'];
			if (!is_null($this -> _mPrestaCongeDebut)) {
				$this -> dateCheck = $this -> _mPrestaCongeDebut;
			}
			$this -> _mPrestaVote = $rows['prestaVote'];
			$this -> _mPrestaNote = $rows['prestaNote'];
			$this -> _mPrestaCongeFin = $rows['prestaCongeFin'];
			$this -> _mPrestaComdeMaxi = $rows['prestaComdeMaxi'];
			$this -> _mCommissionID = $rows['commissionID'];
			$this -> _mMiseValeurID = $rows['miseValeurID'];
			parent::GetUserParID($uID);
			$this -> _mPrestaID = $id;
			//retrouve les categories du prestataire
			$sql = 'CALL get_catprestataire_parID(:pID)';
			$rows = array();
			$rows = DatabaseHandler::GetAll($sql, $param);
			if (!empty($rows)) {
				for ($i = 0; $i < count($rows); $i++) {
					$this -> _mCategorieID[] = $rows[$i]['categorieID'];
				}
			}
			//retrouver les plages horaires
			$sql = 'CALL get_presta_horaire_parID(:pID)';
			$rows = array();
			$rows = DatabaseHandler::GetAll($sql, $param);
			if (!empty($rows)) {
				$this -> _mHoraire = array();
				$j = 1;
				for ($i = 0; $i < 14; $i += 2) {
					$this -> _mHoraire[$i] = array('jour' => $j, 'debut' => 0, 'fin' => 0);
					$this -> _mHoraire[$i + 1] = array('jour' => $j, 'debut' => 0, 'fin' => 0);
					$j++;
				}
				for ($i = 0; $i < count($rows); $i++) {
					switch ($rows[$i]['jourID']) {
						case 1 :
							if ($this -> _mHoraire[0]['debut'] == 0) {
								$this -> _mHoraire[0]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[0]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[1]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[1]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
						case 2 :
							if ($this -> _mHoraire[2]['debut'] == 0) {
								$this -> _mHoraire[2]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[2]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[3]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[3]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
						case 3 :
							if ($this -> _mHoraire[4]['debut'] == 0) {
								$this -> _mHoraire[4]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[4]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[5]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[5]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
						case 4 :
							if ($this -> _mHoraire[6]['debut'] == 0) {
								$this -> _mHoraire[6]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[6]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[7]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[7]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
						case 5 :
							if ($this -> _mHoraire[8]['debut'] == 0) {
								$this -> _mHoraire[8]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[8]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[9]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[9]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
						case 6 :
							if ($this -> _mHoraire[10]['debut'] == 0) {
								$this -> _mHoraire[10]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[10]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[11]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[11]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
						case 7 :
							if ($this -> _mHoraire[12]['debut'] == 0) {
								$this -> _mHoraire[12]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[12]['fin'] = $rows[$i]['plageHorFin'];
							} else {
								$this -> _mHoraire[13]['debut'] = $rows[$i]['plageHorDebut'];
								$this -> _mHoraire[13]['fin'] = $rows[$i]['plageHorFin'];
							}
							break;
					}

				}
			}
			//retrouver les type de livraison
			$sql = 'CALL get_presta_livraison_parID(:pID)';
			$rows = array();
			$rows = DatabaseHandler::GetAll($sql, $param);
			if (!empty($rows)) {
				for ($i = 0; $i < count($rows); $i++) {
					$this -> _mTypeLivraison[] = $rows[$i]['livraisonID'];
					if ($rows[$i]['livraisonID'] == 1) {
						$this -> HasLivraison = TRUE;
					}
				}
			}
			//retrouver les villes de livraison
			$sql = 'CALL get_presta_villelivraison_parID(:pID)';
			$rows = array();
			$rows = DatabaseHandler::GetAll($sql, $param);
			if (!empty($rows)) {
				for ($i = 0; $i < count($rows); $i++) {
					$this -> _mVilleLivraison[] = $rows[$i]['villeID'];
					$this -> villeLivraison[] = $rows[$i]['ville'];
				}
			}

		}
	}

	//detruit un prestataire et l'ensemble de ses données, commentaire et plats
	public static function DeletePrestataire($id) {
		$sql = 'CALL del_prestataire(:pID)';
		$param = array(':pID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	public function GetLivraisonTypeParID() {
		$sql = 'CALL get_presta_livraison_parID(:pID)';
		$param = array(':pID' => $this -> _mPrestaID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	public function GetCategorieNom() {
		$sql = 'CALL get_categorie_nom_display(:pID)';
		$param = array(':pID' => $this -> _mPrestaID);
		return DatabaseHandler::GetAll($sql, $param);
		;
	}

	public static function GetTousCommentaires($id) {
		$sql = 'CALL get_commentaires_prestaID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetAll($sql, $param);
	}

	public function GetNbreCommentaireActif() {
		$sql = 'CALL get_commentairenbre_prestaID(:pID)';
		$param = array(':pID' => $this -> _mPrestaID);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour rediriger un presta non logge
	public static function CheckLoggedPresta() {
		if (((!isset($_SESSION['prestaid'])) && (!isset($_SESSION['userid']))) || (empty($_SESSION['prestaid'])) || (empty($_SESSION['userid']))) {

			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<head>
				<title>Erreur</title>
				<link rel="stylesheet" type="text/css" href="../styles/presta.css" />
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

	//retourne le nom d'un prestataire
	public static function GetEnseigne($prestaID) {
		$sql = "CALL get_presta_nom_parID(:pID)";
		$param = array(':pID' => $prestaID);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//fonction pour retrouver le dernier login d'un presta
	public static function GetPrestaLastLoginParID($id) {
		$row = array();
		$row = parent::GetUserLastLoginParID($id);
		if (!empty($row)) {
			if ($row['userLastLogin'] == '0000-00-00 00:00:00') {
				$row['userLastLogin'] = '<br />C\'est votre première connexion à votre tableau de bord sur RESTOnet.<br />Nous vous conseillons de changer votre mot de passe.';
			} else {
				$date = strtotime($row['userLastLogin']);
				$jour = get_jour($date);
				$mois = get_mois($date);
				$row['userLastLogin'] = '<br />Dernière connexion : ' . $jour . date(' d ', $date) . $mois . date(' Y ', $date) . 'à ' . date('H:i:s', $date) . '.';
			}
			return $row;
		}
	}

	//fonction pour updater le login du presta
	public static function UpdatePrestaLoginParID($id) {
		parent::UpdateUserLoginParID($id);
	}

	//fonction pour update le logout du presta
	public static function UpdateLogoutPrestaParID($id) {
		parent::UpdateUserLogoutParID($id);
	}

	//fonction de mise à jour des détails modifiable par le prestataire
	public function UpdatePrestaDetailParPrestataire() {
		$sql = "CALL upd_prestadetail_parpresta(:pID,:ident,:email,:tel)";
		$params = array(':pID' => $this -> _mPrestaID, ':ident' => parent::GetPseudo(), ':email' => parent::GetEmail(), ':tel' => $this -> _mPrestaTelephone);
		DatabaseHandler::Execute($sql, $params);
	}

	//fonction pour vérifier le mot de passe
	public static function CheckPrestaMDP($mdp, $id) {
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
	public static function UpdatePrestaMDP($mdp, $id) {
		parent::UpdateUserMDP($mdp, $id);
	}

	//retrouve les commandes du jour et celle en retard
	public static function GetPrestaComdeDuJour($presta, $date) {
		$sql = "CALL get_commdujour(:pID,:aDate)";
		$params = array(':pID' => $presta, ':aDate' => $date);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retruve la plage horaire pour un HorID
	public static function GetPlageHoraireParID($plageID) {
		$sql = "CALL get_horaire_plage(:hID)";
		$param = array(':hID' => $plageID);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve les détails de la commande du jour et celle en retard
	public static function GetPrestaComdeDetailDuJour($cmdID) {
		$sql = "CALL get_comdeDetail_dujour(:cID)";
		$param = array(':cID' => $cmdID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//mise à jour d'une commande
	public static function UpdateCommandeParCommandeID($comid, $etatid) {
		$sql = "CALL upd_commandeEtat_cmdeId(:cID,:eID)";
		$params = array(':cID' => $comid, ':eID' => $etatid);
		DatabaseHandler::Execute($sql, $params);
	}

	//retrouve le nombre de commande livrées
	public static function GetNbreComdeLivre($prestaid) {
		$sql = "CALL get_comlivre_prestaID(:pID)";
		$param = array(':pID' => $prestaid);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//retrouve les commandes pour le planning
	public static function GetCommdeplanningPrestaID($indate, $outdate, $prestaid) {
		$sql = "CALL get_comdePlanMonth(:inDate,:outDate,:pID)";
		$params = array(':inDate' => $indate, ':outDate' => $outdate, ':pID' => $prestaid);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retourne les details d'une commande a partir du planning
	public static function GetCommandePourPlanning($cmdID) {
		$sql = "CALL get_commande_parID_fromview(:cID)";
		$param = array(':cID' => $cmdID);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve le CA mensuel d'un presta
	public static function GetPrestaCAPrestaID($presta) {
		$sql = "CALL get_prestaCA(:pID)";
		$param = array(':pID' => $presta);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve le ca par client pour un prestataire
	public static function GetPrestaCAParClient($prestaid) {
		$sql = "CALL get_clt_cmdePrestaID(:pID)";
		$param = array(':pID' => $prestaid);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve la liste de classement des prestataires
	public static function GetPrestaClassement() {
		$sql = "CALL get_prestaClassement()";
		return DatabaseHandler::GetAll($sql);
	}

	//retrouve les notes d'un prestataire par client
	public static function GetNoteListeParPresta($prestaid) {
		$sql = "CALL get_note_byclient_prestaID(:pID)";
		$param = array(':pID' => $prestaid);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//verifie si le prestataire a des commandes
	public static function HasPrestaGotCommande($presta) {
		$sql = "CALL get_presta_nbre_commande(:pID)";
		$param = array(':pID' => $presta);
		if (DatabaseHandler::GetRow($sql, $param) != 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//verifie un numéro de commande
	public static function CheckNumeroCommande($commande) {
		if (!preg_match('/^[0-9]{11}$/i', trim($commande))) {
			return 'Numéro invalide. Le numéro de commande contient 11 chiffres.';
		} else {
			return NULL;
		}
	}

	//retrouve le header commande
	public static function GetCommandeHeader($cmde, $presta) {
		$sql = "CALL get_comheader_presta_comid(:cID,:pID)";
		$params = array(':cID' => $cmde, ':pID' => $presta);
		return DatabaseHandler::GetRow($sql, $params);
	}

	//retrouve le detail commande
	public static function GetCommandeDetail($cmde,$presta){
		$sql = "CALL get_comdet_presta_comid(:cID,:pID)";
		$params = array(':cID' => $cmde, ':pID' => $presta);
		return DatabaseHandler::GetAll($sql, $params);
	}
}
