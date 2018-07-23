<?php
echo '
<!-- COLONNE GAUCHE  -->
<div id="left">';
//afficher le panier
include BUSINESS_DIR . 'show_cart.php';

//affiche la carte france
include BUSINESS_DIR . 'show_categories.php';

echo '</div>
<!-- CONTENU  -->
<div id="right">';
//verification de prestataire
if (isset($_SESSION['curprestid'])) {
	if ($_SESSION['curprestid'] != $presta -> GetPrestaID()) {
		$CanChoose = FALSE;
	} else {
		$CanChoose = TRUE;
	}
} else {
	$CanChoose = TRUE;
}
//creation du breadcrumb
BreadCrumbPresta($presta);
//presentation
$vote = $presta -> GetPrestaNoteMoyenne();
$image = 'images/etoiles/etoile' . $vote . '.jpg';
if ($vote < 1) {
	$ilink = "Soyez le premier à attribuer un note à " . $presta -> GetPrestaNomCommercial();
} else {
	$ilink = 'Note attribuée par les clients de ' . $presta -> GetPrestaNomCommercial();
}
echo '<h1 class="resto">' . $presta -> GetPrestaNomCommercial() . '&nbsp;&nbsp;&nbsp;<img src="' . $image . '" border="0" width="100" height="21" title="' . $ilink . '" /></h1>';
//presentation de l'établissement
include INCLUDE_DIR . 'openboxfront.php';

//image
if (!is_null($presta -> GetPrestaImage())) {
	$image = 'images/prestataire/' . $presta -> GetPrestaImage();
	$size = getimagesize($image);
	echo '<img src="' . $image . '" width ="' . $size[0] . '" heigth="' . $size[1] . '" class="miniimg"  title="Photo de l\'etablissement ' . $presta -> GetPrestaNomCommercial() . '" alt="Photo de l\'etablissement  ' . $presta -> GetPrestaNomCommercial() . '" />';
}//categorie
$link = '<p class="textdesc">Type de cuisines proposées : ';
for ($c = 0; $c < count($cat); $c++) {
	$link .= '<a href="categorie.php?catid=' . $cat[$c]['categorieID'] . '&vilid=' . $presta -> GetPrestaVilleID() . '" title="Autres établissements dans la catégorie ' . $cat[$c]['categorieNom'] . ' à découvrir" class="suite">' . $cat[$c]['categorieNom'] . '</a>&nbsp;&nbsp;&nbsp;';
}
echo $link . '</p>';
//description
echo '<p class="textdesc">' . $presta -> GetPrestaDescription() . '</p>';
//type de livraison
echo $tlivr;
//coordonnées
echo '<table width="580px" border="0" cellpadding="2px" cellspacing="2px">
<tr valign="top"><td width="80px" class="textdesc"><b>Addresse</b></td>
<td width="220px" class="textdesc">' . $presta -> GetPrestaNomCommercial();
echo '<br />' . $presta -> GetPrestaAdresse1();
if (!is_null($presta -> GetPrestaAdresse2())) {
	echo '<br />';
	$presta -> GetPrestaAdresse2();
}
echo '<br />' . $presta -> GetPrestaCodePostal() . '&nbsp;' . $presta -> GetPrestaVille();
echo '</td><td rowspan="2" align="center">';
FormatJourOuverturePrestaFrontAvecHeure($presta);
echo '</td></tr>
<tr valign="top"><td class="textdesc"><b>Téléphone</b></td><td class="textdesc">' . FormatTelephone($presta -> GetPrestaTelephone()) . '</td></tr>
</table>';
//affichage sur les villes de livraison
if ($presta -> PrestataireEstLivreur() == TRUE) {
	$vil = '<p class="textdesc"><b>Livraison sur les villes suivantes :</b>';
	$vrow = $presta -> GetVilleLivraisonListe();
	for ($i = 0; $i < count($vrow); $i++) {
		$vil .= ' ' . $vrow[$i] . ',';
	}
	$vil = rtrim($vil, ',') . '.';
	echo $vil;
}
//commentaires
if ($presta -> GetNbreCommentaireActif() > 0) {
	echo '<p class="textdesc">Découvrez ce que d\'autres internautes pensent de ' . $presta -> GetPrestaNomCommercial() . ' : <a href="#" onclick="window.open(\'voircomment.php?prestaid=' . $presta -> GetPrestaID() . '\',\'comm\',\'top=100,left=100,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="cliquez ici pour afficher les commentaires dans une nouvelle fenêtre" class="suite">voir les commentaires</a>';
}
include INCLUDE_DIR . 'closeboxfront.php';
//affichage des plats par tab
echo '<h2>Les plats proposés par ' . $presta -> GetPrestaNomCommercial() . '</h2>';
include INCLUDE_DIR . 'openboxfront.php';
echo '<div id="tabs" style="overflow:hidden;">
	<ul>';
