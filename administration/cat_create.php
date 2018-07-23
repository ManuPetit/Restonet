<?php

//	cat_create.php
//	ce fichier analyse le data avant la modification des catégories fonctionne avec cat_create_form.php
$cat = new Categorie();
$resp = $cat -> SetCatNom($_POST['catcrenom']);
if (!is_null($resp)) {
	$errors['catcrenom'] = $resp;
}
$resp = $cat -> SetCatTitle($_POST['catcretit']);
if (!is_null($resp)) {
	$errors['catcretit'] = $resp;
}
$resp = $cat -> SetMetaKey($_POST['catcrekey']);
if (!is_null($resp)) {
	$errors['catcrekey'] = $resp;
}
$resp = $cat -> SetMetaDesc($_POST['catcredesc']);
if (!is_null($resp)) {
	$errors['catcredesc'] = $resp;
}
if (empty($errors)) {
	//on n'a pas d'erreur on enregistre la catégorie
	$cat -> CreateCategorie();
	echo '<h2>Creation d\'une nouvelle catégorie de restaurant</h2>
		<p>La création de la catégorie : <b>' . $cat -> GetCatNom() . '</b> est terminée.';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
?>
