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
	$sql="SELECT COUNT(*) AS count FROM prg_prestataire";
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
	
	$sql1 =  "call get_all_presta_liste(:sixd,:sord,:debut,:fin)";
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
		$responce->rows[$i]['id'] = $res[$i]['prestaID'];
		if ($res[$i]['prestaActif'] == 1) {
			$actif='<a href="presta_activ.php?prestaid=' . $res[$i]['prestaID'] . '&act=n" title="Cliquez ici pour désactiver ' . $res[$i]['prestaNom'] . ' sur RESTOnet">Oui.</a>';
		}else{
			$actif='<a href="presta_activ.php?prestaid=' . $res[$i]['prestaID'] . '&act=o" title="Cliquez ici pour activer ' . $res[$i]['prestaNom'] . ' sur RESTOnet">Non.</a>';
		}
		$commis=$res[$i]['commissionTaux'].'%';
		if ($res[$i]['userLastLogin'] == '0000-00-00 00:00:00') {
			$date = "Aucun";
		}else{
			$date = date("d/m/Y",strtotime($res[$i]['userLastLogin']));		
		}
		$edit = '<a href="presta_modif_form.php?prestaid=' . $res[$i]['prestaID'] . '" title="Cliquez ici pour modifier les détails de ' . $res[$i]['prestaNom'] . '">Modif.</a>';
		$delete = '<a href="#" title="Cliquez ici pour supprimer ' . $res[$i]['prestaNom'] . ' de la base de données" onclick="AlertSup(' . $res[$i]['prestaID'] .')">Suppr.</a>';
		$responce->rows[$i]['cell']=array($res[$i]['prestaID'],$res[$i]['prestaNom'],$res[$i]['nom'],$res[$i]['ville'],$actif,$commis,$date,$edit,$delete);
	}
	echo json_encode($responce);
?>