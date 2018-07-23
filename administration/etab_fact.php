<?php
//		etab_fact.php
// permet d'établir les factures aux prestataires
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_activite.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

if (((isset($_GET['p'])) && (is_numeric($_GET['p']))) && ((isset($_GET['m'])) && (is_numeric($_GET['m']))) && ((isset($_GET['a'])) && (is_numeric($_GET['a'])))) {
	$presta = $_GET['p'];
	$mois = $_GET['m'];
	$an = $_GET['a'];
	include 'facture_presta.php';
} else {
	exit();
}
