<?php
//		tva_liste_form.php
//		liste les taux de tva sur le système

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_tva.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Liste des taux de T.V.A.";
include INCLUDE_DIR . 'adminhead.php';

echo '<h2>Liste des taux de T.V.A.</h2>';

//retrouver les taux de tva
$rows=array();
$rows = Tva::GetTvaListe();
if (empty($rows))
{
	echo '<p>Il n\'y a aucun taux de T.V.A. défini dans la base de données.</p>';
}else{
	//on a des tva
	echo '<table width="90%" border="0" cellspacing="0" cellpadding="2">
	<tr class="malistehead">
	<th width="10%" class="maliste">ID</th>
	<th width="40%" class="maliste" align="left">Nom</th>
	<th width="20%" class="maliste" align="center">Taux</th>
	<th width="15%" class="maliste" align="center">Editer</th>
	<th width="15%" class="maliste" align="center">Suppr.</th>
	</tr>';
	$bg = '#b1f3ac';
	for ($i=0; $i<count($rows); $i++)
	{
		$bg = ($bg=='#b1f3ac' ? '#f3d2ac' : '#b1f3ac');
		echo '<tr bgcolor="' . $bg . '">';
		echo '<td class="maliste" align="center">' . $rows[$i]['tvaID'] . '</td>';
		echo '<td class="maliste">' . $rows[$i]['tvaNom'] . '</td>';
		echo '<td class="maliste" align="center">' . $rows[$i]['tvaTaux'] . '</td>';
		echo '<td align="center"><a href="tva_modif_form.php?tvaid=' . $rows[$i]['tvaID'] . '" title="Cliquez ici pour modifier le taux de T.V.A. à ' . $rows[$i]['tvaTaux'] . '%" class="maliste">Editer</a></td></td>';
		echo '<td align="center"><a href="tva_delete_form.php?tvaid=' . $rows[$i]['tvaID'] . '" title="Cliquez ici pour supprimer le taux de T.V.A. à ' . $rows[$i]['tvaTaux'] . '%" class="maliste" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer ce taux de T.V.A. ?\')) return true; else return false;">Suppr.</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>
