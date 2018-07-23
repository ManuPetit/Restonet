<?php
//		presta_ca.php
//		permet l'affichage du CA d'un prestataire
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

//preparation du calendrier
$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Jullet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

$page_title = "Chiffre d'affaire";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Chiffre d\'affaire</h2>';
$ca = Prestataire::GetPrestaCAPrestaID($_SESSION['prestaid']);
if (!empty($ca)) {
	//on a un chiffre d'affaire
	echo '<p>Le chiffre d\'affaire est basé sur les commandes passées chaque mois. Il se peut que certaines commandes n\'aient pas encore été livrées.</p>';
	echo '<table width="90%" border="1" cellspacing="3" align="center">
	<tr valign="top"><td width="20%" align="center"><b>Année</b></td><td width="20%" align="center"><b>Mois</b></td><td width="20%" align="center"><b>Revenu brut</b></td><td width="20%" align="center"><b>Commission</b></td><td width="20%" align="center"><b>Revenu net</b></td></tr>';
	$cab = 0;
	$ccm = 0;
	$can = 0;
	for ($a = 0; $a < count($ca); $a++) {
		echo '<tr valign="top"><td align="center">' . $ca[$a]['an'] . '</td>';
		echo '<td align="center">' . $mois[$ca[$a]['mois'] - 1] . '</td>';
		echo '<td align="right">' . sprintf("%01.2f", $ca[$a]['pTTC']) . '</td>';
		echo '<td align="right">' . sprintf("%01.2f", $ca[$a]['pCOM']) . '</td>';
		echo '<td align="right">' . sprintf("%01.2f", $ca[$a]['revenu']) . '</td></tr>';
		$cab += $ca[$a]['pTTC'];
		$ccm += $ca[$a]['pCOM'];
		$can += $ca[$a]['revenu'];
	}
	echo '<tr valign=top><td colspan="2" align="right"><b>TOTAUX</b></td>';
	echo '<td align="right"><b>' . sprintf("%01.2f", $cab) . '</b></td>';
	echo '<td align="right"><b>' . sprintf("%01.2f", $ccm) . '</b></td>';
	echo '<td align="right"><b>' . sprintf("%01.2f", $can) . '</b></td></tr></table>';
}else{
	echo '<p>Vous n\'avez pas encore réalisé de chiffre d\'affaire sur RESTOnet.</p>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
