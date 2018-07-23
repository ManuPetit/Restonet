<?php
//		cat_create_form.php

//		fichier pour la création d'une nouvelle catégorie

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

$page_title = "Nouvelle catégorie restaurant";
include INCLUDE_DIR . 'adminhead.php';

//variable pour les erreurs
$errors = array();
if ((isset($_POST['catcre'])) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
{
	include 'cat_create.php';
}
?>
<h2>Creation d'une nouvelle catégorie de restaurant</h2>
<fieldset>
  <legend>Entrez les d&eacute;tails de votre nouvelle catégorie : </legend>
  <form action="cat_create_form.php" method="post" accept-charset="utf-8">
    <table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="catcrenom"><strong>Nom de la catégorie :</strong></label></td>
        <td></td>
        <td>
        <?php create_form_input('catcrenom', 'text', $errors, 40, 30);?></td>
</tr>
<tr valign="top">
	<td width="40%" align="right"><label for="catcretit"><strong>Titre de la catégorie :</strong></label></td><td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Titre :</b><br />Il apparait dans l'onglet du navigateur et est donc obligatoire.<br /><br />Le système rajoutera automatiquement le nom de RESTOnet.<br /><br /><i>Exemple de titre :</i><br /> Restaurants asisatiques" /></td>
	<td><?php create_form_input('catcretit', 'text', $errors, 40, 30);?></td>
</tr>
<tr valign="top">
	<td width="40%" align="right"><label for="catcrekey"><strong>Mots clés de la catégorie :</strong></label></td><td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Mots clés :</b><br />Les mots clés sont utilisés pour le référencement. ils n'apparaissent pas dans le contenu visible de la page.<br /><br />Chaque mot clé doit être séparé par une virgule.<br /><br />Le système rajoutera automatiquement le mot clé de RESTOnet.<br /><br /><i>Exemple de mots clés :</i><br /> cuisine, plat, chinois, asisatique" /></td>
	<td><?php create_form_input('catcrekey', 'textarea3', $errors, 40, 30);?></td>
</tr>
<tr valign="top">
	<td width="40%" align="right"><label for="catcredesc"><strong>Description de la catégorie :</strong></label></td>
	<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Description :</b><br />La description est utilisé pour le référencement. Elle n'apparait pas dans le contenu visible de la page.<br /><br />La description peut être une phrase contenant une brève explication de la page.<br /><br /><i>Exemple de description :</i><br /> Retrouvez les restaurants proposants une cuisine asiatique." /></td>
	<td><?php create_form_input('catcredesc', 'textarea3', $errors, 40, 30);?></td>
</tr>
</table>
<br />
<div align="center">
	<input type="submit" name="submit" id="submit" value="Créer la catégorie" />
	<input type="hidden" name="catcre" value="TRUE" />
	</form>
	</fieldset>';
	<?php
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	?>
