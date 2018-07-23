<?php
//		voirmenu.php

//		fichier principal du programme

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'cls_menu.php';

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
$row = array();
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['menuid']))) {
	//retrouver le nom du menu
	$resp = Menu::GetMenuNomParID($_GET['menuid']);
	if (!is_null($resp)) {
		$nom = $resp;
		//retrouver les éléments du menu
		$row = Menu::GetMenuItemParID($_GET['menuid']);
	}
}
echo '<title>';
if ((isset($nom)) && (!empty($row))) {
	echo 'Menu : ' . $nom . ' - RESTOnet';
} else {
	echo 'Erreur - RESTOnet';
}
?>
</title>
</head>
<body>
	<div>
		<?php
		if ((isset($nom)) && (!empty($row))) {
			echo '<table width="90%" align="center" border="0" bgcolor="#fc7c01">
			<tr><td><h1 class="comm">' . $nom . '</h1></td></tr><tr><td>';
			include INCLUDE_DIR . 'openboxfront.php';
			echo '<table width="100%" align="center" border="0" bgcolor="#fccf67">';
			$groupes = array();
			for ($i = 0; $i < count($row); $i++) {
				if (!in_array($row[$i]['groupePlatNom'], $groupes)) {
					$groupes[] = $row[$i]['groupePlatNom'];
				}
			}
			for ($i = 0; $i < count($groupes); $i++) {
				echo '<tr><td align="center"><b>' . $groupes[$i] . '</b></td></tr>';
				for ($j = 0; $j < count($row); $j++) {
					if ($row[$j]['groupePlatNom'] == $groupes[$i]) {
						echo '<tr><td align="center">' . $row[$j]['platNom'] . '</td></tr>';
					}
				}
			}
			echo '<tr><td></td></tr>';
			echo '<tr><td align="center"><br /><input name="button" class="cbutton" type="button" onclick="javascript:self.close();" value="Fermer" /></td></tr>';
			echo '</table>';
			include INCLUDE_DIR . 'closeboxfront.php';
			echo '</td></tr></table>';
		} else {
			echo '<p style="color:#ffffff">Une erreur s\'est produite.</p><div align="center"><input class="cbutton" name="button" type="button" onclick="javascript:self.close();" value="Fermer" /></div>';
		}
		?>
	</div>
</body>
</html> 