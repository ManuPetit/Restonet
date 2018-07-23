<?php
//		voirpanier.php

//		fichier pour voir le panier

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'fonctions.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$page_title = "Mon panier - RESTOnet";
$menu = 'm9';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);

echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

//afficher le panier
include BUSINESS_DIR . 'show_cart.php';
echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Mon panier</h1>';
include INCLUDE_DIR . 'openboxfront.php';
//vérifier que l'on est pas en train de valider une commande
if (!isset($_SESSION['cmdid'])) {
	//voir ce qu'il y a dans le shopping trolley
	if (isset($_SESSION['uniid'])) {
		$itemInCart = Shop::CountCartItem($_SESSION['uniid']);
		if ($itemInCart < 1) {
			//panier vide
			//on s'assure que les variables sont remise à zéro
			if (isset($_SESSION['curprestid'])) {
				unset($_SESSION['curprestid']);
			}
			if (isset($_SESSION['livre'])) {
				unset($_SESSION['livre']);
			}
			if (isset($_SESSION['date'])) {
				unset($_SESSION['date']);
			}
			if (isset($_SESSION['plage'])) {
				unset($_SESSION['plage']);
			}
			if (isset($_SESSION['dateCmd'])) {
				unset($_SESSION['dateCmd']);
			}
			if (isset($_SESSION['cmdid'])) {
				unset($_SESSION['cmdid']);
			}
			if (isset($_SESSION['prixTTC'])) {
				unset($_SESSION['prixTTC']);
			}
			echo '<p>Votre panier est vide. Vous n\'avez pas encore commandé de plat.</p>';
		} else {
			//panier avec items on les faits voir
			$plats = array();
			$plats = Shop::GetCartItemParUniqID($_SESSION['uniid']);
			if (!empty($plats)) {
				$totalcmd = 0;
				echo '<table width="100%" border="0" cellpadding="0" cellspacing="3px">
			<tr><th width="45%" align="left">Plat</th><th width="10%" align="right">Prix</th><th width="10%"></th><th width="20%" align="center">Quantité</th><th width="15%">Total</th></tr>';
				for ($p = 0; $p < count($plats); $p++) {
					echo '<tr valign="bottom"><td  class="plattab">' . $plats[$p]['platNom'] . '</td>';
					echo "\n";
					echo '<td align="right" class="plattab">';
					if ($plats[$p]['platPrixPromo'] != '0.00') {
						echo '<del class="plat">' . sprintf("%01.2f", $plats[$p]['platPrix']) . '&euro;</del></td><td align="right" class="promo">' . sprintf("%01.2f", $plats[$p]['platPrixPromo']) . '&euro;</td>';
					} else {
						echo $plats[$p]['platPrix'] . '&euro;</td><td></td>';
					}
					echo "\n";
					echo '<td align="center"><input type="text" title="Pour modifier le nombre de plats commandés, utilisez les boutons +, - ou x" readonly="readonly" class="mqte" name="qte" value="' . $plats[$p]['cartQte'] . '" size="1" maxlength="3" style="text-align: right" />';
					if ($plats[$p]['isMenu'] == 1) {
						echo '<a href="business/changemenucart.php?platid=' . $plats[$p]['cartID'] . '&act=a" title="Cliquez ici pour commander une quantité de plus à ce plat"><img src="images/common/addtocart.jpg" width="20" height="20" border="0" /></a>';
						echo '<a href="business/changemenucart.php?platid=' . $plats[$p]['cartID'] . '&act=r" title="Cliquez ici pour retirer une quantité de ce plat"><img src="images/common/removefromcart.jpg" width="20" height="20" border="0" /></a>';
					} else {
						echo '<a href="business/changecart.php?platid=' . $plats[$p]['cartID'] . '&act=a" title="Cliquez ici pour commander une quantité de plus à ce plat"><img src="images/common/addtocart.jpg" width="20" height="20" border="0" /></a>';
						echo '<a href="business/changecart.php?platid=' . $plats[$p]['cartID'] . '&act=r" title="Cliquez ici pour retirer une quantité de ce plat"><img src="images/common/removefromcart.jpg" width="20" height="20" border="0" /></a>';
					}
					echo '<a href="business/changecart.php?platid=' . $plats[$p]['cartID'] . '&act=d" title="Cliquez ici pour retirer entièrement ce plat de votre commande"><img src="images/common/deletefromcart.jpg" width="20" height="20" border="0" /></a></td>';
					echo "\n";
					echo '<td align="right" class="plattab">' . sprintf("%01.2f", $plats[$p]['Total']) . '&euro;</td></tr>';
					if ($plats[$p]['isMenu'] == 1) {
						$menu = array();
						$menu = Shop::GetMenuDetailFromCart($_SESSION['uniid'], $plats[$p]['platID']);
						if (!empty($menu)) {
							echo '<tr><td colspan="5">';
							for ($m = 0; $m < count($menu); $m++) {
								echo '<small>' . $menu[$m]['cartQte'] . ' x ' . $menu[$m]['platNom'] . '<br /></small>';
							}
							echo '</td></tr>';
						}

					}
					$totalcmd += $plats[$p]['Total'];
				}
				echo '<tr><td colspan="4" align="right"><b>Total du panier</b></td><td align="right"><b>' . sprintf("%01.2f", $totalcmd) . '&euro;</b></td></tr>';
				echo '</table>';
			}
			echo '<br /><div align="right"><a class="fbutton" href="' . $_SESSION['lastprestapage'] . '" title="Cliquez ici pour continuer vos achats">Continuer mes achats</a>&nbsp;&nbsp;&nbsp;
	<a class="fbutton" href="finalcmd.php" title="Cliquez ici pour finaliser votre commande">Finaliser ma commande</a></div>';
		}
	} else {
		//on s'assure que les variables sont remise à zéro
		if (isset($_SESSION['curprestid'])) {
			unset($_SESSION['curprestid']);
		}
		if (isset($_SESSION['livre'])) {
			unset($_SESSION['livre']);
		}
		if (isset($_SESSION['date'])) {
			unset($_SESSION['date']);
		}
		if (isset($_SESSION['plage'])) {
			unset($_SESSION['plage']);
		}
		if (isset($_SESSION['dateCmd'])) {
			unset($_SESSION['dateCmd']);
		}
		if (isset($_SESSION['cmdid'])) {
			unset($_SESSION['cmdid']);
		}
		if (isset($_SESSION['prixTTC'])) {
			unset($_SESSION['prixTTC']);
		}
		echo '<p>Votre panier est vide. Vous n\'avez pas encore commandé de plat.</p>';
	}
} else {
	echo '<p>Votre commande est en cours de validation. Veuillez terminer votre commande ou l\'annuler.</p>';
	echo '<table border="0" width="100%"><tr>
<td align="center"><a class="fbutton" href="cancelcmd.php?" title="Cliquez ici pour choisir annuler votre commande" onClick="if(confirm(\'Etes-vous certain de vouloir annuler votre commande ?\')) return true; else return false;">Annuler commande</a><td>
<td align="center"><a class="fbutton" href="validcmd.php?" title="Cliquez ici pour valider votre commande">Valider commande</a><td>
</tr></table>';
}
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>