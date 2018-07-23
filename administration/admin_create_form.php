<?php
	//		admin_create_form.php
	
	//		fichier pour la création d'un nouvel administrateur
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_administrateur.php';
	require_once BUSINESS_DIR . 'cls_motdepasse.php';
	require_once BUSINESS_DIR . 'form.php';
	
	//vérifier admin loggedin
	Administrateur::CheckLoggedAdmin();
	
	$page_title = "Nouvel administrateur";
	include INCLUDE_DIR . 'adminhead.php';
	
	//variable pour les erreurs
	$errors=array();
	
	//script de validation
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['adminsub'])))
	{
		//passage des varaibles et création de l'administrateur
		$admin = new Administrateur();
		$resp = $admin->SetAdminPrenom($_POST['adcreprenom']);
		if (!is_null($resp))
		{
			$errors['adcreprenom'] = $resp;
		}
		$resp = $admin->SetAdminNom($_POST['adcrenom']);
		if (!is_null($resp))
		{
			$errors['adcrenom'] = $resp;
		}
		$resp = $admin->SetAdminPseudo($_POST['adcrepseudo']);
		if (!is_null($resp))
		{
			$errors['adcrepseudo'] = $resp;
		}
		$resp = $admin->SetAdminEmail($_POST['adcreemail']);
		if (!is_null($resp))
		{
			$errors['adcreemail'] = $resp;
		}
		$resp = $admin->SetAdminAdresse1($_POST['adcreadresse1']);
		if (!is_null($resp))
		{
			$errors['adcreadresse1'] = $resp;
		}
		$resp = $admin->SetAdminAdresse2($_POST['adcreadresse2']);
		if (!is_null($resp))
		{
			$errors['adcreadresse2'] = $resp;
		}
		$resp = $admin->SetAdminVilleID($_POST['ville_id']);
		if (!is_null($resp))
		{
			$errors['cpville'] = $resp;
		}
		$resp = $admin->SetAdminTelephone($_POST['adcretelephone']);
		if (!is_null($resp))
		{
			$errors['adcretelephone'] = $resp;
		}
		$resp = $admin->SetAdminPortable($_POST['adcreportable']);
		if (!is_null($resp))
		{
			$errors['adcreportable'] = $resp;
		}
		$resp = $admin->SetAdminActif($_POST['actif']);
		if (!is_null($resp))
		{
			$errors['actif'] = $resp;
		}
		$resp = $admin->SetIsSuperAdmin($_POST['super']);
		if (!is_null($resp))
		{
			$errors['super'] = $resp;
		}
		//on a pas d'erreur on peut créer l'administrateur
		if (empty($errors))
		{
			//mdp
			$pass = MotDePasse::MakePassword(12);
			$admin->SetAdminMotDePasse($pass);
			$admin->SaveAdminDetails();
			//récapitulatif
			$message = '<h1>Bienvenue sur RESTOnet</h1>
			<p>Vous trouverez ci-après les détails dont vous aurez besoin pour vous connecter à l\'interface administrative de RESTOnet.</p>
			<p><b>Votre nom :</b> ' . $admin->GetAdminNom();
			$message .= '<br /><b>Votre prénom :</b> ' . $admin->GetAdminPrenom();
			$message .= '<br /><b>Identenfiant de connexion :</b> ' . $admin->GetAdminPseudo();
			$message .= '<br /><b>Mot de passe de connexion :</b> ' . $pass . '<br />(il est recommandé de changer ce mot de passe lors de votre première connexion à RESTOnet)';
			$message .= '<br /><b>Votre adresse email :</b> ' . $admin->GetAdminEmail();
			$message .= '</p><p>Vous pouvez modifier tous vos détails une fois connecté à l\'interface administrative de RESTOnet en allant dans le menu &laquo;Mon profil&raquo;.</p>
			<p>Bienvenue dans RESTOnet,<br />Laetitia</p>';
			echo '<h2>Creation d\'un nouvel administateur</h2><p>La création du nouvel administrateur est terminée.</p><p>Voici les détails du nouvel administrateur :</p>';
			echo '<fieldset><div id="selecttoprint">';
			//message sur page web
			echo $message .	'</div></fieldset><p />';
			//pour envoyer email
			echo '<div style="display: none;" id="to">' . $admin->GetAdminEmail() . '</div>
			<div style="display: none;" id="subject">Bienvenue sur RESTOnet</div>';
			//bouton d'action
			echo '<div id="print_button" title="Cliquez ic pour imprimer ce document à transmettre au nouvel administrateur.">Imprimer</div>&nbsp;&nbsp;
			<button id="envoi_mail">Envoyer email</button><div style="display: none;" id="loading"><img src="../images/css/loading.gif" /> <font color="#FF0000">Envoi en cours...</font></div>
			<div style="display: none;" id="message-sent"><font color="#000000">Message envoyé !</font></div>';
			DatabaseHandler::Close();
			include INCLUDE_DIR . 'adminfooter.php';
			exit();
		}
	}
