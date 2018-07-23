<?php
	//		prestatab1check.php
	//		verification du premier tab
	
	//enseigne
	$flag=FALSE;
	$resp = $npresta->SetPrestaNomCommercial($_POST['enseigne']);
	if(!is_null($resp)){
		$errors['enseigne']=$resp;
		$flag=TRUE;
	}
	//firstname
	$resp=$npresta->SetPrestaPrenom($_POST['firstname']);
	if(!is_null($resp)){
		$errors['firstname']=$resp;
		$flag=TRUE;
	}
	//lastname
	$resp=$npresta->SetPrestaNom($_POST['lastname']);
	if(!is_null($resp)){
		$errors['lastname']=$resp;
		$flag=TRUE;
	}
	//username
	$resp=$npresta->setPrestaPseudo($_POST['username']);
	if (!is_null($resp)){
		$errors['username']=$resp;
		$flag=TRUE;
	}
	//email
	$resp=$npresta->SetPrestaEmail($_POST['email']);
	if(!is_null($resp)){
		$errors['email']=$resp;
		$flag=TRUE;
	}
	//adresse1
	$resp=$npresta->SetPrestaAdresse1($_POST['adresse1']);
	if(!is_null($resp)){
		$errors['adresse1']=$resp;
		$flag=TRUE;
	}
	//adresse2
	$resp=$npresta->SetPrestaAdresse2($_POST['adresse2']);
	if(!is_null($resp)){
		$errors['adresse2']=$resp;
		$flag=TRUE;
	}
	//villeid
	$resp=$npresta->SetPrestaVilleID($_POST['ville_id']);
	if(!is_null($resp)){
		$errors['cpville']=$resp;
		$flag=TRUE;
	}
	//telephone
	$resp=$npresta->SetPrestaTelephone($_POST['telephone']);
	if(!is_null($resp)){
		$errors['telephone']=$resp;
		$flag=TRUE;
	}
	if ($flag==TRUE){
		$errmain[]='Identification';
	}
?>