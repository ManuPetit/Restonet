<?php
//		about.php

//		fichier qui sommes nous

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$page_title = "Qui sommes-nous ? RESTOnet";
$menu = 'm3';
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
	<h1>Qui sommes-nous ?</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<p>
		RESTOnet vous propose un concept unique !!!!
	</p>
	<p>
		A livrer, à emporter ou sur place ?????
	</p>
	<p>
		Dans votre ville, dans votre région ou ailleurs ???
	</p>
	<p>
		RESTOnet répond à toutes vos attentes :
		<br />
		Vous pouvez de chez vous commandez vos plats à emporter, à consommer sur place ou être livré à votre domicile.
	</p>
	<p>
		Les prestataires présents sur le site feront le nécessaire afin de vous satisfaire au mieux.
	</p>
	<p>
		D’une utilisation rapide et simple RESTOnet deviendra la référence incontournable pour passer de bons moments autours de bons plats.
	</p>
	<?php
	include INCLUDE_DIR . 'closeboxfront.php';
	?>
	<h1>Restaurateurs : rejoignez RESTOnet !</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<h3 class="boitetitle">Augmentez le chiffre d'affaires de votre restaurant<br />sans investissement de départ !</h3>
	<p>
		<b>Un service sans engagement</b>
		<br />
		Ne nécessite aucun abonnement.
	</p>
	<p>
		<b>Envoi d'une unique facture en fin de mois</b>
		<br />
		Facilitez votre comptabilité en recevant une seule facture, consultez l’historique de vos commandes sur notre site.
	</p>
	<p>
		<b>Une page personnalisée sur le site</b>
		<br />
		Gérer toute votre activité via votre page personnalisée sur le site.
	</p>
	<p>
		<b>Un support publicitaire </b>
		<br />
		Votre restaurant référencé partout en France et visible très rapidement.
	</p>
	<p>
		<b>Un suivi personnalisé</b>
		<br />
		notre service commercial est à votre écoute.
	</p>
	<p>
		Contactez-nous par <a href="contact.php" class="suite">email</a> pour plus de renseignements...
	</p>
	<?php
	include INCLUDE_DIR . 'closeboxfront.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>