<?php
//facture_presta.php
//permet la création d'une facture
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR .'cls_activite.php';
require_once BUSINESS_DIR . ('tcpdf/config/lang/fra.php');
require_once BUSINESS_DIR . ('tcpdf/tcpdf.php');

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

//les mois
$lesmois = array(1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

//retrouver les données
$facH=Activite::GetFactureHeader($presta, $mois, $an);//header facture
$facD=Activite::GetFactureDetail($presta, $mois, $an);//detail facture
$presD=Activite::GetPrestaDetails($presta);//details prestataire

//les adresses
$adresseRestonet = RESTONET_ADRESSE . '<br />' . RESTONET_SIREN;
$adresse= '<b>'.$presD['prestaNom'].'</b><br />'.$presD['prestaAdresse1'].'<br />';
if (!is_null($presD['prestaAdresse2'])){
	$adresse.=$presD['prestaAdresse2'].'<br />';
}
$adresse.=$presD['villeCP'].' '.$presD['villeNom'].'<br /><br />';

//divers
$entete = "Votre paiement de RESTOnet pour ".$lesmois[$mois]. ' '. $an .'.';
$titre ="Releve_".$an.'_'.$mois.'_P_'.$presta;

//préparation du fichier pdf
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', FALSE);
$pdf -> SetCreator(PDF_CREATOR);
$pdf -> SetAuthor('RESTOnet.fr');
$pdf -> SetTitle($titre);
$pdf -> SetSubject('Votre paiement de ' . $lesmois[$mois] . ' ' . $an);

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
$html = '<table width="100%" border="0" cellspacing="5" align="center">
		<tr valign="top"><td width="60%" align="center">
		<img src="../business/images/logo.jpg" width="180" height="60" border="0" /><br />' . $adresseRestonet . '</td><td width="40%"></td></tr>';
$html .= '<tr valign="top"><td width="60%"></td><td width="40%" align="left">' . $adresse . '</td></tr>';
$html .= '<tr><td colspan="2" align="left"><h4>'.$entete.'</h4></td></tr>';
$html .= '<tr><td colspan="2"Align="right"><small>Relevé effectué '.PreFormatDate(date('Y-m-d')).'.</small></td></tr>';
$html .= '</table>';
$html .= '<br /><br />
		<table width="88%" border="0" cellspacing="0" cellpadding="5" align="center">
		<tr valign="middle"><td width="60%" align="left">Nombre de commandes : '.$facH['nbre'].'</td><td widht="20%"></td><td width="20%"></td></tr>';
$html .= '<tr valign="middle"><td width="60%" align="left">Revenu brut</td><td colspan="2" align="right">'. sprintf("%01.2f",$facH['brut']).'</td></tr>';
$html .= '<tr valign="middle"><td width="60%" align="left">Commission RESTOnet</td><td colspan="2" align="right" style="color:#ff0000">'. sprintf("%01.2f",($facH['comm']*-1)).'</td></tr>';
$html .= '<tr valign="middle"><td width="60%" align="left" style="font-size:36px;font-weight:bold;color:#0000ff">Revenu net</td><td colspan="2" align="right" style="font-size:36px;font-weight:bold;color:#0000ff">'. sprintf("%01.2f",$facH['net']).'</td></tr>';
$html .= '</table>';
$html .= '<br /><br />
		<p>Veuillez trouver ci-joint un chèque d\'un montant de '. sprintf("%01.2f",$facH['net']).'&euro; en paiement de l\'ensemble des commandes passées sur RESTOnet pour le mois de '.$lesmois[$mois].'.</p><p>RESTOnet vous remercie de votre partenariat.</p>';
$pdf -> writeHTML($html, true, false, true, false, '');
//detail des commandes
$pdf->AddPage();
$html = '<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
	<tr valign="top"><td colspan="8" align="center">Details des commandes passées en '.$lesmois[$mois]. ' '.$an.'</td></tr>';
$html .='<tr style="font-size:16px;"><td width="15%">N° Cde</td><td width="15%">Date Cde</td><td width="15%">Date livraison Cde</td><td width="15%">Etat Cde</td><td width="10%">Qté Plat</td><td width="10%">Revenu Brut</td><td width="10%">Commission</td><td width="10%">Revenu Net</td></tr>';
$bg = "#F4F7D5";
for ($c=0;$c<count($facD);$c++){
	$bg =($bg=='#F4F7D5' ? '#D5F6F7' : '#F4F7D5');
	$html .='<tr style="font-size:16px;" bgcolor="'.$bg.'"><td width="15%">'.$facD[$c]['comNumero'].'</td><td width="15%">'.FormatDateSlash($facD[$c]['comDate']).'</td><td width="15%">'.FormatDateSlash($facD[$c]['comDateLivre']).'</td><td width="15%">';
	if ($facD[$c]['etatID']==4){
		$html .= 'Terminée';
	}else{
		$html .= 'En attente';
	}
	$html.='</td><td width="10%" align="right">'.$facD[$c]['qte'].'</td><td width="10%" align="right">'.sprintf("%01.2f",$facD[$c]['pBrut']).'</td><td width="10%" align="right" style="color:#ff0000">'.sprintf("%01.2f",($facD[$c]['pCom']*-1)).'</td><td width="10%" align="right" style="color:#0000ff">'.sprintf("%01.2f",$facD[$c]['pNet']).'</td></tr>';
}
$html .= '<tr style="font-size:16px;"><td colspan="5" align="right"><b>Total</b></td><td width="10%" align="right"><b>'.sprintf("%01.2f",$facH['brut']).'</b></td><td width="10%" align="right" style="color:#ff0000"><b>'. sprintf("%01.2f",($facH['comm']*-1)).'</b></td><td width="10%" align="right" style="color:#0000ff"><b>'. sprintf("%01.2f",$facH['net']).'</b></td></tr>';
$html .='</table><br /><br />
<p>Vous pouvez retrouver le détails de vos commandes, en vous connectant à votre Tableau de Bord sur RESTOnet :<br />&nbsp;&nbsp;&nbsp;&nbsp;- rubrique "Mes commandes"<br />&nbsp;&nbsp;&nbsp;&nbsp;- section "Détails d\'une commande".</p>';
$pdf -> writeHTML($html, true, false, true, false, '');
$pdf -> Output($titre . '.pdf', 'D');
//finalement on met à jour le facturier
Activite::UpdateFactureEditer($presta, $mois, $an);