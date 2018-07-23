<?php
//		departement.php

//		fichier présentant un département

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//retrouver detail de la region
if (($_SERVER['REQUEST_METHOD'] == "GET") && (isset($_GET['depid'])) && (is_numeric($_GET['depid']))) {
	$did = $_GET['depid'];
	$dept = Shop::GetDeptDetailParID($did);
}
if (empty($dept)) {
	//region non valide retour à index
	$url = 'index.php';
	header("Location: $url");
	exit();
}
$page_title = $dept['deptNom'] . ' (' . $dept['deptCode'] . ') : découvrez nos partenaires - RESTOnet';
$metaKey = $dept['deptMetaKey'];
$metaDesc = $dept['deptMetaDescription'];
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
	//affiche les villes
	include BUSINESS_DIR . 'show_ville.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<?php
	echo '<a href="region.php?regid=' . $dept['regionID'] . '" title="Découvrez les établissements en région ' . $dept['regionNom'] . '" class="breadcrumb">' . $dept['regionNom'] . '</a>&nbsp;&nbsp;';
	echo '<span class="bread">>></span>&nbsp;';
	echo '&nbsp;<a href="departement.php?depid=' . $did . '" title="Découvrez les établissements du département ' . $dept['deptNom'] . '" class="breadcrumb">' . $dept['deptNom'] . '</a>&nbsp;&nbsp;';
	echo '<h1>' . $dept['regionNom'] . ' (' . $dept['deptCode'] . ') : découvrez nos partenaires</h1>';
	$typepresta = 'dept';
	include BUSINESS_DIR . 'show_presta.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>