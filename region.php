<?php
//		region.php

//		fichier présentant une région

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//retrouver detail de la region
if (($_SERVER['REQUEST_METHOD'] == "GET") && (isset($_GET['regid'])) && (is_numeric($_GET['regid']))) {
	$rid = $_GET['regid'];
	$region = Shop::GetRegionDetail($rid);
	$map = 'images/maps/region' . $rid . '.jpg';
}
if (empty($region)) {
	//region non valide retour à index
	$url = 'index.php';
	header("Location: $url");
	exit();
}
//retrouver les details des départements de la region
$depts = array();
$depts = Shop::GetActifDeptParRegion($rid);
$page_title = $region['regionNom'] . ' : découvrez nos partenaires - RESTOnet';
$metaKey = $region['regionMetaKey'];
$metaDesc = $region['regionMetaDescription'];
$menu = 'm2';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['REQUEST_URI']);
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte de la region
	include BUSINESS_DIR . 'regionmap.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<?php
	echo '<a href="region.php?regid=' . $region['regionID'] . '" title="Découvrez les établissements en région ' . $region['regionNom'] . '" class="breadcrumb">' . $region['regionNom'] . '</a>&nbsp;&nbsp;';
	echo '<h1>'.$region['regionNom'].' : découvrez nos partenaires</h1>';
	$typepresta = 'region';
	include BUSINESS_DIR . 'show_presta.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>