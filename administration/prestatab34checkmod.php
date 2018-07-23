<?php
//		prestatab34checkmod.php
//		verification tab 3 et 4
//check catégorie
$flag = FALSE;
if (!isset($_POST['categories'])) {
	$errors['categories'] = "Vous devez choisir au moins une catégorie";
	$flag = TRUE;
} else {
	if (array_diff($_POST['categories'], $mpresta -> GetPrestaCategories())) {
		$resp = $mpresta -> SetPrestaCategories($_POST['categories']);
		if (!is_null($resp)) {
			$errors['categories'] = $resp;
			$flag = TRUE;
		}
	}
}
if ($flag == TRUE) {
	$errmain[] = 'Catégorie';
}
$flag = FALSE;
//verifier les types de livraison
if (!isset($_POST['livraisons'])) {
	$errors['livraisons'] = "Vous devez choisir au moins une catégorie";
	$flag = TRUE;
} else {
	if (array_diff($_POST['livraisons'], $mpresta -> GETPrestaTypeLivraison())) {
		$resp = $mpresta -> SetPrestaTypeLivraison($_POST['livraisons']);
		if (!is_null($resp)) {
			$errors['livraisons'] = $resp;
			$flag = TRUE;
		}
	}
}
//flag pour vérifier qu'une ville a été ajoutée
$flaglivraison = FALSE;
//verifier les villes
for ($i = 1; $i < 11; $i++) {
	$tas = 'cpville' . $i;
	if (isset($_POST[$tas]) && (trim($_POST[$tas] != ''))) {
		$tasa = 'cp' . $i;
		if (isset($_POST[$tasa]) && (!in_array($_POST[$tasa], $mpresta -> GetPrestaVilleLivraison()))) {
			$resp = $mpresta -> SetPrestaVilleLivraison($_POST[$tasa]);
			$flaglivraison = TRUE;
			if (!is_null($resp)) {
				$errors[$tas] = $resp;
				$flag = TRUE;
			}
		}
	}
}
//verifier qu'il y a au moins un ville si on fait des livraison
if (($flaglivraison == FALSE) && ($mpresta -> PrestataireEstLivreur() == TRUE)) {
	$errors['cpville1'] = 'Vous devez choisir au moins une ville de livraison';
	$flag = TRUE;
}
if ($flag == TRUE) {
	$errmain[] = 'Livraison';
}
?>