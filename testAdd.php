<?php
//		client_cmd.php
//		permet de voir mes commandes

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_test.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<style>
		.error {color:#ff0000;}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Test adding</title>
	</head>
	<body>';
//verifier
if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	//on fait une vérifiaction
	$test = new Tester();
	$resp = $test -> SetPrenom($_POST['prenom']);
	if (!is_null($resp)) {
		$errors['prenom'] = $resp;
	}
	$resp = $test -> SetNom($_POST['nom']);
	if (!is_null($resp)) {
		$errors['nom'] = $resp;
	}
	$resp = $test -> SetAdresse($_POST['adresse']);
	if (!is_null($resp)) {
		$errors['adresse'] = $resp;
	}
	$resp = $test -> SetDescription($_POST['desc']);
	if (!is_null($resp)) {
		$errors['desc'] = $resp;
	}

	if (empty($errors)) {
		$test -> SaveDetail();
		echo 'Détails sauvés';
		echo '</body>
	<html>';
	}

}
echo '<p><a href="testAdd.php">Ajouter élément</a><br /><a href="voirTest.php">Voir élément</a></p>';
echo '<form action="testAdd.php" method="post" accept-charset="utf-8">';
echo '<p>Prenom : ';
create_form_input('prenom', 'text', $errors, 40, 80);
echo '</p><p>Nom : ';
create_form_input('nom', 'text', $errors, 40, 80);
echo '</p><p>Adresse : ';
create_form_input('adresse', 'text', $errors, 40, 80);
echo '</p><p>Message : <br />';
create_form_input('desc', 'textarea', $errors);
echo '</p><div><input type="submit" name="submit" value="Enregistrer" /><input type="hidden" name="submitted" value="TRUE" />';
echo '</form>';
echo '</body>
	<html>';
