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
if (!$sidx)
	$sidx = 1;

//calcul le nombre de row
$sql = "SELECT COUNT(*) AS count FROM prg_commentaire";
$count = DatabaseHandler::GetOne($sql);

// calculate the total pages for the query
if ($count > 0 && $limit > 0) {
	$total_pages = ceil($count / $limit);
} else {
	$total_pages = 0;
}

// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages)
	$page = $total_pages;

// calculate the starting position of the rows
$start = $limit * $page - $limit;

// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if ($start < 0)
	$start = 0;

$sql1 = "call get_all_comm_liste(:sixd,:sord,:debut,:fin)";
$params = array(':sixd' => $sidx, ':sord' => $sord, ':debut' => $start, ':fin' => $limit);
$res = array();
$res = DatabaseHandler::GetAll($sql1, $params);
//creation du fichier json pour envoyer le data
$responce -> page = $page;
$responce -> total = $total_pages;
$responce -> records = $count;
for ($i = 0; $i < count($res); $i++) {
	$responce -> rows[$i]['id'] = $res[$i]['comteID'];
	if ($res[$i]['comteActif'] == 1) {
		$actif = '<a href="comm_activ.php?commid=' . $res[$i]['comteID'] . '&act=n" title="Cliquez ici pour désactiver ce commentaire sur RESTOnet">Oui.</a>';
	} else {
		$actif = '<a href="comm_activ.php?commid=' . $res[$i]['comteID'] . '&act=o" title="Cliquez ici pour activer ce commentaire sur RESTOnet">Non.</a>';
	}
	$date = date("d/m/Y", strtotime($res[$i]['comteDate']));
	$supp = '<a href="comm_delete_form.php?commid=' . $res[$i]['comteID'] . '" title="Cliquez ici pour supprimer ce commentaire" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer ce commentaire ?\')) return true; else return false;">Suppr.</a>';
	if (strlen($res[$i]['comteDescription']) > 35) {
		$desc = stripslashes(substr($res[$i]['comteDescription'], 0, 35)) . '...&nbsp;&nbsp;(<a href="#"  onclick="window.open(\'showcommentaire.php?commid=' . $res[$i]['comteID'] . '\',\'comm\',\'top=100,left=100,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir le commentaire en entier">Suite</a>)';
	} else {
		$desc = stripslashes($res[$i]['comteDescription']);
	}
	$responce -> rows[$i]['cell'] = array($res[$i]['comteID'], $res[$i]['prestaNom'], $res[$i]['clientNom'], $desc, $date, $actif, $supp);
}
echo json_encode($responce);
?>