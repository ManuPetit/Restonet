<?php
//		activ_jour.php
//		activité du jour
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
//date du jour
$today=PreFormatDate(HeureParis());
$tDate=DateParis();

$page_title = "Activité du jour";
include INCLUDE_DIR . 'adminhead.php';
echo '<h2>Activité pour '.$today.'</h2>';
$row=Activite::GetDailyActivite($tDate);
if (!empty($row)){
	echo '<p>Commandes en cours pour aujourd\'hui :</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr valign="middle" style="font-weight:bold;font-size:10px;" bgcolor="#6cff68"><td align="center" width="34%">Enseigne</td><td width="10%" align="center">Nbre<br />Cde</td><td width="10%" align="center">Cde en<br />Préparation</td><td width="10%" align="center">Cde<br />Terminée</td><td width="12%" align="center">CA<br />Généré</td><td width="12%" align="center">Commission</td><td width="12%" align="center">Revenu<br />Net</td></tr>';
	$b1 = "#affbad";
	$b2 = "#d3fdd2";
	$b3 = "#fbadad";
	$ncde=0;
	$ncat=0;
	$ncli=0;
	$nbrut=0;
	$ncom=0;
	$nnet=0;
	for ($c=0;$c<count($row);$c++){
		$b1 = ($b1 == "#affbad" ? "#8ecd8c" : "#affbad");
		$b2 = ($b2 == "#d3fdd2" ? "#a8cda6" : "#d3fdd2");
		$b3 = ($b3 == "#fbadad" ? "#cda6a6" : "#fbadad");
		echo '<tr valign="middle" style="font-size:10px;"><td width="34%" bgcolor="'.$b1.'"><b>'.$row[$c]['prestaNom'].'</b></td><td width="10%" align="right" bgcolor="'.$b2.'">'.$row[$c]['nCom'].'</td><td width="10%" align="right" bgcolor="'.$b1.'">'.$row[$c]['nAtt'].'</td><td width="10%" align="right" bgcolor="'.$b2.'">'.$row[$c]['nLiv'].'</td><td width="12%" align="right" bgcolor="'.$b1.'">'.Activite::PrepData($row[$c]['cBrut'],TRUE).'</td><td width="12%" align="right" bgcolor="'.$b3.'">'.Activite::PrepData($row[$c]['nComi'],TRUE).'</td><td width="12%" align="right" bgcolor="'.$b2.'">'.Activite::PrepData($row[$c]['cNet'],TRUE).'</td></tr>';
		$ncde+=$row[$c]['nCom'];
		$ncat+=$row[$c]['nAtt'];
		$ncli+=$row[$c]['nLiv'];
		$nbrut+=$row[$c]['cBrut'];
		$ncom+=$row[$c]['nComi'];
		$nnet+=$row[$c]['cNet'];
	}
	echo '<tr valign="middle" style="font-size:11px;font-weight:bold;"><td width="34%" align="right">Totaux</td><td width="10%" align="right">'.$ncde.'</td><td width="10%" align="right">'.$ncat.'</td><td width="10%" align="right">'.$ncli.'</td><td width="12%" align="right">'.Activite::PrepData($nbrut, TRUE).'</td><td width="12%" align="right" bgcolor="#f69af9">'.Activite::PrepData($ncom, TRUE).'</td><td width="12%" align="right">'.Activite::PrepData($nnet, TRUE).'</td></tr>';
	echo'</table>';
}else{
	echo '<p>Il n\'y a aucune activité pour aujourd\'hui pour le moment.</p>';
}
echo '<p></p>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
