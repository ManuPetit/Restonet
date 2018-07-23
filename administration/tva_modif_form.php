<?php
//		tva_modif_form.php
//		modification d'un taux de TVA les taux de tva sur le système

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

$page_title = "Modification d'un taux de T.V.A.";
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
	} else {
		echo '<p>Veuilez choisir le taux de T.V.A. à modifier :</p>';
		echo '<fieldset><legend>Catégorie : </legend>
			<form action="tva_modif_form.php" method="post" accept-charset="utf-8">
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

	//variable pour les erreurs
	$errors = array();
	if (isset($_POST['tvasub'])) {
		//on verifie le taux
		$flag = false;
		if ($_POST['tvataux'] != $tva -> GetTvaTaux()) {
			$resp = $tva -> SetTvaTaux($_POST['tvataux']);
			if (!is_null($resp)) {
				$errors['tvataux'] = $resp;
			} else {
				$flag = true;
			}
		}
		if (empty($errors)) {
			if ($flag == FALSE) {
				echo '<h2>Modification d\'un taux de T.V.A. existant</h2>
				<p>
				Aucun changement n\'a été fait à la base de données.
				</p>
				';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'adminfooter.php';
				exit();
			} else {
				$tva -> UpdateTva();
				echo '<h2>Modification d\'un taux de T.V.A. existant</h2>
				<p>
				Le changement a été enregistré dans la base de données.
				</p>
				';
				DatabaseHandler::Close();
				include INCLUDE_DIR . 'adminfooter.php';
				exit();
			}
		}

	}
}
			?>
<h2>Modification d'un taux de T.V.A. existant</h2>
<fieldset><legend>Indiquez le nouveau taux de T.V.A.</legend>
	 <form action="tva_modif_form.php" method="post" accept-charset="utf-8">
  	<table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="tvataux"><strong>Taux de T.V.A. :</strong></label></td>
        <td><?php create_form_edit('tvataux', 'text', $errors, 6, 15, $tva -> GetTvaTaux());?><br /><small>Ne tapez pas le signe &laquo;<b>%</b>&raquo; dans la boite de taux</small></td>
      </tr>
     </table>
     <br />
     <div align="center"><input type="submit" id="submit" name="submit" value="Modifier taux de T.V.A." /></div>
     <input type="hidden" name="tvasub" value="TRUE" />
     <input type="hidden" name="tvaid" value="<?php
	if (isset($id))
		echo $id;
?>" />
</form>
</fieldset> <?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>