<?php
//		index.php
//		fichier ouverture tableau bord prestataire
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();

include INCLUDE_DIR . 'prestahead.php';

echo '<h2>Tableau de bord : ' . $nom . '</h2>';
$row = array();
$row = Prestataire::GetPrestaLastLoginParID($_SESSION['userid']);
if (!empty($row)) {
	echo '<h4>Bienvenue, ' . $row['userPrenom'] . '.</h4><p>' . $row['userLastLogin'] . '</p>';
}
echo '<br /><p>Pour choisir une action, utilisez le menu à gauche.</p>';

//update le login
Prestataire::UpdatePrestaLoginParID($_SESSION['userid']);

include INCLUDE_DIR . 'prestafooter.php';
