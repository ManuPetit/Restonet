<?php
//		showmenudetail.php
//	ouvre une fenetre avec le menu

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'cls_menu.php';
//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php
		if ((isset($nom)) && (!empty($row))) {
			echo 'Menu : ' . $nom;
		} else {
			echo 'Erreur';
		}
			?></title>
	</head>
	<body style="background-color:#000;color:#FFF;">
		<?php
		if ((isset($nom)) && (!empty($row))) {
			echo '<table width="100%" border="0">
<tr><td align="center"><h1> ' . $nom . '</h1></td></tr>';
			$groupes = array();
			for ($i = 0; $i < count($row); $i++) {
				if (!in_array($row[$i]['groupePlatNom'], $groupes)) {
					$groupes[] = $row[$i]['groupePlatNom'];
				}
			}
			for ($i=0;$i<count($groupes);$i++){
			echo '<tr><td align="center"><h3>' . $groupes[$i] . '</h3></td></tr>';
			for ($j=0;$j<count($row);$j++){
				if($row[$j]['groupePlatNom']==$groupes[$i]){
					echo '<tr><td align="center">' . $row[$j]['platNom'] . '</td></tr>';
				}
			}
			}
			echo '<tr><td></td></tr>
			<tr><td align="center"><br /><input name="button" type="button" onclick="javascript:self.close();" value="Fermer" /></td></tr>';
			echo '</table>';

		} else {
			echo 'Une erreur s\'est produite<br /><br /><input name="button" type="button" onclick="javascript:self.close();" value="Fermer" />';
		}
		?>
	</body>
</html>
