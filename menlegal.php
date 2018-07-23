<?php
//		menlegal.php
//		mentions légal du site

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$page_title = "Mentions légales - RESTOnet";
$menu = 'm10';
include INCLUDE_DIR . 'header.php';

?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Mention légales</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<p></p>';
	echo '<fieldset><legend>Détails légaux de RESTOnet.</legend>';
	echo '<p></p>';
	echo '<table width="90%" align="left" border="0" cellpadding="5" cellspacing="0">';
	echo '<tr valign="top"><td width="35%">La société :</td><td width="65%">RESTOnet.fr'.RESTONET_ADRESSE.'</td></tr>';
	echo '<tr valign="top"><td width="35%">Directeur du site :</td><td width="65%">Laetitia Kieffer Malézieux</td></tr>';
	echo '<tr valign="top"><td width="35%">Conception du site :</td><td width="65%"><a href="http://www.iiidees.com" target="_new" title="Cliquez ici pour le site internet de notre prestataire" class="suiter">www.iiidees.com</a></td></tr>';
	echo '<tr valign="top"><td colspan="2">Les logos, visuels et marques présents sur ce site sont la propriété de leurs détenteurs respectifs.</td></tr>';
	echo '<tr valign="top"><td colspan="2">Ce site peut, à son insu, avoir été relié à d\'autres sites par le biais de liens hypermedia. RESTOnet décline toute responsabilité pour les informations présentées sur ces autres sites.</td></tr>';
	echo '<tr valign="top"><td colspan="2">RESTOnet ne peut être tenue pour responsable du contenu des sites liés.</td></tr>';
	echo '<tr valign="top"><td colspan="2">Vous disposez d\'un droit d\'accès, de modification, de rectification et de suppression des données qui vous concernent (art. 34 de la Loi &quot;Informatiques et libertés&quot; du 6 janvier 1978). Pour exercer ce droit, <a href="contact.php" title="Cliquez ici pour nous envoyer un message" class="suiter">contactez-nous</a>.</td></tr>';
	echo '</table>';
	echo '<p></p>';
	echo '</fieldset>';
	echo '<p></p>';
	include INCLUDE_DIR . 'closeboxfront.php';

echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
