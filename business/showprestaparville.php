<?php
//	showprestaparville.php
// montre les prestataires

$display = 8;
//combien de page
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$pages = $_GET['p'];
} else {
	$sql = 'SELECT COUNT(prestaID) FROM prg_prestataire WHERE prestaActif = 1 AND villeID = ' . $vid;
	$records = DatabaseHandler::GetOne($sql);
	if ($records > $display) {
		$pages = ceil($records / $display);
	} else {
		$pages = 1;
	}
}
//ou commence t-on
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
//sort par défaut le nom
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'p';

//on determine le sort
switch ($sort) {
	case 'n' :
		$order_by = 'Note DESC';
		break;
	case 'c' :
		$order_by = 'Categorie ASC';
		break;
	default :
		$order_by = 'prestaNom ASC';
		break;
}

//creation de la requete
$sql = 'CALL get_presta_parvilleID(:vID,:order_by,:debut,:display)';
$params = array(':vID' => $vid, ':order_by' => $order_by, ':debut' => $start, ':display' => $display);
$vpresta = array();

$vpresta = DatabaseHandler::GetAll($sql, $params);
if (!empty($vpresta)) {
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><th width="30%"><a href="ville.php?vilid=' . $vid . '&sort=p" class="headville" title="cliquez ici pour classer les établissement par ordre alphabetique">Etablissement</a></th><th width="20%" align="left"><a href="ville.php?vilid=' . $vid . '&sort=c" class="headville" title="cliquez ici pour classer les établissement par ordre alphabetique des catégories">Catégorie</a></th><th width="18%"><a href="ville.php?vilid=' . $vid . '&sort=n" class="headville" title="cliquez ici pour classer les établissement par note décroissante">Note</a></th><th width="32%"></th></tr>';
	echo "\n";
	echo '</table>';
	include INCLUDE_DIR . 'closeboxfront.php';
	for ($v = 0; $v < count($vpresta); $v++) {
		include INCLUDE_DIR . 'openboxfront.php';
		echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr valign="top"><td width="30%"><h3 class="boitetitle">' . $vpresta[$v]['prestaNom'] . '</h3></td><td width="20%">';
		$catN = array();
		$catN = explode(',', $vpresta[$v]['Categorie']);
		$catI = array();
		$catI = explode(',', $vpresta[$v]['CatID']);
		for ($c = 0; $c < count($catN); $c++) {
			echo '<a href="categorie.php?catid=' . $catI[$c] . '&vilid=' . $vid . '" title=cliquez ici pour voir les autres établissements de la ville dans cette catégorie" class="suite">' . $catN[$c] . '</a>&nbsp;';
		}
		echo '</td><td width="18%" align="center">';
		$image = 'images/etoiles/minietoile' . $vpresta[$v]['Note'] . '.jpg';
		if ($vpresta[$v]['Note'] < 1) {
			$ntitle = "Soyez le premier à donner une note à " . $vpresta[$v]['prestaNom'];
		} else {
			$ntitle = 'Note attribuée par les internautes pour ' . $vpresta[$v]['prestaNom'];
		}
		echo '<img src="' . $image . '" border="0" width="70" height="15" alt="' . $ntitle . '" title="' . $ntitle . '" /></td><td width="32%" align="center" rowspan="2">';
		if (!is_null($vpresta[$v]['prestaImage'])) {
			$imagep = 'images/prestataire/' . $vpresta[$v]['prestaImage'];
			$size = getimagesize($imagep);
			echo '<a href="prestataire.php?prestaid=' . $vpresta[$v]['prestaID'] . '"><img src="' . $imagep . '" width ="' . $size[0] . '" heigth="' . $size[1] . '" class="miniimg"  title="Cliquez ici avoir plus de détails sur ' . $vpresta[$v]['prestaNom'] . '" alt="Cliquez ici avoir plus de détails sur  ' . $vpresta[$v]['prestaNom'] . '" /></a>';
		}
		echo '</td></tr>';
		echo "\n";
		echo '<tr valign="top"><td colspan="3"><p>' . $vpresta[$v]['prestaDescription'] . '</p></td></tr>';
		echo "\n";

		echo '<tr valign="top"><td colspan="4" align="right"><a href="prestataire.php?prestaid=' . $vpresta[$v]['prestaID'] . '" title="Cliquez ici avoir plus de détails sur ' . $vpresta[$v]['prestaNom'] . '" class="fbutton">+ de détails</a></td></tr>';
		echo '</table>';
		include INCLUDE_DIR . 'closeboxfront.php';
	}
	//on affiche les links
	if ($pages > 1) {
		include INCLUDE_DIR . 'openboxfront.php';
		echo '<p>';
		$current_page = ($start / $display) + 1;
		if ($current_page != 1) {
			echo '<a href="ville.php?vilid=' . $vid . '&s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '" title="Cliquez ici pour aller à la page précédente" class="headville">Préc.</a>&nbsp;&nbsp;';
		}
		//numéro de pages
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="ville.php?vilid=' . $vid . '&s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '" title="Cliquez ici pour aller à la page ' . $i . '" class="headville">'.$i.'</a>&nbsp;';
			} else {
				echo $i . '&nbsp;';
			}
		}
		//not the last page
		if ($current_page != $pages) {
			echo '<a href="ville.php?vilid=' . $vid . '&s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '" title="Cliquez ici pour aller à la page suivante" class="headville">&nbsp;Suiv.</a>&nbsp;';
		}
		echo '</p>';
		include INCLUDE_DIR . 'closeboxfront.php';
	}
}
