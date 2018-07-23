<?php
//		tcom_modif_form.php
//		modification d'un taux de commission sur le système

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_commission.php';
require_once BUSINESS_DIR . 'form.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Modification d'un taux de commission";
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
			<form action="tcom_modif_form.php" method="post" accept-charset="utf-8">
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
	$errors = array();
	echo '<h2>' . $page_title . '</h2>';
	if (isset($_POST['comsub'])) {
		//on valide les données
		$flag = FALSE;
		if ($_POST['comnom'] != $comm -> GetCommissionNom()) {
			$resp = $comm -> SetCommissionNom($_POST['comnom']);
			if (!is_null($resp)) {
				$errors['comnom'] = $resp;
			} else {
				$flag = TRUE;
			}
		}
		if ($_POST['comtaux'] != $comm -> GetCommissionTaux()) {
			$resp = $comm -> SetCommissionTaux($_POST['comtaux']);
			if (!is_null($resp)) {
				$errors['comtaux'] = $resp;
			} else {
				$flag = TRUE;
			}
		}
		//si on a pad d'erreur
		if (empty($errors)) {
			if ($flag == FALSE) {
				//pas de changement
				echo '<p>Aucun changment n\'a été fait dans la base de données.</p>';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'adminfooter.php';
				exit();
			} else {
				//on a des changmeent
				$comm -> UpdateCommission();
				echo '<p>Les modifications ont été enregistrées dans la base de données.</p>';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'adminfooter.php';
				exit();

			}
		}
	}
}
?>
<fieldset><legend>Entrez les détails de la commission que vous souhaitez modifier :</legend>
  <form action="tcom_modif_form.php" method="post" accept-charset="utf-8">
  	<table border="0" width="90%" cellpadding="5">
      <tr valign="top">
      	<td width="40%" align="right"><label for="comnom"><strong>Description :</strong></label></td>
        <td><?php create_form_edit('comnom', 'text', $errors, 40, 60, $comm -> GetCommissionNom());?><br /><small>Ce nom apparaitra sur le système lors de la création de prestataires</small></td>
       </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="comtaux"><strong>Taux de commission :</strong></label></td>
        <td><?php create_form_edit('comtaux', 'text', $errors, 6, 15, $comm -> GetCommissionTaux());?><br /><small>Ne tapez pas le signe &laquo;<b>%</b>&raquo; dans la boite de taux</small></td>
      </tr>
     </table>
     <br />
     <div align="center"><input type="submit" id="submit" name="submit" value="Modifier taux de commission" /></div>
     <input type="hidden" name="comsub" value="TRUE" />
     <input type="hidden" name="tcomid" value="
     <?php
	if (isset($id)) {
		echo $id;
	}
?>
" />
</form>
</fieldset> <?php
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>