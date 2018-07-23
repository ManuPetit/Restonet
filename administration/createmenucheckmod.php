<?php
$menu = new Menu();
$menu -> AddMenuID($id);
for ($i = 0; $i < count($_POST['groupe']); $i++) {
	$pla = 'plat' . ($i + 1);
	if ((is_null($_POST['groupe'][$i])) || (trim($_POST['groupe'][$i]) == '')) {
		//on verifie qu'il n'y a pas d'entrées dans les plats
		for ($j = 0; $j < count($_POST[$pla]); $j++) {
			if (trim($_POST[$pla][$j]) != '') {
				$errors['groupe'][$i] = 'Vous devez donner un nom au groupe';
				break;
			}
		}
	}
	if ((!isset($errors['groupe'][$i])) && (trim($_POST['groupe'][$i]) != '')) {
		//pas d'erreur on ajoute le groupe
		$result = $menu -> AddGroupeMenu($_POST['groupe'][$i]);
		if (is_null($result)) {
			//pas d'erreur on ajoute les plats
			for ($f = 0; $f < count($_POST[$pla]); $f++) {
				$result = $menu -> AddPlatGroupe($_POST['groupe'][$i], $_POST[$pla][$f]);
				if (!is_null($result)) {
					$errors[$pla][$f] = $result;
				}
			}

		} else {
			$errors['groupe'][$i] = $result;
		}
	}
}
if (empty($errors)) {
	//aucune erreur on peut donc enregistrer le menu
	$menu -> UpdateMenu();
	echo '<h2>Modification du menu</h2>';
	echo '<p>le menu <b>' . $nommenu . '</b> a été modifier avec succès dans la base de données.</p>';
} else {
	//on a des erreurs on réaffiche la forme
	echo '<h2>Modification du menu</h2>';
	echo '<p>Veuillez modifier les détails du menu : <b>&laquo;' . $nommenu . '&raquo;</b> pour <i>&laquo;' . $nompresta . '&raquo;</i> offert sur RESTOnet au prix de ' . $prixmenu . '&euro;.</p><br />';
	echo '<form action="platcreatemenumod.php" method="post" accept-charset="utf-8">
	<div id="maincont">';
	for ($i = 0; $i < count($_POST['groupe']); $i++) {
		$pla = 'plat' . ($i + 1);
		$site = 'sites' . ($i + 1);
		echo '<div class="cont1">
			<fieldset>
				<legend>
					<label>Entrez le nom du ' . $nom[$i] . ' groupe : </label>';
		echo '<input type="text" name="groupe[]" maxlength="45" size="30" value="';
		if (isset($_POST['groupe'][$i])) {
			echo $_POST['groupe'][$i];
		}
		if (isset($errors['groupe'][$i])) {
			echo '" class="error" />&nbsp;&nbsp;<span class="error"> ' . $errors['groupe'][$i] . '</span>';
		} else {
			echo '" />';
		}
		echo '</legend>
				<ul id="' . $site . '">';
		for ($j = 0; $j < count($_POST[$pla]); $j++) {
			echo '<li>
						<label>Plat : </label>
						<input type="text" name="' . $pla . '[]" size="70" maxlength="120" value="';
			if (isset($_POST[$pla][$j])) {
				echo $_POST[$pla][$j];
			}
			if (isset($errors[$pla][$j])) {
				echo '" class="error" /><br /><span class="error"> ' . $errors[$pla][$j] . '</span>';
			} else {
				echo '" />';
			}
			echo '<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
			echo '</li>';
		}

		echo '</ul>
				<input type="button" class="add1" value="Ajouter un plat" title="Cliquez ici pour ajouter un plat à ce groupe"/>
			</fieldset>
			<br />
		</div>';
	}
	echo '</div>
	<div align="center">
		<input type="submit" name="submit" value="Modifier ' . $nommenu . '" />
	</div>
	<input type="hidden" value="TRUE" name="menusub"/>
	<input type="hidden" name="platid" value="' . $id . '"/>
</form>';
}
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
exit();
