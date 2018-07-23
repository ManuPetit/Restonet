<?php
//		voircommanet.php

//		permet de voir les commentaires d'un prestataire

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="styles/restonet.css" rel="stylesheet" type="text/css" />
		<link href="styles/jquery-ui-1.8.16.front.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery/jquery-1.6.4.min.js"></script>
		<script src="jquery/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="jquery/restofront.js"></script>';
$title = "Erreur";
$comm = array();
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (is_numeric($_GET['prestaid']))) {
	$title = Prestataire::GetNomParID($_GET['prestaid']) . ' : commentaires';
	$comm = Prestataire::GetTousCommentaires($_GET['prestaid']);
}
echo '<title>' . $title . ' - RESTOnet</title>';
?>
</head>
<body>
	<div>
	<?php
	if (empty($comm)) {
		echo '<p style="color:#ffffff">Une erreur s\'est produite.</p>';
	} else {
		echo '<table width="90%" align="center" border="0" bgcolor="#fc7c01">
		<tr><td><h1 class="comm">'.$title.'</h1></td></tr>';
		
		for ($i=0;$i<count($comm);$i++){
			$ente = 'posté le ' . date("d/m/Y", strtotime($comm[$i]['comteDate'])). ' à '.date("h:i:s", strtotime($comm[$i]['comteDate'])). ' le commentaire suivant :';
			echo '<tr><td>';			
			include INCLUDE_DIR . 'openboxfront.php';
			echo '<p><b>' . $comm[$i]['clientNom'] .'</b> a ' . $ente .'</p>';
			echo '<p class="textdesc">' . stripslashes($comm[$i]['ComteDescription']);		
			include INCLUDE_DIR . 'closeboxfront.php';
			echo '</td></tr>';
		}
		echo '<tr><td align="center"><input class="cbutton" name="button" type="button" onclick="javascript:self.close();" value="Fermer" /><br /><br /></td></tr>';
		echo '</table>';
	}
	?>
	</div>
</body>
</html> 