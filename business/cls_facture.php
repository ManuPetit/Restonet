<?php
//		cls_facture.php
//fichier de création de la facture

//retrouvez adresse client et formater adresse client
$sql = "CALL get_client_adresse(:cID)";
$param = array(':cID' => $_SESSION['clientid']);
$adresse = DatabaseHandler::GetRow($sql, $param);
$cltAdr = '<b>' . $adresse['nom'] . '</b><br />' . $adresse['adresse1'] . '<br />';
if (!is_null($adresse['adresse2'])) {
	$cltAdr .= $adresse['adresse2'] . '<br />';
}
$cltAdr .= $adresse['ville'];
//email client
$sql = "CALL get_client_email(:cID)";
$param = array(':cID' => $_SESSION['clientid']);
$_SESSION['email'] = DatabaseHandler::GetOne($sql, $param);

// retrouvez les détails du prestataire
$sql = "CALL get_presta_detail_parID(:pID)";
$param = array(':pID' => $_SESSION['curprestid']);
$prestaDetail = DatabaseHandler::GetRow($sql, $param);
$enseigne = $prestaDetail['prestaNom'];
$prestaAdr = $prestaDetail['prestaAdresse1'] . '<br />';
if (!is_null($prestaDetail['prestaAdresse2'])) {
	$prestaAdr .= $prestaDetail['prestaAdresse2'] . '<br />';
}
$prestaAdr .= $prestaDetail['villeCP'] . ' ' . $prestaDetail['villeNom'];
$prestaTel = PreFormatTelephone($prestaDetail['prestaTelephone']);
//retrouvez la commande et ses détails
$sql = "CALL get_commande_prix(:cID)";
$param = array(':cID' => $_SESSION['cmdid']);
$prix = DatabaseHandler::GetRow($sql, $param);
$prixHT = $prix['comTotalHT'];
$prixTTC = $prix['comTotalTTC'];
$_SESSION['prixTTC'] = $prix['comTotalTTC'] * 100;
$etatcmd = $prix['etatID'];
$sql = "CALL get_cmde_detail(:cID)";
$param = array(':cID' => $_SESSION['cmdid']);
$plats = DatabaseHandler::GetAll($sql, $param);

//adresse restonet et détails commande
$resAdr = '<b>RESTOnet</b><br />547 route de Puget<br />06260 Puget Rostang<br />SIREN : 0000000000000';
if ($etatcmd == 0) {
	$enteteCommande = '<h3>Bon de commande</h3>';
	$validation = "Votre commande est en attente de paiement";
	$meslivadd = '<br />';
} else {
	$enteteCommande = '<h3>FACTURE</h3>';
	$validation = "Le paiement de votre commande a été validé par notre partenaire bancaire.<br /><h2>Votre commande est validée</h2>";
	$meslivadd = "N'oubliez pas de vous munir de votre numéro de commande et/ou de cette facture.";
	$merci = "RESTOnet vous remercie de votre confiance. Bon appétit, et à bientôt...";
}

$enteteCommande .= '<b>Commande Numéro : </b>' . $_SESSION['cmdid'] . '</br /><b>Commande passée </b>' . PreFormatDate($_SESSION['dateCmd']) . '<br />
	<br /><b>Nom du prestataire : </b>' . $enseigne;

