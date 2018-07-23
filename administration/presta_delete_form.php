<?php
//		presta_delete_form.php
//		fichier pour modifier un prestataire

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Suppression d'un prestataire";
include INCLUDE_DIR . 'adminhead.php';

//on recupère le numéro si on vient de la page presta_liste_form.php
if ((isset($_GET['prestaid'])) && (is_numeric($_GET['prestaid']))) {
	if ($_GET['prestaid'] > 0) {
		$prestanom = Prestataire::GetNomParID($_GET['prestaid']);
		$id = (int)$_GET['prestaid'];
	}
}
//on recupère le numéro si on vient de la page admin_form_form.php
if ((isset($_POST['prestaid'])) && (is_numeric($_POST['prestaid']))) {
	if ($_POST['prestaid'] > 0) {
		$prestanom = Prestataire::GetNomParID($_POST['prestaid']);
		$id = (int)$_POST['prestaid'];
	}
}
if ((!isset($id)) || (!isset($prestanom))) {
	//on n'a pas de prestataire danc on propose le choix
	echo '<h2>Liste des prestataires</h2>';
	$rows = array();
	$rows = Prestataire::GetAllPrestaNomID();
	if (empty($rows)) {
		echo '<p>Il n\'y a aucun prestataire à supprimer, dans la base de données.</p>';
	} else {
		echo '<p>Veuillez choisir le prestataire à modifier :</p>';
		echo '<fieldset><legend>Prestataire : </legend>
			<form action="presta_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm(\'Etes-vous certains de vouloir supprimer ce prestataire ?\')) return true; else return false;">
			<select name="prestaid" id="prestaid">
			<option value="0" selected="selected">Veuillez choisir un nom</option>';
		for ($i = 0; $i < count($rows); $i++) {
			echo '<option value="' . $rows[$i]['prestaID'] . '">' . $rows[$i]['prestaNom'] . '</option>';
		}
		echo '</select>
			<br />
			<div align="center"><input type="submit" name="submit" id="submit" value="Choisir ce prestataire" /></div>
			</form>
			</fieldset>';
	}
} else {
	Prestataire::DeletePrestataire($id);
	echo '<h2>' . $page_title . '</h2>
	<p>Le prestataire : <b>' . $prestanom . '</b> a bien été supprimmé de la base de données.<br />Toutes les données relatives à ce prestataire (plats, commentaire, etc) ont également été suprrimées.</p>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>