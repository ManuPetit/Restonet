<?php
//		client_com.php
//		permet de commenter un prestataire
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$pid = $_POST['p'];
	$resp = Client::InsertPrestaCommentaire($_POST['comm'], $_SESSION['clientid'], $_POST['p']);
	if (is_null($resp)){
		$url="client_com.php";
		header("Location: $url");
		exit();
	}else{
		$errors['comm']=$resp;
	}
} else {
	if (($_SERVER['REQUEST_METHOD'] != 'GET') && (!isset($_GET['p'])) && (!is_numeric($_GET['p']))) {
		//erreur
		$url = "index.php";
		header("Location: $url");
		exit();
	} else {
		$pid = $_GET['p'];
	}
}

//retrouver le nom du prestataire
$prestanom = Prestataire::GetNomParID($pid);

$page_title = "Mon commentaire sur $prestanom - RESTOnet";
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
<h1>Mon commentaire sur ' . $prestanom . '</h1>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<fieldset><legend>Entrez votre commentaire</legend>
<form action="addcomm.php" method="post" accept-charset="utf-8">';
create_form_input('comm', 'textarea', $errors);
echo '<input type="hidden" name="p" value="' . $pid . '" />
<div align="center"><br /><input type="submit" name="submit" value="Enregistrer mon commentaire" /></div>
<input type="hidden" name="submission" value="true" />
</form>
</feildset>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>