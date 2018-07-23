<?php
//		prestarech.php
// 		fichier de recherche d'un prestataire
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'fonctions.php';
require_once BUSINESS_DIR . 'cls_shop.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$page_title = "Recherche de prestataire sur RESTOnet";
$menu = 'm2';
include INCLUDE_DIR . 'header.php';
$errors=array();
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);
$dept = array();
$dept=Shop::GetDepartementActif();
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	
	
	//on vérifie que la page n'a pas ete submitted
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['Sub01'])) && ($_POST['ledept'] != 0)){
		//on a une submission pour un départment
		$did = $_POST['ledept'];
		$vils=array();
		$vils =Shop::GetVillePrestaActifParDeptID($did);
		$cats=array();
		$cats=Shop::GetCategoriePrestaActifParDeptID($did);
		echo '</div>
		<!-- CONTENU  -->
		<div id="right">
		<h1>Recherche de prestataire sur RESTOnet</h1>';
		include INCLUDE_DIR . 'openboxfront.php';
		echo '<p>Utilisez le formulaire pour faire une recherche sur notre site.</p>';
		echo '<form action="prestaredetail.php" method="post" accept-charset="utf-8">';
		echo "\n";
		echo '<table width="100%" border="0" cellpadding="5px" cellspacing="0">';
		echo "\n";
		echo '<tr><th width="40%">Recherche détaillée</th><td width="60%"></td></tr>';
		echo '<tr><td>Choisissez un département</td><td>
		<select name="ledept">';
		echo '<option value="0">Départements...</option>';
		for ($d=0; $d<count($dept);$d++){
			echo '<option value="'. $dept[$d]['deptID'].'"';
			if ($did == $dept[$d]['deptID']){
				echo 'selected="selected"';
			}
			echo '>'. $dept[$d]['dept'] . '</option>';
		}
		echo '</select>';
		echo '<tr><td>Choisissez une ville</td><td>
		<select name="lavil">
		<option value="0">Villes...</option>';
		for ($v=0;$v<count($vils);$v++){
			echo '<option value="'.$vils[$v]['VilleID'].'">'.$vils[$v]['villeNom'].'</option>';
			}
		echo '</select>
		</td></tr>';
		echo '<tr><td>Choisissez une categorie de restaurant</td><td>
		<select name="lacat">
		<option value="0">Catégories...</option>';
		for ($v=0;$v<count($cats);$v++){
			echo '<option value="'.$cats[$v]['categorieID'].'">'.$cats[$v]['categorieNom'].'</option>';
			}
		echo '</select>
		</td></tr>
		</table>
		<div align="center"><input type="submit" value="Recherche..." /></div>
		<input type="hidden" name="Sub02" value="TRUE" />
		</form> 
		';
		include INCLUDE_DIR . 'closeboxfront.php';
		echo '</div>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'footer.php';
		exit();
	}
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Recherche de prestataire sur RESTOnet</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<p>Utilisez le formulaire pour faire une recherche sur notre site.</p>';
	echo '<form action="prestarech.php" method="post" accept-charset="utf-8">';
	echo "\n";
	echo '<table width="100%" border="0" cellpadding="5px" cellspacing="0">';
	echo "\n";
	echo '<tr><th width="40%">Recherche détaillée</th><td width="60%"></td></tr>';
	echo '<tr><td>Choisissez un département</td><td>
	<select name="ledept">';
	echo '<option value="0">Départements...</option>';
	for ($d=0; $d<count($dept);$d++){
		echo '<option value="'. $dept[$d]['deptID'].'">'. $dept[$d]['dept'] . '</option>';
	}
	
	echo '</select>';
	echo '<tr><td>Choisissez une ville</td><td>Vous devez d\'abord choisir un département...</td></tr>
	<tr><td>Choisissez une categorie de restaurant</td><td>Vous devez d\'abord choisir un département...</td></tr>
	</table>
	<div align="center"><input type="submit" value="Recherche..." /></div>
	<input type="hidden" name="Sub01" value="TRUE" />
	</form> 
	';

	include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>