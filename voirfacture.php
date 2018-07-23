<?php
//		voirfacture.php
//		permet de visualiser une facture
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
if ((isset($_GET['f'])) && (is_numeric($_GET['f']))){
	$commandeNumero=$_GET['f'];
	$IsEmail = false;
	include 'create_facture.php';
}else{
	$url = "index.php";
	header("Location: $url");
	exit();
}
?>