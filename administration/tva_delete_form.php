<?php
//		tva_delete_form.php
//		suppression d'un taux de TVA les taux de tva sur le système

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_tva.php';
require_once BUSINESS_DIR . 'form.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Suppression d'un taux de T.V.A.";
include INCLUDE_DIR . 'adminhead.php';

//on recupère le numéro si on vient de la page cat_liste_form.php
if ((isset($_GET['tvaid'])) && (is_numeric($_GET['tvaid']))) {
	if ($_GET['tvaid'] > 0) {
		$id = (int)$_GET['tvaid'];
		$tva = new Tva();
		$tva -> GetTvaParID($id);
	}
}
//on recupère le numéro si on vient de la page cat_delete_form.php
if ((isset($_POST['tvaid'])) && (is_numeric($_POST['tvaid']))) {
	if ($_POST['tvaid'] > 0) {
		$id = (int)$_POST['tvaid'];
		$tva = new Tva();
		$tva -> GetTvaParID($id);
	}
}

//on verifie que l'on a récuperer quelquechose
if (!isset($tva)) {
	echo '<h2>Liste des taux de T.V.A.</h2>';
	//on n'a pas de tva on propose la liste
	$rows = Tva::GetTvaListe();
	if (empty($rows)) {
		echo '<p>Il n\'y a aucun taux de T.V.A. sur le système.</p>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	} else {
		echo '<p>Veuilez choisir le taux de T.V.A. à modifier :</p>';
		echo '<fieldset><legend>T.V.A. : </legend>
			<form action="tva_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm(\'Etes-vous certains de vouloir supprimer ce taux de T.V.A. ?\')) return true; else return false;">
			<select name="tvaid" id="tva">			
			<option value="0" selected="selected">Veuillez choisir le taux</option>';
		//afficher les catégories
		for ($i = 0; $i < count($rows); $i++) {
			echo '<option value="' . $rows[$i]['tvaID'] . '">' . $rows[$i]['tvaNom'] . '</option>';
		}
		echo '</select>
			<div align="center"><input type="submit" name="submit" id="submit" value="Choisir ce taux" />
			</form></fieldset>';
	}
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
} else {
	//on a une tva
	if ($tva -> IsUsed() == 0) {
		//pas utilisé on peut détruire
		$nom = $tva -> GetTvaNom();
		//desctruction de tva
		$tva = NULL;
		//détruire l'entrée
		Tva::DeleteTvaParID($id);
		echo '<h2>' . $page_title . '</h2><p>La <b>' . $nom . '</b> a été supprimé de la base de données.</p>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	} else {

		echo '<h2>' . $page_title . '</h2><p>La <b>' . $nom . '</b> ne peut pas être supprimée de la base de données.</p><p>Les plats suivants utilisent cette T.V.A. :</p>';
		//message pour reminder
		echo '<h1>***** A IMPLEMENTER !!! *****';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	}
}
