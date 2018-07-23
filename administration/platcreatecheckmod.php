<?php
//		platcreatecheckmod.php
//		fichier de vérification de plat
$plat = new Plat();
$plat -> GetPlatDetailParID($pid);
$flag = FALSE;
//nom
if ($_POST['platnom'] != $plat -> GetPlatNom()) {
	$resp = $plat -> SetPlatNom($_POST['platnom']);
	if (!is_null($resp)) {
		$errors['plat'] = $resp;
	} else {
		$flag = TRUE;
	}
}
//description
if ($_POST['desc'] != $plat -> GetPlatDescription()) {
	$resp = $plat -> SetPlatDesc($_POST['desc']);
	if (!is_null($resp)) {
		$errors['desc'] = $resp;
	} else {
		$flag = TRUE;
	}
}
//prix
if ($_POST['prix'] != $plat -> GetPlatPrix()) {
	$resp = $plat -> SetPlatPrix($_POST['prix']);
	if (!is_null($resp)) {
		$errors['prix'] = $resp;
	} else {
		$flag = TRUE;
	}
}
//promo
if ($_POST['promo'] != $plat -> GetPlatPrixPromo()) {

	$resp = $plat -> SetPlatPrixPromo($_POST['promo']);
	if (!is_null($resp)) {
		$errors['promo'] = $resp;
	} else {
		$flag = TRUE;
	}
}
//TVA
if ($_POST['tva'] != $plat -> GetTvaID()) {

	$resp = $plat -> SetPlatTVA($_POST['tva']);
	if (!is_null($resp)) {
		$errors['tva'] = $resp;
	} else {
		$flag = TRUE;
	}
}
//actif
if ($_POST['actif'] != $plat -> GetPlatActif()) {

	$resp = $plat -> SetPlatActif($_POST['actif']);
	if (!is_null($resp)) {
		$errors['actif'] = $resp;
	} else {
		$flag = TRUE;
	}
}
//type de plat
if ($_POST['type'] != $plat -> GetTypePlat()) {

	$resp = $plat -> SetTypePlat($_POST['type']);
	if (!is_null($resp)) {
		$errors['type'] = $resp;
	} else {
		$flag = true;
	}
}
//verifiaction de l'image
if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))) {
	if (is_uploaded_file($_FILES['img']['tmp_name']) && ($_FILES['img']['error'] == UPLOAD_ERR_OK)) {
		$file = $_FILES['img'];
		$size = ROUND($file['size'] / 1024);
		if ($size > 5120) {
			$errors['img'] = "<br />Le fichier image est trop volumineux. Taille maximum : 5 Mo!";
		}
		$all_mime = array('image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG');
		$all_ext = array('.jpg', '.gif', 'jpeg');
		$image_info = getimagesize($file['tmp_name']);
		$ext = strtolower(substr($file['name'], -4));
		if ((!in_array($file['type'], $all_mime)) || (!in_array($image_info['mime'], $all_mime)) || (!in_array($ext, $all_ext))) {
			$errors['img'] = "<br />Le fichier t&eacute;l&eacute;charg&eacute; n'est pas un fichier image reconnu par le syst&egrave;me.";
		}
		//si pas d'erreur
		if (!array_key_exists('img', $errors)) {
			$newname = (string)sha1($file['name'] . uniqid('', true));
			$newname .= ((substr($ext, 0, 1) != '.') ? ".{$ext}" : $ext);
			$dest = IMAGE_PLAT_DIR . $newname;
			if (move_uploaded_file($file['tmp_name'], $dest)) {
				$_SESSION['img']['new_name'] = $newname;
				$_SESSION['img']['file_name'] = $file['name'];
				echo '<h4>Le fichier image a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; avec succ&eacute;s.</h4>';
				//generer thumbnail
				createthumb($dest, 150, 150);
				//Détruire l'image original pour garder selement thumbnail
				unlink($dest);
				//ajouter le nom du fichier à l'objet
				$plat -> SetPlatImage($_SESSION['img']['new_name']);
				$flag = true;
			} else {
				trigger_error('Le fichier ne pouvait &ecirc;tre d&eacute;plac&eacute;.');
				unlink($file['tmp_name']);
			}
		}
		//		FIN DE		if (!array_key_exists('img',$errors))
	} elseif (!isset($_SESSION['img'])) {// No current or previous uploaded file.
		switch ($_FILES['img']['error']) {
			case 1 :
			case 2 :
				$errors['img'] = '<br />Le fichier &agrave; t&eacute;l&eacute;charger est trop volumineux.';
				break;
			case 3 :
				$errors['img'] = '<br />Le fichier n\'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.';
				break;
			case 6 :
			case 7 :
			case 8 :
				$errors['img'] = '<br />Le fichier n\'a pas pu &ecirc;tre t&eacute;l&eacute;charg&eacute; &agrave; cause d\'une erreur syst&egrave;me.';
				break;
			case 4 :
			default :
				$errors['img'] = '<br />Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.';
				break;
		} // End of SWITCH.
	}
}
//		FIN DE		if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))

if (empty($errors)) {
	if ($flag == TRUE) {
		//pas d'erreur on sauvegarde le plat
		$plat -> UpdatePlat();
		//remise à zéro des fichiers
		$_POST = array();
		$_FILES = array();
		unset($file, $_SESSION['img']);
		//verifier si il faut creer le menu
		if ($plat -> IsMenu() == 1) {
			//echo 'in ismenu';
			$url = 'platcreatemenumod.php?platid=' . $plat -> GetPlatID();
			header("Location: $url");
			exit();
		} else {
			include INCLUDE_DIR . 'adminhead.php';
			echo '<h2>Modification d\'un plat</h2>';
			echo '<p>Le plat <b>' . $plat -> GetPlatNom() . '</b> a bien été mis à jour dans la base de données.</p>';
			//fermer la database
			DatabaseHandler::Close();
			include INCLUDE_DIR . 'adminfooter.php';
			exit();
		}
	} else {
		if ($plat -> IsMenu() == 1) {
			//echo 'in ismenu';
			$url = 'platcreatemenumod.php?platid=' . $plat -> GetPlatID();
			header("Location: $url");
			exit();
		} else {
			include INCLUDE_DIR . 'adminhead.php';
			echo '<h2>Modification d\'un plat</h2>';
			echo '<p>Aucune modification n\'a été faite pour le plat <b>' . $plat -> GetPlatNom() . '</b> dans la base de données.</p>';
			//fermer la database
			DatabaseHandler::Close();
			include INCLUDE_DIR . 'adminfooter.php';
			exit();
		}
	}

}
