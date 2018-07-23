<?php
//		presta_cmd_jour.php
//		fichier présentant les commandes du jour
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();

//on verifie que la forme n'a pas été pass par submit
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['etat']))) {
	//mise à jour du fichier commande
	for ($p = 0; $p < count($_POST['etat']); $p++) {
		Prestataire::UpdateCommandeParCommandeID($_POST['comid'][$p], $_POST['etat'][$p]);
	}
}
//retrouver la date du jour
date_default_timezone_set('Europe/Paris');
$aujourdhui = date('Y-m-d');
//Etat de commande
$cmdEtat = array();
$cmdEtat[1] = "Commande validée";
$cmdEtat[2] = "Commande en préparation";
$cmdEtat[3] = "Commande en cours de livraison";
$cmdEtat[4] = "Commande livrée et terminée";

//on retrouve l'ensemble des commandes
$comUrgent = array();
$comJour = array();
$rows = Prestataire::GetPrestaComdeDuJour($_SESSION['prestaid'], $aujourdhui);
if (!empty($rows)) {
	//on a des commandes
	$countU = 0;
	$countJ = 0;
	for ($r = 0; $r < count($rows); $r++) {
		//on vérifie si commande urgent ou pas
		if ($rows[$r]['cType'] == 'AL') {
			$comUrgent[$countU]['comID'] = $rows[$r]['comID'];
			$comUrgent[$countU]['comNumero'] = $rows[$r]['comNumero'];
			$comUrgent[$countU]['comDateLivre'] = FormatDateSlash($rows[$r]['comDateLivre']);
			//retrouver la plage horaire
			$plage = array();
			$plage = Prestataire::GetPlageHoraireParID($rows[$r]['cmdHorID']);
			$comUrgent[$countU]['cmdHorDebut'] = $plage['horDebut'];
			$comUrgent[$countU]['cmdHorFin'] = $plage['horFin'];
			$comUrgent[$countU]['nomClient'] = $rows[$r]['nomClient'];
			$comUrgent[$countU]['adresse1'] = $rows[$r]['adresse1'];
			$comUrgent[$countU]['adresse2'] = $rows[$r]['adresse2'];
			$comUrgent[$countU]['ville'] = $rows[$r]['ville'];
			$comUrgent[$countU]['adresseTelephone'] = $rows[$r]['adresseTelephone'];
			$comUrgent[$countU]['etatID'] = $rows[$r]['etatID'];
			$comUrgent[$countU]['livraisonID'] = $rows[$r]['livraisonID'];
			$comUrgent[$countU]['commande'] = array();
			$comdes = Prestataire::GetPrestaComdeDetailDuJour($rows[$r]['comID']);
			if (!empty($comdes)) {
				$countC = 0;
				$cmd = array();
				$grpplat = NULL;
				$bbg1 = '#d5a2f6';
				$bbg2 = '#a2acf6';
				$bbg3 = '#f6a2b0';
				$bbg4 = '#f6cea2';
				$bbg5 = '#d9f6a2';
				$bggcount = 0;
				for ($c = 0; $c < count($comdes); $c++) {
					$cmd[$countC]['platNom'] = $comdes[$c]['pln'];
					$cmd[$countC]['comDeQte'] = $comdes[$c]['cqte'];
					$cmd[$countC]['platId'] = $comdes[$c]['tplID'];
					switch ($comdes[$c]['tplID']) {
						case 1 :
							$cmd[$countC]['color'] = '#42c4fb';
							break;
						case 2 :
							$cmd[$countC]['color'] = '#70fed4';
							break;
						case 3 :
							$cmd[$countC]['color'] = '#eee66e';
							break;
						case 4 :
							$cmd[$countC]['color'] = '#f37ce4';
							break;
						case 0 :
							if ($grpplat != $comdes[$c]['grpNom']) {
								$bggcount++;
								$grpplat = $comdes[$c]['grpNom'];
							}
							switch ($bggcount) {
								case 1 :
									$cmd[$countC]['color'] = $bbg1;
									break;
								case 2 :
									$cmd[$countC]['color'] = $bbg2;
									break;
								case 3 :
									$cmd[$countC]['color'] = $bbg3;
									break;
								case 4 :
									$cmd[$countC]['color'] = $bbg4;
									break;
								default :
									$cmd[$countC]['color'] = $bbg5;
									break;
							}
							break;
						default :
							$cmd[$countC]['color'] = '#0099da';
							break;
					}
					$countC++;
				}
				$comUrgent[$countU]['commande'] = $cmd;
			}
			$countU++;
		} else {
			$comJour[$countJ]['comID'] = $rows[$r]['comID'];
			$comJour[$countJ]['comNumero'] = $rows[$r]['comNumero'];
			$comJour[$countJ]['comDateLivre'] = FormatDateSlash($rows[$r]['comDateLivre']);
			//retrouver la plage horaire
			$plage = array();
			$plage = Prestataire::GetPlageHoraireParID($rows[$r]['cmdHorID']);
			$comJour[$countJ]['cmdHorDebut'] = $plage['horDebut'];
			$comJour[$countJ]['cmdHorFin'] = $plage['horFin'];
			$comJour[$countJ]['nomClient'] = $rows[$r]['nomClient'];
			$comJour[$countJ]['adresse1'] = $rows[$r]['adresse1'];
			$comJour[$countJ]['adresse2'] = $rows[$r]['adresse2'];
			$comJour[$countJ]['ville'] = $rows[$r]['ville'];
			$comJour[$countJ]['adresseTelephone'] = $rows[$r]['adresseTelephone'];
			$comJour[$countJ]['etatID'] = $rows[$r]['etatID'];
			$comJour[$countJ]['livraisonID'] = $rows[$r]['livraisonID'];
			$comJour[$countJ]['commande'] = array();
			$comdes = Prestataire::GetPrestaComdeDetailDuJour($rows[$r]['comID']);
			if (!empty($comdes)) {
				$countC = 0;
				$grpplat = NULL;
				$bbg1 = '#d5a2f6';
				$bbg2 = '#a2acf6';
				$bbg3 = '#f6a2b0';
				$bbg4 = '#f6cea2';
				$bbg5 = '#d9f6a2';
				$bggcount = 0;
				$cmd = array();
				for ($c = 0; $c < count($comdes); $c++) {
					$cmd[$countC]['platNom'] = $comdes[$c]['pln'];
					$cmd[$countC]['comDeQte'] = $comdes[$c]['cqte'];
					$cmd[$countC]['platId'] = $comdes[$c]['tplID'];
					switch ($comdes[$c]['tplID']) {
						case 1 :
							$cmd[$countC]['color'] = '#42c4fb';
							break;
						case 2 :
							$cmd[$countC]['color'] = '#70fed4';
							break;
						case 3 :
							$cmd[$countC]['color'] = '#eee66e';
							break;
						case 4 :
							$cmd[$countC]['color'] = '#f37ce4';
							break;
						case 0 :
							if ($grpplat != $comdes[$c]['grpNom']) {
								$bggcount++;
								$grpplat = $comdes[$c]['grpNom'];
							}
							switch ($bggcount) {
								case 1 :
									$cmd[$countC]['color'] = $bbg1;
									break;
								case 2 :
									$cmd[$countC]['color'] = $bbg2;
									break;
								case 3 :
									$cmd[$countC]['color'] = $bbg3;
									break;
								case 4 :
									$cmd[$countC]['color'] = $bbg4;
									break;
								default :
									$cmd[$countC]['color'] = $bbg5;
									break;
							}
							break;
						default :
							$cmd[$countC]['color'] = '#0099da';
							break;
					}
					$countC++;
				}
				$comJour[$countJ]['commande'] = $cmd;
			}
			$countJ++;
		}
	}
}

