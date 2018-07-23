<?php
//		act_test.php
//		test pour erreur
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
$errors = array();

//les mois
$lesmois = array(1 => 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');

$page_title = "Activité périodique";
include INCLUDE_DIR . 'adminhead.php';

//on retrouve les jours d'activite
$dates = Activite::GetDateActivite();

echo '<h2>Activité périodique</h2>';
?>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr><td width="15%">Annee</td><td width="15%">Mois</td><td width="10%">Jour</td><td width="50%">Nom</td><td width="10%">CA</td></tr>
	<tr><td width="15%" bgcolor="#6AA2FF">2011</td><td width="15%" bgcolor="#72c6ef">Novembre</td><td width="10%" bgcolor="#d4effc">10</td><td width="50%" bgcolor="#8ed8f8">Test Un</td><td width="10%" bgcolor="#d4effc">45.00</td></tr>
	<tr><td width="15%" bgcolor="#6AA2FF"></td><td width="15%" bgcolor="#72c6ef"></td><td width="10%" bgcolor="#b4dde6">20</td><td width="50%" bgcolor="#6cc4df">Test Un</td><td width="10%" bgcolor="#b4dde6">25.00</td></tr>	
	<tr><td width="15%" bgcolor="#6AA2FF"></td><td width="15%" bgcolor="#72c6ef"></td><td width="10%" bgcolor="#d4effc">30</td><td width="50%" bgcolor="#8ed8f8">Test Un</td><td width="10%" bgcolor="#d4effc">45.00</td></tr>
	<tr><td width="15%" bgcolor="#6AA2FF">2011</td><td width="15%" bgcolor="#72c6ef">Décembre</td><td width="10%" bgcolor="#bde3dc">10</td><td width="50%" bgcolor="#97d5c9">Test Un</td><td width="10%" bgcolor="#bde3dc">45.00</td></tr>
	<tr><td width="15%" bgcolor="#6AA2FF">2011</td><td width="15%" bgcolor="#72c6ef"></td><td width="10%" bgcolor="#b3ddca">10</td><td width="50%" bgcolor="#8ccfb7">Test Un</td><td width="10%" bgcolor="#b3ddca">45.00</td></tr>
</table>