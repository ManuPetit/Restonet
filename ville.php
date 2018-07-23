<?php
//		ville.php

//		fichier présentant une ville

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//retrouver detail de la region
if (($_SERVER['REQUEST_METHOD'] == "GET") && (isset($_GET['vilid'])) && (is_numeric($_GET['vilid']))) {
	$vid = $_GET['vilid'];
	$ville = Shop::GetVilleDetailParVilleID($vid);
}
if (empty($ville)) {
	//region non valide retour à index
	$url = 'index.php';
	header("Location: $url");
	exit();
}
$page_title = $ville['villeNom'] . ' (' . $ville['villeCP'] . ') : découvrez nos partenaires - RESTOnet';
$metaKey = $ville['villeMetaKey'];
$metaDesc = $ville['villeMetaDescription'];
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
	//affiche les catégories
	include BUSINESS_DIR . 'show_categories.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<?php
	echo '<a href="region.php?regid=' . $ville['regionID'] . '" title="Découvrez les établissements en région ' . $ville['regionNom'] . '" class="breadcrumb">' . $ville['regionNom'] . '</a>&nbsp;&nbsp;';
	echo '<span class="bread">>></span>&nbsp;';
	echo '&nbsp;<a href="departement.php?depid=' . $ville['deptID']. '" title="Découvrez les établissements du département ' . $ville['deptNom'] . '" class="breadcrumb">' . $ville['deptNom'] . '</a>&nbsp;&nbsp;';
	echo '<span class="bread">>></span>&nbsp;';
	echo '&nbsp;<a href="ville.php?vilid=' . $vid. '" title="Découvrez les établissements du département ' . $ville['villeNom'] . '" class="breadcrumb">' . $ville['villeNom'] . '</a>&nbsp;&nbsp;';
	echo '<h1>'.$ville['villeNom'] . ' (' . $ville['villeCP'] . ') : découvrez nos partenaires</h1>';
	include BUSINESS_DIR . 'showprestaparville.php';
//fin de page
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>
	