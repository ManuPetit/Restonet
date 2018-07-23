<?php
//		index.php

//		fichier d'arriver dans la partie administrative

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
//procédure de délétion des fichiers de paiement après 7 jours utilisé par retourcheck
$dir = SITE_ROOT . '/detlog';
if ($handle = opendir($dir)) {
	/* This is the correct way to loop over the directory. */
	while (false !== ($file = readdir($handle))) {
		if ($file[0] == '.' || is_dir("$dir/$file")) {
			// ignore hidden files and directories
			continue;
		}
		if ((time() - filemtime($dir .'/' . $file)) > (7 * 86400)) {//7 days
			unlink("$dir/$file");
		} 
	}
	closedir($handle);
}

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Bienvenue";
include INCLUDE_DIR . 'adminhead.php';

echo '<h2>Interface Administrative de RESTOnet</h2>';
//message de bienvenue
$row = array();
$row = Administrateur::GetAdminLastLoginParID($_SESSION['userid']);
if (!empty($row)) {
	echo '<h4>Bienvenue, ' . $row['userPrenom'] . '.</h4><p>' . $row['userLastLogin'] . '</p>';
}
echo '<br /><p>Pour choisir une action, utilisez le menu à gauche.</p>';

//update le login
Administrateur::UpdateAdminLoginParID($_SESSION['userid']);

include INCLUDE_DIR . 'adminfooter.php';
?>