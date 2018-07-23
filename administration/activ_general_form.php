<?php
//		activ_general_form.php

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_activite.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Toutes activités";
include INCLUDE_DIR . 'adminhead.php';

$act = new Activite();
$act -> GetActiviteDetails();
if ($act -> HasActivite() == TRUE) {
	echo '<h2>Toutes activités</h2>';
	echo '<p>Détails de l\'activité du site RESTOnet depuis ' . PreFormatDate($act -> GetDatePremiereComde()) . ' jusqu\'à aujourd\'hui :</p>';
	echo '<table width="90%" cellpadding="5" cellspacing="0" border="0" align="center">';
	echo '<tr bgcolor="#ebf9a0"><td width="28%" align="right">C.A. généré :</td><td width="20%" align="right"><b>' . sprintf("%01.2f", $act -> GetCAGenere()) . '</b></td><td width="4%" bgcolor="#cbd888"></td><td width="28%" align="right">Nombre de clients :</td><td width="20%" align="right"><b>' . $act -> GetNombreClient() . '</b></td></tr>';
	echo '<tr bgcolor="#ebf9a0"><td width="28%" align="right">Commission générée :</td><td width="20%" align="right"><b>' . sprintf("%01.2f", $act -> GetCommissionGenere()) . '</b></td><td width="4%" bgcolor="#cbd888"></td><td width="28" align="right">Nombre de commandes :</td><td width="20%" align="right"><b>' . $act -> GetNombreCommandeTotal() . '</b></td></tr>';
	echo '</table><br /><p>Détails des commandes :</p>';
	echo '<table width="90%" cellpadding="5" cellspacing="0" border="0" align="center">';
	echo '<tr bgcolor="#ebf9a0"><td width="28%" align="right">Commandes validées :</td><td width="18%"align="right"><b>' . $act -> GetNombreCommandeValide() . '</b><td width="2%" bgcolor="#ff0000"></td><td width="4%" bgcolor="#cbd888"></td><td width="28%" align="right">Commandes en préparation :</td><td width="18%"align="right"><b>' . $act -> GetNombreCommandePreparation() . '</b><td width="2%" bgcolor="#ffff00"></td></tr>';
	echo '<tr height="5px"><td colspan="7"></td></tr>';
	echo '<tr bgcolor="#ebf9a0"><td width="28%" align="right">Commandes en livraison :</td><td width="18%"align="right"><b>' . $act -> GetNombreCommandeLivraison() . '</b><td width="2%" bgcolor="#00ff00"></td><td width="4%" bgcolor="#cbd888"></td><td width="28%" align="right">Commandes terminées :</td><td width="18%"align="right"><b>' . $act -> GetNombreCommandeTermine() . '</b><td width="2%" bgcolor="#0000ff"></td></tr>';
	echo '<tr height="5px"><td colspan="7"></td></tr><tr bgcolor="#ebf9a0"><td width="28%" align="right">Commandes annulées :</td><td width="18%" align="right"><b>' . $act -> GetNombreCommandeAnnule() . '</b></td><td width="2%"></td><td colspan="4" bgcolor="#cbd888"></td></tr>';
	echo '</table>';
	//calcul des pourcentages
	$total = $act -> GetNombreCommandeLivraison() + $act -> GetNombreCommandePreparation() + $act -> GetNombreCommandeTermine() + $act -> GetNombreCommandeValide();
	if ($act -> GetNombreCommandeValide() != 0) {
		$pVal = round(($act -> GetNombreCommandeValide() * 100) / $total);
	} else {
		$pval = 0;
	}
	if ($act -> GetNombreCommandeLivraison() != 0) {
		$pLiv = round(($act -> GetNombreCommandeLivraison() * 100) / $total);
	} else {
		$pLiv = 0;
	}
	if ($act -> GetNombreCommandePreparation() != 0) {
		$pPre = round(($act -> GetNombreCommandePreparation() * 100) / $total);
	} else {
		$pPre = 0;
	}
	if ($act -> GetNombreCommandeTermine() != 0) {
		$pTer = round(($act -> GetNombreCommandeTermine() * 100) / $total);
	} else {
		$pTer = 0;
	}
	echo '<br />';
	echo '<table cellpadding="0" cellspacing="0" border="0" width="90%" align="center">';
	echo '<tr height="20px"><td width="' . $pVal . '%" bgcolor="#ff0000"></td><td width="' . $pPre . '%" bgcolor="#ffff00"></td><td width="' . $pLiv . '%" bgcolor="#00ff00"></td><td width="' . $pTer . '%" bgcolor="#0000ff"></td></tr>';
	echo '</table><br />';

	echo '<p>Autres détails</p>';
	echo '<table cellpadding="5" cellspacing="0" border="0" width="90%" align="center">
<tr bgcolor="#ebf9a0" valign="top"><td width="28%" align="right">Nombre de commentaires :</td>';
	echo "\n";
	echo '<td width="20%" align="right"><b>' . $act -> GetNombreCommentaire() . '</b></td>';
	echo "\n";
	echo '<td width="4%" bgcolor="#cbd888"></td>';
	echo "\n";
	echo '<td width="28%" align="right">Commentaires à valider :</td>';
	echo "\n";
	echo '<td width="20%" align="right"><b>' . $act -> GetNombreCommentaireAValider() . '</b></td></tr>';
	echo "\n";
	echo '<tr bgcolor="#ebf9a0" valign="top"><td width="28%" align="right">Nombre de votes :</td>';
	echo "\n";
	echo '<td width="20%" align="right"><b>' . $act -> GetNombreVote() . '</b></td><td colspan="3" bgcolor="#cbd888"></td></tr>
</table><br />';
} else {
	echo '<h2>Toutes activités</h2>';
	echo '<p>Il n\'y a aucune activité sur votre site.</p>';
}
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
