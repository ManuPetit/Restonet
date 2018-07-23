<?php
//		cat_liste_form.php

//		fichier pour lister les catégories

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_categorie.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Liste des catégories de restaurant";
include INCLUDE_DIR . 'adminhead.php';
echo '<h2>' . $page_title . '</h2>';
$rows = array();
$rows = Categorie::GetCategorieDetail();
if (empty($rows)) {
	echo '<p>Il n\'y pas de catégorie dans la base de données.</p>';
}else{
	//on a des catégories
	echo '<table width="90%" border="0" cellspacing="0" cellpadding="2">
	<tr class="malistehead">
	<th width="10%" class="maliste">ID</th>
	<th width="30%" class="maliste" align="left">Nom</th>
	<th width="40%" class="maliste" align="left">Titre</th>
	<th width="10%" class="maliste">Editer</th>
	<th width="10%" class="maliste">Suppr.</th>
	</tr>';
	$bg = '#b1f3ac';
	for ($i=0; $i<count($rows); $i++)
	{
		$bg = ($bg=='#b1f3ac' ? '#f3d2ac' : '#b1f3ac');
		echo '<tr bgcolor="' . $bg . '">';
		echo '<td class="maliste" align="center">' . $rows[$i]['categorieID'] . '</td>';
		echo '<td class="maliste">' . $rows[$i]['categorieNom'] . '</td>';
		echo '<td class="maliste">' . $rows[$i]['categorieTitle'] . '</td>';
		echo '<td align="center"><a href="cat_modif_form.php?catid=' . $rows[$i]['categorieID'] . '" title="Cliquez ici pour modifier la catégorie :' . $rows[$i]['categorieNom'] . '" class="maliste">Editer</a></td>';
		echo '<td align="center"><a href="cat_delete_form.php?catid=' . $rows[$i]['categorieID'] . '" title="Cliquez ici pour supprimer :' . $rows[$i]['categorieNom'] . '" class="maliste" onClick="if(confirm(\'Etes-vous certains de vouloir supprimer cette catégorie ?\')) return true; else return false;">Suppr.</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>