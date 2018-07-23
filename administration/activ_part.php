<?php
//		activ_part.php
//		permet de voir l'activité périodique
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_activite.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();
$errors = array();

//les mois
$lesmois = array(1 => 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');
$page_title = "Activité périodique";
include INCLUDE_DIR . 'adminhead.php';

//on retrouve les jours d'activite
$dates = Activite::GetDateActivite();

echo '<h2>Activité périodique</h2>';
if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	if (trim($_POST['condebut']) == '') {
		$errors['condebut'] = 'Veuillez choisir une date de début';
	}
	if (trim($_POST['condefin']) == '') {
		$errors['condefin'] = 'Veuillez choisir une date de fin';
	}
	if ((trim($_POST['condebut']) != '') && (trim($_POST['condefin']) != '')) {
		if (Activite::GetTimestamp($_POST['condefin']) <= Activite::GetTimestamp($_POST['condebut'])) {
			$errors['condefin'] = 'Date de fin antérieure à la date début.';
		}
	}
	if (empty($errors)) {
		$iDate = Activite::FormatTimeForAct($_POST['condebut'], FALSE);
		$eDate = Activite::FormatTimeForAct($_POST['condefin'], TRUE);
		if ((isset($_POST['days'])) && ($_POST['days'] == 'jour')) {
			$bDay = 1;
		} else {
			$bDay = 0;
		}
		$prest = $_POST['presta'];
		if ($prest == 0) {
			$mes1 = ' pour tous les prestataires';
		} else {
			$mes1 = ' pour ' . Activite::GetPrestaNomParID($prest);
		}
		$rows = Activite::GetActivitePeriodePresta($prest, $iDate, $eDate, $bDay);
		if (!empty($rows)) {
			echo '<p>Activité pour la période du ' . FormatDateSlash($iDate) . ' au ' . FormatDateSlash($eDate) . $mes1 . '.</p>';
			//creation de la table
			echo '<br /><table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">';
			echo "\n";
			echo '<tr valign="middle" style="font-size:10px;font-weight:bold;" bgcolor="#6cff68"><td width="6%" align="center">Année</td>';
			if ($bDay == 1) {
				echo '<td width="7%" align="center">Mois</td><td width="3%" align="center">J</td>';
			} else {
				echo '<td width="10%" align="center">Mois</td>';
			}
			echo '<td width="24%" align="center">Enseigne</td><td width="5%" align="center">Nbre<br />Cde</td><td width="5%" align="center">Cde<br />Livré</td><td width="10%" align="center">Premier<br />Login</td><td width="10%" align="center">Dernier<br />Logout</td><td width="10%" align="center">Montant<br />Ventes</td><td width="10%" align="center">Commission<br />Percues</td><td width="10%" align="center">Versement<br />Prestataire</td></tr>';
			echo "\n";

			//creation tableau
			$preYear = 0;
			$premonth = 0;
			$bgy = "#1ebcff";
			$bmm = '#70a4d8';
			$b1 = "#affbad";
			$b2 = "#d3fdd2";
			$b3 = "#fbadad";
			$tBrut = 0;
			$tCde = 0;
			$tCom = 0;
			$tLiv = 0;
			$tNet = 0;
			for ($c = 0; $c < count($rows); $c++) {
				echo '<tr valign="top" style="font-size:9px;">';
				$b1 = ($b1 == "#affbad" ? "#8ecd8c" : "#affbad");
				$b2 = ($b2 == "#d3fdd2" ? "#a8cda6" : "#d3fdd2");
				$b3 = ($b3 == "#fbadad" ? "#cda6a6" : "#fbadad");
				if ($rows[$c]['cYear'] != $preYear) {
					$preYear = $rows[$c]['cYear'];
					$bgy = ($bgy == '#1ebcff' ? '#0099da' : '#1ebcff');
					echo '<td width="6%" align="center" bgcolor="' . $bgy . '"><b>' . $rows[$c]['cYear'] . '</b></td>';
				} else {
					echo '<td width="6%" bgcolor="' . $bgy . '"></td>';
				}
				if ($rows[$c]['cMonth'] != $premonth) {
					$premonth = $rows[$c]['cMonth'];
					$bmm = ($bmm == '#70a4d8' ? '#8bb8e5' : '#70a4d8');
					if ($bDay == 1) {
						echo '<td width="7" align="left" bgcolor="' . $bmm . '">' . $lesmois[$rows[$c]['cMonth']] . '</td><td width="3%" align="center" bgcolor="' . $b1 . '">' . $rows[$c]['cDay'] . '</td>';
					} else {
						echo '<td width="10%" align="left" bgcolor="' . $bmm . '">' . $lesmois[$rows[$c]['cMonth']] . '</td>';
					}
				} else {
					if ($bDay == 1) {
						echo '<td width="7" align="left" bgcolor="' . $bmm . '"></td><td width="3%" align="center" bgcolor="' . $b1 . '">' . $rows[$c]['cDay'] . '</td>';
					} else {
						echo '<td width="10%" align="left" bgcolor="' . $bmm . '"></td>';
					}
				}

				echo '<td width="24%" align="left" bgcolor="' . $b2 . '">' . $rows[$c]['cNom'] . '</td><td width="5%" align="right" bgcolor="' . $b1 . '">' . Activite::PrepData($rows[$c]['cNbreCde'], FALSE) . '</td><td width="5%" align="right" bgcolor="' . $b2 . '">' . Activite::PrepData($rows[$c]['cNbreCdeLiv'], FALSE) . '</td><td width="10%" align="center" bgcolor="' . $b1 . '">';
				if ($bDay == 1) {
					echo Activite::FormatHeureConnexion($rows[$c]['cLogin']);
				} else {
					if (trim($rows[$c]['cLogin']) != '') {
						echo FormatDateSlash($rows[$c]['cLogin']);
					}
				}
				echo '</td><td width="10%" align="center" bgcolor="' . $b2 . '">';
				if ($bDay == 1) {
					echo Activite::FormatHeureConnexion($rows[$c]['cLogout']);
				} else {
					if (trim($rows[$c]['cLogout']) != '') {
						echo FormatDateSlash($rows[$c]['cLogout']);
					}
				}
				echo '<td width="10%" align="right" bgcolor="' . $b1 . '">' . Activite::PrepData($rows[$c]['cBrut'], TRUE) . '</td><td width="10%" align="right" bgcolor="' . $b3 . '">' . Activite::PrepData($rows[$c]['cCom'], TRUE) . '</td><td width="10%" align="right" bgcolor="' . $b2 . '">' . Activite::PrepData($rows[$c]['cNet'], TRUE) . '</td></tr>';
				echo "\n";
				$tBrut += $rows[$c]['cBrut'];
				$tCde += $rows[$c]['cNbreCde'];
				$tCom += $rows[$c]['cCom'];
				$tLiv += $rows[$c]['cNbreCdeLiv'];
				$tNet += $rows[$c]['cNet'];
			}
			echo '<tr valign="top" style="font-size:9px;font-weight:bold">';
			if ($bDay == 1) {
				echo '<td colspan="4" align="right">Totaux</td>';
			} else {
				echo '<td colspan="3" align="right">Totaux</td>';
			}
			echo '<td width="5%" align="right">' . Activite::PrepData($tCde, FALSE) . '</td><td width="5%" align="right">' . Activite::PrepData($tLiv, FALSE) . '<td colspan="2"></td><td width="10%" align="right">' . Activite::PrepData($tBrut, TRUE) . '</td><td width="10%" align="right"';
			if ($tCom > 0) {
				echo ' bgcolor="#f69af9"';
			}
			echo '>' . Activite::PrepData($tCom, TRUE) . '</td><td width="10%" align="right">' . Activite::PrepData($tNet, TRUE) . '</td></tr>';
			echo '</table>';
		} else {
			echo '<p>Aucune activité enregistrée pour cette période' . $mes1 . '.</p>';
		}
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	}
}

