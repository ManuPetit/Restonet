<?php
	//		presta_activ.php
	// 		active ou désactive un prestataire
	
	
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_prestataire.php';
	
	if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['prestaid'])) && (isset($_GET['act']))){
		//on a des valeurs on va les verifier
		if (is_numeric($_GET['prestaid'])){
			if ($_GET['act']=='o'){
				Prestataire::SetPrestaEstActif($_GET['prestaid']);
			}elseif ($_GET['act']== 'n'){
				Prestataire::SetPrestaEstNonActif($_GET['prestaid']);
			}			
		}
	}
	$url = 'presta_liste_form.php';
	header("Location: $url");
	exit();
?>
