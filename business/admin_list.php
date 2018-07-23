<?php
	//		admin_list.php
	
	//		retrouve les entrées des administrateurs
	
	require_once '../configs/configs.php';
	require_once 'cls_database_handler.php';
	
	// Get the requested page. By default grid sets this to 1. 
	$page = $_POST['page']; 
	 
	// get how many rows we want to have into the grid - rowNum parameter in the grid 
	$limit = $_POST['rows']; 
	 
	// get index row - i.e. user click to sort. At first time sortname parameter -
	// after that the index from colModel 
	$sidx = $_POST['sidx']; 
	 
	// sorting order - at first time sortorder 
	$sord = $_POST['sord']; 
	 
	// if we not pass at first time index use the first column for the index or what you want
	if(!$sidx) $sidx =1; 
	
	//calcul le nombre de row
	$sql="SELECT COUNT(*) AS count FROM prg_administrateur";
	$count = DatabaseHandler::GetOne($sql);
	
	// calculate the total pages for the query 
	if( $count > 0 && $limit > 0) { 
				  $total_pages = ceil($count/$limit); 
	} else { 
				  $total_pages = 0; 
	} 
	 
	// if for some reasons the requested page is greater than the total 
	// set the requested page to total page 
	if ($page > $total_pages) $page=$total_pages;
	 
	// calculate the starting position of the rows 
	$start = $limit*$page - $limit;
	 
	// if for some reasons start position is negative set it to 0 
	// typical case is that the user type 0 for the requested page 
	if($start <0) $start = 0; 
	
	$sql1 =  "call get_all_admin_liste(:sixd,:sord,:debut,:fin)";
	$params = array(':sixd' => $sidx,
				':sord' => $sord,
				':debut' => $start,
				':fin' => $limit);
	$res=array();
	$res = DatabaseHandler::GetAll($sql1,$params);
	//creation du fichier json pour envoyer le data
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	for ($i=0; $i<count($res); $i++)
	{
		$responce->rows[$i]['id'] = $res[$i]['adminID'];
		if ($res[$i]['adminActif'] == 1) {
			$actif="Oui";
		}else{
			$actif="Non";
		}
		if ($res[$i]['isSuperAdmin'] == 1) {
			$super = "Oui";
		}else{
			$super = "Non";
		}
		if ($res[$i]['userLastLogin'] == '0000-00-00 00:00:00') {
			$date = "Aucun";
		}else{
			$date = date("d/m/Y",strtotime($res[$i]['userLastLogin']));		
		}
		$edit = '<a href="admin_modif_form.php?adminid=' . $res[$i]['adminID'] . '" title="Cliquez ici pour modifier les détails de ' . $res[$i]['nom'] . '">Modif.</a>';
		//on ne peut pas supprimer l'admin qui est est loggé
		if ($responce->rows[$i]['id'] == $_SESSION['adminid'])
		{
			$delete = ' ';
		}else{
			$delete = '<a href="#" title="Cliquez ici pour supprimer ' . $res[$i]['nom'] . ' de la base de données" onclick="AlertSup(' . $res[$i]['adminID'] .')">Suppr.</a>';
		}
		$responce->rows[$i]['cell']=array($res[$i]['adminID'],$res[$i]['nom'],$res[$i]['userEmail'],$res[$i]['ville'],$actif,$super,$date,$edit,$delete);
	}
	echo json_encode($responce);
?>