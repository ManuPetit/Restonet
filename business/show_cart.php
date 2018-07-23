<?php
//	showcart.php
//cette fonction affiche le shopping cart si il existe

//ajouter les fichiers d'utilités
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';
require_once BUSINESS_DIR . 'fonctions.php';

//On affiche le panier que si il y a des items dans la commande ou si on est sur la page prestataire
//verifier qu'on a un GUI
if (isset($_SESSION['uniid'])) {
	//voir ce qu'il y a dans le shopping trolley
	$itemInCart = Shop::CountCartItem($_SESSION['uniid']);
	$amountInCart = Shop::GetCartAmount($_SESSION['uniid']);
	//on fait voir le panier que si il y a qqchose ou si on est sur la page prestataire si il est vide
	if (($itemInCart > 0) || (basename($_SERVER['PHP_SELF']) == 'prestataire.php') || (basename($_SERVER['PHP_SELF']) == 'voirpanier.php')) {
		include INCLUDE_DIR . 'openboxfront.php';
		echo '<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr><td width="80%"><h3 class="boitetitleleft">Mon panier</h3></td>
	<td align="right">';
		if ($itemInCart == 0) {
			echo '<img class="panier" src="images/common/paniervide.jpg" width="30" height="30" border="0" />';
		} else {
			echo '<img class="panier" src="images/common/panierplein.jpg" width="30" height="30" border="0" />';
		}
		echo '</td></tr>
	<tr><td colspan="2" align="left">';
		if ($itemInCart == 0) {
			echo '<p><span class="items">Votre panier est vide.</span></p>';
		} else if ($itemInCart == 1) {
			echo '<p><span class="items">Dans votre panier : 1 plat.<br />Montant panier : ' . sprintf("%01.2f", $amountInCart) . '&euro;.</span></p>';
		} else {
			echo '<p><span class="items">Dans votre panier : ' . $itemInCart . ' plats.<br />Montant panier : ' . sprintf("%01.2f", $amountInCart) . '&euro;.</span></p>';
		}
		echo '</td></tr>
	<tr><td colspan="2" align="right"><a class="fbutton" href="voirpanier.php" title="Cliquez ici pour voir le détail de votre panier">Voir panier</a>
	</td></tr></table>';
		include INCLUDE_DIR . 'closeboxfront.php';
	}
}
?>