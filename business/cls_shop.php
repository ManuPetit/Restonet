<?php
//		cls_shop.php
//		fichier contenant info relative au front house

class Shop {

	//retrouve plats prestataire et par type
	public static function GetPlatParType($id, $type) {
		$sql = 'CALL get_plat_partype_presta(:pID,:tpID)';
		$params = array(':pID' => $id, ':tpID' => $type);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retrouve le type de plat
	public static function GetTypePlat($id) {
		$sql = 'CALL get_typeplat_prestaID(:pID)';
		$param = array(':pID' => $id);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//ajouter au cart
	public static function AddToCart($uid, $plat, $qte) {
		$sql = 'CALL add_to_cart(:uID,:pID,:qte)';
		$params = array(':uID' => $uid, ':pID' => $plat, ':qte' => $qte);
		return DatabaseHandler::GetOne($sql, $params);
	}

	//retrouve id du prestataire par plat
	public static function GetPrestaIDParPlatID($plat) {
		$sql = "CALL get_presta_parPlatID(:pID)";
		$param = array(':pID' => $plat);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//nbre de plats dans le cart
	public static function CountCartItem($uid) {
		$sql = 'CALL get_item_incart(:uID)';
		$param = array(':uID' => $uid);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//valeur totale du cart
	public static function GetCartAmount($uid) {
		$sql = 'CALL get_cart_amount(:uID)';
		$param = array(':uID' => $uid);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//verifie si un plat est un menu
	public static function IsPlatMenu($pid) {
		$sql = 'CALL get_plat_detail_parID(:pID)';
		$param = array(':pID' => $pid);
		$row = DatabaseHandler::GetRow($sql, $param);
		if ($row['IsMenu'] == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	//verifie si user session existe dans cart
	public static function CheckMenuForGUID($uid, $pid) {
		$sql = 'CALL check_menu_guid(:uID,:pID)';
		$param = array(':uID' => $uid, ':pID' => $pid);
		$row = DatabaseHandler::GetOne($sql, $param);
		if ($row == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	//retrouve le nom du menu et presta
	public static function GetMenuEtPrestaNom($id) {
		$sql = 'CALL get_menunom_presta_parID(:mID)';
		$param = array(':mID' => $id);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve les éléments d'un menu
	public static function GetMenuItemParID($id) {
		$sql = 'CALL get_menu_item_parID(:mID)';
		$param = array(':mID' => $id);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve les plats dans le cart pour voir le panier
	public static function GetCartItemParUniqID($id) {
		$sql = 'CALL get_cart_item_parUID(:uID)';
		$param = array(':uID' => $id);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//ajoute un element à un plat au cart
	public static function AddOneItemToCart($id) {
		$sql = 'CALL upd_addcart_cartID(:cID)';
		$param = array(':cID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	//enlève un élément à un plat du cart
	public static function RemoveOneItemFromCart($id) {
		$sql = 'CALL upd_remcart_cartID(:cID)';
		$param = array(':cID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	//enlève tous les élément d'un plat du cart
	public static function DeleteFromCart($id) {
		$sql = 'CALL upd_delcart_cartID(:cID)';
		$param = array(':cID' => $id);
		DatabaseHandler::Execute($sql, $param);
	}

	//retroue le détails d'un menu
	public static function GetMenuDetailFromCart($uid, $pid) {
		$sql = 'CALL get_cart_menuitem(:uID,:pID)';
		$params = array(':uID' => $uid, ':pID' => $pid);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//recupère l'ensemble des plats d'un menu pour mise à jour
	public static function GetAllMenuItemParCartID($id) {
		$sql = 'CALL get_cart_menu_item_parCartID(:cID)';
		$param = array(':cID' => $id);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve le nom du menu, la quantite et le prestataire
	public static function GetMenuPrestaQteParCartID($id) {
		$sql = 'CALL get_menu_detail_parCartID(:cID)';
		$param = array(':cID' => $id);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//mets à jour le carte si on a modifie le nombre de menu
	public static function UpdateMenuItemInCartFromModif($uid, $pid, $qte) {
		$sql = 'CALL add_modmenu_tocart(:uID,:pID,:qte)';
		$params = array(':uID' => $uid, ':pID' => $pid, ':qte' => $qte);
		DatabaseHandler::Execute($sql, $params);
	}

	//retrouve les détails de la région
	public static function GetRegionDetail($rid) {
		$sql = 'CALL get_region_detail_parID(:rID)';
		$param = array(':rID' => $rid);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouver tous les départements actifs de la region
	public static function GetActifDeptParRegion($rid) {
		$sql = 'CALL get_dept_parregionID(:rID)';
		$param = array(':rID' => $rid);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouver les details du dept
	public static function GetDeptDetailParID($did) {
		$sql = 'CALL get_dept_detail_pardeptid(:dID)';
		$param = array(':dID' => $did);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve les villes d'un départment et le nombre d'établissement
	public static function GetVilleNbrePrestaParDeptID($did) {
		$sql = 'CALL get_ville_presta_pardeptID(:dID)';
		$param = array(':dID' => $did);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouver les détails de la ville par ville id
	public static function GetVilleDetailParVilleID($vid) {
		$sql = 'CALL get_ville_detail_parid(:vID)';
		$param = array(':vID' => $vid);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouver les categories par ville
	public static function GetCategorieParVilleID($vid) {
		$sql = 'CALL get_categ_parvilleID(:vID)';
		$param = array(':vID' => $vid);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve tous les departements actif
	public static function GetDepartementActif() {
		$sql = 'CALL get_dept_actif';
		return DatabaseHandler::GetAll($sql);
	}

	//retrouve les villes d'un département avec presta actif
	public static function GetVillePrestaActifParDeptID($did) {
		$sql = 'CALL get_villeactif_parDeptID(:dID)';
		$param = array(':dID' => $did);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve les categories par dept par presta actif
	public static function GetCategoriePrestaActifParDeptID($did) {
		$sql = 'CALL get_categorie_parDeptID(:dID)';
		$param = array(':dID' => $did);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve la liste de tous les presta d'un departmeent
	public static function GetPrestaListeParDeptID($did, $order) {
		$sql = 'CALL get_prestaList_DeptID(:dID,:disOrder)';
		$param = array(':dID' => $did, ':disOrder' => $order);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve la liste des tous les presta d'un ville pour une catégorie
	public static function GetPrestaListVilleEtCategorie($vid, $cid, $did, $order) {
		$sql = 'CALL get_prestaList_Ville_Cat(:vID,:cID,:dID,:disOrder)';
		$param = array(':vID' => $vid, ':cID' => $cid, ':dID' => $did, ':disOrder' => $order);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve les filtrages choisis pour la recherche
	public static function GetFiltrageDetail($vid, $cid, $did) {
		$filtre = array();
		if ($vid != 0) {
			$sql = 'CALL get_villeNom_ParID(:vID)';
			$param = array(':vID' => $vid);
			$filtre['ville'] = 'ville de ' . DatabaseHandler::GetOne($sql, $param);
		} else {
			$filtre['ville'] = "toutes les villes";
		}
		if ($cid != 0) {
			$sql = 'CALL get_categNom_ParID(:cID)';
			$param = array(':cID' => $cid);
			$filtre['categ'] = 'catégorie ' . DatabaseHandler::GetOne($sql, $param);
		} else {
			$filtre['categ'] = "toutes les catégories";
		}
		$sql = 'CALL get_deptNom_ParID(:dID)';
		$param = array(':dID' => $did);
		$filtre['dept'] = DatabaseHandler::GetOne($sql, $param);
		return $filtre;
	}

	//retrouve le nom d'un départment
	public static function GetDepartmentNom($did) {
		$sql = 'CALL get_deptNom_ParID(:dID)';
		$param = array(':dID' => $did);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//retrouve le nom d'une ville
	public static function GetVilleNom($vid) {
		$sql = 'CALL get_villeNom_ParID(:vID)';
		$param = array(':vID' => $vid);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//retrouve le nom d'une région
	public static function GetRegionNom($rid) {
		$sql = 'CALL get_regionNom_ParID(:rID)';
		$param = array(':rID' => $rid);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//retrouve liste prestataire par categorie et ville
	public static function GetPrestaParCategVille($cid, $vid, $ord) {
		$sql = 'CALL get_presta_CategID_VilleID(:vID,:cID,:disOrder)';
		$params = array(':vID' => $vid, ':cID' => $cid, ':disOrder' => $ord);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retrouve liste prestataire par categorie dept
	public static function GetPrestaParCategDept($cid, $did, $ord) {
		$sql = 'CALL get_presta_CategID_DeptID(:dID,:cID,:disOrder)';
		$params = array(':dID' => $did, ':cID' => $cid, ':disOrder' => $ord);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retrouve liste prestataire par categorie et region
	public static function GetPrestaParCategRegion($cid, $rid, $ord) {
		$sql = 'CALL get_presta_CategID_RegID(:rID,:cID,:disOrder)';
		$params = array(':rID' => $rid, ':cID' => $cid, ':disOrder' => $ord);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retrouve les details de la catégorie
	public static function GetCategorieDetail($cid) {
		$sql = 'CALL get_categorie_parID(:monID)';
		$param = array(':monID' => $cid);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve tous les restaurants d'une catégorie
	public static function GetPrestaParCategorie($cid, $order) {
		$sql = 'CALL get_allPresta_CategID(:cID,:disOrder)';
		$params = array(':cID' => $cid, ':disOrder' => $order);
		return DatabaseHandler::GetAll($sql, $params);
	}

	//retrouve les types de livraison du prestataire
	public static function GetPrestaTypeDeLivraison($prestID) {
		$sql = "CALL get_presta_livraison_parID(:pID)";
		$param = array(':pID' => $prestID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//verifier le lieu de livraison avec la ville du client
	public static function CheckPrestaLivraisonParClientVille($client, $presta) {
		$sql = "CALL check_livraison_lieu(:cID,:pID)";
		$params = array(':cID' => $client, ':pID' => $presta);
		if (DatabaseHandler::GetOne($sql, $params) == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//vide un cart
	public static function DeleteCartItemFromCartUserID($cartUserID) {
		$sql = "CALL del_from_cart(:cID)";
		$param = array(':cID' => $cartUserID);
		DatabaseHandler::Execute($sql, $param);
	}

	//retrouve les jours de fermeture du prestataire
	public static function GetPrestaJourFerme($presta) {
		$sql = "CALL get_presta_closed_day(:pID)";
		$param = array(':pID' => $presta);
		$jour = array();
		$resultat = array();
		$resultat = DatabaseHandler::GetAll($sql, $param);
		for ($r = 0; $r < count($resultat); $r++) {
			//affecte le jour de la variable à sa valeur
			switch($resultat[$r]['jourA']) {
				case 1 :
					$jour[] = "Mon";
					break;
				case 2 :
					$jour[] = "Tue";
					break;
				case 3 :
					$jour[] = "Wed";
					break;
				case 4 :
					$jour[] = "Thu";
					break;
				case 5 :
					$jour[] = "Fri";
					break;
				case 6 :
					$jour[] = "Sat";
					break;
				default :
					$jour[] = "Sun";
					break;
			}
		}
		return $jour;
	}

	//retrouve la période de fermetre d'un presta
	public static function GetPrestaFermeture($presta) {
		$sql = "CALL get_close_date_presta(:pID)";
		$param = array(':pID' => $presta);
		$dateMonthYearArr = array();
		$conge = array();
		$conge = DatabaseHandler::GetRow($sql, $param);
		if (!is_null($conge['prestaCongeDebut'])) {
			//on a des dates on va donc calculer toutes les dates de fermeture
			$fromDateTS = strtotime($conge['prestaCongeDebut']);
			$toDateTS = strtotime($conge['prestaCongeFin']);
			for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
				// use date() and $currentDateTS to format the dates in between
				$currentDateStr = date('Y-m-d', $currentDateTS);
				$dateMonthYearArr[] = $currentDateStr;
			}
		}
		return $dateMonthYearArr;
	}

	//retrouve les plages horaires pour ce prestataire
	public static function GetPrestaHoraireJour($date, $presta) {
		//retrouver l'heure en ce moment
		$now = HeureParis();
		$aujourd = substr($now, 0, 10);
		// verifier si il s'agit du même jour
		if ($aujourd == $date) {
			//retrouver l'heure courante
			$curH = substr($now, 11, 2);
			$curM = substr($now, 14, 2);
			//retrouver le délai de préparation du prestataire
			$sql = "CALL get_presta_delaiPrep(:pID)";
			$param = array(':pID' => $presta);
			$delai = DatabaseHandler::GetOne($sql, $param);
			$addH = substr($delai, 0, 2);
			$addM = substr($delai, 3, 2);
			//ajouter les minutes
			$newM = $curM + $addM;
			if ($newM >= 60) {
				$newM = $newM - 60;
				$addH++;
			}
			//ajouter les heures
			$newH = $curH + $addH;
			if ($newH >= 24) {
				return '<p>Vous ne pouvez plus faire de réservation pour cette date. Veuillez chosir une nouvelle date...</p>
				<div align="right"><a class="fbutton" href="reccmd.php" title="Choisissez une nouvelle date">Retour en arrière pour changer de date</a>';
			}
			if ($newH < 10) {
				$checktime = '0' . $newH . 'h';

			} else {
				$checktime = $newH . 'h';
			}
			if ($newM < 10) {
				$checktime .= '0' . $newM;

			} else {
				$checktime .= $newH;
			}
			echo $checktime;
		} else {
			$checktime = '00h00';
		}

		//retrouver le jour de la semaine
		$jour = date('N', strtotime($date));
		//retrouver la date du jour et l'heure
		//retrouver les plages horaires pour ce prestataire
		$sql = "CALL get_presta_horaire_jour(:jID,:pID)";
		$params = array(':jID' => $jour, ':pID' => $presta);
		$plages = array();
		$plage = array();
		$plages = DatabaseHandler::GetAll($sql, $params);
		//enumérer les plages horaire
		for ($p = 0; $p < count($plages); $p++) {
			for ($i = $plages[$p]['plageHorDebut']; $i < $plages[$p]['plageHorFin']; $i++) {
				$plage[] = $i;
			}
		}
		//verifie si les heures sont supérieur au checktime
		$nplage = array();
		for ($i = 0; $i < count($plage); $i++) {
			$sql = "CALL get_horaire_tranche_presta(:hor,:hID)";
			$params = array(':hor' => $checktime, ':hID' => $plage[$i]);
			$result = DatabaseHandler::GetRow($sql, $params);
			if (!empty($result)) {
				$nplage[] = $result;
			}
		}
		//verifier si dans les heures possibles pour la date il n'y a pas déja un maximun de commande
		$Horaires = array();
		for ($n = 0; $n < count($nplage); $n++) {
			$sql = "CALL get_verifhoraire_presta(:pID,:dDate,:hID)";
			$params = array(':pID' => $presta, ':dDate' => $date, ':hID' => $nplage[$n]['plaHorID']);
			$result = DatabaseHandler::GetOne($sql, $params);
			$Horaires[$n] = $nplage[$n];
			if (empty($result)) {
				$Horaires[$n]['on'] = TRUE;
			} else {
				$Horaires[$n]['on'] = FALSE;
			}
		}
		if (empty($Horaires)) {
			return '<p>Vous ne pouvez plus faire de réservation pour cette date. Veuillez chosir une nouvelle date...</p>
				<div align="right"><a class="fbutton" href="reccmd.php" title="Choisissez une nouvelle date">Retour en arrière pour changer de date</a>';
		} else {
			//on va afficher les horaires possibles
			$message = '<p><b>Veuillez choisir votre horaire parmi ceux proposés :</b></p>';
			$message .= '<table border="0" cellspacing="5" align="center"><tr>';
			$c = 0;
			for ($n = 0; $n < count($Horaires); $n++) {
				if ($c > 5) {
					$message .= '</tr><tr>';
					$c = 0;
				}
				if ($Horaires[$n]['on'] == TRUE) {
					$message .= '<td><a class="fbutton" href="fincmd.php?h=' . $Horaires[$n]['plaHorID'] . '" title="Cliquez ici pour choisir l\'horaire ' . $Horaires[$n]['plaHorNom'] . '">' . $Horaires[$n]['plaHorNom'] . '</a></td>';
				} else {
					$message .= '<td><a class="nbutton" title="Complet pour cette tranche horaire.">' . $Horaires[$n]['plaHorNom'] . '</a></td>';
				}
				$c++;
			}
			$d = 6 - $c;
			if ($d == 0) {
				$message .= '</tr>';
			} else {
				$message .= '<td colspan="' . $d . '"></td></tr>';
			}
			$message .= '</table>';
			return $message;
		}
	}

	//retrouver la tranche horaire
	public static function GettrancheHoraire($heure) {
		$sql = "CALL get_trancheHoraire(:hID)";
		$param = array(':hID' => $heure);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//creation du numero de commande
	public static function GetNumeroCommande($date) {
		$mois = substr($date, 5, 2);
		$an = substr($date, 2, 2);
		$sql = "CALL get_numero_commande()";
		$num = DatabaseHandler::GetOne($sql);
		return $an . $mois . str_pad($num, 7, "0", STR_PAD_LEFT);
	}

	//creation de la commande
	public static function CreateCommande($cmdNum, $client, $comDate, $livraison, $adresse, $livDate, $horaire) {
		$sql = "CALL add_commande(:cmdNum,:cID,:dDate,:lID,:aID,:dLiv,:hID)";
		$params = array(':cmdNum' => $cmdNum, ':cID' => $client, ':dDate' => $comDate, ':lID' => $livraison, ':aID' => $adresse, ':dLiv' => $livDate, ':hID' => $horaire);
		return DatabaseHandler::GetOne($sql, $params);
	}

	//ajout des détails de la commande
	public static function CreateCommandeDetail($cart, $cmd) {
		$sql = "CALL add_plat_commande(:cartID,:cmdID)";
		$params = array(':cartID' => $cart, ':cmdID' => $cmd);
		DatabaseHandler::Execute($sql, $params);
	}

	//validation de la commande après autorisation bancaire
	public static function ValidationCommandeBanque($autoNum, $transNum, $comNum) {
		DatabaseHandler::SetBeginTransaction();
		try {
			//mettre à jour l'état de la commande
			$sql = "CALL upd_comdeEtat(:comNum,:etat)";
			$params = array(":comNum" => $comNum, ":etat" => 1);
			DatabaseHandler::Execute($sql, $params);
			//creer la commande dans le fichier d'audit des commandes
			$sql = "call aud_commande(:comNum,:transBanque,:numAuto)";
			$params = array(':comNum' => $comNum, ':transBanque' => $transNum, ':numAuto' => $autoNum);
			DatabaseHandler::Execute($sql, $params);
			DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}
	}

	//retrouve une commande
	public static function GetCommandeHeader($comNum) {
		$sql = "CALL get_commande_header(:cmdNum)";
		$param = array(':cmdNum' => $comNum);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve l'adresse du client
	public static function GetClientAdresse($cltID) {
		$sql = "CALL get_client_adresse(:cID)";
		$param = array(':cID' => $cltID);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//retrouve l'email du client
	public static function GetClientEmail($cltID) {
		$sql = "CALL get_client_email(:cID)";
		$param = array(':cID' => $cltID);
		return DatabaseHandler::GetOne($sql, $param);
	}

	//retrouve le détail de la commande
	public static function GetCommandeDetail($comID) {
		$sql = "CALL get_cmde_detail(:cID)";
		$param = array(':cID' => $comID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve le détails du ou des prestataires de la commande
	public static function GetPrestataireDetailFromCommande($comID) {
		$sql = "CALL get_prestataire_commandeID(:cID)";
		$param = array(':cID' => $comID);
		return DatabaseHandler::GetAll($sql, $param);
	}

	//retrouve la liste des prestataires pour une commande
	public static function GetAllPrestaFromCommande($comNum){
		$sql ="CALL get_prestaFromComdeNum(:comNum)";
		$param = array(':comNum'=>$comNum);
		return DatabaseHandler::GetAll($sql,$param);
	}
	
	//mets à jour les disponibilités
	public static function UpdatePrestaDisponibilité($presta,$comNum){
		$sql = "CALL upd_prestaDisponibilite(:pID,:comNum)";
		$params = array(':pID'=>$presta,':comNum'=>$comNum);
		DatabaseHandler::Execute($sql,$params);
	}
	
	//mets à jour le facturier des prestataires
	public static function AjouterPrestaFacture($presta){
		$sql = "CALL add_facture(:pID)";
		$param = array(':pID'=>$presta);
		DatabaseHandler::Execute($sql,$param);
	}
}
