<?php
//			pass_reco.php
//			procédure pour regénérer un mot de passe

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'phpmail/class.phpmailer.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$errors = array();

$page_title = "Mot de passe oublié";
$menu = 'm6';

include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';
//afficher le panier
include BUSINESS_DIR . 'show_cart.php';
echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Mot de passe oublié</h1>';
//faire les vérifications
//vérification
if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	$mails = trim($_POST['email']);
	$resp = MotDePasse::CheckEmailRecover($mails);
	if (!is_null($resp)) {
		$errors['email'] = $resp;
	}
	if (empty($errors)) {
		//créer nouveau mot de passe
		$mdp = MotDePasse::MakePassword(15);
		//enregistrer le mot de passe dans la base de donnée
		DatabaseHandler::SetBeginTransaction();
		try {
			$sql = "CALL upd_recover_mdp(:mMail,:mMDEP)";
			$params = array(':mMail' => $mails, ':mMDEP' => MotDePasse::HashMotDePasse($mdp));
			DatabaseHandler::Execute($sql, $params);
			DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			include INCLUDE_DIR . 'openboxfront.php';
			echo '<p>Une erreur s\'est produite lors de la génération de votre mot de passe. Veuillez recommencer.</p><p>Si le problème persiste, contactez l\'administrateur du site RESTOnet.</p>';
			include INCLUDE_DIR . 'closeboxfront.php';
			echo '</div>';
			include INCLUDE_DIR . 'footer.php';
			trigger_error($e -> getMessage(), E_USER_ERROR);
			exit();
		}
		//créer le mail
		include INCLUDE_DIR . 'openboxfront.php';
		$body = "<h2>Votre nouveau mot de passe</h2><p>Vous avez demandé un nouveau mot de passe pour vous connecter à RESTOnet.fr.</p><p>Le mot de passe généré automatiquement est le suivant : $mdp</p><p>Utilisez ce nouveau mot de passe pour vous connecter à RESTOnet.</p><p>Nous vous conseillons de changer votre nouveau mot de passe, pour un qui vous corresponde mieux, lors de votre prochaine connexion.</p><p>RESTOnet vous remercie pour votre confiance</p><p><small>Ce message a été généré automatiquement. Veuillez ne pas y répondre.<br />Si vous devez contacter RESTOnet, utilisez le formulaire à cet effet en allant à la page ";
		$body .= '<a href="http://www.restonet.fr/contact.php" target="_new">contact</a> de notre site internet.</small></p>';
		$mail = new PHPMailer();
		$mail -> CharSet = 'utf-8';
		$mail -> Host = "restonet.fr";
		$mail -> SetFrom("info@restonet.com", "RESTOnet");
		$mail -> AddAddress($mails);
		$mail -> Subject = "Votre nouveau mot de passe";
		$mail -> MsgHTML($body);
		$ldate=date('Y_m_d');
		$log = 'err/errors_log_'.$ldate.'.txt';
		if (!$mail -> Send()) {
			$date = date('Y-m-d H:i:s');
			$mes = "   |  Date:  " . $date . " -> Erreur Envoi mail : à " . $mails . "\r\n";
			error_log($mes, 3, $log);
			$finalmes = '<p>Une erreur s\'est produite lors de la transmission de l\'email. Veuillez recommencer.</p><p>Si le problème persiste, contactez l\'administrateur du site RESTOnet.</p>';
		} else {
			//enlever le fichier
			$finalmes = '<p>Un email vous a été envoyé avec votre nouveau mot de passe.</p>';
		}
		echo $finalmes;
		include INCLUDE_DIR . 'closeboxfront.php';
		echo '</div>';
		include INCLUDE_DIR . 'footer.php';
		exit();
	}
}
include INCLUDE_DIR . 'openboxfront.php';
echo '<p>Vous avez oublié votre mot de passe de connexion à RESTOnet.</p><p>Veuilez entrer l\'adresse email que vous avez utilisée lors de votre inscription, pour que nous faisions parvenir un nouveau mot de passe.</p>
	<fieldset><legend>Entrez votre adresse email</legend>
	<form action="pass_reco.php" method="post" accept-charset="utf-8">
	<p><strong>Votre email : </strong>';
create_form_input('email', 'text', $errors, 40, 80);
echo '</p>
	<div align="center"><input type="submit" name="submit" value="Demande d\'un nouveau mot de passe" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>';

include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>
