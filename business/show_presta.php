<?php
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';

//on cherche quel type de prestataire on veut
if ($typepresta == 'accueil') {
	$miseval = "WHERE prestaActif=1 AND miseValeurID = 2 OR miseValeurID = 5 ORDER BY RAND() LIMIT 6";
}else if ($typepresta == 'region') {
	$miseval = "INNER JOIN sys_ville ON sys_ville.villeID = prg_prestataire.villeID ";
	$miseval .= "INNER JOIN sys_departement ON sys_departement.deptID = sys_ville.deptID ";
	$miseval .= "INNER JOIN sys_region ON sys_region.regionID = sys_departement.regionID ";
	$miseval .= "WHERE prestaActif=1 AND sys_region.regionID = $rid AND miseValeurID = 3 OR miseValeurID = 5 ORDER BY RAND() LIMIT 6";
}
if ($typepresta == 'dept') {
	$miseval = "INNER JOIN sys_ville ON sys_ville.villeID = prg_prestataire.villeID ";
	$miseval .= "INNER JOIN sys_departement ON sys_departement.deptID = sys_ville.deptID ";
	$miseval .= "WHERE prestaActif=1 AND sys_departement.deptID = $did AND miseValeurID = 4 OR miseValeurID = 5 ORDER BY RAND() LIMIT 6";
}
$sql = 'SELECT DISTINCT(prestaID) FROM prg_prestataire ' . $miseval;
$rows = array();
$rows = DatabaseHandler::GetAll($sql);
if ((empty($rows) || (count($rows) < 7)) && ($typepresta == 'accueil')) {
	$limit = 6 - count($rows);
	$sql = 'SELECT DISTINCT(prestaID) FROM prg_prestataire WHERE prestaActif=1 AND miseValeurID = 1 ORDER BY RAND() LIMIT ' . $limit;
	if (empty($rows)) {
		$rows = DatabaseHandler::GetAll($sql);
	} else {
		$inrows = array();
		$inrows = DatabaseHandler::GetAll($sql);
		for ($t = 0; $t < count($inrows); $t++) {
			$rows[] = $inrows[$t];
		}
	}
}
if ((empty($rows) || (count($rows) < 7)) && ($typepresta == 'region')) {
	$limit = 6 - count($rows);
	$sql = 'SELECT DISTINCT(prestaID) FROM prg_prestataire INNER JOIN sys_ville ON sys_ville.villeID = prg_prestataire.villeID ';
	$sql .= 'INNER JOIN sys_departement ON sys_departement.deptID = sys_ville.deptID INNER JOIN sys_region ON sys_region.regionID = sys_departement.regionID ';
	$sql .= ' WHERE prestaActif=1 AND sys_region.regionID = ' . $rid . ' AND miseValeurID = 1 ORDER BY RAND() LIMIT ' . $limit;
	if (empty($rows)) {
		$rows = DatabaseHandler::GetAll($sql);
	} else {
		$inrows = array();
		$inrows = DatabaseHandler::GetAll($sql);
		for ($t = 0; $t < count($inrows); $t++) {
			$rows[] = $inrows[$t];
		}
	}
}
if ((empty($rows) || (count($rows) < 7)) && ($typepresta == 'dept')) {
	$limit = 6 - count($rows);
	$sql = 'SELECT DISTINCT(prestaID) FROM prg_prestataire INNER JOIN sys_ville ON sys_ville.villeID = prg_prestataire.villeID ';
	$sql .= 'INNER JOIN sys_departement ON sys_departement.deptID = sys_ville.deptID ';
	$sql .= ' WHERE prestaActif=1 AND sys_departement.deptID = ' . $did . ' AND miseValeurID = 1 ORDER BY RAND() LIMIT ' . $limit;
	if (empty($rows)) {
		$rows = DatabaseHandler::GetAll($sql);
	} else {
		$inrows = array();
		$inrows = DatabaseHandler::GetAll($sql);
		for ($t = 0; $t < count($inrows); $t++) {
			$rows[] = $inrows[$t];
		}
	}
}
if (!empty($rows)) {
	if ($typepresta == 'accueil') {
		echo '<h2>A découvrir...</h2>';
	}
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	for ($i = 0; $i < count($rows); $i += 2) {
		echo '<tr><td class="topleft"></td><td class="topmid"></td><td class="topright"></td><td width="10px"></td>';
		if (($i + 1) < count($rows)) {
			echo '<td class="topleft"></td><td class="topmid"></td><td class="topright"></td></tr>';
		} else {
			echo '<td colspan="3"></td></tr>';
		}
		echo '<tr><td class="midleft"></td><td class="midmid">';
		$prestaid = $rows[$i]['prestaID'];
		include BUSINESS_DIR . 'boite_presta_front.php';
		echo '</td><td class="midright"></td><td width="10px"></td>';
		if (($i + 1) < count($rows)) {
			echo '<td class="midleft"></td><td class="midmid">';
			$prestaid = $rows[$i + 1]['prestaID'];
			include BUSINESS_DIR . 'boite_presta_front.php';
			echo '</td><td class="midright"></td></tr>';
		} else {
			echo '<td colspan="3"></td></tr>';
		}
		echo '<tr><td class="botleft"></td><td class="botmid"></td><td class="botright"></td><td width="10px"></td>';
		if (($i + 1) < count($rows)) {
			echo '<td class="botleft"></td><td class="botmid"></td><td class="botright"></td></tr>';
		} else {
			echo '<td colspan="3"></td></tr>';
		}
		echo '<tr height="10px"><td colspan="7"></td></tr>';
	}
}
echo '</table>';
