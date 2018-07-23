<?php
//	addtocart.php
//cette fonction ajoute un plat au cart et vérifie si c'est un menu

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';
require_once BUSINESS_DIR . 'fonctions.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

if (($_SERVER['REQUEST_METHOD'] == 'POST')&&(isset($_POST['menuid']))&&(is_numeric($_POST['menuid']))&&(isset($_POST['qte']))&&(is_numeric($_POST['qte']))){
	//on a une valeur transmisse
	$resp=Shop::AddToCart($_SESSION['uniid'], $_POST['menuid'], $_POST['qte']);
	if (!isset($_SESSION['curprestid'])){
		$_SESSION['curprestid']=Shop::GetPrestaIDParPlatID($_POST['menuid']);
	}
	$amount=Shop::GetCartAmount($_SESSION['uniid']);
	echo json_encode(array("nbr"=>$resp,'amt'=>$amount));
}
?>