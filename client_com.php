<?php
//		client_com.php
//		permet de commenter un prestataire
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR .'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
//retrouver la liste des presta utilisé par le client
$prestau=array();
$prestau=Client::ReturnPrestaUsedCommCliendID($_SESSION['clientid']);

$page_title = "Je commente mes prestataires - RESTOnet";
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
<h1>Je commente mes prestataires</h1>';
include INCLUDE_DIR . 'openboxfront.php';
//on vérifie si il y a des presta
if (empty($prestau)){
	echo '<p>Vous n\'avez pas encore utilisé l\'un de nos prestataires (ou bien votre commande n\'a pas encore été livré).</p><p>Vous ne pouvez donc pas encore noter un prestataire.</p>';
}else{
//on des presta on les affiches
	echo '<table width="90%" border="0" cellspacing="5" cellpadding="0" align="center">
	<tr valign="top"><td width="60%" align="left"><b>Mes prestataires</b></td><td width="20%" align="center"><b>Nbr Comment.</b></td><td width="20%" align="center"><b>Commenter</b></td></tr>';
	for ($p=0;$p<count($prestau);$p++){
		echo '<tr><td width="60%" align="left">'.$prestau[$p]['prestaNom'].'</td><td width="20%" align="center">'.$prestau[$p]['nbrCom'].'</td><td width="20%" align="center"><a class="fbutton" href="addcomm.php?p='. $prestau[$p]['prestaID']. '" title="Cliquez ici pour ajouter un commentaire pour '.$prestau[$p]['prestaNom'].'">Commentez</a></td></tr>';
	}		

	echo '</table>';
}

include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>