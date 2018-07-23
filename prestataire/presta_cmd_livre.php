<?php
//		presta_cmd_livre.php
//		fichier présentant les commandes livrées
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

$page_title = "Mes commandes livrées";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Mes commandes livrées</h2>';
$row = Prestataire::GetNbreComdeLivre($_SESSION['prestaid']);
if (empty($row)) {
	echo '<p>Vous n\'avez pas encore fait de livraison, ou servi des clients de RESTOnet.</p>';
} else {
	echo '<table id="list"><tr><td></td></tr></table>
<div id="pager"></div>';
}
include INCLUDE_DIR . 'prestafooter.php';
