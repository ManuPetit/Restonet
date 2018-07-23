<?php
	//			inscrire.php
	//	fichier d'inscription à RESTOnet
	//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';


//preparer le handler d'erreur
ErrorHandler::SetHandler();

$errors = array();

//vérification
if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')){
	$client= new Client();
	$resp = $client->SetClientPrenom($_POST['prenom']);
	if (!is_null($resp)){
		$errors['prenom']=$resp;
	}
	$resp=$client->SetClientNom($_POST['nom']);
	if (!is_null($resp)){
		$errors['nom']=$resp;
	}
	$resp=$client->SetClientEmail($_POST['email']);
	if (!is_null($resp)){
		$errors['email']=$resp;
	}
	$resp=$client->SetClientPseudo($_POST['ident']);
	if (!is_null($resp)){
		$errors['ident']=$resp;
	}
	
	//vérification des deux champs de mot de passe
	if ((isset($_POST['mdp1'])) && (isset($_POST['mdp2']))){
		if ($_POST['mdp1'] == $_POST['mdp2']){
			//les deux mots de passe sont similaires on verifie le premier
			$resp = $client->SetClientMotDePasse($_POST['mdp1']);
			if (!is_null($resp)){
				$errors['mdp1']=$resp;
				unset($_POST['mdp1']);
				unset($_POST['mdp2']);
			}
		}else{
			$errors['mdp2']='La confirmation du mot de passe ne correspond pas au mot de passe original.';
			unset($_POST['mdp2']);
		}
	}
	$resp=$client->SetClientAdresse1($_POST['adr1']);
	if (!is_null($resp)){
		$errors['adr1']=$resp;
	}
	$resp=$client->SetClientAdresse2($_POST['adr2']);
	if (!is_null($resp)){
		$errors['adr2']=$resp;
	}
	if ((isset($_POST['cp1']))&& (trim($_POST['cp1']) != '')){
		if ((isset($_POST['cp']) &&(trim($_POST['cp']) != ''))){
			$resp=$client->SetClientVilleID($_POST['cp']);
			if (!is_null($resp)){
				$errors['cp1']=$resp;
			}
		}else{
			$errors['cp1']="Veuillez choisir votre ville dans la liste déroulante";
		}
	}else{
		$errors['cp1']= 'Entrez votre code postal';
	}
	$resp=$client->SetClientTelephone($_POST['telf']);
	if (!is_null($resp)){
		$errors['telf']=$resp;
	}
	$resp=$client->SetClientPortable($_POST['telp']);
	if (!is_null($resp)){
		$errors['telp']=$resp;
	}
	if ((isset($_POST['news'])) && ($_POST['news']=='Oui')){
		$resp=$client->SetClientNewsLetter(TRUE);
	}else{
		$resp=$client->SetClientNewsLetter(FALSE);		
	}
	
	//s'il n'y a pas d'erreur on sauvegarde les détails
	if (empty($errors)){
		$client->SaveClientDetails();
		$message = "<h2>Bienvenue sur RESTOnet</h2><p>Ce message vous est envoyé, pour confirmer votre inscription au site RESTOnet.fr</p>";
		$message = $message . "<p>Vous avez choisi les identifiants de connexion suivants :<br /><b>Identifiant :</b> " .$client->GetClientPseudo();
		$message = $message . "<br /><b>Mot de passe :</b> " . $_POST['mdp1']. "</p>";
		$message = $message . "<p>Vous pouvez modifier vos détails à partir du menu mon compte une fois que vous êtes connecté au site RESTOnet.fr.</p><p>Nous restons à votre écoute. N'hésitez pas à nous contacter, en cas de besoin...</p><h4>RESTOnet</h4><p><b>PS :</b>Ce message est généré automatiquement, veuillez ne pas y répondre.</p>";
				//envoyer l'email de confirmation
		require_once BUSINESS_DIR . 'phpmail/class.phpmailer.php';
		$mail = new PHPMailer();
	$mail -> CharSet = 'utf-8';
	$mail -> Host = "restonet.fr";
	$body = $message;
	$mail -> SetFrom("info@restonet.com");
	$mail -> AddAddress($client->GetEmail());
	$mail -> Subject = "Bienvenue sur RESTOnet";
	$mail -> MsgHTML($body);
	$log = '/err/errors_log.txt';
	if (!$mail -> Send()) {
		$date = date('Y-m-d H:i:s');
		$mes = "   |  Date:  " . $date . " -> Erreur Envoi mail : " . $email . " à $to\r\n";
		error_log($mes, 3, $log);
	}
		//affecter les variables de sessions
		$_SESSION['userid']=$client->GetClientUserID();
		$_SESSION['clientid']=$client->GetClientID();
		if (isset($_SESSION['lastpage'])){
			$url=$_SESSION['lastpage'];
		}else{
			$url='index.php';
		}
		header("Location: $url");
		exit();
	}
}

