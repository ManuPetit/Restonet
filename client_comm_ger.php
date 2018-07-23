<?php
//		client_comm_ger.php
//		permet à un client de voir tous ses commentaires et de les supprimer
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}

//retrouver la liste des commentaires de ce client
$comms = Client::GetAllCommenataireClientID($_SESSION['clientid']);

$page_title = "Gérer mes commentaires- RESTOnet";
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
<h1>Gérer mes commentaires</h1>';
include INCLUDE_DIR . 'openboxfront.php';
if (!empty($comms)) {
	//on affiche les commentaires
	echo '<table width="90%" border="1" cellspacing="0" cellpadding="3" align="center">
	<tr><td width="35%" align="center"><b>Etablissement</b></td><td width="20%" align="center"><b>Date</b></td><td width="30%" align="center"><b>Extrait</b></td><td width="15%" align="center"><b>Supprimer</b></td></tr>';
	for ($c = 0; $c < count($comms); $c++) {
		echo '<tr valign="middle"><td width="35%"><b>' . $comms[$c]['prestaNom'] . '</b><td width="20%" align="center">' . FormatDateSlash($comms[$c]['comteDate']) . '</td>';
		echo '<td width="30%" align="left">' . stripslashes($comms[$c]['commDesc']) . '... <a href="#" class="fbutton" style="font-size:10px;" onclick="window.open(\'windowcom.php?c='.$comms[$c]['comteID'].'\',\'comm\',\'top=100,left=100,width=630,height=400,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir votre commenataire">(suite)</a></td>';
		echo '<td width="15%" align="center"><a href="supcom.php?c=' . $comms[$c]['comteID'] . '" class="fbutton" style="font-size:10px;" title="Cliquez ici pour supprimer ce commentaire" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer ce commentaire ?\')) return true; else return false;">Supprimer</a></td></tr>';
	}
	echo '</table>';
} else {
	echo '<p>Vous n\'avez pas encore fait de commentaires sur l\'un des prestataires de RESTOnet.</p>';
}

include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>