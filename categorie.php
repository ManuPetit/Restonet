<?php
	//		categorie.php
	//		permet de voir les restaurant d'une catégorie
	//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'fonctions.php';
require_once BUSINESS_DIR . 'cls_shop.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//On vérifie que l'on a une categorie, une région ou un dept ou une ville
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['catid'])) && (is_numeric($_GET['catid']))){
	$cid = $_GET['catid'];
	
	//retrouve les détail de la catégorie
	$catdet=array();
	$catdet=Shop::GetCategorieDetail($cid);
	$sentc = 'Restaurants de catégorie '.$catdet['categorieNom'];
	$listc=array();
	
	if (isset($_GET['o'])){
		//on selectionne l'ordre
		switch ($_GET['o']) {
			case 'v':
				$ord = 'Ville';
				break;
			case 'n':
				$ord='Note DESC';
				break;
			default:
				$ord='prestaNom';
				break;
		}
	}else{
		$ord='prestaNom';
	}
	if ((isset($_GET['regid'])) && (is_numeric($_GET['regid']))){
		$rid=$_GET['regid'];
		$sentc .= ' en '.Shop::GetRegionNom($rid);
		$listc=Shop::GetPrestaParCategRegion($cid, $rid, $ord);
		$lien = '?catid='.$cid.'&regid='.$rid .'&o=';
	}elseif ((isset($_GET['depid'])) && (is_numeric($_GET['depid']))){
		$did=$_GET['depid'];
		$sentc .= ' en ' .Shop::GetDepartmentNom($did);
		$listc=Shop::GetPrestaParCategDept($cid, $did, $ord);
		$lien = '?catid='.$cid.'&depid='.$did .'&o=';
	}elseif ((isset($_GET['vilid'])) && (is_numeric($_GET['vilid']))){
			$vid=$_GET['vilid'];
			$sentc .= ' à ' .Shop::GetVilleNom($vid);
			$listc=Shop::GetPrestaParCategVille($cid, $vid, $ord);
			$lien = '?catid='.$cid.'&vilid='.$vid .'&o=';
	}else{
		$sentc .= ' sur RESTOnet';
		$listc=Shop::GetPrestaParCategorie($cid, $ord);
		$lien ='?catid='.$cid.'&o=';
	}
	//affihage de la page
	$page_title = $sentc .' - RESTOnet';
	$metaKey = $catdet['categorieMetaKey'];
	$metaDesc = $catdet['categorieMetaDescription'];
	$menu = 'm2';
	include INCLUDE_DIR . 'header.php';
	//necessaire pour retourner à la page après la connection
	$_SESSION['lastpage'] = basename($_SERVER['REQUEST_URI']);
	echo '
	<!-- COLONNE GAUCHE  -->
	<div id="left">';
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	//affichage
	echo '</div>
	<!-- CONTENU  -->
	<div id="right">
	<h1>'.$sentc.'</h1>';
	//création du titre
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><th width="30%" align="left"><a href="categorie.php'.$lien . 'p" class="headville" title="cliquez ici pour classer les établissement par ordre alphabetique">Etablissement</a></th><th width="30%" align="left"><a href="categorie.php'.$lien . 'v" class="headville" title="cliquez ici pour classer les établissement par ordre alphabetique des villes">Ville</a></th><th width="20%" align="left"><a href="categorie.php'.$lien . 'n" class="headville" title="cliquez ici pour classer les établissement par ordre décroissant des notes">Note</a></th><th width="20%"></th></tr>';
	echo "\n";
	echo '</table>';	
	include INCLUDE_DIR . 'closeboxfront.php';
	
	//affichage des restaurants
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<table width="100%" border="0"cellpadding="0" cellspacing="0">';
	for ($l=0;$l<count($listc);$l++){
		echo '<tr valign="center"><td width="30%"><h3 class="boitetitle">' . $listc[$l]['prestaNom']. '</h3></td><td width="30%">';
		echo '<a href="ville.php?vilid=' . $listc[$l]['villeID'] . '" title=cliquez ici pour voir les autres établissement de ' .$listc[$l]['Ville'] . '" class="suite">'.$listc[$l]['Ville'] . '</a></td>';
		echo '<td width="20%">';
		$image = 'images/etoiles/minietoile' . $listc[$l]['Note'] . '.jpg';
		if ($listc[$l]['Note'] < 1) {
			$ntitle = "Soyez le premier à donner une note à " . $listc[$l]['prestaNom'];
		} else {
			$ntitle = 'Note attribuée par les internautes pour ' . $listc[$l]['prestaNom'];
		}
		echo '<img src="' . $image . '" border="0" width="70" height="15" alt="' . $ntitle . '" title="' . $ntitle . '" /></td>';
		echo '<td width="20%"><a href="prestataire.php?prestaid=' . $listc[$l]['prestaID'] . '" title="Cliquez ici avoir plus de détails sur ' . $listc[$l]['prestaNom'] . '" class="fbutton">+ de détails</a></td></tr>';
	}
	echo '</table>';
	include INCLUDE_DIR . 'closeboxfront.php';
	
	//fin de page
	echo '</div>';
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'footer.php';
}else{
	$url='index.php';
	header("Location: $url");
	exit();
}
