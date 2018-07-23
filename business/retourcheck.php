<?php
//retourcheck.php
//lors du retour du paiement permet de verifier si user est toujours connecter
//procedure de validation
//on retrouve les détails de la requête
if (isset($_GET['ref'])){
	$cmdNumber=$_GET['ref'];
}
//ajouter les fichiers d'utilités
if ((!isset($_SESSION['userid'])) || (!isset($_SESSION['uniid'])) || (!isset($_SESSION['clientid']))){
	//on retrouve le fichier
	$log = SITE_ROOT . '/detlog/'. $cmdNumber. '.log';
	$fh=fopen($log,'r');
	$details=array();
	while (!feof($fh)){
		$details[]=fgets($fh,256);
	}
	fclose($fh);
	$_SESSION['uniid']=$details[0];
	$_SESSION['userid']=$details[1];
	$_SESSION['clientid']=$details[2];
}
