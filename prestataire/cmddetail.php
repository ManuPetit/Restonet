<?php
//		cmddetail.php
//		permet de voir le détail d'une commande à partir du planning

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
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['cmd']))) {
	$cmd = $_GET['cmd'];
	$row = Prestataire::GetCommandePourPlanning($cmd);
	if (!empty($row)) {
		$nom = '<b>' . $row['nomClient'] . '</b>';
		$adresse = $row['adresse1'] . '<br />';
		if (!is_null($row['adresse2'])) {
			$adresse .= $row['adresse2'] . '<br />';
		}
		$adresse .= $row['ville'];
		$telephone = FormatTelephone($row['adresseTelephone']);
		$datelivre = FormatDateSlash($row['comDateLivre']);
		switch ($row['etatID']) {
			case 1 :
				$etat = "Commande validée";
				break;
			case 2 :
				$etat = "Commande en préparation";
				break;
			case 3 :
				$etat = "Commande en cours de livraison";
				break;
			default :
				$etat = "Commande livrée et servie";
				break;
		}
		switch ($row['livraisonID']) {
			case 1 :
				$livre = "Livraison chez le client";
				break;
			case 2 :
				$livre = "Vente à emporter";
				break;
			default :
				$livre = "Repas sur place";
				break;
		}
		//retrouver la plage horaire
		$plage = array();
		$plage = Prestataire::GetPlageHoraireParID($row['cmdHorID']);
		$horIn = $plage['horDebut'];
		$horFin = $plage['horFin'];
		$cmdes = Prestataire::GetPrestaComdeDetailDuJour($row['comID']);

		//creation de la page
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>';
		echo 'Détails de la commande';
		echo '</title></head>
	<body style="color:#040248;background:#a8f3f8"><h2>Commande Numéro ' . $cmd . '</h2>';
		echo '<table width="90%" align="center" cellpadding="0" cellspacing="5" border="0">
	<tr valign="top"><td align="right" width="40%">Date :</td><td width="60%">' . $datelivre . '</td></tr>
	<tr valign="top"><td align="right" width="40%">Horaire :</td><td width="60%">entre ' . $horIn . ' et ' . $horFin . '</td></tr>
	<tr valign="top"><td align="right" width="40%">Type de livraison :</td><td width="60%">' . $livre . '</td></tr>';
		echo '<tr valign="top"><td align="right" width="40%">Client :</td><td width="60%">' . $nom . '</td></tr>';
		if ($row['livraisonID'] == 1) {
			echo '<tr valign="top"><td align="right" width="40%">Adresse de livraison :</td><td width="60%">' . $adresse . '</td></tr>';
		}
		echo '<tr valign="top"><td align="right" width="40%">Téléphone client :</td><td width="60%">' . $telephone . '</td></tr>';
		echo '<tr valign="top"><td align="right" width="40%">Etat de préparation :</td><td width="60%">' . $etat . '</td></tr>';
		echo '<tr valign="top"><td colspan="2"><b>Détails de la commande :</td></tr>';
		echo '<tr valign="top"><td colspan="2">';
		for ($d = 0; $d < count($cmdes); $d++) {
			echo '<b>' . $cmdes[$d]['cqte'] . '</b> x ' . $cmdes[$d]['pln'] . '<br />';
		}
		echo '</td></tr>
</table><br />';
		echo '<div style="text-align:center;"><input class="isbutton" name="button" type="button" onclick="javascript:self.close();" value="Fermer" /><br /><br />
	</body>
	</html>';
		exit();
	}
}
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>';
echo 'Erreur';
echo '</title></head>
	<body style="color:#040248;background:#a8f3f8"><p>Une erreur s\'est produite. Veuillez contacter l\'administrateur du site si celà se reproduit.</p>
	<div style="text-align:center;"><input class="isbutton" name="button" type="button" onclick="javascript:self.close();" value="Fermer" /><br /><br />
	</body>
	</html>';