echo "\n";
//création des tabs
$tplat = array();
$tplat = Shop::GetTypePlat($presta -> GetPrestaID());
for ($i = 0; $i < count($tplat); $i++) {
	$var = $i + 1;
	echo '<li><a href="#tabs-' . $var . '">' . $tplat[$i]['typePlatNom'] . '</a></li>';
	echo "\n";
}
echo '</ul>';
echo "\n";
//creation du contenu des tabs
for ($i = 0; $i < count($tplat); $i++) {
	$var = $i + 1;
	echo '<div id="tabs-' . $var . '">';
	$aplat = array();
	$aplat = Shop::GetPlatParType($presta -> GetPrestaID(), $tplat[$i]['typePlatID']);
	if (!empty($aplat)) {
		//on a un numéro de commande donc la commande doit être finalisée
		if (isset($_SESSION['cmdid'])) {
			echo '<div align="center" style="color:red;font-weight:bold;">Vous avez une commande en cours.<br />Veuillez finaliser cette commande ou l\'annuler avant de faire une nouvelle commande.<br />Merci...</div>';
			echo '<table border="0" width="100%"><tr>
<td align="center"><a class="fbutton" href="cancelcmd.php?" title="Cliquez ici pour choisir annuler votre commande" onClick="if(confirm(\'Etes-vous certain de vouloir annuler votre commande ?\')) return true; else return false;">Annuler commande</a><td>
<td align="center"><a class="fbutton" href="validcmd.php?" title="Cliquez ici pour valider votre commande">Valider commande</a><td>
</tr></table>';
		} else {
			if ($CanChoose == FALSE) {
				echo '<div align="center" style="color:red;font-weight:bold;">Pour pouvoir commander des plats chez ce prestataire,<br />veuillez d\'abord finaliser votre commande en cours.</div>';
			}
			echo '<table width="555" border="0" cellpadding="0" cellspacing="5px"><tr valign="top">
		<td width="85px"></td>
		<th width="230px" align="left">Plats proposés</td>
		<th width="50px" align="right">Prix</td>
		<td width="50px"></td>
		<th width="40px" align="center">Qté.</td>
		<td></td>
		</tr>';
			for ($j = 0; $j < count($aplat); $j++) {
				//echo '<tr>';
				if (!is_null($aplat[$j]['platImage'])) {
					$imgplat = 'images/plat/' . $aplat[$j]['platImage'];
					$size = getimagesize($imgplat);
					$s1 = intval($size[0] * 0.5);
					$s2 = intval($size[1] * 0.5);
					echo '<tr><td width="85px" align="center"><img src="' . $imgplat . '" title="Image du plat : ' . $aplat[$j]['platNom'] . '" alt="Image du plat : ' . $aplat[$j]['platNom'] . '" border="0" width="' . $s1 . '" height="' . $s2 . '" class="plat" /></td><td width="230px" class="plattab">';
				} else {
					echo '<tr height="40px"><td width="315px" align="left" colspan="2" class="plattab">';
				}
				echo $aplat[$j]['platNom'];
				if ($aplat[$j]['platPrixPromo'] != '0.00') {
					echo '&nbsp;&nbsp;&nbsp;<span class="promo">En Promo</span>';
				}
				if (!is_null($aplat[$j]['platDescription'])) {
					echo '<br><small>' . $aplat[$j]['platDescription'] . '</small>';
				}
				//ajouter link ver menu
				if ($aplat[$j]['isMenu'] == 1) {
					echo '<br /><a href="#" title="Cliquez ici pour voir les détails de ce menu" class="suite" onclick="window.open(\'voirmenu.php?menuid=' . $aplat[$j]['platID'] . '\',\'menu\',\'top=100,left=100,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;">Voir le menu...</a>';
				}
				echo '</td>';
				echo '</td><td align="right" width="50px" class="plattab">';
				if ($aplat[$j]['platPrixPromo'] == '0.00') {
					echo $aplat[$j]['platPrix'] . '&euro;</td><td></td>';
				} else {
					echo '<del class="plat">' . $aplat[$j]['platPrix'] . '&euro;</del></td><td align="right" width="50px" class="promo">' . $aplat[$j]['platPrixPromo'] . '&euro;</td>';
				}
				//si on peut choisir on fait voir quantité et bouton, si on peut pas choisir c'est parce que on a commandé chez un autre presta
				if ($CanChoose == TRUE) {
					//bouton different pour le menu
					if ($aplat[$j]['isMenu'] == 1) {
						echo '<td width="40px" align="center"><input type="text" class="mqte" name="qte" value="1" size="1" maxlength="3" style="text-align: right" /></td>';
						echo '<td>';
						echo '<input class="mcmd" name="button" type="button" value="Commander" />';
						echo '<input type="hidden" value="' . $aplat[$j]['platID'] . '" class="mmenu" /></td></tr>';
					} else {
						echo '<td width="40px" align="center"><input type="text" class="qte" name="qte" value="1" size="1" maxlength="3" style="text-align: right" title="Entrez la quantité désirée du plat" /></td>';
						echo '<td>';
						echo '<input class="cmd" name="button" type="button" value="Commander" title="cliquez pour commander la quantité de ce plat"/>';
						echo '<input type="hidden" value="' . $aplat[$j]['platID'] . '" class="menu" /></td></tr>';
					}
				}
				echo "\n";
			}
			echo '</table>';
		}
		echo '</div>';
		echo "\n";
	}
}
echo '</div>';
include INCLUDE_DIR . 'closeboxfront.php';
if (!isset($_SESSION['cmdid'])) {
	echo '<div align="right"><a href="finalcmd.php" class="fbutton" title="Cliquez ici pour finaliser votre commande">Terminer ma commande</a></div><br />';
}
//fin de page
echo '</div>';
?>