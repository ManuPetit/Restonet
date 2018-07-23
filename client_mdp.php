<?php
//		client_mdp.php
//		permet de modifier le mot de passe

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'cls_client.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
$page_title = "Modifier mon mot de passe - RESTOnet";
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
<h1>Modifier mon mot de passe </h1>';
//verification du mot de passe
if ((isset($_POST['mdpmod'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	if (!preg_match('/^[a-zA-Z0-9]{5,20}$/i', trim($_POST['passa']))) {
		$errors['passa'] = 'Votre mot de passe actuel contient des caratères non valides.';
	} else {
		if (Client::CheckClientMDP(trim($_POST['passa']), $_SESSION['userid']) == false) {
			$errors['passa'] = 'Mauvaise entrée de votre mot de passe actuel';
		} else {
			if (!preg_match('/^[a-zA-Z0-9]{5,20}$/i', trim($_POST['passb']))) {
				$errors['passb'] = 'Votre nouveau mot de passe contient des caratères non valides.';
			} else {
				if ((trim($_POST['passb'])) != (trim($_POST['passc']))) {
					$errors['passc'] = 'Votre nouveau mot de passe ne correspond pas à la confirmation de votre mot de passe.';
				} else {
					Client::UpdateClientMDP(trim($_POST['passb']), $_SESSION['userid']);
					include INCLUDE_DIR . 'openboxfront.php';
					echo '<p>Votre mot de passe a été modifié avec succès.</p>';
					include INCLUDE_DIR . 'closeboxfront.php';
					echo '</div>';
					DatabaseHandler::Close();
					include INCLUDE_DIR . 'footer.php';
					exit();
				}
			}
		}
	}

	if (!empty($errors)) {
		$_POST['passa'] = NULL;
		$_POST['passb'] = NULL;
		$_POST['passc'] = NULL;
	}
}
include INCLUDE_DIR . 'openboxfront.php';
echo '<p>Entrez les détails suivants pour modifier votre mot de passe.</p>';
echo '<fieldset><legend>Détails de votre mot de passe : </legend>
<form action="client_mdp.php" method="post"  accept-charset="utf-8">
    <table border="0" width="100%" cellpadding="5">
	<tr valign="top">
        <td width="50%" align="right"><label for="passa"><strong>Votre mot de passe actuel :</strong></label></td>			
		<td>&nbsp;<img src="images/css/transgif.gif" width="16" height="16" border="0" />';
create_form_input('passa', 'password', $errors, 30, 20);
echo '</td></tr>
	<tr valign="top">
        <td width="50%" align="right"><label for="passb"><strong>Entrez votre nouveau mot de passe :</strong></label></td>			
		<td><img src="images/css/orangeinfo.jpg" width="16" height="16" border="0" title="Votre mot de passe ne peut contenir que des lettres (minuscules et/ou majuscules) et/ou des chiffres. Votre mot de passe doit faire entre 5 et 20 caractères." />&nbsp;';
create_form_input('passb', 'password', $errors, 30, 20);
echo '</td></tr>
	<tr valign="top">
        <td width="50%" align="right"><label for="passc"><strong>Confirmez votre nouveau mot de passe :</strong></label></td>			
		<td>&nbsp;<img src="images/css/transgif.gif" width="16" height="16" border="0" />';
create_form_input('passc', 'password', $errors, 30, 20);
echo '</td></tr>
	</table>
	<br /><div align="center"><input type="submit" name="submit" id="submit" value="Modifier mon mot de passe" />
	<input type="hidden" name="mdpmod" value="TRUE" />
</form>
</fieldset>';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>