<?php
//		changemenuitemcart.php
//		nécessaire pour changer les éléments du cart
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['platid'])) && (is_numeric($_GET['platid']))) {
	$cartid = $_GET['platid'];
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['platid'])) && (is_numeric($_POST['platid']))) {
	$cartid = $_POST['platid'];
}
if (!isset($cartid)) {
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
$plats = array();
$plats = Shop::GetAllMenuItemParCartID($cartid);
if (empty($plats)) {
	//on ne devrait pas être la
	if (isset($_SESSION['lastpage'])) {
		$url = $_SESSION['lastpage'];
	} else {
		$url = 'index.php';
	}
	header("Location: $url");
	exit();
}
$groupes = array();
for ($p = 0; $p < count($plats); $p++) {
	if (!in_array($plats[$p]['groupePlatNom'], $groupes)) {
		$groupes[] = $plats[$p]['groupePlatNom'];
	}
}
$detail = array();
$detail = Shop::GetMenuPrestaQteParCartID($cartid);
$page_title = 'Modifier : ' . $detail['platNom'] . ' - RESTOnet';
$qte = $detail['cartQte'];
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
				shop::UpdateMenuItemInCartFromModif($_SESSION['uniid'], $_POST[$platid][$key], $value);
			}
		}
		//on se redirige vers la page précédente
		$url = $_SESSION['lastpage'];
		header("Location: $url");
		exit();
	}
}
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
		<?php
		echo '<h1>Modifier ' . $detail['platNom'] . '</h1>';
		include INCLUDE_DIR . 'openboxfront.php';
		echo '<p>Vous avez modifié la quantité du menu <b>' . $detail['platNom'] . '</b> commandé chez <i>' . $detail['prestaNom'] . '</i>.<br />La quantité commandée est de ';
		if ($qte == 1) {
			echo ' <b>1</b> menu.';
		} else {
			echo '<b>' . $qte . '</b> menus.';
		}
		echo '</p>';
		echo '<form action="changemenuitemcart.php" method="post" accept-charset="utf-8">
<fieldset><legend>Modifiez vos plats : </legend>
<table width="90%" border="0" cellpadding="2px" align="center">
<tr><th width="80%">Plats</th><th width="20%">Quantité</th></tr>';
		echo "\n";
		//on cree la formeor
		for ($g = 0; $g < count($groupes); $g++) {
			echo '<tr><td colspan="2" class="heading">' . $groupes[$g] . '</td></tr>';
			echo "\n";
			//counter pour afficher la bonne variable
			$counter = 0;
			for ($p = 0; $p < count($plats); $p++) {
				if ($plats[$p]['groupePlatNom'] == $groupes[$g]) {
					echo '<tr><td width="80%"  class="plattab">' . $plats[$p]['platNom'] . '</td><td width="20%" align="center">';
					echo "\n";
					echo '<input type="text" name="qte' . $g . '[]" size="2" maxlength="3" style="text-align: right" value="';
					$val = 'qte' . $g;
					$hid = 'pid' . $g;
					if (isset($_POST[$val][$counter])) {
						echo $_POST[$val][$counter];
					} else {
						echo $plats[$p]['cartQte'];
					}
					if (isset($errors[$g])) {
						echo '" class="error';
					}
					echo '" title="Entrez ici la quantité désirée pour le plat : ' . $plats[$p]['platNom'] . '" /></td></tr>';
					/*if (isset($_POST[$val][$counter])) {
					 echo '<tr><td colspan="2">$val= ' .$val .' $counter= '. $counter.' $_POST= '.$_POST[$val][$counter].'</td></tr>' ;
					 }*/
					echo "\n";
					echo '<input type="hidden" name="' . $hid . '[]" value="' . $plats[$p]['platID'] . '" />';
					echo "\n";
					$counter++;
				}
			}
		}
		if (isset($errors[$g])) {
			echo '<tr><td colspan="2"><span class="error">' . $errors[$g] . '</span></td></tr>';
		}
		echo '</table>
		</fieldset><br />
		<div align="center"><input type="submit" name="submit" value="commander le menu" title="Cliquez ici pour confirmer votre commande du menu" /></div>
		<input type="hidden" name="menusub" value="TRUE" />
		<input type="hidden" name="platid" value="' . $cartid . '" />
		</form>';
		include INCLUDE_DIR . 'closeboxfront.php';
		echo '</div>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'footer.php';
	?>