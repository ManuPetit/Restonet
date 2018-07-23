<?php
//		prestatab34check.php
//		verification tab 3 et 4
//check catégorie
$flag = FALSE;
if (!isset($_POST['categories'])) {
	$errors['categories'] = "Vous devez choisir au moins une catégorie";
	$flag = TRUE;
} else {
	$resp = $npresta -> SetPrestaCategories($_POST['categories']);
	$flagpresta=TRUE;
	if (!is_null($resp)) {
		$errors['categories'] = $resp;
		$flag = TRUE;
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
	$resp = $npresta -> SetPrestaTypeLivraison($_POST['livraisons']);
	$flagpresta=TRUE;
	if (!is_null($resp)) {
		$errors['livraisons'] = $resp;
		$flag = TRUE;
	}
}
//flag pour vérifier qu'une ville a été ajoutée
$flaglivraison=FALSE;
//verifier les villes
for ($i = 1; $i < 11; $i++) {
	$tas = 'cpville' . $i;
	if (isset($_POST[$tas]) && (trim($_POST[$tas] != ''))) {
		$tasa = 'cp' . $i;
		if (isset($_POST[$tasa])) {
			$resp = $npresta -> SetPrestaVilleLivraison($_POST[$tasa]);
			$flagpresta=TRUE;
			$flaglivraison=TRUE;
			if (!is_null($resp)) {
				$errors[$tas] = $resp;
				$flag = TRUE;
			}
		}
	}
}
//verifier qu'il y a au moins un ville si on fait des livraison
if (($flaglivraison==FALSE) && ($npresta->PrestataireEstLivreur()== TRUE)){
	$errors['cpville1']='Vous devez choisir au moins une ville de livraison';
	$flag = TRUE;
}
if ($flag == TRUE) {
	$errmain[] = 'Livraison';
}
?>