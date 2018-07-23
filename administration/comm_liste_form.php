<?php
	//		comm_liste_form.php
	
	//		fichier pour voir la liste de tous les commentaires
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_administrateur.php';
	require_once BUSINESS_DIR . 'cls_commentaire.php';
	require_once BUSINESS_DIR . 'cls_motdepasse.php';
	//vérifier admin loggedin
	Administrateur::CheckLoggedAdmin();
	
	$page_title = "Liste des commentaires";
	include INCLUDE_DIR . 'adminhead.php';
	
	echo '<h2>Liste des commentaires</h2>';
	
	if (Commentaire::HasCommentaireInDB()==FALSE){
		'<p>Il n\'y a aucun commentaire dans la base de données pour le moment.</p>';
		
	}else{
		echo '<table id="commlist"><tr><td></td></tr></table>
<div id="cpager"></div>';
	}
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>
	
