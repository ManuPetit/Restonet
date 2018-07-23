<?php
//		presta_livre.php
//		fichier permettant de retrouver les les livraisons d'un presta
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
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
$sql = "SELECT COUNT(DISTINCT comID) AS count FROM view_allcommandes WHERE etatID = 4 AND prestaID = " . $_SESSION['prestaid'];
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

$sql1 = "call get_allComLivr_prestaID(:sixd,:sord,:debut,:fin,:pID)";
$params = array(':sixd' => $sidx, ':sord' => $sord, ':debut' => $start, ':fin' => $limit, ':pID' => $_SESSION['prestaid']);
$res = array();
$res = DatabaseHandler::GetAll($sql1, $params);
//creation du fichier json pour envoyer le data
$responce -> page = $page;
$responce -> total = $total_pages;
$responce -> records = $count;
for ($i = 0; $i < count($res); $i++) {
	$date = FormatDateSlash($res[$i]['comDateLivre']);
	$comde = $res[$i]['comNumero'];
	$client = '<a href="#" onclick="window.open(\'cltdet.php?clt=' . $res[$i]['clientID'] . '\',\'comm\',\'top=100,left=100,width=400,height=250,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir les détails de ce client.">' . $res[$i]['nomClient'] . '</a>';
	$detail = '<a href="#" onclick="window.open(\'cdedet.php?cmd=' . $res[$i]['comID'] . '\',\'comm\',\'top=100,left=100,width=630,height=400,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir les détails de cette commande.">Détails commande</a>';

	$responce -> rows[$i]['cell'] = array($date, $comde, $client, $detail);
}
echo json_encode($responce);
?>