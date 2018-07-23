<?php
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
//		changecart.php
//		permet de changer le nombre d'élément d'un plat dans le panier
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['platid'])) && (is_numeric($_GET['platid'])) && (isset($_GET['act']))) {
	//on a des valeurs
	if ($_GET['act'] == 'a') {
		Shop::AddOneItemToCart($_GET['platid']);
		$url = '../changemenuitemcart.php?platid=' . $_GET['platid'];
		header("Location: $url");
		exit();
	}else if ($_GET['act'] == 'r') {
		Shop::RemoveOneItemFromCart($_GET['platid']);
		$url = '../changemenuitemcart.php?platid=' . $_GET['platid'];
		header("Location: $url");
		exit();
	}
}
if (isset($_SESSION['lastpage'])) {
	$url = '../' . $_SESSION['lastpage'];
} else {
	$url = '../index.php';
}
header("Location: $url");
exit();
?>