$page_title = "Votre inscription sur RESTOnet";
$menu = 'm5';

include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Votre inscription sur RESTOnet</h1>';
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<fieldset><legend>Entrez vos détails</legend>
	<p>Les champs marqués <span style="color:#ff0000;">*</span> doivent être complétés.</p>
	<form action="inscrire.php" method="post" accept-charset="utf-8">
	<table width="90%" border="0" cellspacing="3" align="center">
	<tr valign="top"><td colspan="3" align="right"><strong>Vos détails</strong></td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Prénom :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('prenom', 'text', $errors, 25, 25);
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Nom :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('nom', 'text', $errors, 25, 45);
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Email :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	if (isset($_SESSION['tmpemail'])){
		create_form_edit('email', 'text', $errors, 25, 80, $_SESSION['tmpemail']);
		unset($_SESSION['tmpemail']);
	}else{
		create_form_input('email', 'text', $errors, 25, 80);
	}
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Identifiant connexion :</strong><br /><small>Cet identifiant vous permettra de vous connecter à votre compte</small></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('ident', 'text', $errors, 25, 25);
	echo '</td></tr><tr valign="top"><td width="35%" align="right"><strong>Mot de passe :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	if (isset($_SESSION['tmpmdp'])){
		create_form_edit('mdp1', 'password', $errors, 25, 20, $_SESSION['tmpmdp']);
		unset($_SESSION['tmpmdp']);
	}else{
		create_form_input('mdp1', 'password', $errors, 25, 20);
	}
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Confirmez mot de passe :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('mdp2', 'password', $errors, 25, 20);
	echo '</td></tr>
	<tr valign="top"><td colspan="3" align="right"><strong>Vos coordonnées</strong></td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Adresse première ligne :</strong></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('adr1', 'text', $errors, 35, 60);
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Complément d\'adresse :</strong></td><td width="5%" align="right"></td><td width="60%">';
	create_form_input('adr2', 'text', $errors, 35, 60);
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Code postal :</strong><br /><small>Entrez votre code postal et choisissez votre ville dans la liste</small></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('cp1', 'text', $errors, 35, 150);
	echo '
	<input type="hidden" id="cp" name="cp" value="';
	if (isset($_POST['cp'])) echo $_POST['cp']; 
	echo '" />
	</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Téléphone :</strong><br /><small>Entrez votre numéro sans espace</small></td><td width="5%" align="right"><span style="color:#ff0000;">*</span></td><td width="60%">';
	create_form_input('telf', 'text', $errors, 35, 15);
	echo '</td></tr>
	<tr valign="top"><td width="35%" align="right"><strong>Portable :</strong><br /><small>Entrez votre numéro sans espace</small></td><td width="5%" align="right"></td><td width="60%">';
	create_form_input('telp', 'text', $errors, 35, 15);
	echo '</td></tr>
	<tr valign="top"><td colspan="3">Souhaitez-vous recevoir la lettre d\'information de RESTOnet ? <input type="checkbox" name="news" value="Oui"';
	if ((isset($_POST['news'])) && ($_POST['news']=='Oui')){
		echo ' checked="cheked"';
	}
	echo ' /></td></tr>
	<tr valign="top"><td colspan="3" align="center"><br /><input type="submit" name="submit" value="Inscription" title="Cliquez ici pour finaliser votre inscription sur RESTOnet"/></td></tr></table>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>
	</fieldset>
	';	
	include INCLUDE_DIR . 'closeboxfront.php';
	echo '</div>';
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'footer.php';
?>