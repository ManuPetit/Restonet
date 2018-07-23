<?php
//		windowcom.php
//		affiche un commentaire

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
if ($_SERVER['REQUEST_METHOD'] != 'GET' && (!isset($_GET['c'])) && (!is_numeric($_GET['c']))) {
	//erreur on ne devrait pas être la//erreur
	$url = "index.php";
	header("Location: $url");
	exit();
} else {
	$com = $_GET['c'];
}

//retrouver le commentaire
$commentaire = Client::GetCommentaireParID($com);
if (empty($commentaire)) {//erreur on ne devrait pas être la//erreur
	$url = "index.php";
	header("Location: $url");
	exit();
}
//créer la page
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="styles/restonet.css" rel="stylesheet" type="text/css" />
		<link href="styles/jquery-ui-1.8.16.front.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery/jquery-1.6.4.min.js"></script>
		<script src="jquery/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="jquery/restofront.js"></script>';
echo '<title>Mon commentaire sur ' . $commentaire['prestaNom'] . ' - RESTOnet</title>';
echo '</head>
<body>
	<div>';

echo '<table width="90%" align="center" border="0" bgcolor="#fc7c01">
	<tr><td width="100%" align="center">
	<h1 class="comm">Commentaire posté ' . PreFormatDate($commentaire['comteDate']) . ' sur ' . $commentaire['prestaNom'] . '</h1></td></tr>';
echo '<tr><td>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<p class="textdesc">' . stripslashes($commentaire['comteDescription']) . '</p>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</td></tr>';
echo '<tr><td align="center"><input class="cbutton" name="button" type="button" onclick="javascript:self.close();" value="Fermer" /><br /><br /></td></tr>
	</table>
	</div>
</body>
</html>';
