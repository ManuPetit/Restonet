<?php
	//		villeparcp.php
	//		permet de retrouver une liste des villes pour autocomplete box avec jquery
	require_once '../configs/configs.php';
	require_once 'cls_database_handler.php';
	
	//valeur envoyé par jquery
	$ac_term= $_GET['term'];
	//creation des arrays
	$return_array = array();
	$ville = array();
	//requete
	$sql = 'CALL get_ville_par_cp(:code_postal)';
	$params = array(':code_postal' => $ac_term);
	$ville = DatabaseHandler::GetAll($sql,$params);
	//creation array retour
	for ($i=0; $i< count($ville); $i++)
	{
		$row_array['id'] = $ville[$i]['villeID'];
		$row_array['value'] = $ville[$i]['ville'];
		array_push($return_array,$row_array);
	}
	//encodage
	echo json_encode($return_array);
?>