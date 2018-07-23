<?php
	//		admin_modiif_form.php
	
	//		fichier pour modifier un administrateur
	
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
	
	$page_title = "Modification d'un administrateur";
	include INCLUDE_DIR . 'adminhead.php';
	
	//on recupère le numéro si on vient de la page admin_liste_form.php
	if ((isset($_GET['adminid'])) && (is_numeric($_GET['adminid'])))
	{
		if ($_GET['adminid'] >0)
		{
			$adminom = Administrateur::GetNomParId($_GET['adminid']);
			$id = (int)$_GET['adminid'];
		}
	}
	//on recupère le numéro si on vient de la page admin_form_form.php
	if ((isset($_POST['adminid'])) && (is_numeric($_POST['adminid'])))
	{
		if ($_POST['adminid'] >0)
		{
			$adminom = Administrateur::GetNomParId($_POST['adminid']);
			$id = (int)$_POST['adminid'];
		}
	}
	if ((!isset($id)) || (!isset($adminom)))
	{
		//on n'a pas d'admin danc on propose le choix
		echo '<h2>Liste des administateurs</h2>';
		$rows = array();
		$rows = Administrateur::GetAllAdminNomID();
		if (empty($rows))
		{
			echo '<p>Il n\'y a aucun administrateur à modifier, dans la base de données.</p>';
		}else{
			echo '<p>Veuillez choisir l\'administrateur à modifier :</p>';
			echo '<fieldset><legend>Administrateur : </legend>
			<form action="admin_modif_form.php" method="post" accept-charset="utf-8">
			<select name="adminid" id="adminid">
			<option value="0" selected="selected">Veuillez choisir un nom</option>';
			for ($i=0; $i < count($rows); $i++)
			{
				echo '<option value="' . $rows[$i]['adminID'] . '">' . $rows[$i]['nom'] .'</option>';
			}
			echo '</select>
			<br />
			<div align="center"><input type="submit" name="submit" id="submit" value="Choisir cet administrateur" /></div>
			</form>
			</fieldset>';
		}
	}else{
		//on a des modif à faire
		echo '<h2>' . $page_title . '</h2>';
		$errors = array();
		$admin = new Administrateur();
		$admin->GetAdminParID($id);
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
			//on ne peut pas changer le pseudo ou l'email d'un admin non loggé
			if ($_SESSION['adminid'] == $id)
			{
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
			if ($_POST['actif'] != $admin->GetAdminActif())
			{
				$resp = $admin->SetAdminActif($_POST['actif']);
				if (!is_null($resp))
				{
					$errors['actif'] = $resp;
				} else {
					$flag = true;
				}
			}
			if ($_POST['super'] != $admin->GetIsSuperAdmin())
			{
				$resp = $admin->SetIsSuperAdmin($_POST['super']);
				if (!is_null($resp))
				{
					$errors['super'] = $resp;
				} else {
					$flag = true;
				}
			}
			if (empty($errors))
			{
				if ($flag == false)
				{
					echo '<p>Aucun changement n\'a été effectué sur la base de données concernant ' . $adminom . '.</p>';
					DatabaseHandler::Close();
					include INCLUDE_DIR . 'adminfooter.php';
					exit();
				}else{
					$admin->UpdateAdminParID();
					echo '<p>Les changements concernant ' . $adminom . ' ont été effectués avec succès.</p>';
					DatabaseHandler::Close();
					include INCLUDE_DIR . 'adminfooter.php';
					exit();
				}
			}
		}
		//pas de soumission donc on affiche la forme
		echo '<div id="dialog-super" title="Super administrateur">
<p><b>ATTENTION :</b><br />Un super administrateur possède des droits complets sur l\'interface administrative de RESTOnet.<br /></p>
<p>Nous vous conseillons de donner ce status à des personnes de confiance.</p>
<p>Un administrateur qui ne possède pas le status de super admnistrateur peut seulement avoir accès aux options suivantes:
<ul><li>Mon profil</li><li>Prestataires</li><li>Plats</li><li>Commentaires</li><li>Activité du site</li></ul>
</p>
</div>';
		echo '<fieldset>
  <legend>Modifiez les d&eacute;tails de '. $adminom .' : </legend>	
  
  <form action="admin_modif_form.php" method="post" accept-charset="utf-8">
    <table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreprenom"><strong>Pr&eacute;nom de l\'administrateur :</strong></label></td>
        <td></td>			
		<td>';
		create_form_edit('adcreprenom','text',$errors,40,25,$admin->GetAdminPrenom()); 
		echo '</td></tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcrenom"><strong>Nom de l\'administrateur :</strong></label></td>
        <td></td>
        <td>';
		create_form_edit('adcrenom','text',$errors,50,45,$admin->GetAdminNom());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcrepseudo"><strong>Identifiant de connexion :</strong></label></td>
        <td></td>
        <td>';
		//on ne peut pas changer le pseudo d'un admin non loggé
		if ($_SESSION['adminid'] != $id)
		{
			echo '<input type ="text" size="40" name="adcrepseudo" readonly="readonly" class="readonly" value="' . $admin->GetAdminPseudo() . '" />';
			echo '<br /><small>Ce champs ne peut être changé que par le titulaire du compte.</small>';
		}else{
			create_form_edit('adcrepseudo','text',$errors,50,25,$admin->GetAdminPseudo());
		}
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreemail"><strong>Adresse email :</strong></label></td>
        <td></td>
        <td>';
		//on ne peut pas changer l'email d'un admin non loggé
		if ($_SESSION['adminid'] != $id)
		{
			echo '<input type ="text" size="50" name="adcrepseudo" readonly="readonly" class="readonly" value="' . $admin->GetAdminEmail() . '" />';
			echo '<br /><small>Ce champs ne peut être changé que par le titulaire du compte.</small>';
		}else{
			create_form_edit('adcreemail','text',$errors,50,45,$admin->GetAdminEmail());
		}
	  echo '</td> </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreadresse1"><strong>Première ligne adresse :</strong></label></td>
        <td></td>
        <td>';
		create_form_edit('adcreadresse1','text',$errors,50,80,$admin->GetAdminAdresse1());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreadresse2"><strong>Deuxième ligne adresse :</strong></label></td>
        <td></td>
        <td>';
        create_form_edit('adcreadresse2','text',$errors,50,80, $admin->GetAdminAdresse2()); 
		echo '<br />
          <small>(optionnel)</small></td>
      </tr> 
	  <tr valign="top">
        <td width="40%" align="right"><label for="cpville"><strong>Ville : </strong></label></td>
        <td></td>
        <td>';
		$ville = $admin->GetAdminVille() . ' - (' . $admin->GetAdminCodePostal() . ')';
		create_form_edit('cpville','text',$errors,50,80,$ville);
        echo '<br />
          <small>Pour changer la ville, commencez par taper son code postal.</small></td>
		   </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcretelephone"><strong>Numéro de téléphone :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Téléphone : </b>Seulement les chiffres. Pas d\'espaces entre les chiffres." /></td>
        <td>';
		create_form_edit('adcretelephone','text',$errors,20,10,$admin->GetAdminTelephone());
		echo '</td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="adcreportable"><strong>Numéro de portable :</strong></label></td>
        <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Téléphone : </b>Seulement les chiffres. Pas d\'espaces entre les chiffres." /></td>
        <td>';
		create_form_edit('adcreportable','text',$errors,20,10,$admin->GetAdminPortable());
		echo '<br />
          <small>(optionnel)</small></td>
      </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="actif"><strong>Administrateur activé :</strong></label></td>
        <td></td>
        <td><select name="actif" id="actif">';
		if (isset($_POST['actif'])) {
			$visible = $_POST['actif'];
		} else {
			$visible = $admin->GetAdminActif();
		}
		if ($visible == 1)
		{
			echo '<option value="1" selected="selected">Oui</option>
			<option value="0">Non</option>';
		}
		else
		{
			echo '<option value="1">Oui</option>
			<option value="0" selected="selected">Non</option>';
		}
		echo ' </select></td>
      </tr>
      <td width="40%" align="right"><label for="super"><strong>Super administrateur :</strong></label></td>
      <td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>ATTENTION : </b><br />Un super administrateur dispose de tous les droits sur le système administratif de RESTOnet." /></td>
        <td><select name="super" id="super">';
		if (isset($_POST['actif'])) {
			$visible2 = $_POST['super'];
		} else {
			$visible2 = $admin->GetIsSuperAdmin();
		}
		if ($visible2 == 1)
		{
			echo '<option value="1" selected="selected">Oui</option>
			<option value="0">Non</option>';
		}
		else
		{
			echo '<option value="1">Oui</option>
			<option value="0" selected="selected">Non</option>';
		}
		echo '</select>
          </td>
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
    <div align="center"><input type="submit" name="admincreer" id="admincreer" value="Modifier administrateur" /></div>
    <input type="hidden" name="adminmodif" value="TRUE"  />
	<input type="hidden" name="adminid" value="' . $id .'"  />
  </form>
</fieldset>';
	}
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>