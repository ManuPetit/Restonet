<?php
//		addadresse.php

//		ajout d'adresse de client

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['submitted']))) {
	$client = new Client();
	$resp = $client -> SetClientAdresse1('adr1');
	if (!is_null($resp)) {
		$errors['adr1'] = $resp;
	}
	$resp = $client -> SetClientAdresse2($_POST['adr2']);
	if (!is_null($resp)) {
		$errors['adr2'] = $resp;
	}
	if ((isset($_POST['cp1'])) && (trim($_POST['cp1']) != '')) {
		if ((isset($_POST['cp']) && (trim($_POST['cp']) != ''))) {
			$resp = $client -> SetClientVilleID($_POST['cp']);
			if (!is_null($resp)) {
				$errors['cp1'] = $resp;
			}
		} else {
			$errors['cp1'] = "Veuillez choisir votre ville dans la liste déroulante";
		}
	} else {
		$errors['cp1'] = 'Entrez votre code postal';
	}
	$resp = $client -> SetClientTelephoneAdresse($_POST['telf']);
	if (!is_null($resp)) {
		$errors['telf'] = $resp;
	}

	if (empty($errors)) {
		//pas d'erreur on enregistre l'adresse et on retourne à la page précedénte
		$client -> SaveClientAdresse($_SESSION['clientid']);
		if (isset($_SESSION['lastpage'])) {
			$url = $_SESSION['lastpage'];
		} else {
			$url = 'index.php';
		}
		header("Location: $url");
		exit();
	}
}
$page_title = "Nouvelle adresse - RESTOnet";
$menu = 'm5';
include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

//afficher le panier
include BUSINESS_DIR . 'menuclient.php';
echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Nouvelle adresse</h1>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<fieldset><legend>Entrez votre nouvelle adresse</legend>
	<p>Les champs marqués <span style="color:#ff0000;">*</span> doivent être complétés.</p>
	<form action="addadresse.php" method="post" accept-charset="utf-8">
	<table width="90%" border="0" cellspacing="3" align="center">
	<tr valign="top"><td width="35%" align="right"><strong>Adresse première ligne :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_input('adr1', 'text', $errors, 35, 60);
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Complément d\'adresse :</strong></td><td width="5%" align="right"></td><td width="60%">';
create_form_input('adr2', 'text', $errors, 35, 20);
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Code postal :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_input('cp1', 'text', $errors, 35, 150);
echo '
	<input type="hidden" id="cp" name="cp" value="';
if (isset($_POST['cp']))
	echo $_POST['cp'];
echo '" />
	</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Téléphone :</strong></td><td width="5%" align="right"></td><td width="60%">';
create_form_input('telf', 'text', $errors, 35, 15);
echo '</td></tr>
	<tr><td align="center" colspan="3"><input type="submit" value="Enregistrer l\'adresse" name="submit" /></td></tr> 
	</table>
	</fieldset>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>';

include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>