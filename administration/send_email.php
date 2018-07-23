<?php
//		send_email.php

//		envoye un message à partir d'un bouton

require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();


if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['m']))) {
	$filtext = ADMIN_DIR . 'temp/text' . $_GET['m'] . '.log';
	$filmail = ADMIN_DIR . 'temp/mail' . $_GET['m'] . '.log';
	$ft = fopen($filtext, 'r');
	$message=fread($ft, filesize($filtext));
	fclose($ft);
	$fe = fopen($filmail, 'r');
	$email = fread($fe, filesize($filmail));
	fclose($fe);
	require_once BUSINESS_DIR . 'phpmail/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail -> CharSet = 'utf-8';
	$mail -> Host = "restonet.fr";
	$body = $message;
	$mail -> SetFrom("info@restonet.com");
	$mail -> AddAddress($email);
	$mail -> Subject = "Bienvenue sur RESTOnet";
	$mail -> MsgHTML($body);
	$log = '../err/errors_log.txt';
	if (!$mail -> Send()) {
		$date = date('Y-m-d H:i:s');
		$mes = "   |  Date:  " . $date . " -> Erreur Envoi mail : " . $email . " à $to\r\n";
		error_log($mes, 3, $log);
		$finalmes ='<h2>Creation d\'un nouveau prestataire</h2><p>Une erreur s\'est produite lors de la transmission de l\'email.</p>';
	}else{
		//enlever le fichier
		unlink($filmail);
		unlink($filtext);
		$finalmes = '<h2>Creation d\'un nouveau prestataire</h2><p>L\'email d\'inscription a bien été transmis pour ce nouveau prestataire.</p>';
	}
	$page_title = "Création d'un prestataire";
	include INCLUDE_DIR . 'adminhead.php';
	echo $finalmes;
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';	
	exit();
}else{
	$url = ADMIN_DIR . 'index.php';
	header("Locaion: $url");
	exit();
}
?>