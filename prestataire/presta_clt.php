<?php
//		presta_clt.php
//		permet l'affichage du CA par client d'un prestataire
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();

$page_title = "Chiffre d'affaire par client";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Chiffre d\'affaire par client</h2>';
$clt=Prestataire::GetPrestaCAParClient($_SESSION['prestaid']);
if (!empty($clt)){
	//on a des données
	echo '<table width="90%" border="1" cellspacing="3" align="center">
	<tr valign="top"><td width="50%" align="center"><b>Nom client</b></td><td width="30%" align="center"><b>Commandes passées</b></td><td width="20%" align="center"><b>Revenu net client</b></td></tr>';
	for ($c=0;$c<count($clt);$c++){
		echo '<tr valign="top"><td width="50%">'.$clt[$c]['clientNom'].'</td><td width="30%" align="right">'.$clt[$c]['nbre'].'</td><td width="20%" align="right">'.$clt[$c]['revenu'].'</td></tr>';
	}
	echo '</table>';
}else{
	echo '<p>Vous n\'avez pas encore réalisé de chiffre d\'affaire sur RESTOnet.</p>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
