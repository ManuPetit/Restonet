<?php
	//			finalcmd.php
	//	page de finalisation de la commande
	
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';

	//vérifier que l'utilisateur est loggé
	if (isset($_SESSION['userid']) && (isset($_SESSION['clientid']))){
		//on a un client pas la peine de demander conexion ou inscription
		//redirection sur la page de finalisation
		$url = 'reccmd.php';
		header("Location: $url");
		exit();
	}else{
		//donner le nom de la page sur laquelle aller après inscription
		$_SESSION['lastpage'] = 'reccmd.php';
		//redirection page conexion inscription
		$url = 'connect.php';
		header("Location: $url");
		exit();
	}
