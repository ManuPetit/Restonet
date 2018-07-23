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
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'cls_plat.php';
require_once BUSINESS_DIR . 'form.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();

$page_title = "Suppression de plats";
include INCLUDE_DIR . 'prestahead.php';
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
	include INCLUDE_DIR . 'prestafooter.php';
	exit();
}
//retrouvez la liste des plats du prestataire
$lesPlats = Plat::GetPlatParPrestaID($_SESSION['prestaid']);
if (empty($lesPlats)) {
	echo "<h2>Suppression de plats</h2>
<p>
	Vous n'avez aucun plat à suprrimer.
</p>";
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'prestafooter.php';
	exit();
}
?>
<h2>Suppression de plats</h2>
<fieldset>
	<legend>
		Plat à supprimer :
	</legend>
	<form id="delplat" action="plat_delete_form.php" method="post" accept-charset="utf-8" onSubmit="if(confirm('Etes-vous certains de vouloir supprimer ce plat ?')) return true; else return false;">
		<table width="100%" cellpadding="5px">
			<tr valign="top">
				<td width ="25%" align="right"><strong>Plats : </strong></td>
				<td>
				<select name="plat">
					<option value="">Choisissez un plat</option>
					<?php
					for ($i = 0; $i < count($lesPlats); $i++) {
						echo '<option value="' . $lesPlats[$i]['platID'] . '">' . $lesPlats[$i]['platNom'] . '</option>';
					}
					?>
				</select></td>
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
include INCLUDE_DIR . 'prestafooter.php';
?> 