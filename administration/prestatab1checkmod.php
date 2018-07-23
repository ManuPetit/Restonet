<?php
//		prestatab1checkmod.php
//		verification du premier tab

//flag pour mise à jour
$flagpresta = FALSE;
//enseigne
$flag = FALSE;
if ($_POST['enseigne'] != $mpresta -> GetPrestaNomCommercial()) {
	$resp = $mpresta -> SetPrestaNomCommercial($_POST['enseigne']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['enseigne'] = $resp;
		$flag = TRUE;
	}
}
//firstname
if ($_POST['firstname'] != $mpresta -> GetPrestaPrenom()) {
	$resp = $mpresta -> SetPrestaPrenom($_POST['firstname']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['firstname'] = $resp;
		$flag = TRUE;
	}
}
//lastname
if ($_POST['lastname'] != $mpresta -> GetPrestaNom()) {
	$resp = $mpresta -> SetPrestaNom($_POST['lastname']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['lastname'] = $resp;
		$flag = TRUE;
	}

}
//adresse1
if ($_POST['adresse1'] != $mpresta -> GetPrestaAdresse1()) {
	$resp = $mpresta -> SetPrestaAdresse1($_POST['adresse1']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['adresse1'] = $resp;
		$flag = TRUE;
	}

}
//adresse2
if ($_POST['adresse2'] != $mpresta -> GetPrestaAdresse2()) {
	$resp = $mpresta -> SetPrestaAdresse2($_POST['adresse2']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['adresse2'] = $resp;
		$flag = TRUE;
	}

}
//villeid
if ($_POST['ville_id'] != $mpresta -> GetPrestaVilleID()) {
	$resp = $mpresta -> SetPrestaVilleID($_POST['ville_id']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['cpville'] = $resp;
		$flag = TRUE;
	}
}

//telephone
if ($_POST['telephone'] != $mpresta -> GetPrestaTelephone()) {
	$resp = $mpresta -> SetPrestaTelephone($_POST['telephone']);
	$flagpresta = TRUE;
	if (!is_null($resp)) {
		$errors['telephone'] = $resp;
		$flag = TRUE;
	}
}
if ($flag == TRUE) {
	$errmain[] = 'Identification';
}
?>