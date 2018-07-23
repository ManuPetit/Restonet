<?php
	//fichier pour faire test sur database
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_tva.php';
	
	$tva = new Tva();
	$reps=$tva->SetTvaTaux('8.2 5');
	if (is_null($reps)){
	echo '<br />12 => ' . $tva->GetTvaNom().' - - - taux-> '.$tva->GetTvaTaux();
	$id = $tva->AddTva();
	echo ' id = ' . $tva->GetTvaID();
	}else{
		echo $reps;
	}	
	?>