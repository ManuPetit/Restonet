<?php
// map de la region
include INCLUDE_DIR . 'openboxfront.php';
echo '<h3 class="boitetitleleft">' . $region['regionNom'] . ' : nos prestataires</h3>
<p align="center">';
if (!empty($depts)) {
	echo '<img src="' . $map . '" width="170" height="182" border="0" title ="Carte des prestataires de RESTOnet de la région" alt="Carte des prestataires de RESTOnet de la région" usemap="#region" /></p>';
	echo '<map name="region">';
	for ($i = 0; $i < count($depts); $i++) {
		$sent = 'Cliquez ici pour découvrir nos prestataires dans le département ' . $depts[$i]['deptNom'];

		echo '<area shape="poly" coords="' . $depts[$i]['deptPolyCarte'] . '" href="departement.php?depid=' . $depts[$i]['deptID'] . '" title="' . $sent . '" />';
	}
	echo '</map>';
} else {
	echo '<img src="' . $map . '" width="170" height="182" border="0" title ="Carte des prestataires de RESTOnet de la région" alt="Carte des prestataires de RESTOnet de la région" /></p>';
}
echo '<p align="center"><small>Cliquez sur un département pour voir nos prestataires ou allez à la page <a href="prestataire.php" title="Cliquez ici pour faire une recherche détaillée sur les prestataires de RESTOnet" class="suite">prestataire</a> du site pour une recherche détaillée.</small></p>';
include INCLUDE_DIR . 'closeboxfront.php';
?>