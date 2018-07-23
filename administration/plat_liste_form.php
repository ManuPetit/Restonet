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
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'cls_plat.php';
//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Liste des Plats";
include INCLUDE_DIR . 'adminhead.php';

//array pour prestataire
$presta = array();
$presta = Plat::GetPrestataireListe();
//pas de prestataire, on ne peut pas continuer
if (empty($presta)) {
	echo '<h2>Liste des Plats</h2>';
	echo '<p>Il n\'y a aucun prestataire dans la base de données et aucun n\'a pu être créé.<br /><br />Entrez d\'abord vos prestataires, puis vos plats.</p>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
if (Plat::HasPlat() == FALSE) {
	echo '<h2>Liste des Plats</h2>';
	echo '<p>Il n\'y a aucun plat dans la base de données.<br /><br />Entrez d\'abord vos plats.</p>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();

}
$display = 15;
if ((isset($_POST['listesub'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	$records = Plat::GetNumberPlat($_POST['presta']);
	if ($records > $display) {
		$pages = ceil($records / $display);
	} else {
		$pages = 1;
	}
	$start = 0;
	if ($_POST['presta'] == 0) {
		$num = 0;
		$order_by = 'prestaNom ASC';
		$sql = "SELECT platID, platNom, prestaNom, platPrix, platActif,typePlatID FROM prg_plat";
		$sql .= " INNER JOIN prg_prestataire ON prg_plat.prestaID=prg_prestataire.prestaID";
		$sql .= " WHERE typePlatID > 0";
		$sql .= " ORDER BY $order_by LIMIT $start, $display";
		echo '<h2>Liste des plat de tous les prestataires</h2>';
		$sort = 'p';
	} else {
		$num = (int)$_POST['presta'];
		$order_by = 'platNom ASC';
		$sql = "SELECT platID, platNom, prestaNom, platPrix, platActif,typePlatID FROM prg_plat";
		$sql .= " INNER JOIN prg_prestataire ON prg_plat.prestaID=prg_prestataire.prestaID";
		$sql .= " WHERE typePlatID > 0 AND prg_plat.prestaID = $num";
		$sql .= " ORDER BY $order_by LIMIT $start, $display";
		echo '<h2>Liste des plats de : ' . Plat::GetPrestaNomParID($num) . '</h2>';
		$sort = 'n';
	}
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr class="malistehead">
	<th width="6%" class="maliste">ID</th>
	<th width="30%" class="maliste" align="left"><a href="plat_liste_form.php?sort=n&i=' . $num . '" title="Cliquez ici pour ordonner la liste par nom de plats">Nom</a></th>
	<th width="24%" class="maliste" align="left"><a href="plat_liste_form.php?sort=p&i=' . $num . '" title="Cliquez ici pour ordonner la liste par nom de prestataires">Prestataire</a></th>
	<th width="6%" class="maliste">Prix</th>
	<th width="8%" class="maliste"><a href="plat_liste_form.php?sort=a&i=' . $num . '" title="Cliquez ici pour ordonner la liste par plat activés">Actif</a></th>
	<th width="10%" class="maliste"><a href="plat_liste_form.php?sort=i&i=' . $num . '" title="Cliquez ici pour ordonner la liste par type de plats">Type</a></th>';
	if ($_SESSION['issuper'] == 1) {
		echo '<th width="8%" class="maliste">Editer</th>
	<th width="8%" class="maliste">Suppr.</th>';
	} else {
		echo '<th width="16%" class="maliste">Editer</th>';
	}
	echo '</tr>';
	$row = array();
	$row = DatabaseHandler::GetAll($sql);
	$bg = '#b1f3ac';
	for ($i = 0; $i < count($row); $i++) {$bg = ($bg == '#b1f3ac' ? '#f3d2ac' : '#b1f3ac');
		echo '<tr bgcolor="' . $bg . '" valign="top">';
		echo '<td class="maliste" align="center">' . $row[$i]['platID'] . '</td>';
		echo '<td class="maliste">' . $row[$i]['platNom'] . '</td>';
		echo '<td class="maliste">' . $row[$i]['prestaNom'] . '</td>';
		echo '<td class="maliste" align="right">' . $row[$i]['platPrix'] . '</td>';
		echo '<td align="center">';
		if ($row[$i]['platActif'] == 0) {
			echo '<a href="plat_active.php?s=' . $start . '&p='. $pages . '&sort=' . $sort . '&i='. $num . '&platid=' . $row[$i]['platID'] . '&a=o" class="maliste" title="Cliquez ici pour activer ce plat">Non</a>';
		} else {
			echo '<a href="plat_active.php?s=' . $start . '&p='. $pages . '&sort=' . $sort . '&i='. $num . '&platid=' . $row[$i]['platID'] . '&a=n" class="maliste" title="Cliquez ici pour désactiver ce plat">Oui</a>';
		}
		echo '</td>';
		if ($row[$i]['typePlatID'] == 4) {
			echo '<td align="center"><a href="#"  onclick="window.open(\'showmenudetail.php?menuid=' . $row[$i]['platID'] . '\',\'menu\',\'top=100,left=100,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir les détails du menu" class="maliste">Menu</a></td>';
		} else if ($row[$i]['typePlatID'] == 1) {
			echo '<td class="maliste" align="center">Entrée</td>';
		}else if ($row[$i]['typePlatID'] == 2) {
			echo '<td class="maliste" align="center">Plat</td>';
		}else if ($row[$i]['typePlatID'] == 3) {
			echo '<td class="maliste" align="center">Dessert</td>';
		}
		echo '<td align="center"><a href="plat_modif_form.php?platid=' . $row[$i]['platID'] . '" title="Cliquez ici pour modifier le plat : ' . $row[$i]['platNom'] . '" class="maliste">Editer</a></td>';
		if ($_SESSION['issuper'] == 1) {
			echo '<td align="center"><a href="plat_delete_form.php?platid=' . $row[$i]['platID'] . '" title="Cliquez ici pour supprimer le plat : ' . $row[$i]['platNom'] . '" class="maliste" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer ce plat ?\')) return true; else return false;">Suppr.</a></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	//faire les liens vers autres pages
	if ($pages > 1) {
		echo '<br /><p>';
		$current_page = ($start / $display) + 1;
		if ($current_page != 1) {
			echo '<a href="plat_liste_form.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '&i=' . $num . '" class="plat">Préc.</a> ';
		}
		//faire les pages
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="plat_liste_form.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&i=' . $num . '" class="plat">' . $i . '</a> ';
			} else {
				echo $i . ' ';
			}
		}
		//suivant
		if ($current_page != $pages) {
			echo '<a href="plat_liste_form.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '&i=' . $num . '" class="plat">Suiv.</a>';
		}
		echo '</p>';
	}

	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['i']))) {
	if ((isset($_GET['p'])) && (is_numeric($_GET['p']))) {
		$pages = $_GET['p'];
	} else {
		if ($_GET['i'] == 0) {
			$records = Plat::GetNumberPlat(0);
		} else {
			$records = Plat::GetNumberPlat($_GET['i']);
		}
		if ($records > $display) {
			$pages = ceil($records / $display);
		} else {
			$pages = 1;
		}
	}
	if ((isset($_GET['s'])) && (is_numeric($_GET['s']))) {
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
	if ((isset($_GET['i'])) && (is_numeric($_GET['i']))) {
		$num = $_GET['i'];
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'n';
	} else {
		$num = 0;
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'p';
	}
	switch ($sort) {
		case 'n' :
			$order_by = 'platNom ASC';
			break;
		case 'a' :
			$order_by = 'platActif ASC';
			break;
		case 'i' :
			$order_by = 'typePlatID ASC';
			break;
		default :
			$order_by = 'prestaNom ASC';
			$sort = 'p';
			break;
	}
	if ($num == 0) {
		$sql = "SELECT platID, platNom, prestaNom, platPrix, platActif,typePlatID FROM prg_plat";
		$sql .= " INNER JOIN prg_prestataire ON prg_plat.prestaID=prg_prestataire.prestaID";
		$sql .= " WHERE typePlatID > 0";
		$sql .= " ORDER BY $order_by LIMIT $start, $display";
		echo '<h2>Liste des plat de tous les prestataires</h2>';
	} else {
		$sql = "SELECT platID, platNom, prestaNom, platPrix, platActif,typePlatID FROM prg_plat";
		$sql .= " INNER JOIN prg_prestataire ON prg_plat.prestaID=prg_prestataire.prestaID";
		$sql .= " WHERE typePlatID > 0 AND prg_plat.prestaID = $num";
		$sql .= " ORDER BY $order_by LIMIT $start, $display";
		echo '<h2>Liste des plats de : ' . Plat::GetPrestaNomParID($num) . '</h2>';
	}
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">
	<tr class="malistehead">
	<th width="6%" class="maliste">ID</th>
	<th width="30%" class="maliste" align="left"><a href="plat_liste_form.php?sort=n&i=' . $num . '" title="Cliquez ici pour ordonner la liste par nom de plats">Nom</a></th>
	<th width="24%" class="maliste" align="left"><a href="plat_liste_form.php?sort=p&i=' . $num . '" title="Cliquez ici pour ordonner la liste par nom de prestataires">Prestataire</a></th>
	<th width="6%" class="maliste">Prix</th>
	<th width="8%" class="maliste"><a href="plat_liste_form.php?sort=a&i=' . $num . '" title="Cliquez ici pour ordonner la liste par plat activés">Actif</a></th>
	<th width="10%" class="maliste"><a href="plat_liste_form.php?sort=i&i=' . $num . '" title="Cliquez ici pour ordonner la liste par type de plat">Type</a></th>';
	if ($_SESSION['issuper'] == 1) {
		echo '<th width="8%" class="maliste">Editer</th>
	<th width="8%" class="maliste">Suppr.</th>';
	} else {
		echo '<th width="16%" class="maliste">Editer</th>';
	}
	echo '</tr>';
	$row = array();
	$row = DatabaseHandler::GetAll($sql);
	$bg = '#b1f3ac';
	for ($i = 0; $i < count($row); $i++) {$bg = ($bg == '#b1f3ac' ? '#f3d2ac' : '#b1f3ac');
		echo '<tr bgcolor="' . $bg . '">';
		echo '<td class="maliste" align="center">' . $row[$i]['platID'] . '</td>';
		echo '<td class="maliste">' . $row[$i]['platNom'] . '</td>';
		echo '<td class="maliste">' . $row[$i]['prestaNom'] . '</td>';
		echo '<td class="maliste" align="right">' . $row[$i]['platPrix'] . '</td>';
		echo '<td align="center">';
		if ($row[$i]['platActif'] == 0) {
			echo '<a href="plat_active.php?s=' . $start . '&p='. $pages . '&sort=' . $sort . '&i='. $num . '&platid=' . $row[$i]['platID'] . '&a=o" class="maliste" title="Cliquez ici pour activer ce plat">Non</a>';
		} else {
			echo '<a href="plat_active.php?s=' . $start . '&p='. $pages . '&sort=' . $sort . '&i='. $num . '&platid=' . $row[$i]['platID'] . '&a=n" class="maliste" title="Cliquez ici pour désactiver ce plat">Oui</a>';
		}
		echo '</td>';
		if ($row[$i]['typePlatID'] == 4) {
			echo '<td align="center"><a href="#"  onclick="window.open(\'showmenudetail.php?menuid=' . $row[$i]['platID'] . '\',\'presse01\',\'top=100,left=100,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir les détails du menu" class="maliste">Menu</a></td>';
		} else if ($row[$i]['typePlatID'] == 1) {
			echo '<td class="maliste" align="center">Entrée</td>';
		}else if ($row[$i]['typePlatID'] == 2) {
			echo '<td class="maliste" align="center">Plat</td>';
		}else if ($row[$i]['typePlatID'] == 3) {
			echo '<td class="maliste" align="center">Dessert</td>';
		}
		echo '<td align="center"><a href="plat_modif_form.php?platid=' . $row[$i]['platID'] . '" title="Cliquez ici pour modifier le plat : ' . $row[$i]['platNom'] . '" class="maliste">Editer</a></td>';
		if ($_SESSION['issuper'] == 1) {
			echo '<td align="center"><a href="plat_delete_form.php?platid=' . $row[$i]['platID'] . '" title="Cliquez ici pour supprimer le plat : ' . $row[$i]['platNom'] . '" class="maliste" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer ce plat ?\')) return true; else return false;">Suppr.</a></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	//faire les liens vers autres pages
	if ($pages > 1) {
		echo '<br /><p>';
		$current_page = ($start / $display) + 1;
		if ($current_page != 1) {
			echo '<a href="plat_liste_form.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '&i=' . $num . '" class="plat">Préc.</a> ';
		}
		//faire les pages
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="plat_liste_form.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&i=' . $num . '" class="plat">' . $i . '</a> ';
			} else {
				echo $i . ' ';
			}
		}
		//suivant
		if ($current_page != $pages) {
			echo '<a href="plat_liste_form.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '&i=' . $num . '" class="plat">Suiv.</a>';
		}
		echo '</p>';
	}

	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
echo '<p>Vous pouvez choisir de voir tous les plats, ou selectionnez un prestataire.</p><fieldset><legend>Faites votre choix</legend>';
echo '<form action="plat_liste_form.php" method="post" accept-charset="utf-8"><select name="presta">
<option value="0">Voir les plats de tous les prestataires</option>';

for ($i = 0; $i < count($presta); $i++) {
	if (Plat::HasPrestaGotPlat($presta[$i]['prestaID']) == TRUE) {
		echo '<option value="' . $presta[$i]['prestaID'] . '">' . $presta[$i]['prestaNom'] . '</option>';
	}
}

echo '<h2>Liste des Plats</h2>';
echo '</select>';
echo '<div align="center"><input type="submit" name="submit" value="Visualiser la liste" />
<input type="hidden" name="listesub" value="TRUE" />
</fieldset>
</form>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
