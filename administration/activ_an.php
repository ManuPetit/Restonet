<?php
//		activ_an.php
//		permet de voir l'activité annuelle
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_activite.php';
require CHART . 'GoogleChart.php';
require CHART . 'markers/GoogleChartShapeMarker.php';
require CHART . 'markers/GoogleChartTextMarker.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

//les mois
$lesmois = array(1 => 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');

//on récupère l'année sinon on utilise celle qui est en cours
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['an'])) && (is_numeric($_GET['an']))) {
	$an = $_GET['an'];
} else {
	$an = date('Y');
}

$page_title = "Activité annuelle";
include INCLUDE_DIR . 'adminhead.php';

echo '<h2>Activité annuelle</h2>';
//on retrouve les jours d'activite
$dates = Activite::GetDateActivite();
if (is_null($dates)) {
	echo '<p>Aucune activité n\'a été enregistrée sur RESTOnet.</p>';
} else {
	//calcul années autour
	$precAn = $an - 1;
	$nextAn = $an + 1;
	$minAn = substr($dates['minDate'], 0, 4);
	$maxAn = substr($dates['maxDate'], 0, 4);
	echo '<table width="80%" align="center" cellspacing="0" cellpadding="5" border="0">
	<tr valign="middle"><td width="20%" align="left"><a href="activ_an.php?an=' . $precAn . '" ';
	if ($minAn >= $an) {
		echo 'title="Il n\'y a aucune activité pour l\'année ' . $precAn . '" class="notenable"';
	} else {
		echo 'title="Voir l\'activité de l\'année ' . $precAn . '" class="isbutton"';
	}
	echo '>' . $precAn . '</a></td><td width="60%" align="center" style="font-size:18px;"><b> Année ' . $an . '</b></td><td width="20%" align="right"><a href="activ_an.php?an=' . $nextAn . '" ';
	if ($maxAn <= $an) {
		echo 'title="Il n\'y a aucune activité pour l\'année ' . $nextAn . '" class="notenable"';
	} else {
		echo 'title="Voir l\'activité de l\'année ' . $nextAn . '" class="isbutton"';
	}
	echo '>' . $nextAn . '</a></td></tr>
	</table><br /><br />';
	//creation de la table des détails
	echo '<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr valign="middle" style="font-weight:bold;font-size:10px;" align="center" bgcolor="#6cff68"><td width="10%">Mois</td><td width="10%">Nouveaux<br />Prestataires</td><td width="10%">Nouveaux<br />Clients</td><td width="10%">Nombre<br />Commandes</td><td width="10%">Commandes<br />Annulées</td><td width="13%">Montant<br />Ventes</td><td width="12%">Commissions<br />Perçues</td><td width="13%">Versement<br />Prestataires</td><td width="12%">Commission<br />Par Cde</td></tr>';
	$act = Activite::GetActiviteAnnuelle($an);
	//variable addition
	$npres = 0;
	$nclt = 0;
	$nann = 0;
	$ncmde = 0;
	$nbrut = 0;
	$ncom = 0;
	$nnet = 0;
	$b1 = "#affbad";
	$b2 = "#d3fdd2";
	$b3 = "#fbadad";
	for ($a = 0; $a < count($act); $a++) {
		echo '<tr valign="middle" style="font-size:11px;"><td width="10%" align="left" bgcolor="#6cff68">' . $lesmois[$a + 1] . '</td>';
		$b1 = ($b1 == "#affbad" ? "#8ecd8c" : "#affbad");
		$b2 = ($b2 == "#d3fdd2" ? "#a8cda6" : "#d3fdd2");
		$b3 = ($b3 == "#fbadad" ? "#cda6a6" : "#fbadad");
		if (is_array($act[$a])) {
			echo '<td width="10%" align="right" bgcolor="' . $b1 . '">' . Activite::PrepData($act[$a]['presta'], FALSE) . '</td>';
			echo "\n";
			echo '<td width="10%" align="right" bgcolor="' . $b2 . '">' . Activite::PrepData($act[$a]['clt'], FALSE) . '</td>';
			echo "\n";
			echo '<td width="10%" align="right" bgcolor="' . $b1 . '">' . Activite::PrepData($act[$a]['cmde'], FALSE) . '</td>';
			echo "\n";
			echo '<td width="10%" align="right" bgcolor="' . $b2 . '">' . Activite::PrepData($act[$a]['ann'], FALSE) . '</td>';
			echo "\n";
			echo '<td width="13%" align="right" bgcolor="' . $b1 . '">' . Activite::PrepData($act[$a]['brut'], TRUE) . '</td>';
			echo "\n";
			echo '<td width="12%" align="right" bgcolor="' . $b3 . '">' . Activite::PrepData($act[$a]['com'], TRUE) . '</td>';
			echo "\n";
			echo '<td width="13%" align="right" bgcolor="' . $b1 . '">' . Activite::PrepData($act[$a]['NET'], TRUE) . '</td>';
			echo "\n";
			echo '<td width="12%" align="right" bgcolor="' . $b2 . '">' . Activite::MoyenneComCde($act[$a]['com'], $act[$a]['cmde']) . '</td>';
			echo "\n";
			$npres += $act[$a]['presta'];
			$nclt += $act[$a]['clt'];
			$nann += $act[$a]['ann'];
			$ncmde += $act[$a]['cmde'];
			$nbrut += $act[$a]['brut'];
			$ncom += $act[$a]['com'];
			$nnet += $act[$a]['NET'];
		} else {
			echo '<td width="10%" bgcolor="' . $b1 . '"></td><td width="10%" bgcolor="' . $b2 . '"></td><td width="10%" bgcolor="' . $b1 . '"></td><td width="10%" bgcolor="' . $b2 . '"></td><td width="13%" bgcolor="' . $b1 . '"></td><td width="12%" bgcolor="' . $b3 . '"></td><td width="13%" bgcolor="' . $b1 . '"></td><td width="12%" bgcolor="' . $b2 . '"></td>';
		}
		echo '</tr>';
		echo "\n";
	}
	echo '<tr valign="middle" style="font-size:11px;font-weight:bold;"><td width="10%" align="right">Totaux</td><td width="10%" align="right">' . Activite::PrepData($npres, FALSE) . '</td><td width="10%" align="right">' . Activite::PrepData($nclt, FALSE) . '</td><td width="10%" align="right">' . Activite::PrepData($ncmde, FALSE) . '</td><td width="10%" align="right">' . Activite::PrepData($nann, FALSE) . '</td><td width="13%" align="right">' . Activite::PrepData($nbrut, FALSE) . '</td><td width="12%" align="right"';
	if ($ncom > 0) {
		echo ' bgcolor="#f69af9"';
	}
	echo '>' . Activite::PrepData($ncom, TRUE) . '</td><td width="13%" align="right">' . Activite::PrepData($nnet, TRUE) . '</td><td width="10%" align="right">' . Activite::MoyenneComCde($ncom, $ncmde) . '</td>';
	echo '</table>';
	echo '<br /><br />';
	//creation des diagrammes
	echo '<table width="100%" border="0" cellspacing="5" cellpadding="5">
	<tr valign="middle"><td width="50%" align="center">';
	$values = array();
	$max = 0;
	for ($t = 0; $t < count($act); $t++) {
		if (is_array($act[$t])) {
			$values[$t] = $act[$t]['com'];
			if ($max < $act[$t]['com']) {
				$max = $act[$t]['com'];
			}
		} else {
			$values[$t] = 0;
		}
	}
	if ($max == 0) {
		$max = 10;
	}
	$titlegraph = "Commissions percues en $an";
	$colorgraph = "fb00cf";
	include 'graph_test.php';
	echo '</td><td width="50%" align="center">';
	$values = array();
	$max = 0;
	for ($t = 0; $t < count($act); $t++) {
		if (is_array($act[$t])) {
			$values[$t] = $act[$t]['cmde'];
			if ($max < $act[$t]['cmde']) {
				$max = $act[$t]['cmde'];
			}
		} else {
			$values[$t] = 0;
		}
	}
	if ($max == 0) {
		$max = 10;
	}
	$titlegraph = "Nombre de commandes en $an";
	$colorgraph = "2e16e0";
	include 'graph_test.php';
	echo '</td></tr>
	<tr valign="middle"><td width="50%" align="center">';
	$values = array();
	$max = 0;
	for ($t = 0; $t < count($act); $t++) {
		if (is_array($act[$t])) {
			$values[$t] = $act[$t]['presta'];
			if ($max < $act[$t]['presta']) {
				$max = $act[$t]['presta'];
			}
		} else {
			$values[$t] = 0;
		}
	}
	if ($max == 0) {
		$max = 10;
	}
	$titlegraph = "Nouveaux prestataires en $an";
	$colorgraph = "fdbe00";
	include 'graph_test.php';
	echo '</td><td width="50%" align="center">';
	$values = array();
	$max = 0;
	for ($t = 0; $t < count($act); $t++) {
		if (is_array($act[$t])) {
			$values[$t] = $act[$t]['clt'];
			if ($max < $act[$t]['clt']) {
				$max = $act[$t]['clt'];
			}
		} else {
			$values[$t] = 0;
		}
	}
	if ($max == 0) {
		$max = 10;
	}
	$titlegraph = "Nouveaux clients en $an";
	$colorgraph = "0a702e";
	include 'graph_test.php';
	echo '</td></tr>';
	echo '</table><br /><br />';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
