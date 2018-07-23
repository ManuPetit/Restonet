<?php
	//		comm_delete_form.php
	// 		supprime un commentaire
	
	
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_commentaire.php';
	
	if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['commid']))){
		//on a des valeurs on va les verifier
		if (is_numeric($_GET['commid'])){
			Commentaire::DeleteCommentaire($_GET['commid'])	;		
		}
	}
	$url = 'comm_liste_form.php';
	header("Location: $url");
	exit();
?>