?>
<div id="dialog-super" title="Super administrateur">
<p><b>ATTENTION :</b><br />Un super administrateur possède des droits complets sur l'interface administrative de RESTOnet.<br /></p>
<p>Nous vous conseillons de donner ce status à des personnes de confiance.</p>
<p>Un administrateur qui ne possède pas le status de super admnistrateur peut seulement avoir accès aux options suivantes:
<ul><li>Mon profil</li><li>Prestataires</li><li>Plats</li><li>Commentaires</li><li>Activité du site</li></ul>
</p>
</div>
<h2>Creation d'un nouvel administateur</h2>
<fieldset>
  <legend>Entrez les d&eacute;tails de votre nouvel administrateur : </legend>
  <form action="admin_create_form.php" method="post" accept-charset="utf-8">
    <table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreprenom"><strong>Pr&eacute;nom de l'administrateur :</strong></label></td>
        <td></td>
        <td><?php create_form_input('adcreprenom','text',$errors,40,25); ?></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcrenom"><strong>Nom de l'administrateur :</strong></label></td>
        <td></td>
        <td><?php create_form_input('adcrenom','text',$errors,50,45); ?></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcrepseudo"><strong>Identifiant de connexion :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Identifiant :</b><br />Il est nécessaire pour se connecter à l'interface admnstrative de RESTOnet.<br />Vous pouvez utiliser celui qui a été auto-générer par le système ou, entrer celui de votre choix." /></td>
        <td><?php create_form_input('adcrepseudo','text',$errors,40,25); ?></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreemail"><strong>Adresse email :</strong></label></td>
        <td></td>
        <td><?php create_form_input('adcreemail','text',$errors,50,80); ?></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreadresse1"><strong>Première ligne adresse :</strong></label></td>
        <td></td>
        <td><?php create_form_input('adcreadresse1','text',$errors,50,80); ?></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreadresse2"><strong>Deuxième ligne adresse :</strong></label></td>
        <td></td>
        <td><?php create_form_input('adcreadresse2','text',$errors,50,80); ?>
          <br />
          <small>(optionnel)</small></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="cpville"><strong>Ville : </strong></label></td>
        <td></td>
        <td><?php create_form_input('cpville','text',$errors,50,80); ?>
          <br />
          <small>Entrez le code postal de la ville pour la selectionner</small></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcretelephone"><strong>Numéro de téléphone :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Téléphone : </b>Seulement les chiffres. Pas d'espaces entre les chiffres." /></td>
        <td><?php create_form_input('adcretelephone','text',$errors,20,10); ?></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreportable"><strong>Numéro de portable :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Portable : </b>Seulement les chiffres. Pas d'espaces entre les chiffres." /></td>
        <td><?php create_form_input('adcreportable','text',$errors,20,10); ?>
          <br />
          <small>(optionnel)</small></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="actif"><strong>Administrateur activé :</strong></label></td>
        <td></td>
        <td><select name="actif" id="actif">
            <?php
				if (isset($_POST['actif']))
				{
					if ($_POST['actif'] == 1)
					{
						echo '<option value="1" selected="selected">Oui</option>
						<option value="0">Non</option>';
					}
					else
					{
						echo '<option value="1">Oui</option>
						<option value="0" selected="selected">Non</option>';
					}
				}
				else
				{
					echo '<option value="1" selected="selected">Oui</option>
					<option value="0">Non</option>';
				}
			?>
          </select></td>
      </tr>
      <td width="40%" align="right"><label for="super"><strong>Super administrateur :</strong></label></td>
      <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>ATTENTION : </b><br />Un super administrateur dispose de tous les droits sur le système administratif de RESTOnet." /></td>
        <td><select name="super" id="super">
            <?php
				if (isset($_POST['super']))
				{
					if ($_POST['super'] == 1)
					{
						echo '<option value="1" selected="selected">Oui</option>
						<option value="0">Non</option>';
					}
					else
					{
						echo '<option value="1">Oui</option>
						<option value="0" selected="selected">Non</option>';
					}
				}
				else
				{
					echo '<option value="1">Oui</option>
					<option value="0" selected="selected">Non</option>';
				}
			?>
          </select>
          </td>
      </tr>
    </table>
    <input type="hidden" id="ville_id" name="ville_id" value="<?php if (isset($_POST['ville_id'])) echo $_POST['ville_id']; ?>" />
    <div align="center"><input type="submit" name="admincreer" id="admincreer" value="Créer administrateur" /></div>
    <input type="hidden" name="adminsub" value="TRUE"  />
  </form>
</fieldset>
<?php
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>
