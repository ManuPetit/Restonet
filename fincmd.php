<?php
//			fincmd.php
//	fichier de validation final de la commande
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

//verifier que l'on a des données
if ((!isset($_SESSION['uniid'])) || (!isset($_SESSION['curprestid'])) || (!isset($_SESSION['clientid'])) || (!isset($_SESSION['livre'])) || (!isset($_SESSION['date'])) || (!isset($_GET['h']))) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
if (!is_numeric($_GET['h'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
} else {
	$_SESSION['plage'] = (int)$_GET['h'];
}
$page_title = "Validation de ma commande - RESTOnet";
$menu = 'm9';

include INCLUDE_DIR . 'header.php';
echo '<script type="text/javascript">
<!--
function det_time()
   {
   var d = new Date();
   var c_hour = d.getHours();
   var c_min = d.getMinutes();
   var c_sec = d.getSeconds();
   var t = c_hour + ":" + c_min + ":" + c_sec;
   return t;
   }
//-->
</script>';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Validation de ma commande</h1>';
include INCLUDE_DIR . 'openboxfront.php';

//voir ce qu'il y a dans le shopping trolley
$totalcmd = 0;
$plats = array();
$plats = Shop::GetCartItemParUniqID($_SESSION['uniid']);

echo '<table width="100%" border="0" cellpadding="0" cellspacing="3px">
<tr><th width="45%" align="left">Plat</th><th width="10%" align="right">Prix</th><th width="10%"></th><th width="20%" align="center">Quantité</th><th width="15%">Total</th></tr>';
for ($p = 0; $p < count($plats); $p++) {
	echo '<tr valign="bottom"><td  class="plattab">' . $plats[$p]['platNom'] . '</td>';
	echo "\n";
	echo '<td align="right" class="plattab">';
	if ($plats[$p]['platPrixPromo'] != '0.00') {
		echo '<del class="plat">' . sprintf("%01.2f", $plats[$p]['platPrix']) . '&euro;</del></td><td align="right" class="promo">' . sprintf("%01.2f", $plats[$p]['platPrixPromo']) . '&euro;</td>';
	} else {
		echo $plats[$p]['platPrix'] . '&euro;</td><td></td>';
	}
	echo "\n";
	echo '<td align="right">' . $plats[$p]['cartQte'] . '</td>';
	echo "\n";
	echo '<td align="right" class="plattab">' . sprintf("%01.2f", $plats[$p]['Total']) . '&euro;</td></tr>';
	$totalcmd += $plats[$p]['Total'];
}
echo '<tr><td colspan="4" align="right"><b>Total du panier</b></td><td align="right"><b>' . sprintf("%01.2f", $totalcmd) . '&euro;</b></td></tr>';
echo '</table>';
include INCLUDE_DIR . 'closeboxfront.php';

echo '<h2>Validation de la prestation</h2>';
include INCLUDE_DIR . 'openboxfront.php';
//mise en place de la date
$message = "<p>Vous avez choisi ";
$heure=shop::GettrancheHoraire($_SESSION['plage']);
switch ($_SESSION['livre']) {
	case 1 :
		$message .= "d'être livré à domicile ";
		break;
	case 2 :
		$message .= "d'aller chercher votre commande chez le prestataire ";
		break;
	default :
		$message .= "de réserver une table chez le prestataire pour ";
		break;
}
$message .='<b>'. PreFormatDate($_SESSION['date']).'</b><br />entre '.$heure['horaire1'].' et '.$heure['horaire2'].'.</p>';
echo $message;
echo '<table border="0" width="100%"><tr>
<td align="center"><a class="fbutton" href="cancelcmd.php?" title="Cliquez ici pour choisir annuler votre commande" onClick="if(confirm(\'Etes-vous certain de vouloir annuler votre commande ?\')) return true; else return false;">Annuler commande</a><td>
<td align="center"><a class="fbutton" href="validcmd.php?" title="Cliquez ici pour valider votre commande">Valider commande</a><td>
</tr></table>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>