if (is_null($dates)) {
	echo '<p>Aucune activité n\'a été enregistrée sur RESTOnet.</p>';
} else {
	//on retrouve la liste des prestataires
	$presta = Activite::GetPrestaListe();
	//mettre les dates du date picker
	$aujourd = date('Y-m-d');
	$mindate = substr($dates['minDate'], 0, 10);
	$diff = abs(strtotime($aujourd) - strtotime($mindate));
	$days = floor($diff / (60 * 60 * 24));
	echo '<script type="text/javascript">
		$(document).ready(function() {
			$.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
			$( ".datepicker" ).datepicker({
				minDate : -' . $days . ',
				maxDate : 0
			});
		});
	</script>';

	echo '<p><fieldset><legend>Selectionnez la période souhaitée</legend><p></p>';
	echo '<form action="activ_part.php" method="post" accept-charset="utf-8">
	<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
	<tr valign="top"><td wdith="30%">
	<b>Date de début : </b></td>
	<td width="20"><input type="text" class="datepicker" name="condebut" size="20" maxlength="10" value="';
	if (isset($_POST['condebut']))
		echo $_POST['condebut'];
	echo '" />';
	if (isset($errors['condebut'])) {
		echo '<br /><span class="error">' . $errors['condebut'] . '</span>';
	}
	echo '</td>
	<td wdith="30%">
	<b>Date de fin : </b></td>
	<td width="20"><input type="text" class="datepicker" name="condefin" size="20" maxlength="10" value="';
	if (isset($_POST['condefin']))
		echo $_POST['condefin'];
	echo '" />';
	if (isset($errors['condefin'])) {
		echo '<br /><span class="error">' . $errors['condefin'] . '</span>';
	}
	echo '</td></tr>';
	echo '<tr valign="top"><td width="30%"><b>Choix du prestataire :</b></td><td colspan="3"><select name="presta">
	<option value="0">Voir tous les prestataires</option>';
	for ($c = 0; $c < count($presta); $c++) {
		echo '<option value="' . $presta[$c]['prestaID'] . '"';
		if (isset($_POST['presta'])) {
			if ($_POST['presta'] == $presta[$c]['prestaID']) {
				echo ' selected="selected"';
			}
		}
		echo '>' . $presta[$c]['prestaNom'] . '</option>';
	}
	echo '</select>
	</td></tr>';
	echo '<tr valign="top"><td width="30%"></td><td colspan="2" align="right"><b>Affichage par jour :</b><br /><small>Non recommandé pour les longues periodes</small></td><td width="20%"><input type="checkbox" name="days" value="jour"';
	if (isset($_POST['days']) && ($_POST['days'] == 'jour')) {
		echo ' checked="checked"';
	}
	echo '></td></tr>';
	echo '</table>
	<br /><div align="center"><input type="submit" name="submit" value="Voir l\'activité" /></div>
	<input type="hidden" name="submitted" value="TRUE" /></fieldset>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
