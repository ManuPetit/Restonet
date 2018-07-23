<?php
//		contact.php

//		permet d'envoyer un mail à restonet.fr

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'phpmail/class.phpmailer.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();

$page_title = "Contactez-nous - RESTOnet";
$menu = 'm4';
include INCLUDE_DIR . 'header.php';
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	
	<?php
	// verification du submitted
	if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
		//vérifier le nom
		if (!preg_match('/^[a-zA-Z éèàçâêîôûùëïö\'-]{2,120}$/i', trim(stripslashes($_POST['nom'])))) {
			$errors['nom'] = 'Il y a des caractères non valides dans votre nom.';
		}else if (strlen($_POST['nom']) > 120) {
			$errors['nom'] = 'Vote nom ne peut pas faire plus de 120 caractères';
		} else {
			$nom = stripslashes($_POST['nom']);
		}
		//verifier l'email
		if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
			$errors['mail'] = 'L\'email entr&eacute;e n\'est pas valide';
		}else if (strlen($_POST['mail']) > 120) {
			$errors['mail'] = 'L\'email ne doit pas faire plus de 120 caract&egres';
		} else {
			$mailFROM = $_POST['mail'];
		}
		//verifier le sujet
		if (!preg_match('/^[0-9a-zA-Z éèàçâêîôûùëïö\'-]{2,120}$/i', trim(stripslashes($_POST['subj'])))) {
			$errors['subj'] = 'Il y a des caractères non valides dans l\'objet de votre message.';
		}else if (strlen($_POST['subj']) > 120) {
			$errors['subj'] = 'L\'objet de votre message ne peut pas faire plus de 120 caractères';
		} else {
			$objet = stripslashes($_POST['subj']);
		}
		//verifier le message
		if (!preg_match('/^[^<>"]{6,10000}$/u', stripslashes($_POST['mess']))) {
			$errors['mess'] = "Il y a des caractères non valides dans votre message.";
		} else {
			//conversion du message pour les htmlentities
			$mess = stripslashes($_POST['mess']);
		}

		//si pas d'erreur
		if (empty($errors)) {
			//preparation du message
			$mail = new PHPMailer();
			$mail -> CharSet = 'utf-8';
			$mail -> Host = "restonet.fr";
			$body = $mess;
			$mail -> SetFrom($mailFROM);
			$mail -> AddAddress(RESTONET_MAIL);
			$mail -> Subject = $objet;
			$mail -> MsgHTML($body);
			$log = '../err/errors_log.txt';
			if (!$mail -> Send()) {
				$date = date('Y-m-d H:i:s');
				$mes = "   |  Date:  " . $date . " -> Erreur Envoi mail : " . $email . " à $to\r\n";
				error_log($mes, 3, $log);
				echo '<h1>Erreur d\'envoi</h1>';
				include INCLUDE_DIR . 'openboxfront.php';
				echo '<p>Une erreur s\'est produite lors de la transmission de l\'email. Veuillez réessayer.</p>';
				include INCLUDE_DIR . 'closeboxfront.php';
				echo '</div>';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'footer.php';
				exit();
			}else{
				echo '<h1>Message envoyé</h1>';
				include INCLUDE_DIR . 'openboxfront.php';
				echo '<p>Nous nous efforcerons de répondre à votre message dans les délais les plus brefs.</p><p>Merci de votre confiance...</p>';
				include INCLUDE_DIR . 'closeboxfront.php';
				echo '</div>';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'footer.php';
				exit();
			}
		}
	}
?>
<h1>Contactez-nous</h1>
<?php
include INCLUDE_DIR . 'openboxfront.php';
?>
<p>
	Vous désirez nous envoyer un message, nous faire une remarque, ou une demande ? Utilisez le formulaire suivant pour nous contacter.
	<br />
	<small>Tous les champs doivent être complétés.</small>
</p>
<form action="contact.php" method="post" accept-charset="utf-8" >
	<fieldset>
		<legend>
			Envoyer un message
		</legend>
		<table width="90%" border="0" cellpadding="5" cellspacing="0" align="center">
			<?php
			echo '<tr valign="top"><td width="40%" align="left"><b>Votre nom :</b></td><td width="60%">';
			create_form_input('nom', 'text', $errors, 40, 120);
			echo '</td></tr>';
			echo '<tr valign="top"><td width="40%" align="left"><b>Votre email :</b></td><td width="60%">';
			create_form_input('mail', 'text', $errors, 40, 120);
			echo '</td></tr>';
			echo '<tr valign="top"><td width="40%" align="left"><b>Objet de votre message :</b></td><td width="60%">';
			create_form_input('subj', 'text', $errors, 40, 120);
			echo '</td></tr>';
			echo '<tr valign="top"><td colspan="2"><b>Votre message :</b></td></tr>
<tr valign="top"><td colspan="2">';
			create_form_input('mess', 'textarea2', $errors);
			echo '</td></tr>';
			?>
		</table>
		<br />
		<div align="center">
			<input type="submit" name="submit" value="Envoyer le message" />
		</div>
		<input type="hidden" name="submitted" value="TRUE" />
	</fieldset>
</form>
<br />
<?php
include INCLUDE_DIR . 'closeboxfront.php';
?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>