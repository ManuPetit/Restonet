<?php
//			cancelcmd.php
//	fichier d'annulation de la commande
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//on vide le cart
Shop::DeleteCartItemFromCartUserID($_SESSION['uniid']);
//on enlève la session de prestataire
unset($_SESSION['curprestid']);
$page_title = "Suppression de ma commande - RESTOnet";
$menu = 'm9';
include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Suppression de ma commande</h1>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<p>Votre panier a bien été vidé. Vous n\'avez plus de plat en commande...</p>';
//vérifier que il n'y a pas de détail dans la commande
if (isset($_SESSION['cmdid'])) {
	$sql = "CALL del_commande(:cID)";
	$param = array(':cID'=>$_SESSION['cmdid']);
	DatabaseHandler::Execute($sql,$param);
	unset($_SESSION['dateCmd']);
	unset($_SESSION['livre']);
	unset($_SESSION['date']); 
	unset($_SESSION['plage']);
	unset($_SESSION['prixTTC']);
	unset($_SESSION['cmdid']);
}
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>