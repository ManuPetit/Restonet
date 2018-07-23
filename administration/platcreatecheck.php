<?php
//		platcreate.php
//		fichier de vérification de plat
$plat = new Plat();
//ID
if ($_POST['presta'] == 0) {
	$errors['presta'] = "Veuillez sélectionner un prestataire";
} else {
	$resp = $plat -> SetPrestaID($_POST['presta']);
	if (!is_null($resp)) {
		$errors['presta'] = $resp;
	}
}
//nom
$resp = $plat -> SetPlatNom($_POST['plat']);
if (!is_null($resp)) {
	$errors['plat'] = $resp;
}
//description
$resp = $plat -> SetPlatDesc($_POST['desc']);
if (!is_null($resp)) {
	$errors['desc'] = $resp;
}
//prix
$resp = $plat -> SetPlatPrix($_POST['prix']);
if (!is_null($resp)) {
	$errors['prix'] = $resp;
}
//promo
$resp = $plat -> SetPlatPrixPromo($_POST['promo']);
if (!is_null($resp)) {
	$errors['promo'] = $resp;
}
//TVA
$resp = $plat -> SetPlatTVA($_POST['tva']);
if (!is_null($resp)) {
	$errors['tva'] = $resp;
}
//actif
$resp = $plat -> SetPlatActif($_POST['actif']);
if (!is_null($resp)) {
	$errors['actif'] = $resp;
}
//type de plat
$reps = $plat -> SetTypePlat($_POST['type']);
if (!is_null($resp)) {
	$errors['type'] = $reps;
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
				$imgresp = '<h4>Le fichier image a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; avec succ&eacute;s.</h4>';
				//generer thumbnail
				createthumb($dest, 150, 150);
				//Détruire l'image original pour garder selement thumbnail
				unlink($dest);
				//ajouter le nom du fichier à l'objet
				$plat -> SetPlatImage($_SESSION['img']['new_name']);
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
	//echo 'in error';
	//pas d'erreur on peut donc sauvegarder le plat
	$plat -> CreatePlat();
	$leid = $_POST['presta'];
	//remise à zéro des fichiers
	$_POST = array();
	$_FILES = array();
	unset($file, $_SESSION['img']);
	//verifier si il faut creer le menu
	if ($plat -> IsMenu() == 1) {
		//echo 'in ismenu';
		$url = 'platcreatemenu.php?platid=' . $plat -> GetPlatID();
		header("Location: $url");
		exit();
	} else {
		include INCLUDE_DIR . 'adminhead.php';
		if (isset($imgresp)) {
			echo $imgresp;
			$imgresp = null;
		}
		echo '<p>Le plat <b>' . $plat -> GetPlatNom() . '</b> a bien été enregistré dans la base de données.</p>';
		//on change pour permettre la creation d'un autre plat
		echo '<h4>Création d\'un autre plat</h4>';
	}

} else {
	include INCLUDE_DIR . 'adminhead.php';
	echo '<h2>Création d\'un nouveau plat</h2>';
}
