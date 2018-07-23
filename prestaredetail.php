<?php
//		prestaredetail.php
// 		fichier de recherche d'un prestataire
//		affichage des détails de la recherche
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'fonctions.php';
require_once BUSINESS_DIR . 'cls_shop.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//on vérifie que l'on a quelquechose
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['ledept'] != 0) && (isset($_POST['lavil'])) && (isset($_POST['lacat']))){
	//information transmise par la page précédente
	$did = $_POST['ledept'];
	$vid=$_POST['lavil'];
	$cid=$_POST['lacat'];
	$order = 'n';
} else if (($_SERVER['REQUEST_METHOD'] == 'GET') && ($_GET['d'] != 0) && (isset($_GET['d'])) & (isset($_GET['v'])) & (isset($_GET['v'])) & (isset($_GET['o']))){
	//information transmises par cette page
	$did = $_GET['d'];
	$vid=$_GET['v'];
	$cid=$_GET['c'];
	$order = $_GET['o'];
}else{
	//on a rien à faire ici
	$url = 'prestarech.php';
	header("Location: $url");
	exit();
}
//on retrouve les filtres
$filt=array();
$filt=Shop::GetFiltrageDetail($vid, $cid, $did);

$page_title = "Résultats de la recherche de prestataire sur RESTOnet";
$menu = 'm2';
include INCLUDE_DIR . 'header.php';
$errors=array();
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	
	//affichage
	echo '</div>
	<!-- CONTENU  -->
	<div id="right">
	<h1>Résultat de la recherche de prestataire sur RESTOnet</h1>
	<h4>Vos critères de recherche: <br />Département : '.$filt['dept']. ', '.$filt['ville'].', '.$filt['categ'].'</h4>';
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><th width="30%" align="left"><a href="prestaredetail.php?d='.$did.'&v='.$vid.'&c='.$cid.'&o=n" class="headville" title="cliquez ici pour classer les établissement par ordre alphabetique">Etablissement</a></th><th width="30%" align="left"><a href="prestaredetail.php?d='.$did.'&v='.$vid.'&c='.$cid.'&o=c" class="headville" title="cliquez ici pour classer les établissement par ordre alphabetique des catégories">Catégorie</a></th><th width="20%" align="left"><a href="prestaredetail.php?d='.$did.'&v='.$vid.'&c='.$cid.'&o=v" class="headville" title="cliquez ici pour classer les établissement par order alphabétique des villes">Ville</a></th><th width="20%"></th></tr>';
	echo "\n";
	echo '</table>';
	include INCLUDE_DIR . 'closeboxfront.php';

	//établir l'ordre
	switch ($order) {
		case 'v':
			$disOrder = 'Ville';
			break;
		case 'c':
			$disOrder = 'Categorie';
			break;
		default:
			$disOrder = 'prestaNom';
			break;
	}
	
	//faire les requêtes selon les valeurs

	$listp=array();
	$listp=Shop::GetPrestaListVilleEtCategorie($vid, $cid,$did, $disOrder);
	include INCLUDE_DIR . 'openboxfront.php';
	if (count($listp)>0){
		echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
		for ($l=0;$l<count($listp);$l++){
			echo '<tr valign="center"><td width="30%"><h3 class="boitetitle">' . $listp[$l]['prestaNom']. '</h3></td><td width="30%">';
			$catN = array();
			$catN = explode(',', $listp[$l]['Categorie']);
			$catI = array();
			$catI = explode(',', $listp[$l]['CatID']);
			for ($c = 0; $c < count($catN); $c++) {
				echo '<a href="categorie.php?catid=' . $catI[$c] . '&vilid=' . $listp[$l]['villeID'] . '" title=cliquez ici pour voir les autres établissements de la ville dans cette catégorie" class="suite">' . $catN[$c] . '</a>&nbsp;';
			}
			echo '</td><td width="20%"><a href="ville.php?vilid=' . $listp[$l]['villeID'] . '" title=cliquez ici pour voir les autres établissement de ' .$listp[$l]['ville'] . '" class="suite">'.$listp[$l]['ville'] . '</a></td>';
			echo '<td width="20%"><a href="prestataire.php?prestaid=' . $listp[$l]['prestaID'] . '" title="Cliquez ici avoir plus de détails sur ' . $listp[$l]['prestaNom'] . '" class="fbutton">+ de détails</a></td></tr>';
		}
		echo '</table>';
	}else{
		echo 'Désolé, mais votre recherche n\'a donné aucun résultat... Veuillez faire une nouvelle recherche en modifiant vos critères de sélection...<br />';
	}
	echo '<div align="center"><a href="prestarech.php" title="Cliquez ici pour faire une nouvelle recherche" class="fbutton">Nouvelle recherche</a></div>';
	include INCLUDE_DIR . 'closeboxfront.php';

	
	//fin du contenu
	echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>