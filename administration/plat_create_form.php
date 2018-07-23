<?php
//		plat_create_form.php
//fichier de création de plats

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_plat.php';
require_once BUSINESS_DIR . 'form.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Nouveau plat";

//array pour prestataire
$presta = array();
$presta = Plat::GetPrestataireListe();
//pas de prestataire, on ne peut pas continuer
if (empty($presta)) {
	include INCLUDE_DIR . 'adminhead.php';
	echo '<h2>Création d\'un nouveau plat</h2>';
	echo '<p>Il n\'y a aucun prestataire dans la base de données. Vous ne pouvez pas encore créer de plat.<br /><br />Entrez d\'abord vos prestataires, puis revenez ici pour entrer vos plats.</p>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
//variable pour les erreurs
$errors = array();
//array pour tva
$tva = array();
$tva = Plat::GetTvaListe();
//array type de plats
$type = array();
$type = Plat::GetTypePlatList();
//on vérifie si on submit

if ((isset($_POST['platsub'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	//on a une submission
	include 'platcreatecheck.php';
} else {
	include INCLUDE_DIR . 'adminhead.php';
	echo '<h2>Création d\'un nouveau plat</h2>';
}
if (isset($imgresp)) {
	echo $imgresp;
}
?>

<fieldset>
	<legend>
		Entrez les d&eacute;tails du nouveau plat :
	</legend>
	<form action="plat_create_form.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
		<table border="0" width="100%" cellpadding="5">
			<tr valign="top">
				<td width="30%" align="right"><label for="presta"><strong>Nom du prestataire :</strong></label></td>
				<td></td>
				<td>
				<select name="presta">
					<option value="0">Choisissez un prestataire</option>
					<?php
					for ($i = 0; $i < count($presta); $i++) {
						echo '<option value="' . $presta[$i]['prestaID'] . '"';
						if (isset($_POST['presta'])) {
							if ($_POST['presta'] == $presta[$i]['prestaID']) {
								echo ' selected="selected"';
							}
						}else if (isset($leid)) {
							if ($leid == $presta[$i]['prestaID']) {
								echo ' selected="selected"';
							}
						}
						echo '>' . $presta[$i]['prestaNom'] . '</option>';
					}
					
				echo '</select>';
				if (isset($errors['presta'])){
					echo '<br /><span class="error">'.$errors['presta'].'</span>';
				}
				?>
				</td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="plat"><strong>Nom du plat :</strong></label></td>
				<td></td>
				<td><?php create_form_input('plat', 'text', $errors, 70, 120);?></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="desc"><strong>Description :</strong></label></td>
				<td></td>
				<td><?php create_form_input('desc', 'textarea', $errors, 40, 10000);?>
				<br>
				<small>(optionnel)</small></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="prix"><strong>Prix normal du plat :</strong></label></td>
				<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Prix : </b><br />Entrez seulement le prix, <b>sans</b> le signe l'Euro." /></td>
				<td><?php create_form_input('prix', 'text', $errors, 10, 10);?></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="promo"><strong>Prix promotionnel du plat :</strong></label></td>
				<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Prix : </b><br />Entrez seulement le prix, <b>sans</b> le signe l'Euro.<br />Ce prix est optionnel." /></td>
				<td><?php create_form_input('promo', 'text', $errors, 10, 10);?>
				<br>
				<small>(optionnel)</small></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="tva"><strong>Taux de T.V.A. :</strong></label></td>
				<td></td>
				<td>
				<select name="tva">
					<?php
					for ($i = 0; $i < count($tva); $i++) {
						echo '<option value="' . $tva[$i]['tvaID'] . '"';
						if (isset($_POST['tva'])) {
							if ($_POST['tva'] == $tva[$i]['tvaID']) {
								echo ' selected="selected"';
							}
						}
						echo '>' . $tva[$i]['tvaNom'] . '</option>';
					}
					?>
				</select></td>
			</tr>
			<tr valign="top">
				<td width="40%" align="right"><label for="actif"><strong>Plat activé :</strong></label></td>
				<td></td>
				<td>
				<select name="actif" id="actif">
					<?php
					if (isset($_POST['actif'])) {
						if ($_POST['actif'] == 1) {
							echo '<option value="1" selected="selected">Oui</option>
<option value="0">Non</option>';
						} else {
							echo '<option value="1">Oui</option>
<option value="0" selected="selected">Non</option>';
						}
					} else {
						echo '<option value="1" selected="selected">Oui</option>
<option value="0">Non</option>';
					}
					?>
				</select></td>
			</tr>
			<tr valign="top">
				<td width="30%" align="right"><label for="type"><strong>Type de plat :</strong></label></td>
				<td></td>
				<td>
				<select name="type">
					<?php
					for ($i = 0; $i < count($type); $i++) {
						echo '<option value="' . $type[$i]['typePlatID'] . '"';
						if (isset($_POST['type'])) {
							if ($_POST['type'] == $type[$i]['typePlatID']) {
								echo ' selected="selected"';
							}
						}
						echo '>' . $type[$i]['typePlatNom'] . '</option>';
					}
					?>
				</select></td>
			</tr>
			<tr valign="top">
				<td align="right" width="40%"><label for="img"><strong>Fichier image &agrave; t&eacute;l&eacute;charger :</strong></label></td>
				<td><img src="../images/css/greeninfo.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Image : </b><br />L'ajout d'une image est falcutatif.<br />Les fichiers acceptés sont de type *.gif et *.jpg.<br />La taille maximum du fichier est de 5Mo.<br />Le fichier sera automatiquement mis à l'échelle pour être inclus dans le site internet." /></td>
				<td><?php
				echo '
<input type="file" size="50" name="img" id="img"';
				if (array_key_exists('img', $errors)) {
					echo ' class="error" />
<span class="error">' . $errors['img'] . '</span>';
				} else {
					echo ' />';
					if (isset($_SESSION['img'])) {
						echo "
<br />
Actuellement '" . $_SESSION['img']['file_name'] . "'";
					}
				}
				?>
				<br />
				<small>(optionnel)</small>
				<br />
				<small>Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo.</small></td>
			</tr>
		</table>
		<div align="center">
			<input type="submit" name="platcreer" id="platcreer" value="Créer le plat" />
		</div>
		<input type="hidden" name="platsub" value="TRUE"  />
	</form>
</fieldset>
<?php
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>