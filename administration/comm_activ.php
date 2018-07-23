<?php
	//		presta_activ.php
	// 		active ou désactive un prestataire
	
	
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_commentaire.php';
	
	if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['commid'])) && (isset($_GET['act']))){
		//on a des valeurs on va les verifier
		if (is_numeric($_GET['commid'])){
			if ($_GET['act']=='o'){
				Commentaire::CommentaireSetActif($_GET['commid']);
			}elseif ($_GET['act']== 'n'){
				Commentaire::CommentaireSetNonActif($_GET['commid']);
			}			
		}
	}
	$url = 'comm_liste_form.php';
	header("Location: $url");
	exit();
?>
