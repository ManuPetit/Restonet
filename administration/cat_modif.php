<?php

//	cat_modif.php
//	ce fichier analyse le data avant la modification des catégories fonctionne avec cat_modif_form.php
$flag = false;

if ($_POST['catcrenom'] != $cat -> GetCatNom()) {
	$resp = $cat -> SetCatNom($_POST['catcrenom']);
	if (!is_null($resp)) {
		$errors['catcrenom'] = $resp;
	} else {
		$flag = true;
	}
}
if ($_POST['catcretit'] != $cat -> GetCatTitle()) {
	$resp = $cat -> SetCatTitle($_POST['catcretit']);
	if (!is_null($resp)) {
		$errors['catcretit'] = $resp;
	} else {
		$flag = TRUE;
	}
}
if ($_POST['catcrekey'] != $cat -> GetMetaKey()) {

	$resp = $cat -> SetMetaKey($_POST['catcrekey']);
	if (!is_null($resp)) {
		$errors['catcrekey'] = $resp;
	} else {
		$flag = true;
	}
}
if ($_POST['catcredesc'] != $cat -> GetMetaDesc()) {

	$resp = $cat -> SetMetaDesc($_POST['catcredesc']);
	if (!is_null($resp)) {
		$errors['catcredesc'] = $resp;
	} else {
		$flag = true;
	}
}
if (empty($errors)) {
	//on n'a pas d'erreur
	if ($flag == FALSE) {
		//rien à modifier
		echo '<p>Aucune modification n\'a été apportée à la catégorie ' . $cat -> GetCatNom() . '.</p>';
	} else {
		//on modifie la catégorie
		$cat -> UpdateCategorie();
		echo '<p>La catégorie ' . $cat -> GetCatNom() . ' a été modifiée dans la base de données.</p>';
	}
	DatabaseHandler::Close();

	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
?>