<?php
//			reccmd2.php
//	fichier de récapitulation de la commande
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
if ((!isset($_SESSION['uniid'])) || (!isset($_SESSION['curprestid'])) || (!isset($_SESSION['clientid'])) || (!isset($_SESSION['livre'])) || (!isset($_SESSION['date']))) {
	$url = "index.php";
	header("Location: $url");
	exit();
}

$page_title = "Récapitulatif de ma commande - RESTOnet";
$menu = 'm9';

include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Récapitulatif de ma commande</h1>';
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

echo '<h2>Choix et date de la prestation</h2>';
include INCLUDE_DIR . 'openboxfront.php';
//mise en place de la date
$message = "<p>Vous avez choisi ";
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
$message .='<b>'. PreFormatDate($_SESSION['date']).'</b>.</p>';
echo $message;
include INCLUDE_DIR . 'closeboxfront.php';
echo '<h2>Choix de l\'horaire</h2>';
include INCLUDE_DIR . 'openboxfront.php';

echo Shop::GetPrestaHoraireJour($_SESSION['date'], $_SESSION['curprestid']);
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>