//Message livraison
$heure = shop::GettrancheHoraire($_SESSION['plage']);
switch ($_SESSION['livre']) {
	case 1 :
		$mesliv = 'Vous avez choisi d\'être livré à domicile.<br /><br />La livraison aura lieu <b>' . PreFormatDate($_SESSION['date']) . '</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;entre <b>' . $heure['horaire1'] . '</b> et <b>' . $heure['horaire2'] . '</b> à l\'adresse suivante :<br />';
		$mesliv .= "<b>Adresse de livraison :</b><br />" . $cltAdr;
		break;
	case 2 :
		$mesliv = 'Vous avez opté pour une commande à emporter.<br /><br />Veuillez vous rendre à l\'adresse suivante, <b>' . PreFormatDate($_SESSION['date']) . '</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;entre <b>' . $heure['horaire1'] . '</b> et <b>' . $heure['horaire2'] . '</b> :<br />';
		$mesliv .= '<b>' . $enseigne . '</b><br />' . $prestaAdr . $meslivadd;
	default :
		$mesliv = 'Vous avez choisi de manger au restaurant.<br />';
		if ($etatcmd == 0) {
			$mesliv .= 'Votre table sera réservée ';
		} else {
			$mesliv .= 'Votre table a été réservée ';
		}
		$mesliv .= 'pour <b>' . PreFormatDate($_SESSION['date']) . '</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;entre <b>' . $heure['horaire1'] . '</b> et <b>' . $heure['horaire2'] . '</b>.<br /><br />Le jour de la réservation, veuillez vous rendre à l\'adresse suivante :<br />';
		$mesliv .= '<b>' . $enseigne . '</b><br />' . $prestaAdr . $meslivadd;
		break;
}
//log des informations de la facture
$log = SITE_ROOT . '/factmp/' . $_SESSION['cmdid'] . '.log';
$fh=fopen($log,'w');
fwrite($fh,$_SESSION['uniid']."\r\n");
fwrite($fh,$_SESSION['userid']."\r\n");
fwrite($fh,$_SESSION['clientid']."\r\n");
fwrite($fh,$_SESSION['curprestid']."\r\n");
fwrite($fh,$_SESSION['cmdid']."\r\n");
fwrite($fh,$_SESSION['date']."\r\n");
fwrite($fh,$_SESSION['dateCmd']."\r\n");
fwrite($fh,$_SESSION['plage']."\r\n");
fwrite($fh,$_SESSION['livre']."\r\n");
fclose($fh);

//log des infos pour reconnexion
$nlog = SITE_ROOT . '/detlog/'. $_SESSION['cmdid'] . '.log';
$fg=fopen($nlog,'w');
fwrite($fg,$_SESSION['uniid']."\r\n");
fwrite($fg,$_SESSION['userid']."\r\n");
fwrite($fg,$_SESSION['clientid']."\r\n");
fclose($fg);

//creation de la facture
echo '<br /><table width="90%" style="background-color:white" border="0" align="center" cellspacing="5">
	<tr valign="top"><td width="40%">' . $cltAdr . '</td><td colspan="2"></td><td colspan="2" Align="right">' . $resAdr . '</td></tr>
	<tr valign="top"><td colspan="5">' . $enteteCommande . '</td></tr>
	<tr valign="top"><td colspan="5"><b>Détail de la commande</b></td></tr>
	<tr><td width="40%">Plats commandés</td><td width="10%" align="right">Qté.</td><td width="15%" align="right">Prix</td><td width="15%"> unitaire</td><td width="20%" align="right">Prix  Total</td></tr>';
for ($i = 0; $i < count($plats); $i++) {
	echo '<tr valign="top">';
	if ($plats[$i]['menuPlatID'] == 0) {
		echo '<td width="40%" style="font-size:11px;">' . $plats[$i]['platNom'] . '</td>';
		echo '<td width="10%" style="font-size:11px;" align="right">' . $plats[$i]['comDeQte'] . '</td>';
	} else {
		echo '<td colspan="5" style="font-size:9px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $plats[$i]['comDeQte'] . ' x ' . $plats[$i]['platNom'] . '</td>';
	}
	if ($plats[$i]['menuPlatID'] == 0) {
		if ($plats[$i]['platPrixPromo'] == '0.00') {
			echo '<td colspan="2" style="font-size:11px;" align="right">' . sprintf("%01.2f", $plats[$i]['platPrix']) . '</td><td width="20%" style="font-size:11px;" align="right">' . sprintf("%01.2f", $plats[$i]['comDePrixTTC']) . '</td>';
		} else {
			echo '<td width="15%" style="font-size:11px;" align="right"><del>' . sprintf("%01.2f", $plats[$i]['platPrix']) . '<del></td><td width="15%" style="font-size:11px;color:red;" align="right">' . sprintf("%01.2f", $plats[$i]['platPrixPromo']) . '</td><td width="20%" style="font-size:11px;" align="right">' . sprintf("%01.2f", $plats[$i]['comDePrixTTC']) . '</td>';
		}
	}
	echo '</tr>';
	echo "\n";
}
echo '<tr><td width="40%" align="right"><b>Total à payer</b></td><td colspan="3"></td><td width="20%" align="right"><b>' . sprintf("%01.2f", $prixTTC) . '</td></tr>';
echo '<tr valign="top"><td colspan="5"><br />' . $mesliv . '</td></tr>';
echo '</table><br />
<div align="center"><a class="fbutton" href="business/payement.php" title="Cliquez ici pour accéder au paiement en ligne sécurisé">Paiement en ligne<br /><img src="images/common/CA.jpg" border="0" width="140" height="39" /></a></div><br />';
?>
