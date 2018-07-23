<?php
//		presta_cmd_plan.php
//		permet l'affichage du planning d'un prestataire
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

//preparation du calendrier
$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Jullet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['month'])) && (isset($_GET['year']))) {
	$cMonth = $_GET['month'];
	$cYear = $_GET['year'];
} else {
	$cMonth = date("n");
	$cYear = date("Y");
}
$cprevYear = $cYear;
$cnextYear = $cYear;
$cprevMonth = $cMonth - 1;
$cnextMonth = $cMonth + 1;
if ($cprevMonth == 0) {
	$cprevMonth = 12;
	$cprevYear = $cprevYear - 1;
}
if ($cnextMonth == 13) {
	$cnextMonth = 1;
	$cnextYear = $cnextYear + 1;
}
$cejour = date('d');
$cemois = date('m');
$cetan = date('Y');

$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
$maxday = date("t", $timestamp);
$endtime = mktime(23, 59, 59, $cMonth, $maxday, $cYear);
$debut = date('Y-m-d', $timestamp);
$fin = date('Y-m-d', $endtime);
$thismonth = getdate($timestamp);
$startday = $thismonth['wday'];
//retrouver les commandes de ce prestataire
$cmde = Prestataire::GetCommdeplanningPrestaID($debut, $fin, $_SESSION['prestaid']);
for ($c = 0; $c < count($cmde); $c++) {
	$cmde[$c]['jour'] = (int)substr($cmde[$c]['comDateLivre'], -2);
}

$page_title = "Planning commande";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Planning commande</h2>';

echo '<table width="840px" align="center" border="0" cellpadding="0" cellspacing="10">
<tr valign="middle"><td colspan="2"><a href="presta_cmd_plan.php?month=' . $cprevMonth . '&year=' . $cprevYear . '" title="cliquez ici pour voir le mois précédent." class="isbutton">Précédent</a></td><td colspan="3" align="center"><h3>' . $mois[$cMonth - 1] . ' ' . $cYear . '</h3></td><td colspan="2" align="right"><a href="presta_cmd_plan.php?month=' . $cnextMonth . '&year=' . $cnextYear . '" title="cliquez ici pour voir le mois suivant." class="isbutton">Suivant</a></td></tr>';
echo '<tr valign="top"><td width="120" align="center">Dimanche</td>
<td width="110" align="center">Lundi</td>
<td width="110" align="center">Mardi</td>
<td width="110" align="center">Mercredi</td>
<td width="110" align="center">Jeudi</td>
<td width="110" align="center">Vendredi</td>
<td width="110" align="center">Samedi</td></tr>';
//calendrier
for ($i = 0; $i < ($maxday + $startday); $i++) {
	if (($i % 7) == 0) {
		echo "<tr valign=\"top\">\n";
	}
	if ($i < $startday) {
		echo "<td></td>\n";
	} else {
		if (($cYear == $cetan) && ($cMonth == $cemois) && (($i - $startday + 1) == $cejour)) {
			echo "<td class=\"planOn\"><b>" . ($i - $startday + 1) . "</b><br />\n";

		} else {
			echo "<td class=\"plan\"><b>" . ($i - $startday + 1) . "</b><br />\n";

		}
		for ($c = 0; $c < count($cmde); $c++) {
			if ($cmde[$c]['jour'] == ($i - $startday + 1)) {
				if ($cmde[$c]['etatID'] == 4) {
					$cls = "livre";
				} else {
					$cls = "cours";
				}
				echo '<p><a href="#" onclick="window.open(\'cmddetail.php?cmd=' . $cmde[$c]['comNumero'] . '\',\'comm\',\'top=100,left=100,width=600,height=500,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir le détail de cette commande." class="' . $cls . '">' . $cmde[$c]['comNumero'] . '</a></p>';
			}
		}

	}
	if (($i % 7) == 6) {
		echo "</tr>\n";
	}
}
echo '</table>';
echo '<table border="0" width="500" align="center">
<tr><td width="50%" align="right"><a href="#" class="livre">légende</a></td><td width="50%"> : commande déjà effectuée</td></tr>
<tr><td width="50%" align="right"><a href="#" class="cours">légende</a></td><td width="50%"> : commande en cours</td></tr>
</table>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
