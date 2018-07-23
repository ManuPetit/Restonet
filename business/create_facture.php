<?php
//			create_facture.php
//			permet la création d'une facture
//			pour afficher à l'écran, ou envoyer par mail
//
//			doit renseigner le numéro de la facture et
//			si envoyer par mail

require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';
require_once BUSINESS_DIR . ('tcpdf/config/lang/fra.php');
require_once BUSINESS_DIR . ('tcpdf/tcpdf.php');

//pour faire les test
//$commandeNumero = '12020000040';
//$IsEmail = true;

$adresseRestonet = RESTONET_ADRESSE.'<br />'.RESTONET_SIREN;

if (!isset($commandeNumero)) {
	//on a pas de numero de commande alors on sort
	exit();
}
$factureNumero = $commandeNumero;
//par default IsEmail est false
IF (!isset($IsEmail)) {
	$IsEmail = FALSE;
}


//on retrouve les détails de la facture
$comDetail = Shop::GetCommandeHeader($factureNumero);
$commandeDate = PreFormatDate($comDetail['comDate']);
$commdandeLivraison = PreFormatDate($comDetail['comDateLivre']);

//retrouver plage horaire
$heure = Shop::GettrancheHoraire($comDetail['cmdHorID']);

//retrouver le nom du client et son adresse et formatter
$cltDetail = Shop::GetClientAdresse($comDetail['clientID']);
$adresse = '<b>' . $cltDetail['nom'] . '</b><br />' . $cltDetail['adresse1'] . '<br />';
if (!is_null($cltDetail['adresse2'])) {
	$adresse .= $cltDetail['adresse2'] . '<br />';
}
$adresse .= $cltDetail['ville'];

//retrouver email client
$emailClient = Shop::GetClientEmail($comDetail['clientID']);

//retrouver détails de la commande
$DetailsCommande = Shop::GetCommandeDetail($factureNumero);

//création du tableau détail commande
$tableau = '<table width="100%" cellpadding="0" cellspacing="2" border="0">
<tr style="color:blue;"><td width="60%" align="center">Plats commandés</td><td width="10%" align="right">Qté.</td><td width="15%" align="right">Prix</td><td width="15%" align="right">Total</td></tr>';
for ($dc = 0; $dc < count($DetailsCommande); $dc++) {
	if ($DetailsCommande[$dc]['menuPlatID'] == 0) {
		//on a un plat
		$prixUnit = $DetailsCommande[$dc]['comDePrixTTC'] / $DetailsCommande[$dc]['comDeQte'];
		$tableau .= '<tr style="font-size:24px;"><td width="60%">' . $DetailsCommande[$dc]['platNom'] . '</td><td width="10%" align="right">' . $DetailsCommande[$dc]['comDeQte'] . '</td><td width="15%" align="right">' . sprintf("%01.2f", $prixUnit) . '</td><td width="15%" align="right">' . sprintf("%01.2f", $DetailsCommande[$dc]['comDePrixTTC']) . '</td></tr>';
	} else {
		$tableau .= '<tr style="font-size:20px;"><td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $DetailsCommande[$dc]['comDeQte'] . ' x ' . $DetailsCommande[$dc]['platNom'] . '</td></tr>';
	}
}
$tableau .= '<tr style="color:blue;font-size:24px;"><td colspan="3" align="right"><b>Prix total de la commande</b></td><td width="15%"  align="right"><b>' . sprintf("%01.2f", $comDetail['comTotalTTC']) . '</b></td></tr>';
$tableau .= '</table>';

//retrouver les détails du ou des prestataires
$prestaDetail = Shop::GetPrestataireDetailFromCommande($comDetail['comID']);
$prestaEnseigne = array();
$prestaAdresse = array();
$prestaTelephone = array();
for ($pd = 0; $pd < count($prestaDetail); $pd++) {
	$prestaEnseigne[] = '<b>' . $prestaDetail[$pd]['prestaNom'] . '</b>';
	if (!is_null($prestaDetail[$pd]['prestaAdresse2'])) {
		$prestaAdresse[] = $prestaDetail[$pd]['prestaAdresse1'] . '<br />' . $prestaDetail[$pd]['prestaAdresse2'] . '<br />' . $prestaDetail[$pd]['ville'];
	} else {
		$prestaAdresse[] = $prestaDetail[$pd]['prestaAdresse1'] . '<br />' . $prestaDetail[$pd]['ville'];
	}
	$prestaTelephone[] = $prestaDetail[$pd]['prestaTelephone'];
}

