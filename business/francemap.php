<?php
include INCLUDE_DIR . 'openboxfront.php';
//retrouver l'image map
$rows = array();
$sql = 'CALL count_presta_region()';
$rows = DatabaseHandler::GetAll($sql);
if (empty($rows)) {
	echo '<h3 class="boitetitleleft">Nos prestataires en régions</h3>
<p align="center">
<img src="images/maps/pays_01.jpg" width="170" height="182" border="0" title ="Carte des prestataires de RESTOnet" alt="Carte des prestataires de RESTOnet" /></p>';
} else {
	echo '<h3 class="boitetitleleft">Nos prestataires en régions</h3>
<p align="center">
<img src="images/maps/pays_01.jpg" width="170" height="182" border="0" title ="Carte des prestataires de RESTOnet" alt="Carte des prestataires de RESTOnet" usemap="#pays" /></p>';
	echo '<map name="pays">';
	for ($i = 0; $i < count($rows); $i++) {
		if ($rows[$i]['nombre'] > 1) {
			$sent = 'Cliquez ici pour découvrir les ' . $rows[$i]['nombre'] . ' prestataires dans la région ' . $rows[$i]['regionNom'];
		} else {
			$sent = 'Cliquez ici pour découvrir le  prestataire de la région ' . $rows[$i]['regionNom'];
		}
		echo '<area shape="poly" coords="' . $rows[$i]['regionPolyCarte'] . '" href="region.php?regid=' . $rows[$i]['regionID'] . '" title="' . $sent . '" />';
	}
	echo '</map>';
	echo '<p align="center"><small>Cliquez sur une region pour voir nos prestataires ou allez à la page <a href="prestataire.php" title="Cliquez ici pour faire une recherche détaillée sur les prestataires de RESTOnet" class="suite">prestataire</a> du site pour une recherche détaillée.</small></p>';
}
include INCLUDE_DIR . 'closeboxfront.php';
?>
