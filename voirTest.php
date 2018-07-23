<?php
//		client_cmd.php
//		permet de voir mes commandes

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_test.php';

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

echo '<p><a href="testAdd.php">Ajouter élément</a><br /><a href="voirTest.php">Voir élément</a></p>';
echo '<form action="testAdd.php" method="post" accept-charset="utf-8">';
if (isset($_GET['tID'])) {
	$test=new Tester();
	$test -> GetDetail($_GET['tID']);
	echo '<p>Détail Numéro ' . $_GET['tID'] . '</p>';
	echo '<p>Prénom : ' . $test -> GetPrenom() . '</p>';
	echo '<p>Nom : ' . $test -> getNom() . '</p>';
	echo '<p>Adresse : ' . $test -> GetAdresse() . '</p>';
	echo '<p>Description : ' . $test -> GetDescription() . '</p>';
}
$row = Tester::GetNbreDetail();
if (!empty($row)) {
	for ($c = 0; $c < count($row); $c++) {
		echo '<p><a href="voirTest.php?tID=' . $row[$c]['tID'] . '">Detail N° ' . $row[$c]['tID'] . '</a></p>';
	}
}

echo '</body>
	<html>';
