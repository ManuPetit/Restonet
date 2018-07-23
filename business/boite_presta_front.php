<?php
//creation de boite pour prestataire
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (is_numeric($prestaid))) {
	$presta = new Prestataire();
	$presta -> GetPrestaParID($prestaid);
	if (!is_null($presta -> GetPrestaNomCommercial())) {
		//on a un prestataire on  peut afficher ses détails
		$cat = array();
		$cat = $presta -> GetCategorieNom();
		$counter = 2;
		if (count($cat) <= 2) {
			$counter = count($cat);
		}
		$link = '';
		for ($c = 0; $c < $counter; $c++) {
			//pour les regions
			$posreg = strrpos(basename($_SERVER['REQUEST_URI']), 'regid');
			$posdept = strrpos(basename($_SERVER['REQUEST_URI']), 'depid');
			$posvil = strrpos(basename($_SERVER['REQUEST_URI']), 'vilid');
			$clink = 'categorie.php?catid=' . $cat[$c]['categorieID'];
			$ctext = 'Autres établissements dans la catégorie ' . $cat[$c]['categorieNom'] . ' à découvrir';
			if ($posreg !== FALSE) {
				//region
				$pos = $posreg + 6;
				$len = strlen(basename($_SERVER['REQUEST_URI']));
				$end = $len - $pos + 1;
				$rid = substr(basename($_SERVER['REQUEST_URI']), $pos, $end);
				$clink = 'categorie.php?catid=' . $cat[$c]['categorieID'] . '&regid=' . $rid;
				$ctext = 'Autres établissements dans la catégorie ' . $cat[$c]['categorieNom'] . ' à découvrir dans cette région';
			}
			if ($posdept !== FALSE) {
				//département
				$pos = $posdept + 6;
				$len = strlen(basename($_SERVER['REQUEST_URI']));
				$end = $len - $pos + 1;
				$rid = substr(basename($_SERVER['REQUEST_URI']), $pos, $end);
				$clink = 'categorie.php?catid=' . $cat[$c]['categorieID'] . '&depid=' . $rid;
				$ctext = 'Autres établissements dans la catégorie ' . $cat[$c]['categorieNom'] . ' à découvrir dans ce département';
			}
			if ($posvil !== FALSE) {
				//ville
				$pos = $posdept + 6;
				$len = strlen(basename($_SERVER['REQUEST_URI']));
				$end = $len - $pos + 1;
				$rid = substr(basename($_SERVER['REQUEST_URI']), $pos, $end);
				$clink = 'categorie.php?catid=' . $cat[$c]['categorieID'] . '&vilid=' . $rid;
				$ctext = 'Autres établissements dans la catégorie ' . $cat[$c]['categorieNom'] . ' à découvrir dans cette ville';
			}
			$link .= '<a href="' . $clink . '" title="' . $ctext . '" class="suite"">' . $cat[$c]['categorieNom'] . '</a>&nbsp;&nbsp;&nbsp;';
		}
		if (!is_null($presta -> GetPrestaImage())) {
			$image = 'images/prestataire/' . $presta -> GetPrestaImage();
			$size = getimagesize($image);
			$s1 = intval($size[0] * 0.6);
			$s2 = intval($size[1] * 0.6);
			echo '<a href="prestataire.php?prestaid=' . $presta -> GetPrestaID() . '"><img src="' . $image . '" width ="' . $s1 . '" heigth="' . $s2 . '" class="miniimg"  title="Cliquez ici avoir plus de détails sur ' . $presta -> GetPrestaNomCommercial() . '" alt="Cliquez ici avoir plus de détails sur  ' . $presta -> GetPrestaNomCommercial() . '" /></a>';
		}
		echo $link;
		echo "\n";
		echo '<h3 class="boitetitle">' . $presta -> GetPrestaNomCommercial() . '</h3>';
		$vote = $presta -> GetPrestaNoteMoyenne();
		$image = 'images/etoiles/minietoile' . $vote . '.jpg';
		if ($vote == 0) {
			$mesvote = 'Soyez le premier à donner une note  sur ' . $presta -> GetPrestaNomCommercial();
		} else {
			$mesvote = 'Note attribuée par les internautes pour ' . $presta -> GetPrestaNomCommercial();
		}
		echo '<img src="' . $image . '" border="0" width="70" height="15" alt="' . $mesvote . '" title="' . $mesvote . '" />';
		echo '<p><small>Situé à </small><a href="ville.php?vilid=' . $presta -> GetPrestaVilleID() . '" title="Cliquez ici pour découvrir les autres prestataires de RESTOnet sur ' . $presta -> GetPrestaVille() . '" class="suite">' . $presta -> GetPrestaVilleCP() . '</a></p>';
		echo "\n";
		if (strlen($presta -> GetPrestaDescription()) > 150) {
			echo '<p>' . substr($presta -> GetPrestaDescription(), 0, 150) . '... <a href="prestataire.php?prestaid=' . $presta -> GetPrestaID() . '" title="Cliquez ici avoir plus de détails sur ' . $presta -> GetPrestaNomCommercial() . '" class="suite">(suite)</a></p>';
		} else {

			echo '<p>' . $presta -> GetPrestaDescription() . '</p>';
		}
		echo "\n";
		FormatLivraisonBoitePrestaFront($presta);
		echo '<div align="right">';
		echo "\n";
		FormatJourOuverturePrestaFront($presta);
		echo '<br /><a href="prestataire.php?prestaid=' . $presta -> GetPrestaID() . '" title="Cliquez ici avoir plus de détails sur ' . $presta -> GetPrestaNomCommercial() . '" class="fbutton">+ de détails</a>';
		echo '</div>';
	}
}
