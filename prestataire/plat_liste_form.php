<?php
//		plat_liste_form.php

//		fichier pour voir la liste de tous les administrateurs

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'cls_plat.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();

$page_title = "Liste des Plats";
include INCLUDE_DIR . 'prestahead.php';

//retrouvez la liste des plats du prestataire
$lesPlats = Plat::GetPlatParPrestaID($_SESSION['prestaid']);
if (empty($lesPlats)) {
	echo "<h2>Liste de plats</h2>
<p>
	Vous n'avez aucun plat dans la base de données. Entrez d'abord vos plats.
</p>";
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'prestafooter.php';
	exit();
}
$display = 15;
//nombre de pages
if ((isset($_GET['p'])) && (is_numeric($_GET['p']))) {
	$pages = $_GET['p'];
} else {
	$records = count($lesPlats);
	if ($records > $display) {
		$pages = ceil($records / $display);
	} else {
		$pages = 1;
	}
}
//debut dans la base de données
if ((isset($_GET['s'])) && (is_numeric($_GET['s']))) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
//sorting order
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'tp';
switch ($sort) {
	case 'tp' :
		$order_by = 'typePlatID ASC';
		break;
	case 'px' :
		$order_by = 'platPrix ASC';
		break;
	case 'pa' :
		$order_by = 'platActif ASC';
		break;
	case 'pn' :
		$order_by = 'platNom';
		break;
	default :
		$order_by = 'platNom';
		break;
}
//requete
$moi = $_SESSION['prestaid'];
$sql = "SELECT platID, platNom, prestaNom, platPrix, platActif,typePlatID FROM prg_plat";
$sql .= " INNER JOIN prg_prestataire ON prg_plat.prestaID=prg_prestataire.prestaID";
$sql .= " WHERE typePlatID > 0 AND prg_plat.prestaID = $moi";
$sql .= " ORDER BY $order_by LIMIT $start, $display";
echo '<h2>Liste des mes plats.</h2>';
echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr class="malistehead">
<th width="50%" class="maliste" align="left"><a href="plat_liste_form.php?sort=pn" title="Cliquez ici pour ordonner la liste par nom de plats">Nom</a></th>
<th width="4%" class="maliste"><a href="plat_liste_form.php?sort=px" title="Cliquez ici pour ordonner par prix croissant">Prix</th>
<th width="8%" class="maliste"><a href="plat_liste_form.php?sort=pa" title="Cliquez ici pour ordonner la liste par plat activés">Actif</a></th>
<th width="16%" class="maliste"><a href="plat_liste_form.php?sort=tp" title="Cliquez ici pour ordonner la liste par type de plat">Type</a></th>
<th width="8%" class="maliste">Editer</th>
<th width="8%" class="maliste">Suppr.</th>
</tr>';
$row = array();
$row = DatabaseHandler::GetAll($sql);
$bg = '#b1f3ac';
for ($i = 0; $i < count($row); $i++) {$bg = ($bg == '#b1f3ac' ? '#f3d2ac' : '#b1f3ac');
	echo '<tr bgcolor="' . $bg . '">';
	echo '<td class="maliste">' . $row[$i]['platNom'] . '</td>';
	echo '<td class="maliste" align="right">' . $row[$i]['platPrix'] . '</td>';
	echo '<td align="center">';
	if ($row[$i]['platActif'] == 0) {
		echo '<a href="plat_active.php?s=' . $start . '&p=' . $pages . '&sort=' . $sort . '&i=' . $_SESSION['prestaid'] . '&platid=' . $row[$i]['platID'] . '&a=o" class="maliste" title="Cliquez ici pour activer ce plat">Non</a>';
	} else {
		echo '<a href="plat_active.php?s=' . $start . '&p=' . $pages . '&sort=' . $sort . '&i=' . $_SESSION['prestaid'] . '&platid=' . $row[$i]['platID'] . '&a=n" class="maliste" title="Cliquez ici pour désactiver ce plat">Oui</a>';
	}
	echo '</td>';
	if ($row[$i]['typePlatID'] == 4) {
		echo '<td align="center"><a href="#"  onclick="window.open(\'showmenudetail.php?menuid=' . $row[$i]['platID'] . '\',\'presse01\',\'top=100,left=100,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir les détails du menu" class="maliste">Menu</a></td>';
	} else if ($row[$i]['typePlatID'] == 1) {
		echo '<td class="maliste" align="center">Entrée</td>';
	} else if ($row[$i]['typePlatID'] == 2) {
		echo '<td class="maliste" align="center">Plat</td>';
	} else if ($row[$i]['typePlatID'] == 3) {
		echo '<td class="maliste" align="center">Dessert</td>';
	}
	echo '<td align="center"><a href="plat_modif_form.php?platid=' . $row[$i]['platID'] . '" title="Cliquez ici pour modifier le plat : ' . $row[$i]['platNom'] . '" class="maliste">Editer</a></td>';

	echo '<td align="center"><a href="plat_delete_form.php?platid=' . $row[$i]['platID'] . '" title="Cliquez ici pour supprimer le plat : ' . $row[$i]['platNom'] . '" class="maliste" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer ce plat ?\')) return true; else return false;">Suppr.</a></td>';

	echo '</tr>';
}
echo '</table>';
//faire les liens vers autres pages
if ($pages > 1) {
	echo '<br /><p>';
	$current_page = ($start / $display) + 1;
	if ($current_page != 1) {
		echo '<a href="plat_liste_form.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '" class="plat">Préc.</a> ';
	}
	//faire les pages
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="plat_liste_form.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '" class="plat">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	//suivant
	if ($current_page != $pages) {
		echo '<a href="plat_liste_form.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '" class="plat">Suiv.</a>';
	}
	echo '</p>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'prestafooter.php';
exit();
