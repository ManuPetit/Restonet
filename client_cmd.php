<?php
//		client_cmd.php
//		permet de voir mes commandes

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

//on retrouve l'ensemble des commandes pour ce client
$commandes=Client::GetAllValidCommandeClientID($_SESSION['clientid']);

$page_title = "Mes commandes - RESTOnet";
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
<h1>Mes commandes</h1>';
include INCLUDE_DIR . 'openboxfront.php';
if (empty($commandes)){
	echo '<p>Vous n\'avez pas encore passé de commande sur notre site.</p>';
}else{
echo '<table width="98%" border="0" cellpadding="4" cellspacing="0" align="center">
<tr valign="top"><td width="26%" align="center">Date</td><td width="19%" align="center">N° Cmd.</td><td width="15%" align="right">Montant</td><td width="25%" align="center">Etat</td><td width="15%" align="center">Facture</td></tr>';
$bg = '#fef1d3';
for ($c=0;$c<count($commandes);$c++){
	$bg = ($bg == '#fef1d3' ? '#d3fef7':'#fef1d3');
	echo '<tr valign="middle"><td width="26%" bgcolor="'.$bg.'" style="font-size:11px" align="left">' . PreFormatDate($commandes[$c]['comDate']) .'</td>';
	echo '<td width="19%" bgcolor="'.$bg.'" style="font-size:11px" align="center">'. $commandes[$c]['comNumero'].'</td>';
	echo '<td width="15%" bgcolor="'.$bg.'" style="font-size:11px" align="right">'. sprintf("%01.2f", $commandes[$c]['comTotalTTC']).'</td>';
	echo '<td width="25%" bgcolor="'.$bg.'" style="font-size:11px" align="center">'. $commandes[$c]['etatNom'].'</td>';
	echo '<td width="15%" bgcolor="'.$bg.'" style="font-size:11px" align="center"><a class="fbutton" href="voirfacture.php?f='. $commandes[$c]['comNumero']. '" title="Cliquez ici pour visualiser votre facture" target="_new">Facture</a></td></tr>';
}
echo '</table>';
}
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>