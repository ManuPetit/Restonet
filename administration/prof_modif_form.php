<?php
	//		prof_modif_form.php
	
	//		fichier pour modifier mon profil
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_administrateur.php';
	require_once BUSINESS_DIR . 'form.php';
	//vérifier admin loggedin
	Administrateur::CheckLoggedAdmin();
	
	$page_title = "Modification de mes détails";
	include INCLUDE_DIR . 'adminhead.php';
	

	//on a des modif à faire
	echo '<h2>' . $page_title . '</h2>';
	$errors = array();
	$admin = new Administrateur();
	$admin->GetAdminParID($_SESSION['adminid']);
	if (isset($_POST['adminmodif']))
	{
		//la forme a été soumise donc on l'analyse
		$flag = false;
		if ($_POST['adcreprenom'] != $admin->GetAdminPrenom())
		{
			$resp = $admin->SetAdminPrenom($_POST['adcreprenom']);
			if (!is_null($resp))
			{
				$errors['adcreprenom'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['adcrenom'] != $admin->GetAdminNom())
		{
			$resp = $admin->SetAdminNom($_POST['adcrenom']);
			if (!is_null($resp))
			{
				$errors['adcrenom'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['adcrepseudo'] != $admin->GetAdminPseudo())
		{
			$resp = $admin->SetAdminPseudo($_POST['adcrepseudo']);
			if (!is_null($resp))
			{
				$errors['adcrepseudo'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['adcreemail'] != $admin->GetAdminEmail())
		{
			$resp = $admin->SetAdminEmail($_POST['adcreemail']);
			if (!is_null($resp))
			{
				$errors['adcreemail'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['adcreadresse1'] != $admin->GetAdminAdresse1())
		{
			$resp = $admin->SetAdminAdresse1($_POST['adcreadresse1']);
			if (!is_null($resp))
			{
				$errors['adcreadresse1'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['adcreadresse2'] != $admin->GetAdminAdresse2())
		{
			$resp = $admin->SetAdminAdresse2($_POST['adcreadresse2']);
			if (!is_null($resp))
			{
				$errors['adcreadresse2'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['ville_id'] != $admin->GetAdminVilleID())
		{
			$resp = $admin->SetAdminVilleID($_POST['ville_id']);
			if (!is_null($resp))
			{
				$errors['cpville'] = $resp;
			}else{
				$flag = true;
			}
		}
		if ($_POST['adcretelephone'] != $admin->GetAdminTelephone())
		{
			$resp = $admin->SetAdminTelephone($_POST['adcretelephone']);
			if (!is_null($resp))
			{
				$errors['adcretelephone'] = $resp;
			} else {
				$flag = true;
			}
		}
		if ($_POST['adcreportable'] != $admin->GetAdminPortable())
		{
			$resp = $admin->SetAdminPortable($_POST['adcreportable']);
			if (!is_null($resp))
			{
				$errors['adcreportable'] = $resp;
			} else {
				$flag = true;
			}
		}
		if (empty($errors))
		{
			if ($flag == false)
			{
				echo '<p>Vous n\'avez fait aucune modification des détails de votre profil.</p>';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'adminfooter.php';
				exit();
			}else{
				$admin->UpdateAdminParID();
				echo '<p>Les changements concernant votre profil ont été sauvegardés dans la base de données.</p>';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'adminfooter.php';
				exit();
			}
		}
	}
		//pas de soumission donc on affiche la forme

		echo '<fieldset>
  <legend>Editez les détails de votre profil : </legend>	
  
  <form action="prof_modif_form.php" method="post" accept-charset="utf-8">
    <table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreprenom"><strong>Votre pr&eacute;nom :</strong></label></td>	
        <td></td>		
		<td>';
		create_form_edit('adcreprenom','text',$errors,40,25,$admin->GetAdminPrenom()); 
		echo '</td></tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcrenom"><strong>Votre nom :</strong></label></td>
        <td></td>		
        <td>';
		create_form_edit('adcrenom','text',$errors,50,45,$admin->GetAdminNom());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcrepseudo"><strong>Votre identifiant de connexion :</strong></label></td>
        <td></td>		
        <td>';
		create_form_edit('adcrepseudo','text',$errors,50,25,$admin->GetAdminPseudo());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreemail"><strong>Votre adresse email :</strong></label></td>
        <td></td>		
		<td>';
        create_form_edit('adcreemail','text',$errors,50,45,$admin->GetAdminEmail());
	   echo '</td> </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreadresse1"><strong>Votre première ligne d\'adresse :</strong></label></td>
        <td></td>		
        <td>';
		create_form_edit('adcreadresse1','text',$errors,50,80,$admin->GetAdminAdresse1());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreadresse2"><strong>Votre deuxième ligne d\'adresse :</strong></label></td>
        <td></td><td>';
        create_form_edit('adcreadresse2','text',$errors,50,80, $admin->GetAdminAdresse2()); 
		echo '<br />
          <small>(optionnel)</small></td>
      </tr> 
	  <tr valign="top">
        <td width="40%" align="right"><label for="cpville"><strong>Votre ville : </strong></label></td>
        <td></td>		
        <td>';
		$ville = $admin->GetAdminVille() . ' - (' . $admin->GetAdminCodePostal() . ')';
		create_form_edit('cpville','text',$errors,50,80,$ville);
        echo '<br />
          <small>Pour changer la ville, commencez par taper son code postal.</small></td>
		   </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcretelephone"><strong>Votre numéro de téléphone :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Portable : </b>Seulement les chiffres. Pas d\'espaces entre les chiffres." /></td>		
        <td>';
		create_form_edit('adcretelephone','text',$errors,20,10,$admin->GetAdminTelephone());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreportable"><strong>Votre numéro de portable :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Portable : </b>Seulement les chiffres. Pas d\'espaces entre les chiffres." /></td>		
        <td>';
		create_form_edit('adcreportable','text',$errors,20,10,$admin->GetAdminPortable());
		echo '<br />
          <small>(optionnel)</small></td>
      </tr>
    </table>
	<input type="hidden" id="ville_id" name="ville_id" value="';
	if (isset($_POST['ville_id']))
	{
		echo $_POST['ville_id']; 
	}else{
		echo $admin->GetAdminVilleID();
	}
	echo '" />
    <div align="center"><input type="submit" name="admincreer" id="admincreer" value="Modifier mes détails personnels" /></div>
    <input type="hidden" name="adminmodif" value="TRUE"  />
  </form>
</fieldset>';

	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>