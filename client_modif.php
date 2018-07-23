<?php
//		client_modif.php
//		permet la modification des détails du client
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
//retrouver les données du client
$client = new Client();
$client -> GetClientParID($_SESSION['clientid']);
$ville = $client -> GetVilleCpParID();
$villeid = $client -> GetClientVilleID();

$page_title = "Mes données personnelles - RESTOnet";
$menu = 'm5';

include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';
//afficher le panier
include BUSINESS_DIR . 'show_cart.php';
include BUSINESS_DIR . 'show_menuclient.php';
echo '</div>
<!-- CONTENU  -->
<div id="right">
<h1>Mes données personnelles</h1>';

//vérification des données
if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	if ($_POST['prenom'] != $client -> GetClientPrenom()) {
		$resp = $client -> SetClientPrenom($_POST['prenom']);
		if (!is_null($resp)) {
			$errors['prenom'] = $resp;
		}
	}
	if ($_POST['nom'] != $client -> GetClientNom()) {
		$resp = $client -> SetClientNom($_POST['nom']);
		if (!is_null($resp)) {
			$errors['nom'] = $resp;
		}
	}
	if ($_POST['email'] != $client -> GetEmail()) {
		$resp = $client -> SetClientEmail($_POST['email']);
		if (!is_null($resp)) {
			$errors['email'] = $resp;
		}
	}
	if ($_POST['ident'] != $client -> GetClientPseudo()) {
		$resp = $client -> SetClientPseudo($_POST['ident']);
		if (!is_null($resp)) {
			$errors['ident'] = $resp;
		}
	}
	if ($_POST['adr1'] != $client -> GetClientAdresse1()) {
		$resp = $client -> SetClientAdresse1($_POST['adr1']);
		if (!is_null($resp)) {
			$errors['adr1'] = $resp;
		}
	}
	if ($_POST['adr2'] != $client -> GetClientAdresse2()) {
		$resp = $client -> SetClientAdresse2($_POST['adr2']);
		if (!is_null($resp)) {
			$errors['adr2'] = $resp;
		}
	}
	if ($_POST['cp'] != $client -> GetClientVilleID()) {
		if ((isset($_POST['cp1'])) && (trim($_POST['cp1']) != '')) {
			$resp = $client -> SetClientVilleID($_POST['cp']);
			if (!is_null($resp)) {
				$errors['cp1'] = $resp;
			}
		}
	}
	if ($_POST['telf'] != $client -> GetClientTelephone()) {
		$resp = $client -> SetClientTelephone($_POST['telf']);
		if (!is_null($resp)) {
			$errors['telf'] = $resp;
		}
	}
	if ($_POST['telp'] != $client -> GetClientPortable()) {
		$resp = $client -> SetClientPortable($_POST['telp']);
		if (!is_null($resp)) {
			$errors['telp'] = $resp;
		}
	}
	if ((isset($_POST['news'])) && ($_POST['news'] == 'Oui')) {
		$resp = $client -> SetClientNewsLetter(TRUE);
	} else {
		$resp = $client -> SetClientNewsLetter(FALSE);
	}

	if (empty($errors)) {
		include INCLUDE_DIR . 'openboxfront.php';
		if ($client -> UpdateClientDetail() == true) {
			echo '<p>Vos détails ont été modifiés avec succès dans la base de données.</p>';
		} else {
			echo '<p>Une erreur s\'est produite lors de la mise à jour de vos données personnelles. Veuillez réessayer.</p><p>Si l\'erreur persiste, veuillez contacter l\'administrateur du site.</p>';
		}
		include INCLUDE_DIR . 'closeboxfront.php';
		echo '</div>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'footer.php';
		exit();
	}
}
include INCLUDE_DIR . 'openboxfront.php';
//modification
echo '<fieldset><legend>Entrez vos détails</legend>
	<p>Les champs marqués <span style="color:#ff0000;">*</span> doivent être complétés.</p>
	<form action="client_modif.php" method="post" accept-charset="utf-8">
	<table width="90%" border="0" cellspacing="3" align="center">
	<tr valign="top"><td colspan="3" align="right"><strong>Vos détails</strong></td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Prénom :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_edit('prenom', 'text', $errors, 25, 25, $client -> GetClientPrenom());
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Nom :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_edit('nom', 'text', $errors, 25, 45, $client -> GetClientNom());
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Email :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';

create_form_edit('email', 'text', $errors, 25, 80, $client -> GetEmail());
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Identifiant connexion :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_edit('ident', 'text', $errors, 25, 25, $client -> GetClientPseudo());
echo '<tr valign="top"><td colspan="3" align="right"><strong>Vos coordonnées</strong></td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Adresse première ligne :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_edit('adr1', 'text', $errors, 35, 60, $client -> GetClientAdresse1());
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Complément d\'adresse :</strong></td><td width="5%" align="right"></td><td width="60%">';
create_form_edit('adr2', 'text', $errors, 35, 20, $client -> GetClientAdresse2());
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Ville et Code postal :</strong><br><small>Pour changer la ville, tapez d\'abord votre code postal et selectionnez la ville dans la liste.</small></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_edit('cp1', 'text', $errors, 35, 150, $ville);
echo '
	<input type="hidden" id="cp" name="cp" value="';
if (isset($_POST['cp'])) {
	echo $_POST['cp'];
} else {
	echo $client -> GetClientVilleID();
}
echo '" />
	</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Téléphone :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
create_form_edit('telf', 'text', $errors, 35, 15, $client -> GetClientTelephone());
echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Portable :</strong></td><td width="5%" align="right"></td><td width="60%">';
create_form_edit('telp', 'text', $errors, 35, 15, $client -> GetClientPortable());
echo '</td></tr>
	<tr valign="top"><td colspan="3">Souhaitez-vous recevoir la lettre d\'information de RESTOnet ? <input type="checkbox" name="news" value="Oui"';
if (((isset($_POST['news'])) && ($_POST['news'] == 'Oui'))) {
	echo ' checked="cheked"';
}else if ($client->GetClientNewsLetter()==TRUE){
	echo ' checked="cheked"';	
}
echo ' /></td></tr>
	<tr valign="top"><td colspan="3" align="center"><br /><input type="submit" name="submit" value="Modifier" title="Cliquez ici pour modifier vos données personnelles"/></td></tr></table>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>
	</fieldset>
	';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>