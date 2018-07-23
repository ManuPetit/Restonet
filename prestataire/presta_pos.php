<?php
//		presta_pos.php
//		permet de voir la position d'un prestataire par rapport à d'autre
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

$page_title = "Mon classement";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Mon classement vis à vis des autres prestataires</h2>';
$data = Prestataire::GetPrestaClassement();
if (!empty($data)) {
	echo '<p>Voici votre classement en nombre de commandes réalisées sur RESTOnet par rapport aux autres prestataire du réseau.</p>';
	echo '<table width="80%" border="1" cellpadding="5" align="center" cellspacing="0">';
	echo '<tr valign="top"><td width="20%" align="center"><b>Position</b></td><td width="60%" align="center"><b>Etablissement</b></td><td width="20%" align="center"><b>Nbre commande</b></td></tr>';
	echo "\n";
	$bg = "#A9FBA";
	$flag = false;
	$pos=0;
	for ($d = 0; $d < count($data); $d++) {
		$pos++;
		if ($data[$d]['prestaID'] == $_SESSION['prestaid']) {
			echo '<tr valign="top" bgcolor="#F87E6A"><td width="20%" align="right" style="font-size:16px;font-weight:bold;">' . $pos . '</td><td width="60%" style="font-size:16px;font-weight:bold;">' . $data[$d]['prestaNom'] . '</td><td width="20%" align="right" style="font-size:16px;font-weight:bold;">' . $data[$d]['nbre'] . '</td></tr>';
			echo "\n";
			$flag = true;
		} else {
			if ($bg == '#A9FBA'){
				$bg = '#FBF0A2';
			}else{
				$bg='#A9FBA';
			}
			echo '<tr valign="top" bgcolor="' . $bg . '"><td width="20%" align="right">' . $pos . '</td><td width="60%">' . $data[$d]['prestaNom'] . '</td><td width="20%" align="right">' . $data[$d]['nbre'] . '</td></tr>';
			echo "\n";
		}
	}
	echo '</table>';
	if ($flag == false) {
		echo '<p>Vous n\'apparaissez pas dans ce classement, car vous n\'avez pas encore reçu de commandes.</p>';
	}
} else {
	echo '<p>Aucun prestataire n\'a encore eu de commandes sur le site RESTOnet.</p>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