//détails relatifs à la livraison
$livreText = "<b>Autres détails de votre commande :</b><br />";
if ($comDetail['livraisonID'] == 1) {
	//livraison
	$livreText .= '<p>Vous avez choisi d\'être livré <b>' . $commdandeLivraison . '</b> entre <b>' . $heure['horaire1'] . '</b> et <b>' . $heure['horaire2'] . '</b> à votre adresse.</p>';
	if (count($prestaDetail) > 1) {
		$livreText .= '<p>Les prestataires qui assureront votre livraison sont :<br>';
		for ($p = 0; $p < count($prestaEnseigne); $p++) {
			$livreText .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $prestaEnseigne[$p] . ' (numéro de téléphone : ' . PreFormatTelephone($prestaTelephone[$p]) . ')';
		}
		$livreText .= '</p><p>N\'hésitez pas à les contacter en cas de problème.</p>';
	} else {
		$livreText .= '<p>Le prestataire qui assurera votre livraison est :<br>';
		for ($p = 0; $p < count($prestaEnseigne); $p++) {
			$livreText .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $prestaEnseigne[$p] . ' (numéro de téléphone : ' . PreFormatTelephone($prestaTelephone[$p]) . ')';
		}
		$livreText .= '</p><p>N\'hésitez pas à le contacter en cas de problème.</p>';
	}
}else if ($comDetail['livraisonID'] == 2) {
	//emporter
	$livreText .= '<p>Vous avez opté pour aller chercher vous même votre repas, <b>' . $commdandeLivraison . '</b> entre <b>' . $heure['horaire1'] . '</b> et <b>' . $heure['horaire2'] . '</b> à votre adresse.</p>';
	if (count($prestaDetail) > 1) {
		$livreText .= '<p>Les prestataires qui assureront votre commande sont :<br>';
		for ($p = 0; $p < count($prestaEnseigne); $p++) {
			$livreText .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $prestaEnseigne[$p] . ' (numéro de téléphone : ' . PreFormatTelephone($prestaTelephone[$p]) . ')<br />Veuillez vous rendre aux adresses suivantes à la date et horaire indiqué ci-dessus pour collecter votre repas :<br />' . $prestaAdresse[$p];
		}
		$livreText .= '</p><p><b>IMPORTANT : </b>n\'oubliez pas de vous munir de votre numéro de commande et/ou de cette facture.</p>';
	} else {
		$livreText .= '<p>Le prestataire qui assurera votre commande est :<br>';
		for ($p = 0; $p < count($prestaEnseigne); $p++) {
			$livreText .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ' . $prestaEnseigne[$p] . ' (numéro de téléphone : ' . PreFormatTelephone($prestaTelephone[$p]) . ')<br />Veuillez vous rendre à l\'adresse suivante à la date et horaire indiqué ci-dessus pour collecter votre repas :<br />' . $prestaAdresse[$p];
		}
		$livreText .= '</p><p><b>IMPORTANT : </b>n\'oubliez pas de vous munir de votre numéro de commande et/ou de cette facture.</p>';
	}
}else if ($comDetail['livraisonID'] == 3) {
	//sur place
	$livreText .= '<p>Vous avez choisi d\'aller manger au restaurant ' . $prestaEnseigne[0] . ' ' . $commdandeLivraison . '. Votre table a été réservé </b> entre <b>' . $heure['horaire1'] . '</b> et <b>' . $heure['horaire2'] . '</b>.</p><p>Le jour de la réservation, veuillez vous rendre à l\'adresse suivante :<br />' . $prestaEnseigne[0] . '<br />' . $prestaAdresse[0] . '</p><p>En cas de necéssité, vous pouvez contacter le restaurant au numéro suivant :<br />' . PreFormatTelephone($prestaTelephone[0]) . '.</p>';
	$livreText .= '<p><b>IMPORTANT : </b>n\'oubliez pas de vous munir de votre numéro de commande et/ou de cette facture.<br /><b>Tout autre prestation non mentionnée sur cette facture, devra être payée directement au restaurant.<b /></p>';
}
$livreText .= '<p>RESTOnet vous souhaite un bon appétit... A bientôt sur RESTOnet.fr</p>';

//préparation du fichier pdf
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', FALSE);
$pdf -> SetCreator(PDF_CREATOR);
$pdf -> SetAuthor('RESTOnet.fr');
$pdf -> SetTitle('FACTURE ' . $factureNumero);
$pdf -> SetSubject('Votre facture');

//police du pied de page
$pdf -> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//police par défault
$pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//margins
$pdf -> SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
$pdf -> SetHeaderMargin(0);
$pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set font
$pdf -> SetFont('dejavusans', '', 12);

// add a page
$pdf -> AddPage();

//Entete de la page
$html = '<table border="0" cellspacing="5">
		<tr valign="top"><td width="60%" align="Left">' . $adresse . '</td>
		<td width="40%" align="center">
			<img src="images/logo.jpg" width="180" height="60" border="0" />' . $adresseRestonet . '
		</td>
		</tr>
		<tr><td colspan="2"><b>Commande numéro : ' . $factureNumero . '</b><br /><small>commande passée ' . $commandeDate . ' sur le site RESTOnet.fr.</small></td></tr>
		<tr><td colspan="2"><h2>Votre facture</h2><br /><b>Détail de votre commande</b></td></tr>
		<tr><td colspan="2">' . $tableau . '</td></tr>
		</table>' . $livreText;
$pdf -> writeHTML($html, true, false, true, false, '');
if ($IsEmail == true) {
	$stream = $pdf -> Output('', 'S');
	//faire le mail
	require_once BUSINESS_DIR . 'phpmail/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail->CharSet = 'utf-8';
	$mail->Host = "restonet.fr";
	$body = "Veuillez trouver ci-joint votre facture, suite à votre commande sur le site www.restonet.fr.<br />RESTOnet vous remercie de votre confiance, et vous souhaite un bon appétit...<br /><br />Ce courriel est généré automatiquement. Veuillez ne pas y répondre.";
	$mail->SetFrom("confirmation@restonet.fr");
	$mail->AddAddress($emailClient,$cltDetail['nom']);
	$mail->Subject = "Confirmation commande " .  $factureNumero . " sur RESTOnet";
	$mail->MsgHTML($body);
	//ajout du pdf
	$pdf_content=base64_encode($stream);
	$mail->AddStringAttachment($stream, 'Facture' . $commandeNumero . '.pdf',"base64","application/pdf");
	
	if (!$mail -> Send()) {
		$date = date('Y-m-d H:i:s');
		$mes = "   |  Date:  " . $date . " -> Erreur Envoi mail :Facture". $commandeNumero . ".pdf à $emailClient\r\n";
		error_log($mes, 3, $log);
	}
} else {
	//on fait voir à l'écran
	$pdf -> Output('Facture' . $commandeNumero . '.pdf', 'I');
}
?>
