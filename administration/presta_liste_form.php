<?php
	//		presta_liste_form.php
	//		retourne la liste des prestataires
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_administrateur.php';
	require_once BUSINESS_DIR . 'cls_prestataire.php';
	require_once BUSINESS_DIR . 'cls_motdepasse.php';
	//vérifier admin loggedin
	Administrateur::CheckLoggedAdmin();
	
	$page_title = "Liste des prestataires";
	include INCLUDE_DIR . 'adminhead.php';
	
	echo '<h2>Liste des prestataires</h2>';
	$rows = array();
	$rows=Prestataire::GetAllPrestaNomID();
	if (empty($rows)){		
		echo '<p>Il n\'y a aucun prestataire dans la base de données.</p>';
	}else{
		if ((isset($_SESSION['issuper'])) && ($_SESSION['issuper']==1)){
		//superadmin peut supprimer prestataire
		echo '<table id="psalist"><tr><td></td></tr></table>
<div id="ppager"></div>';
			
		}else {
		echo '<table id="plist"><tr><td></td></tr></table>
<div id="ppager"></div>';			
		}
	}
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>