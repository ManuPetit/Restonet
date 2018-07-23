<?php
	//		admin_delete_form.php
	
	//		fichier pour supprimer administrateur
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_administrateur.php';
	require_once BUSINESS_DIR . 'cls_motdepasse.php';
	//vérifier admin loggedin
	Administrateur::CheckLoggedAdmin();
	
	$page_title = "Suppression d'un administrateur";
	include INCLUDE_DIR . 'adminhead.php';
	
	//on recupère le numéro si on vient de la page admin_liste_form.php
	if ((isset($_GET['adminid'])) && (is_numeric($_GET['adminid'])))
	{
		if ($_GET['adminid'] >0)
		{
			$admin = Administrateur::GetNomParId($_GET['adminid']);
			$id = (int)$_GET['adminid'];
		}
	}
	//on recupère le numéro si on vient de la page admin_delete_form.php
	if ((isset($_POST['adminid'])) && (is_numeric($_POST['adminid'])))
	{
		if ($_POST['adminid'] >0)
		{
			$admin = Administrateur::GetNomParId($_POST['adminid']);
			$id = (int)$_POST['adminid'];
		}
	}
	//si on a pas de valeur c'est que l'on a pas encore choisi l'admin a detruire sinon on fait ce qui suit
	if ((isset($id)) && (isset($admin)))
	{
		Administrateur::DeleteAdmin($id);
		echo '<h2>' . $page_title . '</h2>
		<p>L\'administrateur : <b>' . $admin . '</b> a bien été supprimmé de la base de données.<br />Toutes les données relatives à cette personne ont également été suprrimées.</p>';
	}
	else
	{
		//on n'a pas de valeur on choisi l'admin
		echo '<h2>Liste des administateurs</h2>';
		$rows = array();
		$rows = Administrateur::GetAllAdminNomID();
		if (empty($rows))
		{
			echo '<p>Il n\'y a aucun administrateur à supprimer, dans la base de données.</p>';
		}else{
			echo '<p>Veuillez choisir l\'administrateur à supprimer :</p>';
			echo '<fieldset><legend>Administrateur : </legend>
			<form action="admin_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm(\'Etes-vous certains de vouloir supprimer cet administrateur ?\')) return true; else return false;">
			<select name="adminid" id="adminid">
			<option value="0" selected="selected">Veuillez choisir un nom</option>';
			for ($i=0; $i < count($rows); $i++)
			{
				//on peut pas supprimer l'admin qui est loggé
				if ($rows[$i]['adminID'] != $_SESSION['adminid'])
				{
					echo '<option value="' . $rows[$i]['adminID'] . '">' . $rows[$i]['nom'] .'</option>';
				}
			}
			echo '</select>
			<br />
			<div align="center"><input type="submit" name="submit" id="submit" value="Supprimer administrateur" /></div>
			</form>
			</fieldset>';
		}
	}

	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>
