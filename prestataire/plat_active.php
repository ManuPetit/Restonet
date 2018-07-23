<?php
//		plat_active.php
// 		active ou désactive un plat

require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_plat.php';
$url = 'plat_liste_form.php';
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['platid'])) && (isset($_GET['s'])) && (isset($_GET['p'])) && (isset($_GET['sort'])) && (isset($_GET['i'])) && (isset($_GET['a']))) {
	if ($_GET['a'] == 'o') {
		Plat::SetPlatEstActif($_GET['platid']);
	}else if ($_GET['a'] == 'n') {
		Plat::SetPlatEstNonActif($_GET['platid']);
	}
	$url .= '?s=' . $_GET['s'] . '&p=' . $_GET['p'] . '&sort=' . $_GET['sort'] . '&i=' . $_GET['i'];
}
header("Location: $url");
exit();
?>
