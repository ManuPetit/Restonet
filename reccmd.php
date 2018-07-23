<?php
//			reccmd.php
//	fichier de récapitulation de la commande
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

//verifier que l'on a des données
if ((!isset($_SESSION['uniid'])) || (!isset($_SESSION['curprestid'])) || (!isset($_SESSION['clientid']))) {
	$url = "index.php";
	header("Location: $url");
	exit();
}

//on fait les vérifs
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['submitted']))) {
	if (isset($_POST['liv'])) {
		if ($_POST['liv'] != 0) {
			$_SESSION['livre'] = $_POST['liv'];
		} else {
			$errors['liv'] = "Veuillez choisir un mode de livraison";
		}
	}
	if (isset($_POST['date1'])) {
		$_SESSION['date'] = $_POST['date1'];
		$an = substr($_POST['date1'], 0, 4);
		$mois = substr($_POST['date1'], 5, 2);
		$jour = substr($_POST['date1'], 8, 2);
	}
	if (empty($errors)) {
		//pas d'erreur on va sur la page des horaires
		$url = "reccmd2.php";
		header("Location: $url");
		exit();
	}
}

$page_title = "Récapitulatif de ma commande - RESTOnet";
$menu = 'm9';
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);

include INCLUDE_DIR . 'header.php';
//variable pour le calendrier
define("L_LANG", "fr_FR");
require_once ('calendar/tc_calendar.php');

echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Récapitulatif de ma commande</h1>';
include INCLUDE_DIR . 'openboxfront.php';
//voir ce qu'il y a dans le shopping trolley
$totalcmd = 0;
$plats = array();
$plats = Shop::GetCartItemParUniqID($_SESSION['uniid']);
//on retrouve les mode de livraison de ce prestataire
$livre = array();
$livrai = Shop::GetPrestaTypeDeLivraison($_SESSION['curprestid']);
//vérifier que l'on peut livrer cette ville
$livre = array();
$j = 0;
for ($l = 0; $l < count($livrai); $l++) {
	if ($livrai[$l]['livraisonID'] == 1) {
		if (Shop::CheckPrestaLivraisonParClientVille($_SESSION['clientid'], $_SESSION['curprestid']) == TRUE) {
			$livre[$j]['livraisonID'] = $livrai[$l]['livraisonID'];
			$livre[$j]['livraisonNom'] = $livrai[$l]['livraisonNom'];
			$flagLivre = TRUE;
			$j++;
		}else{
			$flagLivre = FALSE;
		}
	} else {
		$livre[$j]['livraisonID'] = $livrai[$l]['livraisonID'];
		$livre[$j]['livraisonNom'] = $livrai[$l]['livraisonNom'];
		$j++;
	}
}
//on retrouve les jours de fermeture du presta
$ferme = array();
$ferme = Shop::GetPrestaJourFerme($_SESSION['curprestid']);
//on récupère la période de fermeture du presta
$conges = array();
$conges = Shop::GetPrestaFermeture($_SESSION['curprestid']);

echo '<table width="100%" border="0" cellpadding="0" cellspacing="3px">
<tr><th width="45%" align="left">Plat</th><th width="10%" align="right">Prix</th><th width="10%"></th><th width="20%" align="center">Quantité</th><th width="15%">Total</th></tr>';
for ($p = 0; $p < count($plats); $p++) {
	echo '<tr valign="bottom"><td  class="plattab">' . $plats[$p]['platNom'] . '</td>';
	echo "\n";
	echo '<td align="right" class="plattab">';
	if ($plats[$p]['platPrixPromo'] != '0.00') {
		echo '<del class="plat">' . sprintf("%01.2f", $plats[$p]['platPrix']) . '&euro;</del></td><td align="right" class="promo">' . sprintf("%01.2f", $plats[$p]['platPrixPromo']) . '&euro;</td>';
	} else {
		echo $plats[$p]['platPrix'] . '&euro;</td><td></td>';
	}
	echo "\n";
	echo '<td align="right">' . $plats[$p]['cartQte'] . '</td>';
	echo "\n";
	echo '<td align="right" class="plattab">' . sprintf("%01.2f", $plats[$p]['Total']) . '&euro;</td></tr>';
	$totalcmd += $plats[$p]['Total'];
}
echo '<tr><td colspan="4" align="right"><b>Total du panier</b></td><td align="right"><b>' . sprintf("%01.2f", $totalcmd) . '&euro;</b></td></tr>';
echo '</table>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '<h2>Choisissez votre type de livraison</h2>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<form action="reccmd.php" method="post" accept-charset="utf-8">';
if (count($livre) > 0) {
	echo '<strong>Modes de livraison : <strong>';
	echo '<select name="liv"';
	if (isset($errors['liv'])) {
		echo ' style="border: 2px solid #ff0000"';
	}
	echo '>
<option value="0">Faites votre choix...</option>';
	for ($l = 0; $l < count($livre); $l++) {
		echo '<option value="' . $livre[$l]['livraisonID'] . '">' . $livre[$l]['livraisonNom'] . '</option>';
	}
	echo '</select>';
	if (isset($errors['liv'])) {
		echo '<p class="error">' . $errors['liv'] . '</p>';
	}
	if ((isset($flagLivre)) && ($flagLivre == FALSE)) {
		echo '<p><small>Le prestataire choisi ne dessert pas votre lieu d\'habitation, il ne sera donc pas possible de choisir la livraison à domicile.</small></p>';
	}
	include INCLUDE_DIR . 'closeboxfront.php';
	echo '<h2>Choisissez votre date de prestation</h2>';
	//calendrier
	include INCLUDE_DIR . 'openboxfront.php';
	echo '	
	<table border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td nowrap>Date de la prestation : </td>
                  <td valign=top>';
	//creation date du jour
	$aujour = time();
	$date_debut = date('Y-m-d', $aujour);
	//creation du calendrier
	$myCalendar = new tc_calendar("date1", TRUE, FALSE);
	$myCalendar -> setIcon("calendar/images/iconCalendar.gif");
	if (isset($an)) {
		$myCalendar -> setDate($jour, $mois, $an);
	} else {
		$myCalendar -> setDate(date('d'), date('m'), date('Y'));
	}
	$myCalendar -> setPath("calendar/");
	$myCalendar -> dateAllow($date_debut, '', FALSE);
	//jour fermeture hebdomadaire
	for ($f = 0; $f < count($ferme); $f++) {
		$myCalendar -> disabledDay($ferme[$f]);
	}
	//jour conge
	if (!empty($conges)) {
		$myCalendar -> setSpecificDate($conges, 0, 'year');
	}
	$myCalendar -> setAlignment('left', 'bottom');
	$myCalendar -> writeScript();
	echo '</td></tr></table>';
	echo '<div align="right"><input class="cbutton" name="submit" type="submit" value="Continuer commande" title="cliquez pour continuer votre commande" /></div>';
} else {
	echo '<p><strong>Ce prestataire ne peut pas vous offrir de livraison d\'après vos adresses enregistrées.</strong></p><p>Que souhaitez vous faire ?</p>
	<table width="100%" border="0">
	<tr><td width="50%" align="center">
	<a class="fbutton" href="addadresse.php" title="cliquez pour ajouter une nouvelle adresse de livraison">Ajouter une adresse</a>
	</td><td width="50%" align="center">
	<a class="fbutton" href="cancelcmd.php" title="cliquez pour annuler votre commande" onClick="if(confirm(\'Etes-vous certain de vouloir annuler votre commande ?\')) return true; else return false;">Annuler ma commande</a>
	</td></tr></table>';
}
echo '<input type="hidden" name="submitted" value="TRUE" />
</form>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>