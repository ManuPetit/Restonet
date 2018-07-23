<?php
//		plat_modif_form.php
//fichier de création de plats

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'cls_plat.php';
require_once BUSINESS_DIR . 'form.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Modification d'un plat";

//liste prestataire
$presta = array();
$presta = Prestataire::GetAllPrestaNomID();
//erreurs variable
$errors = array();
//array pour tva
$tva = array();
$tva = Plat::GetTvaListe();
//array type de plats
$type = array();
$type = Plat::GetTypePlatList();


if ((isset($_POST['subplat'])) && ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['plat'])) && ($_POST['plat'] > 0)) {
	$pid = $_POST['plat'];
}
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['platid'])) && ($_GET['platid'] > 0)) {
	$pid = $_GET['platid'];
}
if ((isset($_POST['platsub'])) && ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['platid'])) && ($_POST['platid'] > 0)) {
	//on a fait des modifs et on va les vérifier
	$pid = $_POST['platid'];
	include 'platcreatecheckmod.php';
}
include INCLUDE_DIR . 'adminhead.php';
if (isset($pid)) {
	//on a un plat on retrouve ces elements
	$plat = new Plat();
	$plat -> GetPlatDetailParID($pid);
	//presenter la page de modification
	echo '<h2>Modification d\'un plat</h2><p>';
	echo '<fieldset>
	<legend>
		Modifiez les détails du plat : ' . $plat -> GetPlatNom();
	echo '</legend>
	<form action="plat_modif_form.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
		<table border="0" width="100%" cellpadding="5">
			<tr valign="top">
				<td width="30%" align="right"><label for="presta"><strong>Nom du prestataire :</strong></label></td>
				<td></td>
				<td><input type="text" value="' . $plat -> GetPrestaNom() . '" readonly="readonly" class="readonly" /></td>';
	echo '<tr valign="top">
				<td width="30%" align="right"><label for="platnom"><strong>Nom du plat :</strong></label></td>
				<td></td>
				<td>';
	create_form_edit('platnom', 'text', $errors, 70, 120, $plat -> GetPlatNom());
	echo '</td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="desc"><strong>Description :</strong></label></td>
				<td></td>
				<td>';
	create_form_edit('desc', 'textarea', $errors, 40, 10000, $plat -> GetPlatDescription());
	echo '<br>
				<small>(optionnel)</small></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="prix"><strong>Prix normal du plat :</strong></label></td>
				<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Prix : </b><br />Entrez seulement le prix, <b>sans</b> le signe l\'Euro." /></td>
				<td>';
	create_form_edit('prix', 'text', $errors, 10, 10, $plat -> GetPlatPrix());
	echo '</td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="promo"><strong>Prix promotionnel du plat :</strong></label></td>
				<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Prix : </b><br />Entrez seulement le prix, <b>sans</b> le signe l\'Euro.<br />Ce prix est optionnel." /></td>
				<td>';
	create_form_edit('promo', 'text', $errors, 10, 10, $plat -> GetPlatPrixPromo());
	echo '<br>
				<small>(optionnel)</small></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="tva"><strong>Taux de T.V.A. :</strong></label></td>
				<td></td>
				<td>
				<select name="tva">';

	for ($i = 0; $i < count($tva); $i++) {
		echo '<option value="' . $tva[$i]['tvaID'] . '"';
		if (isset($_POST['tva'])) {
			if ($_POST['tva'] == $tva[$i]['tvaID']) {
				echo ' selected="selected"';
			}
		} elseif ($plat -> GetTvaID() == $tva[$i]['tvaID']) {
			echo ' selected="selected"';
		}
		echo '>' . $tva[$i]['tvaNom'] . '</option>';
	}
	echo '</select></td>
			</tr>
			<tr valign="top">
				<td width="40%" align="right"><label for="actif"><strong>Plat activé :</strong></label></td>
				<td></td>
				<td>
				<select name="actif" id="actif">';
	if (isset($_POST['actif'])) {
		if ($_POST['actif'] == 1) {
			echo '<option value="1" selected="selected">Oui</option>
					<option value="0">Non</option>';
		} else {
			echo '<option value="1">Oui</option>
					<option value="0" selected="selected">Non</option>';
		}
	} else {
		if ($plat -> GetPlatActif() == 1) {
			echo '<option value="1" selected="selected">Oui</option>
					<option value="0">Non</option>';
		} else {
			echo '<option value="1">Oui</option>
					<option value="0" selected="selected">Non</option>';
		}
	}
	echo '</select></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="type"><strong>Type de plat :</strong></label></td>
				<td></td>
				<td>
				<select name="type">';
	for ($i = 0; $i < count($type); $i++) {
		echo '<option value="' . $type[$i]['typePlatID'] . '"';
		if (isset($_POST['type'])) {
			if ($_POST['type'] == $type[$i]['typePlatID']) {
				echo ' selected="selected"';
			}
		} elseif ($plat -> GetTypePlat() == $type[$i]['typePlatID']) {
			echo ' selected="selected"';
		}
		echo '>' . $type[$i]['typePlatNom'] . '</option>';
	}
	echo '</select></td>
			</tr>
			<tr valign="top">
				<td align="right" width="40%"><label for="img"><strong>Fichier image &agrave; t&eacute;l&eacute;charger :</strong></label></td>
				<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Image : </b><br />L\'ajout d\'une image est falcutatif.<br />Les fichiers acceptés sont de type *.gif et *.jpg.<br />La taille maximum du fichier est de 5Mo.<br />Le fichier sera automatiquement mis à l\'échelle pour être inclus dans le site internet." /></td>
				<td>';
	echo '<input type="file" size="50" name="img" id="img"';
	if (array_key_exists('img', $errors)) {
		echo ' class="error" /><span class="error">' . $errors['img'] . '</span>';
	} else {
		echo ' />';
		if (isset($_SESSION['img'])) {
			echo "<br />Actuellement '" . $_SESSION['img']['file_name'] . "'";
		}
	}

	echo '<br /><small>(optionnel)</small>
<br />
<small>Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo.</small>';
	if (($plat -> GetPlatImage() != '') && (!isset($_SESSION['img']))) {
		echo '<p>L\'image actuelle est la suivante :</p><p><img src="';
		echo '../images/plat/' . $plat -> GetPlatImage();
		echo '" title="image représentant ' . $plat -> GetPlatNom() . ' sur le site RESTOnet" border="0" alt="image représentant ' . $plat -> GetPlatNom();
		echo ' sur le site RESTOnet" /></p>';
	}
	echo '</td>
</tr>
</table>
<div align="center">';
	echo '<input type="submit" name="platcreer" id="platcreer" value="Modifier le plat" />
		</div>
		<input type="hidden" name="platsub" value="TRUE"  />
		<input type="hidden" name="platid" value="' . $pid . '" />
			</form>
</fieldset>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
?>
<h2>Modification d'un plat</h2>
<p>
	Selectionnez le prestataire dont vous voulez modifier le plat :
</p>
<fieldset>
	<legend>
		Plat à modifier :
	</legend>
	<form id="delplat" action="plat_modif_form.php" method="post" accept-charset="utf-8">
		<table width="100%" cellpadding="5px">
			<tr valign="top">
				<td width ="25%" align="right"><strong>Prestataire : </strong></td>
				<td>
				<select name="presta" id="presta">
					<option value="">Choisissez un prestataire</option>
					<?php
					for ($i = 0; $i < count($presta); $i++) {
						echo '<option value="' . $presta[$i]['prestaID'] . '">' . $presta[$i]['prestaNom'] . '</option>';
					}
					?>
				</select></td>
			</tr>
			<tr valign="top">
				<td width ="25%" align="right"><strong>Plat : </strong></td>
				<td id="plat">Veuillez d'abord choisir un prestataire</td>
			</tr>
		</table>
		<div align="center">
			<input type="submit" name="submit" value="Modifier ce plat" />
		</div>
		<input type="hidden" name="subplat" value="TRUE"/>
	</form>
</fieldset>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?> 