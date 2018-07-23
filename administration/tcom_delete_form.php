<?php
//		tcom_delete_form.php
//		suppression d'un taux de commission sur le système

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_commission.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Suppression d'un taux de commission";
include INCLUDE_DIR . 'adminhead.php';

//on recupère le numéro si on vient de la page cat_liste_form.php
if ((isset($_GET['tcomid'])) && (is_numeric($_GET['tcomid']))) {
	if ($_GET['tcomid'] > 0) {
		$id = (int)$_GET['tcomid'];
		$comm = new Commission();
		$comm -> GetCommissionParID($id);
	}
}
//on recupère le numéro si on vient de la page cat_delete_form.php
if ((isset($_POST['tcomid'])) && (is_numeric($_POST['tcomid']))) {
	if ($_POST['tcomid'] > 0) {
		$id = (int)$_POST['tcomid'];
		$comm = new Commission();
		$comm -> GetCommissionParID($id);
	}
}

//on verifie que l'on a récuperer quelquechose
if (!isset($comm)) {
	echo '<h2>Liste des taux de commission</h2>';
	//on n'a pas de commission on propose la liste
	$rows = Commission::GetAllCommissionListe();
	if (empty($rows)) {
		echo '<p>Il n\'y a aucun taux de commission sur le système.</p>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	} else {
		echo '<p>Veuilez choisir le taux de commission à modifier :</p>';
		echo '<fieldset><legend>Commission : </legend>
			<form action="tcom_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm(\'Etes-vous certains de vouloir supprimer ce taux de commission ?\')) return true; else return false;">
			<select name="tcomid" id="tcomid">			
			<option value="0" selected="selected">Veuillez choisir la commission</option>';
		//afficher les catégories
		for ($i = 0; $i < count($rows); $i++) {
			echo '<option value="' . $rows[$i]['commissionID'] . '">' . $rows[$i]['commissionNom'] . '</option>';
		}
		echo '</select>
			<div align="center"><input type="submit" name="submit" id="submit" value="Choisir cette commission" />
			</form></fieldset>';
	}
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
} else {
	//on a une commission
	$nom = $comm -> GetCommissionNom();
	if ($comm -> IsUsed() == 0) {
		//pas utilisé on peut détruire
		//desctruction de l'objet
		$comm = NULL;
		//détruire l'entrée
		Commission::DeleteCommissionParID($id);
		echo '<h2>' . $page_title . '</h2><p>La <b>' . $nom . '</b> a été supprimé de la base de données.</p>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	} else {

		echo '<h2>' . $page_title . '</h2><p>La <b>' . $nom . '</b> ne peut pas être supprimée de la base de données.</p><p>Les prestataires suivants utilisent ce taux de commission :</p>';
		//message pour reminder
		echo '<h1>***** A IMPLEMENTER !!! *****';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	}
}
