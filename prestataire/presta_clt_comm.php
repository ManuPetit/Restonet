<?php
//		presta_clt_comm.php
//		permet de voir les commentaires données par les clients au prestataire
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
$page_title = "Commentaire des clients";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Commentaire des clients</h2>';
$coms=Prestataire::GetTousCommentaires($_SESSION['prestaid']);
if (!empty($coms)){
	echo '<p>Voici la liste de tous les commentaires donnés par vos clients.</p>';
	echo '<table width="700px" border="0" cellpadding="5" cellspacing="0" align="center">';
	for ($c=0;$c<count($coms);$c++){
		echo '<tr bgcolor="#ffffff"><td>Commentaire posté le ' . date("d/m/Y", strtotime($coms[$c]['comteDate'])). ' à '.date("h:i:s", strtotime($coms[$c]['comteDate'])). ' par <b>'.$coms[$c]['clientNom'].'</b></td></tr>';
		echo '<tr bgcolor="#ffffff"><td>'. stripslashes($coms[$c]['ComteDescription']).'</td></td><tr height="10px"><td></td></tr>';
	}
	echo '</table>';
}else{
	echo '<p>Aucun client n\'a encore fait de commentaire sur votre établissement.</p>';
}
DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
