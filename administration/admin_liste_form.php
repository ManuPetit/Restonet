<?php
	//		admin_liste_form.php
	
	//		fichier pour voir la liste de tous les administrateurs
	
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
	
	$page_title = "Liste des administrateurs";
	include INCLUDE_DIR . 'adminhead.php';
	
	echo '<h2>Liste des administateurs</h2>';
	$rows = array();
	$rows = Administrateur::GetAllAdminNomID();
	if (empty($rows))
	{
		echo '<p>Il n\'y a aucun administrateur dans la base de données.</p>';
	}else{
		echo '<table id="list"><tr><td></td></tr></table>
<div id="pager"></div>';
	}
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>
