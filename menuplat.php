<?php
//		menuplat.php

//		fichier de selection des plats d'un menu

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$presta = new Prestataire();
//on verifie que l'on a bien un prestataire
if (($_SERVER['REQUEST_METHOD'] == "GET") && (isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])) && (isset($_GET['qte'])) && (is_numeric($_GET['qte']))) {
	//verifier que l'on a bien ce menu pour cet id
	if (Shop::CheckMenuForGUID($_SESSION['uniid'], $_GET['menuid']) == 1) {
		$qte = $_GET['qte'];
		$menuid = $_GET['menuid'];
	}
}
if (($_SERVER['REQUEST_METHOD'] == "POST") && (isset($_POST['menuid'])) && (is_numeric($_POST['menuid'])) && (isset($_POST['qte'])) && (is_numeric($_POST['qte']))) {
	//verifier que l'on a bien ce menu pour cet id
	if (Shop::CheckMenuForGUID($_SESSION['uniid'], $_POST['menuid']) == 1) {
		$qte = $_POST['qte'];
		$menuid = $_POST['menuid'];
	}
}
if (!isset($qte)) {
	//on ne devrait pas être la
	if (isset($_SESSION['lastpage'])) {
		$url = $_SESSION['lastpage'];
	} else {
		$url = 'index.php';
	}
	header("Location: $url");
	exit();
}
$errors = array();
$platerr = array();
//on retrouve le nom du menu et son prestataire
$row = array();
$row = Shop::GetMenuEtPrestaNom($menuid);
//les plats du menu
$plat = array();
$plat = shop::GetMenuItemParID($menuid);
$groupes = array();
for ($i = 0; $i < count($plat); $i++) {
	if (!in_array($plat[$i]['groupePlatNom'], $groupes)) {
		$groupes[] = $plat[$i]['groupePlatNom'];
	}
}
//on verifie que l'on n'a pas un submit
if (($_SERVER['REQUEST_METHOD'] == "POST") && (isset($_POST['menusub']))) {
	//On vérifie le menu
	$totalgroupe = array();

	//verification du nombre de plat par groupe égal à qte
	for ($g = 0; $g < count($groupes); $g++) {
		$totalgroupe[$g] = 0;
		$val = 'qte' . $g;
		foreach ($_POST[$val] as $key => $value) {
			if (!is_numeric($value)) {
				$errors[$g] = 'Vous avez entré une valeur non numérique dans ce groupe.';
				break 2;
			} else {
				$totalgroupe[$g] += (int)$value;
			}
		}
		if ($totalgroupe[$g] != $qte) {
			$errors[$g] = 'Le nombre de plats commandés dans ce groupe ne correspond pas au nombre total de menu commandé.';
		}
	}
	//on n'a pas d'erreur
	if (empty($errors)) {
		//on ajoute les plats
		for ($g = 0; $g < count($groupes); $g++) {
			$platqte = 'qte' . $g;
			$platid = 'pid' . $g;
			foreach ($_POST[$platqte] as $key => $value) {
				//on ajoute les plats dont la valeur n'est pas zéro
				if ($value != 0) {
					shop::AddToCart($_SESSION['uniid'], $_POST[$platid][$key], $value);
				}
			}
		}
		//on se redirige vers la page précédente
		$url = $_SESSION['lastpage'];
		header("Location: $url");
		exit();
	}
}

/*
 echo '<pre>';
 print_r($_POST);
 echo '</pre>';
 exit();
 */

$page_title = $row['platNom'] . ' (' . $row['prestaNom'] . ') - RESTOnet';
$metaDesc = $row['platNom'] . ' proposé par ' . $row['prestaNom'];
$menu = 'm2';
include INCLUDE_DIR . 'header.php';
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<h1><?php echo $row['platNom'] . ' - ' . $row['prestaNom'];?></h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<p>Vous avez commandé ' . $qte . ' ' . $row['platNom'] . ' à ' . $row['platPrix'] . '&euro; chacun.</p>';
	echo '<form action="menuplat.php" method="post" accept-charset="utf-8">
<fieldset><legend>Choisissez vos plats : </legend>
<table width="90%" border="0" cellpadding="2px" align="center">
<tr><th width="80%">Plats</th><th width="20%">Quantité</th></tr>';
	echo "\n";
	//on cree la forme
	for ($g = 0; $g < count($groupes); $g++) {
		echo '<tr><td colspan="2" class="heading">' . $groupes[$g] . '</td></tr>';
		echo "\n";
		//counter pour afficher la bonne variable
		$counter = 0;
		for ($p = 0; $p < count($plat); $p++) {
			if ($plat[$p]['groupePlatNom'] == $groupes[$g]) {
				echo '<tr><td width="80%"  class="plattab">' . $plat[$p]['platNom'] . '</td><td width="20%" align="center">';
				echo "\n";
				echo '<input type="text" name="qte' . $g . '[]" size="2" maxlength="3" style="text-align: right" value="';
				$val = 'qte' . $g;
				$hid = 'pid' . $g;
				if (isset($_POST[$val][$counter])) {
					echo $_POST[$val][$counter];
				} else {
					echo '0';
				}
				if (isset($errors[$g])) {
					echo '" class="error';
				}
				echo '" title="Entrez ici la quantité désirée pour le plat : ' . $plat[$p]['platNom'] . '" /></td></tr>';
				/*if (isset($_POST[$val][$counter])) {
				 echo '<tr><td colspan="2">$val= ' .$val .' $counter= '. $counter.' $_POST= '.$_POST[$val][$counter].'</td></tr>' ;
				 }*/
				echo "\n";
				echo '<input type="hidden" name="' . $hid . '[]" value="' . $plat[$p]['platID'] . '" />';
				echo "\n";
				$counter++;
			}
		}
		if (isset($errors[$g])) {
			echo '<tr><td colspan="2"><span class="error">' . $errors[$g] . '</span></td></tr>';
		}
	}
	echo '</table>
</fieldset><br />
<div align="center"><input type="submit" name="submit" value="commander le menu" title="Cliquez ici pour confirmer votre commande du menu" /></div>
<input type="hidden" name="menusub" value="TRUE" />
<input type="hidden" name="menuid" value="' . $menuid . '" />
<input type="hidden" name="qte" value="' . $qte . '" />
</form>
<br />';
	include INCLUDE_DIR . 'closeboxfront.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>