<?php
//		show_ville.php
//		affiche les villes d'un department et le nombre de restaurant
$villes = array();
$villes = Shop::GetVilleNbrePrestaParDeptID($did);
if (!empty($villes)) {
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<h3 class="boitetitleleft">' . $dept['deptNom'] . ' :<br />villes de nos prestataires</h3>';
	for ($v = 0; $v < count($villes); $v++) {
		if ($villes[$v]['Counter'] == 1) {
			$sent = 'Découvrez le partenaire de RESTOnet à ' . $villes[$v]['villeNom'];
		} else {
			$sent = 'Découvrez les ' . $villes[$v]['Counter'] . ' partenaires de RESTOnet à ' . $villes[$v]['villeNom'];
		}
		echo '<a href="ville.php?vilid=' . $villes[$v]['villeID'] . '" title="' . $sent . '" class="suite">' . $villes[$v]['villeNom'] . ' (' . $villes[$v]['Counter'] . ')</a>';
		echo '<br />';
	}
	echo '<br />';
	include INCLUDE_DIR . 'closeboxfront.php';
}
