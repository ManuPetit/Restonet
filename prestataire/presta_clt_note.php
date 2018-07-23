<?php
//		presta_clt_note.php
//		permet de voir les notes données par les clients au prestataire
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

$page_title = "Vote des clients";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Vote des clients</h2>';
$notes=Prestataire::GetNoteListeParPresta($_SESSION['prestaid']);
if (!empty($notes)){
	$rows=array();
	$tnote=0;
	$count=0;
	for ($c=0;$c<count($notes);$c++){
		$tnote+=$notes[$c]['note'];
		$count++;
		$rows[$c]='<tr valign="middle"><td width="320px" align="right">'.$notes[$c]['nom'].'</td><td width="144px" align="center"><img src="../images/etoiles/bmetoile'.$notes[$c]['note'].'.jpg" width="70" height="15" border="0" /></td></tr>';
	}
	//calcul de la note moyenne
	if ($tnote>0){
		$mnote = round($tnote/$count);
	}else{
		$mnote=0;
	}
	echo '<p>Voici la liste de vos notes données par vos clients.</p>
	<table width="484" cellpadding="5" cellspacing="0" border="0" align="center">
	<tr valign="middle"><td align="right" width="320"><h4>Votre note moyenne</h4></td><td width="144" align="center"><img src="../images/etoiles/betoiles'.$mnote.'.jpg" width="144" height="31" border="0" /></td></tr>
	<tr height="10px"><td colspan="2"></td></tr>
	<tr><td width="320" align="right"><b>Nom du client</b></td><td width="144" align="center"><b>Note</b></td></tr>';
	for ($r=0;$r<count($rows);$r++){
		echo $rows[$r];
	}
	echo '</table>';
}else{
	echo '<p>Aucun client ne vous a encore noté.</p>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';