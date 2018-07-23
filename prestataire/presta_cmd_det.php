<?php
//		presta_cmd_det.php
//		affiche les détails d'une commande

require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'form.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();
$page_title = "Détails d'une commande";
include INCLUDE_DIR . 'prestahead.php';
//affichage des commandes en cours
echo '<h2>Détails d\'une commande</h2>';

//on verifie la submission
if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	$resp = Prestataire::CheckNumeroCommande($_POST['cmd']);
	if (!is_null($resp)) {
		$errors['cmd'] = $resp;
	} else {
		$cmd = trim($_POST['cmd']);
	}
	//si on a pas d'erreur on retrouve le détail de la commande
	if (empty($errors)) {
		$head = Prestataire::GetCommandeHeader($cmd, $_SESSION['prestaid']);
		if (empty($head)) {
			$errors['cmd'] = 'Ce numéro de commande ne correspond pas à une de vos commandes.<br />Veuillez le vérifier.';
			unset($_POST['cmd']);
		} else {
			$plage = Prestataire::GetPlageHoraireParID($head['cmdHorID']);
			$rows = Prestataire::GetCommandeDetail($cmd, $_SESSION['prestaid']);
			echo '<fieldset><legend>Commande numéro : ' . $cmd . '</legend>';
			echo '<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
			<tr valign="top" style="font-size:12px;"><td width="25%" align="right">Date de la commande :</td><td width="25%">' . FormatDateSlash($head['comDate']) . '</td><td width="50%" rowspan="4">Détails client :<br/><b>' . $head['clientNom'] . '</b><br>' . $head['adresse1'] . '<br />';
			if (!is_null($head['adresse2'])) {
				echo $head['adresse2'] . '<br />';
			}
			echo $head['ville'] . '<br />Tél. : ' . PreFormatTelephone($head['adresseTelephone']) . '</td></tr>';
			switch ($head['etatID']) {
				case 1 :
					$etat = 'Commande validée';
					break;
				case 2 :
					$etat = 'Commande en préparation';
					break;
				case 3 :
					$etat = 'Commande en livraison';
					break;
				default :
					$etat = 'Commande terminée';
					break;
			}
			echo '<tr valign="top" style="font-size:12px;"><td width="25%" align="right">Etat de la commande :</td><td width="25%">' . $etat . '</td></tr>';
			echo '<tr valign="top" style="font-size:12px;"><td width="25%" align="right">Date de livraison :</td><td width="25%">' . FormatDateSlash($head['comDateLivre']) . '<br />entre ' . $plage['horDebut'] . ' et ' . $plage['horFin'] . '</td></tr>';
			echo '<tr valign="top" style="font-size:12px;"><td width="25%" align="right">Type de commande :</td><td width="25%">';
			switch ($head['livraisonID']) {
				case 1 :
					$liv = 'Livraison';
					break;
				case 2 :
					$liv = 'A emporter';
					break;
				default :
					$liv = 'Sur place';
					break;
			}
			echo $liv . '</td></tr>
			</table>';
			$brut=0;
			$comm=0;
			$net=0;
			echo '<p>Plats commandés :</p>
			<table width="90%" border="0" cellspacing="0" cellpadding="2" align="center">
			<tr valign="top" style="font-size:12px;font-weight:bold;" align="center"><td width="10%">Qté.</td><td width="45%">Plats</td><td width="15%" align="right">Prix TTC</td><td width="15%" align="right">Commission</td><td width="15%" align="right">Revenu net</td></tr>';
			$bg='#C5FAF1';
			for ($c=0;$c<count($rows);$c++){
				$bg =($bg=='#C5FAF1' ? '#C5E3DE' : '#C5FAF1');
				echo '<tr valign="top" style="font-size:12px;" bgcolor="'.$bg.'"><td width="10%" align="right">'.$rows[$c]['comDeQte'].' x </td><td width="45%" align="left">'.$rows[$c]['platNom'].'</td><td width="15%" align="right">'.sprintf("%01.2f",$rows[$c]['comDePrixTTC']).'</td><td width="15%" align="right" style="color:#ff0000;">'.sprintf("%01.2f",($rows[$c]['comCommission']*-1)).'</td><td width="15%" align="right">'.sprintf("%01.2f",$rows[$c]['net']).'</td></tr>';
				$brut+=$rows[$c]['comDePrixTTC'];
				$comm+=$rows[$c]['comCommission'];
				$net+=$rows[$c]['net'];
			}
			echo '<tr valign="top" style="font-size:12px;font-weight:bold"><td colspan="2" align="right">Total</td><td width="15%" align="right">'.sprintf("%01.2f",$brut).'</td><td width="15%" align="right" style="color:#ff0000;">'.sprintf("%01.2f",($comm*-1)).'</td><td width="15%" align="right">'.sprintf("%01.2f",$net).'</td></tr>';
			echo'</table><br /><br />';
			echo '<div align="center"><a href="presta_cmd_det.php" class="isbutton" title="cliquez ici pour voir le détail d\'une autre commande.">Voir autre commande</a></div><br />';
			//fin de page
			DatabaseHandler::Close();
			include INCLUDE_DIR . 'prestafooter.php';
			exit();
		}
	}
}
//vérifier qu'il y a des commandes
if (Prestataire::HasPrestaGotCommande($_SESSION['prestaid']) == FALSE) {
	echo '<p>Vous n\'avez pas encore de commande à consulter.</p>';
} else {
	echo '<form action="presta_cmd_det.php" method="post" accept-charset="utf-8">
	<fieldset><legend>Voir le détail d\'une commande</legend>
	<table border="0" width="90%" align="center" cellspacing="0" cellpading="5">
	<tr valign="top"><td width="50%" align="right"><b>Numéro de commande : </b></td><td width="50%">';
	create_form_input('cmd', 'text', $errors, 20, 11);
	echo '</td></tr>
	</table><br />
	<div align="center"><input type="submit" name="submit" value="Voir les détails de cette commande" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</fieldset>
	</form>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
