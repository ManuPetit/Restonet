<?php
//		cat_modif_form.php

//		fichier pour modifier catégorie

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_categorie.php';
require_once BUSINESS_DIR . 'form.php';
//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Modification d'une catégorie";
include INCLUDE_DIR . 'adminhead.php';


//on recupère le numéro si on vient de la page cat_liste_form.php
if ((isset($_GET['catid'])) && (is_numeric($_GET['catid']))) {
	if ($_GET['catid'] > 0) {
		$id = (int)$_GET['catid'];
		$cat = new Categorie();
		$cat -> GetCategorieParID($id);
	}
}
//on recupère le numéro si on vient de la page cat_delete_form.php
if ((isset($_POST['catid'])) && (is_numeric($_POST['catid']))) {
	if ($_POST['catid'] > 0) {
		$id = (int)$_POST['catid'];
		$cat = new Categorie();
		$cat -> GetCategorieParID($id);
	}
}
if (!isset($cat)) {
	//on n'a pas de catégorie donc on fait faire un choix
	echo '<h2>Liste des catégories de restaurant</h2>';
	$rows = Categorie::GetCategorieDetail();
	if (empty($rows)) {
		echo '<p>Il n\'y a aucune catégorie à modifier.</p>';
	} else {
		echo '<p>Veuilez choisir la catégorie à modifier :</p>';
		echo '<fieldset><legend>Catégorie : </legend>
			<form action="cat_modif_form.php" method="post" accept-charset="utf-8">
			<select name="catid" id="catid">			
			<option value="0" selected="selected">Veuillez choisir une catégorie</option>';
		//afficher les catégories
		for ($i = 0; $i < count($rows); $i++) {
			echo '<option value="' . $rows[$i]['categorieID'] . '">' . $rows[$i]['categorieNom'] . '</option>';
		}
		echo '</select>
			<div align="center"><input type="submit" name="submit" id="submit" value="Choisir cette catégorie" />
			</form></fieldset>';
	}
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
} else {	
	//on a une catégorie
	echo '<h2>' . $page_title . '</h2>';
	$errors = array();
	if (isset($_POST['catsub']))
	{
		// on a soumis la forme danc on l'analyse
		include 'cat_modif.php';
	}
?>
<fieldset>
  <legend>Modifiez les détails de la catégorie <?php echo $cat -> GetCatNom();?> : </legend>
  <form action="cat_modif_form.php" method="post" accept-charset="utf-8">
    <table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="catcrenom"><strong>Nom de la catégorie :</strong></label></td>
        <td></td>
        <td>
        <?php create_form_edit('catcrenom', 'text', $errors, 40, 30, $cat -> GetCatNom());?></td>
</tr>
<tr valign="top">
	<td width="40%" align="right"><label for="catcretit"><strong>Titre de la catégorie :</strong></label></td><td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Titre :</b><br />Il apparait dans l'onglet du navigateur et est donc obligatoire.<br /><br />Le système rajoutera automatiquement le nom de RESTOnet.<br /><br /><i>Exemple de titre :</i><br /> Restaurants asisatiques" /></td>
	<td><?php create_form_edit('catcretit', 'text', $errors, 40, 30, $cat -> GetCatTitle());?></td>
</tr>
<tr valign="top">
	<td width="40%" align="right"><label for="catcrekey"><strong>Mots clés de la catégorie :</strong></label></td><td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Mots clés :</b><br />Les mots clés sont utilisés pour le référencement. ils n'apparaissent pas dans le contenu visible de la page.<br /><br />Chaque mot clé doit être séparé par une virgule.<br /><br />Le système rajoutera automatiquement le mot clé de RESTOnet.<br /><br /><i>Exemple de mots clés :</i><br /> cuisine, plat, chinois, asisatique" /></td>
	<td><?php create_form_edit('catcrekey', 'textarea3', $errors, 40, 30, $cat -> GetMetaKey());?></td>
</tr>
<tr valign="top">
	<td width="40%" align="right"><label for="catcredesc"><strong>Description de la catégorie :</strong></label></td>
	<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Description :</b><br />La description est utilisé pour le référencement. Elle n'apparait pas dans le contenu visible de la page.<br /><br />La description peut être une phrase contenant une brève explication de la page.<br /><br /><i>Exemple de description :</i><br /> Retrouvez les restaurants proposants une cuisine asiatique." /></td>
	<td><?php create_form_edit('catcredesc', 'textarea3', $errors, 40, 30, $cat -> GetMetaDesc());?></td>
</tr>
</table>
<br />
<div align="center">
	<input type="submit" name="submit" id="submit" value="Modifiez la catégorie" />
	<input type="hidden" name="catsub" value="TRUE" />
	<input type="hidden" name="catid" value="<?php 
	if (isset($id)) 
		echo $id;
	 ?>" />
	</form>
	</fieldset>';
<?php
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
exit();
?>