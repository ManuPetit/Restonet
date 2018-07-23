<?php
//		plat_delete_form.php
//		permet de detruire un plat du fichier

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

$page_title = "Suppression de plats";
include INCLUDE_DIR . 'adminhead.php';

$presta = array();
$presta = Prestataire::GetAllPrestaNomID();
if (empty($presta)) {
	echo '<h2>Suppression de plats</h2><p>Il n\'y a aucun prestataire dans la base de données.</p><p>Vous ne pouvez donc pas supprimer de plat</p>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
if ((isset($_POST['subplat'])) && ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['plat'])) && ($_POST['plat'] > 0)) {
	$pid = $_POST['plat'];
}
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['platid'])) && ($_GET['platid'] > 0)) {
	$pid = $_GET['platid'];
}
if (isset($pid)) {
	$nom = Plat::GetPlatParID($pid);
	Plat::DeletePlatParID($pid);
	echo '<h2>Suppression de plats</h2><p>Le plat <b>' . $nom . '</b> a été supprimé de la base de données avec succès.</p>';
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
?>
<h2>Suppression de plats</h2>
<p>
	Selectionnez le prestataire dont vous voulez supprimer des plats :
</p>
<fieldset>
	<legend>
		Plat à supprimer :
	</legend>
	<form id="delplat" action="plat_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm('Etes-vous certains de vouloir supprimer ce plat ?')) return true; else return false;">
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
			<input type="submit" name="submit" value="Supprimer le plat" />
		</div>
		<input type="hidden" name="subplat" value="TRUE"/>
	</form>
</fieldset>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?> 