$page_title = "Mes commandes du jour";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Mes commandes du  jour</h2>';
if ((empty($comUrgent)) && (empty($comJour))) {
	echo '<p>Vous n\'avez pas encore de commande pour aujourd\'hui.</p>';
} else {
	echo '<form action="presta_cmd_jour.php" method="post">';
}
if (!empty($comUrgent)) {
	echo '<p class="urgent">Commandes nécéssitant votre attention immédiate</p><p>Ces commandes sont soit en retard, ou n\'ont pas été finalisées. Veuillez les mettre à jour.</p>';
	echo '<table border="0" cellpadding="3" cellspacing="0" width="96%" align="center">
	<tr valign="top" bgcolor="#FF6666"><td width="15%" align="center"><b>Date</b></td><td width="15%" align="center"><b>Horaire</b></td><td width="25%" align="center"><b>Détails client</b></td><td width="45%" align="center"><b>Détails commande</b></td></tr>';
	for ($u = 0; $u < count($comUrgent); $u++) {
		echo '<tr valign="top"><td width="15%" align="center" class="urgent">' . $comUrgent[$u]['comDateLivre'] . '</td><td width="15%" align="center" class="urgent">Entre ' . $comUrgent[$u]['cmdHorDebut'] . '<br />et ' . $comUrgent[$u]['cmdHorFin'] . '<td width="25%" align="left" class="urgent">Cmde N° : <b>' . $comUrgent[$u]['comNumero'] . '</b></td><td width="45" align="left" rowspan="3" bgcolor="#FAA2A2">';
		echo '<table width="100%" border="0" cellpadding="2" cellspacing="0">';
		for ($d = 0; $d < count($comUrgent[$u]['commande']); $d++) {
			echo '<tr><td style="font-size:11px;color:#000000" bgcolor="' . $comUrgent[$u]['commande'][$d]['color'] . '">';
			if ($comUrgent[$u]['commande'][$d]['platId'] == 0) {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			echo '<b>' . $comUrgent[$u]['commande'][$d]['comDeQte'] . '</b> x ' . $comUrgent[$u]['commande'][$d]['platNom'] . '<br /></td></tr>';

		}
		echo '</table>';
		echo '</td></tr>';
		echo '<tr valign="top"><td align="center" class="urgent" colspan="2" rowspan="2">Type de livraison :<br /><b>';
		switch ($comUrgent[$u]['livraisonID']) {
			case 1 :
				echo 'Livraison à domicile';
				$adresse = $comUrgent[$u]['adresse1'] . '<br />' . $comUrgent[$u]['adresse2'] . '<br />' . $comUrgent[$u]['ville'];
				break;
			case 2 :
				echo 'Vente à emporter';
				$adresse = '';
				break;
			default :
				echo 'Repas sur place';
				$adresse = '';
				break;
		}
		echo '<td width="25%" align="left" class="urgent">Client :<br /><b>' . $comUrgent[$u]['nomClient'] . '</b><br />' . $adresse . '</td></tr>';
		echo '<tr valign="top"><td width="25%" align="left" class="urgent">Téléphone :<br /><b>' . FormatTelephone($comUrgent[$u]['adresseTelephone']) . '</b></td></tr>';
		echo '<tr valign="center"><td colspan="4" align="center" class="urgent"><b>Etat de la commande :<b/> <select name="etat[]" onChange="submit()">';
		for ($e = 1; $e <= count($cmdEtat); $e++) {
			echo '<option value="' . $e . '"';
			if ($e == $comUrgent[$u]['etatID']) {
				echo ' selected="selected"';
			}
			echo '>' . $cmdEtat[$e] . '</option>';
		}
		echo '</select></td></tr><tr height="10px"><td colspan="4"></td></tr>
		<input type="hidden" name="comid[]" value="' . $comUrgent[$u]['comID'] . '" />';
	}
	echo '</table>';
}
if (!empty($comJour)) {
	echo '<h3>Commandes en cours</h3>';
	echo '<table border="0" cellpadding="3" cellspacing="0" width="96%" align="center">
	<tr valign="top" bgcolor="#ffffff"><td width="15%" align="center"><b>Date</b></td><td width="15%" align="center"><b>Horaire</b></td><td width="25%" align="center"><b>Détails client</b></td><td width="45%" align="center"><b>Détails commande</b></td></tr>';
	$bg = '#D6D694';
	for ($u = 0; $u < count($comJour); $u++) {
		$bg = ($bg == '#D6D694' ? 'D4D6D6' : '#D6D694');
		echo '<tr valign="top" bgcolor="' . $bg . '"><td width="15%" align="center" class="commande">' . $comJour[$u]['comDateLivre'] . '</td><td width="15%" align="center" class="commande">Entre ' . $comJour[$u]['cmdHorDebut'] . '<br />et ' . $comJour[$u]['cmdHorFin'] . '<td width="25%" align="left" class="commande">Cmde N° : <b>' . $comJour[$u]['comNumero'] . '</b></td><td width="45" align="left" rowspan="3" bgcolor="#d4d6d6">';
		echo '<table width="100%" border="0" cellpadding="2" cellspacing="0">';
		for ($d = 0; $d < count($comJour[$u]['commande']); $d++) {
			echo '<tr><td style="font-size:11px;color:#000000" bgcolor="' . $comJour[$u]['commande'][$d]['color'] . '">';
			if ($comJour[$u]['commande'][$d]['platId'] == 0) {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			echo '<b>' . $comJour[$u]['commande'][$d]['comDeQte'] . '</b> x ' . $comJour[$u]['commande'][$d]['platNom'] . '<br /></td></tr>';

		}
		echo '</table>';
		echo '</td></tr>';
		echo '<tr valign="top" bgcolor="' . $bg . '"><td align="center" colspan="2" rowspan="2" class="commande">Type de livraison :<br /><b>';
		switch ($comJour[$u]['livraisonID']) {
			case 1 :
				echo 'Livraison à domicile';
				$adresse = $comJour[$u]['adresse1'] . '<br />' . $comJour[$u]['adresse2'] . '<br />' . $comJour[$u]['ville'];
				break;
			case 2 :
				echo 'Vente à emporter';
				$adresse = '';
				break;
			default :
				echo 'Repas sur place';
				$adresse = '';
				break;
		}
		echo '<td width="25%" align="left" class="commande">Client :<br /><b>' . $comJour[$u]['nomClient'] . '</b><br />' . $adresse . '</td></tr>';
		echo '<tr valign="top" bgcolor="' . $bg . '"><td width="25%" align="left" class="commande">Téléphone :<br /><b>' . FormatTelephone($comJour[$u]['adresseTelephone']) . '</b></td></tr>';
		echo '<tr valign="center" bgcolor="' . $bg . '"><td colspan="4" align="center" class="commande"><b>Etat de la commande :<b/> <select name="etat[]" onChange="submit()">';
		for ($e = 1; $e <= count($cmdEtat); $e++) {
			echo '<option value="' . $e . '"';
			if ($e == $comJour[$u]['etatID']) {
				echo ' selected="selected"';
			}
			echo '>' . $cmdEtat[$e] . '</option>';
		}
		echo '</select></td></tr><tr height="10px"><td colspan="4"></td></tr>
		<input type="hidden" name="comid[]" value="' . $comJour[$u]['comID'] . '" />';
	}
	echo '</table>';
}
if ((!empty($comJour)) && (!empty($comUrgent))) {
	echo '</form>';
}
include INCLUDE_DIR . 'prestafooter.php';
