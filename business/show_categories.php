<?php
//		show_categories.php
//		fais voir les catégories de restaurant dans une ville
$categ = Shop::GetCategorieParVilleID($vid);
if (!empty($categ)) {
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<h3 class="boitetitleleft">Catégories de restaurants<br />à '. $ville['villeNom'].'</h3>';
	for ($c = 0; $c < count($categ); $c++) {
		if ($categ[$c]['Counter'] == 1) {
			$mes = 'Découvrez notre partenaire dans la catégorie ' . $categ[$c]['categorieNom'] . ' à ' . $ville['villeNom'];
		} else {
			$mes = 'Découvrez nos ' . $categ[$c]['Counter'] . ' partenaires dans la catégorie ' . $categ[$c]['categorieNom'] . ' à ' . $ville['villeNom'];
		}
		echo '<a href="categorie.php?catid=' . $categ[$c]['categorieID'] . '&vilid=' . $vid . '" title="' . $mes . '" class="suite">' . $categ[$c]['categorieNom'] . ' (' . $categ[$c]['Counter'] . ')</a>';
		echo '<br />';
	}
	echo '<br />';
	include INCLUDE_DIR . 'closeboxfront.php';
}
