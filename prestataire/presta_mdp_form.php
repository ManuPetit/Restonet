<?php
	//		presta_mdp_form.php
	//		fichier de modification du mot de passe
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_prestataire.php';
	require_once BUSINESS_DIR . 'cls_motdepasse.php';
	require_once BUSINESS_DIR . 'form.php';
	//vérifier admin loggedin
	Prestataire::CheckLoggedPresta();
	
	$page_title = "Changer mon mot de passe";
	include INCLUDE_DIR . 'prestahead.php';
	
	$errors = array();
	
	echo '<h2>' . $page_title . '</h2>';
	
	if (isset($_POST['mdpmod']))
	{
		//on valide les entrees
		if (!preg_match('/^[a-zA-Z0-9]{5,20}$/i',trim($_POST['passa'])))
		{
			$errors['passa'] = 'Votre mot de passe actuel contient des caratères non valides.';
		}else{
			if (Prestataire::CheckPrestaMDP(trim($_POST['passa']),$_SESSION['userid']) == false)
			{
				$errors['passa'] = 'Mauvaise entrée de votre mot de passe actuel';
			}else{
				if (!preg_match('/^[a-zA-Z0-9]{5,20}$/i',trim($_POST['passb'])))
				{
					$errors['passb'] = 'Votre nouveau mot de passe contient des caratères non valides.';
				}else{
					if ((trim($_POST['passb'])) != (trim($_POST['passc'])))
					{
						$errors['passc'] = 'Votre nouveau mot de passe ne correspond pas à la confirmation de votre mot de passe.';
					}else{
						Prestataire::UpdatePrestaMDP(
						trim($_POST['passb']),$_SESSION['userid']);
						echo '<p>Votre mot de passe a été modifié avec succès.</p>';
						DatabaseHandler::Close();
						include INCLUDE_DIR . 'adminfooter.php';
						exit();
					}
				}
			}
		}
	}
		
	if (!empty($errors))
	{
		$_POST['passa'] = NULL;
		$_POST['passb'] = NULL;
		$_POST['passc'] = NULL;
	}
	echo '<p>Entrez les détails suivants pour modifier votre mot de passe.</p>';
	echo '<fieldset><legend>Détails de votre mot de passe : </legend>
<form action="presta_mdp_form.php" method="post"  accept-charset="utf-8">
    <table border="0" width="90%" cellpadding="5">
	<tr valign="top">
        <td width="50%" align="right"><label for="passa"><strong>Votre mot de passe actuel :</strong></label></td>			
		<td>&nbsp;<img src="../images/css/transgif.gif" width="16" height="16" border="0" />';
        create_form_input('passa','password',$errors,30,20); 
		echo '</td></tr>
	<tr valign="top">
        <td width="50%" align="right"><label for="passb"><strong>Entrez votre nouveau mot de passe :</strong></label></td>			
		<td><img src="../images/css/blueinfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="Votre mot de passe ne peut contenir que des lettres (minuscules et/ou majuscules) et/ou des chiffres.Votre mot de passe doit faire entre 5 et 20 caractères." />&nbsp;';
        create_form_input('passb','password',$errors,30,20); 
		echo '</td></tr>
	<tr valign="top">
        <td width="50%" align="right"><label for="passc"><strong>Confirmez votre nouveau mot de passe :</strong></label></td>			
		<td>&nbsp;<img src="../images/css/transgif.gif" width="16" height="16" border="0" />';
		create_form_input('passc','password',$errors,30,20);
		 echo '</td></tr>
	</table>
	<br /><div align="center"><input type="submit" name="submit" id="submit" value="Modifier mon mot de passe" />
	<input type="hidden" name="mdpmod" value="TRUE" />
</form>
</fieldset>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>