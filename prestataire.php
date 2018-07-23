<?php
//		prestataire.php

//		fichier principal du programme

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$presta = new Prestataire();
//on verifie que l'on a bien un prestataire
if (($_SERVER['REQUEST_METHOD'] == "GET") && (isset($_GET['prestaid'])) && (is_numeric($_GET['prestaid']))) {
	$presta -> GetPrestaParID($_GET['prestaid']);
} else {
	//erreur on retourne à l'accueil
	$url = 'prestarech.php';
	header("Location: $url");
	exit();
}
//verifier qu'on a un GUI
if (!isset($_SESSION['uniid'])) {
	$_SESSION['uniid'] = NewGuid();
}
//verifie que l'on a un prestataire valide et activé
if (($presta -> GetPrestaID() == NULL) || ($presta -> GetPrestaActif() == 0)) {
	//erreur on retourne à l'accueil
	$url = 'index.php';
	header("Location: $url");
}
//nom des categories
$cat = array();
$cat = $presta -> GetCategorieNom();
//nom des types de livraison
$livr = array();
$livr = $presta -> GetLivraisonTypeParID();
$tlivr = '<p class="textdesc"><b>Type de livraisons proposées</b> : ';
//faire le titre
$page_title = $presta -> GetPrestaNomCommercial() . ' sur RESTOnet';
//faire les meta
$metaKey = $presta -> GetPrestaNomCommercial() . ',';
$vid = $presta->GetPrestaVilleID();
$ville=array();
$ville['villeNom'] = $presta->GetPrestaVille();
$metaDesc = 'RESTOnet vous propose de découvrir les mets offerts par ' . $presta -> GetPrestaNomCommercial() . ' à ' . $presta -> GetPrestaVille() . '. Type de cuisine : ';
for ($i = 0; $i < count($cat); $i++) {
	$metaKey .= $cat[$i]['categorieNom'] . ',';
	$metaDesc .= $cat[$i]['categorieNom'] . ',';
}
$metaDesc = rtrim($metaDesc, ',') . '. Cet établissement offre :';
for ($i = 0; $i < count($livr); $i++) {
	$metaKey .= lcfirst($livr[$i]['livraisonNom']) . ',';
	$metaDesc .= lcfirst($livr[$i]['livraisonNom']) . ',';
	$tlivr .= ' ' . lcfirst($livr[$i]['livraisonNom']) . ',';
}
$metaDesc = rtrim($metaDesc, ',') . '.';
$metaKey .= strtolower($presta -> GetPrestaVille()) . ',restonet';
$tlivr = rtrim($tlivr, ',') . '.</p>';
$menu = 'm2';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
$_SESSION['lastprestapage'] = basename($_SERVER['REQUEST_URI']);
$_SESSION['lastpage'] = basename($_SERVER['REQUEST_URI']);
include 'apresta.php';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>
