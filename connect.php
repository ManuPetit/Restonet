<?php
	//			connect.php
	//	fichier de connexion à RESTOnet
	//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_login.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$errors = array();
//faire les vérification de la submission
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['subl']))){
	
	//le bouton de login  a été cliqué
	if (isset($_POST['logi'])){
		$numlog = $_POST['numlog']+1;
		//verification des inputs
		if (!empty($_POST['ident'])) {
			if (preg_match('/^[a-zA-Z0-9 éèàçâêîôûùëïö]{3,25}$/i', trim($_POST['ident']))) {
				$ident = trim($_POST['ident']);
			} else {
				$errors['ident'] = 'Caractères invalides. Resaisissez votre identifiant.';
			}
		} else {
			$errors['ident'] = 'Vous devez entrer votre identifiant';
		}
		if (!empty($_POST['mdpas'])) {
			if (preg_match('/^[a-zA-Z0-9]{5,20}$/i', trim($_POST['mdpas']))) {
				$mpass = trim($_POST['mdpas']);
			} else {
				$errors['mdpas'] = 'Votre mot de passe ne peut contenir que des lettres (minuscules ou majuscules) et des chiffres,<br />et doit faire entre 5 et 20 caractères.';
			}
		} else {
			$errors['mdpas'] = 'Vous devez entrer votre mot de passe';
		}
		if (empty($errors)) {
			//on a pas d'erreur donc on va essayer de se logger
			$response = Login::CheckLogin($ident, $mpass);
			if ($response == 'admin') {
				$url = 'administration/index.php';
				header("Location: $url");
				exit();
			}else if ($response == 'presta') {
				$url = 'prestataire/index.php';
				header("Location: $url");
				exit();
			}else if ($response == 'client') {
				if (isset($_SESSION['lastpage'])) {
					$url = $_SESSION['lastpage'];
				} else {
					$url = 'index.php';
				}
				header("Location: $url");
				exit();
			} else {
				$errors['mdpas'] = $response;
			}
		}
	}
	
	//le bouton d'inscription a été cliqué
	if (isset($_POST['insc'])){
		//verif email
		if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
			$errors['email']="Email invalide";
		}else{
			$_SESSION['tmpemail']=$_POST['email'];
		}
		if ((strlen($_POST['mdpi']) <5) || (strlen($_POST['mdpi']) >20))
		{
			$errors['mdpi'] = 'Votre mot de passe doit avoir entre 5 et 20 caract&egrave;res';
		}elseif (!preg_match('/^[a-zA-Z0-9]{5,20}$/i',trim($_POST['mdpi']))){
			$errors['mdpi'] = 'Votre mot de passe ne peut contenir que des lettres (minuscules ou majuscules) et des chiffres';
		}else{
			$_SESSION['tmpmdp']=$_POST['mdpi'];
		}
		//si pas d'erreurs on va à la page d'inscription
		if (empty($errors)){
			$url='inscrire.php';
			header("Location: $url");
			exit();
		}
	}
}

$page_title = "Veuillez vous connecter à RESTOnet";
$menu = 'm6';
include INCLUDE_DIR . 'header.php';
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Veuillez vous connecter à RESTOnet</h1>';
	
	include INCLUDE_DIR . 'openboxfront.php';
	//creation d'une table
	echo '<form action="connect.php" method="post" accept-charset="utf-8">
	<table width="100%" border="0" cellspacing="5">
	<tr valign="top"><td width="48%">
	<fieldset><legend class="conex">S\'inscrire</legend>
	<table width="100%" border="0">
	<tr valign="top"><td width="40%" class="conex">Votre email : </td><td width="60%" class="conex">';
	create_form_input('email', 'text', $errors, 18, 80);
	echo '</td></tr>
	<tr valign="top"><td width="40%" class="conex">Mot de passe : </td><td width="60%" class="conex">';
	create_form_input('mdpi', 'password', $errors, 18, 20);
	echo '</td></tr>
	<tr><td colspan="2" class="conex">Si c\'est la première fois que vous utilisez RESTOnet, veuillez indiquez votre adresse email, et créer un mot de passe qui vous servira lors de vos prochaines connexions.<br />Continuez ensuite, votre inscription...</td></tr>
	<tr><td colspan="2" align="center"><input type="submit" name="insc" value="S\'inscrire" title="Cliquez ici pour créer votre compte sur RESTOnet" /></td></tr></table></fieldset>';
	
	echo '</td><td width="4%"></td><td width="48%">
	<fieldset><legend class="conex">Se connecter</legend>
	<table width="100%" border="0">
	<tr valign="top"><td width="40%" class="conex">Identifiant : </td><td width="60%" class="conex">';
	create_form_input('ident', 'text', $errors, 18, 80);
	echo '</td></tr>
	<tr valign="top"><td width="40%" class="conex">Mot de passe : </td><td width="60%" class="conex">';
	create_form_input('mdpas', 'password', $errors, 18, 20);
	echo '</td></tr>
	<tr><td colspan="2" class="conex">Si vous êtes déja un utilisateur de RESTOnet, veuillez indiquez votre identifiant de connexion et votre mot de passe.<br />Continuez ensuite, pour finaliser votre commande...</td></tr>
	<tr><td colspan="2" align="center"><input type="submit" name="logi" value="Connexion" title="Cliquez ici pour vous connecter à votre compte RESTonet" /></td></tr>';

	if (isset($numlog) && ($numlog > 2)){
		echo '<tr><td colspan="2" align="center"><a class="fbutton" href="pass_reco.php" title="Cliquez ici si vous ne vous souvenez plus de votre mot de passe">Mot de passe oublié</a></td></tr>';
	}
	echo '</table></fieldset>
	</td></tr></table>
	<input type="hidden" name="subl" value="TRUE" />
	<input type="hidden" name="numlog" value="';
	if (isset($numlog)){
		echo $numlog;
	}else{
		echo '0';
	}	
	echo '" />';
	include INCLUDE_DIR . 'closeboxfront.php';
	echo '</div>';
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'footer.php';
?>
