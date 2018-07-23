<?php
// fonctions.php

//fonctions du programme

//format les livraisons
function FormatLivraisonBoitePrestaFront($presta) {
	$rows = array();
	$rows = $presta -> GetLivraisonTypeParID();
	if (!empty($rows)) {
		$str = '<p>' . $presta -> GetPrestaNomCommercial() . ' vous propose :<ul>';
		for ($i = 0; $i < count($rows); $i++) {
			$str .= '<li>' . $rows[$i]['livraisonNom'] . '</li>';
		}
		$str .= '</ul></p>';
		echo $str;
	}
}

//formater les ouvertures
function FormatJourOuverturePrestaFront($presta) {
	$rows = array();
	$rows = $presta -> GetHoraire();
	$jour = array(0 => 0, 0, 0, 0, 0, 0, 0);
	if (!empty($rows)) {
		for ($i = 0; $i < count($rows); $i++) {
			switch ($rows[$i]['jour']) {
				case 1 :
					if ($rows[$i]['debut'] > 0) {
						$jour[0] = 1;
					}
					break;
				case 2 :
					if ($rows[$i]['debut'] > 0) {
						$jour[1] = 1;
					}
					break;
				case 3 :
					if ($rows[$i]['debut'] > 0) {
						$jour[2] = 1;
					}
					break;
				case 4 :
					if ($rows[$i]['debut'] > 0) {
						$jour[3] = 1;
					}
					break;
				case 5 :
					if ($rows[$i]['debut'] > 0) {
						$jour[4] = 1;
					}
					break;
				case 6 :
					if ($rows[$i]['debut'] > 0) {
						$jour[5] = 1;
					}
					break;
				default :
					if ($rows[$i]['debut'] > 0) {
						$jour[6] = 1;
					}
					break;
			}
		}
		$str = '<table border="0" cellspacing="2px"><tr><td>Jours d\'ouverture : </td><td class="jour">L</td><td class="jour">M</td><td class="jour">M</td><td class="jour">J</td><td class="jour" >V</td><td class="jour">S</td><td class="jour">D</td></tr><tr><td></td>';
		for ($i = 0; $i < count($jour); $i++) {
			if ($jour[$i] == 0) {
				$str .= '<td align="center" class="ferme" title="Fermé ce jour">F</td>';
			} else {
				$str .= '<td class="ouvert" title="Ouvert ce jour"></td>';
			}
		}
		$str .= '</tr></table>';
		echo $str;
	}
}

//formater les ouvertures
function FormatJourOuverturePrestaFrontAvecHeure($presta) {
	$rows = array();
	$rows = $presta -> RetourneListeHoraire();
	if (!empty($rows)){
		$str = '<table border="0" cellspacing="2px"></tr><tr><td colspan="7" class="textdesc" align="center"><b>Horaire d\'ouverture</b></td></tr><tr><td class="jour">L</td><td class="jour">M</td><td class="jour">M</td><td class="jour">J</td><td class="jour" >V</td><td class="jour">S</td><td class="jour">D</td></tr><tr>';
		for ($i = 1; $i <=count($rows); $i++) {
			if (strpos($rows[$i],'Fermé')>0) {
				$str .= '<td align="center" class="ferme" title="' . $rows[$i] . '"></td>';
			} else {
				$str .= '<td class="ouvert" title="' . $rows[$i] . '"></td>';
			}
		}
		$str .= '</tr><tr><td colspan="7" class="textdesc" align="center"><small>passez votre souris sur les cases colorées pour les horaires</small></td></tr></table>';
		echo $str;
	}
}

//creation breadcrumb presta
function BreadCrumbPresta($presta) {
	$sql = 'CALL get_breadcrumb_presta(:pID)';
	$param = array(':pID' => $presta -> GetPrestaID());
	$row = DatabaseHandler::GetRow($sql, $param);
	if (!empty($row)) {
		$bread = '<a href="region.php?regid=' . $row['regionID'] . '" title="Découvrez les établissements en région ' . $row['regionNom'] . '" class="breadcrumb">' . $row['regionNom'] . '</a>&nbsp;&nbsp;';
		$bread .= '&nbsp;<span class="bread">>></span>&nbsp;';
		$bread .= '&nbsp;<a href="departement.php?depid=' . $row['deptID'] . '" title="Découvrez les établissements du département ' . $row['deptNom'] . '" class="breadcrumb">' . $row['deptNom'] . '</a>&nbsp;&nbsp;';
		$bread .= '&nbsp;<span class="bread">>></span>&nbsp;';
		$bread .= '&nbsp;<a href="ville.php?vilid=' . $row['villeID'] . '" title="Découvrez les autres établissements de ' . $row['villeNom'] . '" class="breadcrumb">' . $row['villeNom'] . '</a>&nbsp;&nbsp;';
		$bread .= '&nbsp;<span class="bread">>></span>&nbsp;&nbsp;<span class="ttpresta">'.$presta->GetPrestaNomCommercial().'</span>';
		echo $bread;
	}
}

//fonction pour reformatter un téléphone
function FormatTelephone($numero) {
	$tel = str_split($numero);
	$ntel = $tel[0] . $tel[1] . ' ' . $tel[2] . $tel[3] . ' ' . $tel[4] . $tel[5] . ' ' . $tel[6] . $tel[7] . ' ' . $tel[8] . $tel[9];
	return $ntel;
}

//generation du unique ID pour le panier
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}