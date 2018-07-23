<?php
//	moncompte.php
//  permet à l'utilisateur de vérifier son compte
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
$page_title = "Votre compte sur RESTOnet";
$menu = 'm5';

include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';
//afficher le panier
include BUSINESS_DIR . 'show_cart.php';
include BUSINESS_DIR . 'show_menuclient.php';
echo '</div>
<!-- CONTENU  -->
<div id="right">
<h1>Votre compte sur RESTOnet</h1>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<p>Utilisez le menu de gauche pour gérer votre compte personnel sur RESTOnet.</p>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>
