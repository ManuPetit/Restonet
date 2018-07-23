<?php
//		index.php

//		fichier principal du programme

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$page_title = "Bienvenue sur RESTOnet : choisissez votre repas en ligne";
$menu = 'm1';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);
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
	<h1>Bienvenue sur RESTOnet : choisissez votre repas en ligne</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<p>
		Bienvenue sur notre site. Vous allez pouvoir découvrir de nombreux restaurateurs qui vous proposeront de commander leurs plats.
	</p>
	<p>
		Vous pourrez soit aller manger dans leur établissement, aller chercher le plat ou vous faire livrer.
	</p>
	<?php
	include INCLUDE_DIR . 'closeboxfront.php';
	$typepresta = 'accueil';
	include BUSINESS_DIR . 'show_presta.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>