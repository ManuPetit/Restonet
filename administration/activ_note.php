<?php
//		activ_note.php
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

//les mois
$lesmois = array(1 => 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');

$page_title = "Etablir les factures des prestataires";
include INCLUDE_DIR . 'adminhead.php';

echo '<h2>Etablir les factures des prestataires</h2>';
///retrouver le mois et l'année
$mois = date('m');
$an = date('Y');
$date = $an . '-' . $mois . '-01 00:00:00';

//retourver les factures dues
$facs = Activite::GetFacturesDues($date);
if (empty($facs)) {
	echo '<p>Vous n\'avez aucune facture en retard.</p>';
} else {
	//detail prestataire
	for ($c = 0; $c < count($facs); $c++) {
		$presD[$c] = Activite::GetPrestaDetails($facs[$c]['prestaID']);
	}
	//creation des factures
	echo '<p>Cliquez sur le bouton pour créer la facture du prestataire.<br />Utilisez le bouton "Rafraîchir" pour mettre à jour la liste (attendez d\'avoir enregistré les factures).</p>';
	echo '<div align="center"><input type="button" value="Rafraichîr" onClick="window.location.reload()" class="isbutton"></div><p></p>';
	echo '<table width="90%" border="0" cellpadding="5" cellspacing="0" align="center">
	<tr><td width="50%"><b>Prestataires</b></td><td width="25%" align="center"><b>Périodes</b></td><td width="25%"></td></tr>';
	echo "\n";
	$bg = '#b1f3ac';
	for ($c = 0; $c < count($facs); $c++) {
		$bg = ($bg == '#b1f3ac' ? '#f3d2ac' : '#b1f3ac');
		echo '<tr valign="middle" bgcolor="'.$bg.'"><td width="50%">' . $presD[$c]['prestaNom'] . '</td><td width="25%" align="center">' . $lesmois[$facs[$c]['monthFac']] . ' ' . $facs[$c]['yearFac'] . '</td><td width="25%" align="center"><a href="etab_fact.php?p=' . $facs[$c]['prestaID'] . '&m=' . $facs[$c]['monthFac'] . '&a=' . $facs[$c]['yearFac'] . '" title="Cliquez ici pour établir la facture de ce prestataire." class="isbutton" target="_new">Facturer</a></td></tr>';
		echo "\n";
	}
	echo '</table>
	<br />';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
