<?php
//		cat_delete_form.php

//		fichier pour supprimer catégorie

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

$page_title = "Suppression d'une catégorie";
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
if (isset($cat)) {
	//on a une catégorie
	$nom = $cat -> GetCatNom();
	if ($cat -> IsUsed() == 0) {
		//elle n'est pas joint à des prestataires
		//on detruit la variable
		$cat = NULL;
		//detruire la catégorie
		Categorie::DeleteCategorie($id);
		echo '<h2>' . $page_title . '</h2><p>La catégorie <b>' . $nom . '</b> a été supprimée de la base de données.</p>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	} else {
		echo '<h2>' . $page_title . '</h2><p>La catégorie <b>' . $nom . '</b> ne peut pas être supprimée de la base de données.</p><p>Les prestataires suivants sont reliés à cette catégorie :</p>';
		//message pour reminder
		echo '<h1>***** A IMPLEMENTER !!! *****';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	}
} else {
	//on n'a pas de catégorie donc on fait faire un choix
	echo '<h2>Liste des catégories de restaurant</h2>';
	$rows = Categorie::GetCategorieDetail();
	if (empty($rows)) {
		echo '<p>Il n\'y a aucune catégorie à supprimer.</p>';
	} else {
		echo '<p>Veuilez choisir la catégorie à supprimer :</p>';
		echo '<fieldset><legend>Catégorie : </legend>
			<form action="cat_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm(\'Etes-vous certains de vouloir supprimer cette catégorie ?\')) return true; else return false;">
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
}
