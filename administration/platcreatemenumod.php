<?php
//		platcreatemenu.php
//fichier de création des plats

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_menu.php';
require_once BUSINESS_DIR . 'form.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$errors = array();
if ((isset($_POST['platid'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	if ((is_numeric($_POST['platid'])) && ($_POST['platid'] > 0)) {
		$id = (int)$_POST['platid'];
		$row = array();
		$row = Menu::GetMenuNom($id);
		if (!empty($row)) {
			$nommenu = $row['platNom'];
			$nompresta = $row['prestaNom'];
			$prixmenu = number_format($row['platPrix'], 2, ',', ' ');
		}
	}
}
if ((isset($_GET['platid'])) && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
	if ((is_numeric($_GET['platid'])) && ($_GET['platid'] > 0)) {
		$id = (int)$_GET['platid'];
		$row = array();
		$row = Menu::GetMenuNom($id);
		if (!empty($row)) {
			$nommenu = $row['platNom'];
			$nompresta = $row['prestaNom'];
			$prixmenu = number_format($row['platPrix'], 2, ',', ' ');
		}
	}
}
if (!isset($nommenu)) {
	//on est la par erreur donc on retourne a la page accueil
	$url = 'index.php';
	header("Location: $url");
	exit();
}
//on retrouve tous les groupes des menus
$groupes = array();
$groupes = Menu::GetMenuGroupe($id);
//on retrouve les plats
$plats = array();
$plats = Menu::GetMenuItemParID($id);
//array des nom
$nom = array(0 => 'premier', 'deuxième', 'troisième', 'quatrième', 'cinquième');
$page_title = "Nouveau menu";
include INCLUDE_DIR . 'adminhead.php';
if ((isset($_POST['menusub'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	include 'createmenucheckmod.php';
}

echo '<h2>Modification du menu</h2>';
echo '<p>Veuillez modifier les détails du menu : <b>&laquo;' . $nommenu . '&raquo;</b> pour <i>&laquo;' . $nompresta . '&raquo;</i> offert sur RESTOnet au prix de ' . $prixmenu . '&euro;.</p><br />';
//creation de la forme
echo '<form action="platcreatemenumod.php" method="post" accept-charset="utf-8">
	<div id="maincont">';
for ($i = 1; $i < 6; $i++) {
	echo '<div class="cont' . $i . '">
	<fieldset>
	<legend>';
	if (isset($groupes[$i - 1]['groupeNom'])) {
		echo '<Label>Nom du ' . $nom[$i - 1] . ' groupe : </label>
		<input type="text" name="groupe[]" maxlength="45" size="30" value="' . $groupes[$i - 1]['groupeNom'] . '"/>';
	} else {
		echo '<Label>Entrez le nom du ' . $nom[$i - 1] . ' groupe : </label>
		<input type="text" name="groupe[]" maxlength="45" size="30" />';
	}
	echo '</legend>
	<ul id="sites' . $i . '">';
	for ($j = 0; $j < count($plats); $j++) {
		if (isset($groupes[$i - 1]['groupeNom'])) {
			if ($plats[$j]['groupePlatNom'] == $groupes[$i - 1]['groupeNom']) {
				echo '<li><label>Plat : </label><input type="text" name="plat' . $i . '[]" size="70" maxlength="120" value="' . $plats[$j]['platNom'] . '" />';
				echo '&nbsp;&nbsp;&nbsp;<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
				echo '</li>';
			}

		} else {
			echo '<li><label>Plat : </label><input type="text" name="plat' . $i . '[]" size="70" maxlength="120" />';
			break;
		}
	}
	echo '</ul>
				<input type="button" class="add' . $i . '" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>';
}
echo '<div align="center">
		<input type="submit" name="submit" value="Modifier ' . $nommenu . '" />
	</div>
	<input type="hidden" value="TRUE" name="menusub"/>
	<input type="hidden" name="platid" value="' . $id . '"/>
</form>';

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>