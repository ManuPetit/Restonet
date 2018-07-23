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
$page_title = "Nouveau menu";
include INCLUDE_DIR . 'adminhead.php';
if ((isset($_POST['menusub'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	include 'createmenucheck.php';
}

echo '<h2>Création du menu</h2>';
echo '<p>Vous pouvez entrer un <b>maximum de 5 groupes</b> par menu. Chaque groupe doit être nommé. <i>Par exemple : le premier groupe peut s\'appeler "Entrées", le deuxième "Plats" etc...</i></p>L\'ordre dans lequel vous entrerez les groupes definira l\'ordre de présentation du menu.</p>
<p>Veuillez entrer les détails du menu : <b>&laquo;' . $nommenu . '&raquo;</b> pour <i>&laquo;' . $nompresta . '&raquo;</i> offert sur RESTOnet au prix de ' . $prixmenu . '&euro;.</p><br />';
?>
<form action="platcreatemenu.php" method="post" accept-charset="utf-8">
	<div id="maincont">
		<div class="cont1">
			<fieldset>
				<legend>
					<label>Entrez le nom du premier groupe : </label>
					<input type="text" name="group[]" maxlength="45" size="30"/>
				</legend>
				<ul id="sites1">
					<li>
						<label>Plat : </label>
						<input type="text" value="" name="plat1[]" size="70" maxlength="120"/>
					</li>
				</ul>
				<input type="button" class="add1" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>
		<div class="cont2">
			<fieldset>
				<legend>
					<label>Entrez le nom du deuxième groupe : </label>
					<input type="text" name="group[]" maxlength="45" size="30"/>
				</legend>
				<ul id="sites2">
					<li>
						<label>Plat : </label>
						<input type="text" value="" name="plat2[]" size="70" maxlength="120"/>
					</li>
				</ul>
				<input type="button" class="add2" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>
		<div class="cont3">
			<fieldset>
				<legend>
					<label>Entrez le nom du troisième groupe : </label>
					<input type="text" name="group[]" maxlength="45" size="30"/>
				</legend>
				<ul id="sites3">
					<li>
						<label>Plat : </label>
						<input type="text" value="" name="plat3[]" size="70" maxlength="120"/>
					</li>
				</ul>
				<input type="button" class="add3" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>
		<div class="cont4">
			<fieldset>
				<legend>
					<label>Entrez le nom du quatrième groupe : </label>
					<input type="text" name="group[]" maxlength="45" size="30"/>
				</legend>
				<ul id="sites4">
					<li>
						<label>Plat : </label>
						<input type="text" value="" name="plat4[]" size="70" maxlength="120"/>
					</li>
				</ul>
				<input type="button" class="add4" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>
		<div class="cont5">
			<fieldset>
				<legend>
					<label>Entrez le nom du cinquieme groupe : </label>
					<input type="text" name="group[]" maxlength="45" size="30"/>
				</legend>
				<ul id="sites5">
					<li>
						<label>Plat : </label>
						<input type="text" value="" name="plat5[]" size="70" maxlength="120"/>
					</li>
				</ul>
				<input type="button" class="add5" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>
	</div>
	<div align="center">
		<input type="submit" name="submit" value="Enregistrer <?php echo $nommenu;?>" />
	</div>
	<input type="hidden" value="TRUE" name="menusub"/>
	<input type="hidden" name="platid" value="<?php echo $id;?>"/>
</form>
<?php
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>