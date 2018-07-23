<?php
//		supcom.php
//		fichier de suppression de commentaire
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
//verifier la valeur
if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['c'])) && (is_numeric($_GET['c']))) {
	//on a un commentaire à supprimer
	Client::DeleteCommentaire($_SESSION['clientid'], $_GET['c']);
} 
//on retourne à la page de gestion des commentaires
$url="client_comm_ger.php";
header("Location: $url");
exit();
