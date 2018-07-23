<?php
//		tcom_create_form.php
//		création d'un taux de commission sur le système

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

$page_title = "Création d'un nouveau taux de commission";
include INCLUDE_DIR . 'adminhead.php';

echo '<h2>Création d\'un nouveau taux de commission</h2>';
//variable pour les erreurs
$errors = array();
//script de validation
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['comsub']))) {
	$comm = new Commission();
	$resp = $comm -> SetCommissionNom($_POST['comnom']);
	if (!is_null($resp)) {
		$errors['comnom'] = $resp;
	}
	$resp = $comm -> SetCommissionTaux($_POST['comtaux']);
	if (!is_null($resp)) {
		$errors['comtaux'] = $resp;
	}
	if (empty($errors)) {
		//pas d'erreur on peut créer la commission
		$comm -> AddCommission();
		echo '<p>Vous avez créer avec succès la commission suivante : <b>' . $comm -> GetCommissionNom() . '</b> dans la base de données.</p>';
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	}
}
echo '<p>Indiquez le taux et le nom de la nouvelle commission à créer.</p>';
?>
<fieldset><legend>Entrez les détails de la commission que vous souhaitez ajouter :</legend>
  <form action="tcom_create_form.php" method="post" accept-charset="utf-8">
  	<table border="0" width="90%" cellpadding="5">
      <tr valign="top">
      	<td width="40%" align="right"><label for="comnom"><strong>Description :</strong></label></td>
        <td><?php create_form_input('comnom', 'text', $errors, 40, 60);?><br /><small>Ce nom apparaitra sur le système lors de la création de prestataires</small></td>
       </tr>
      <tr valign="top">
        <td width="40%" align="right"><label for="comtaux"><strong>Taux de commission :</strong></label></td>
        <td><?php create_form_input('comtaux', 'text', $errors, 6, 15);?><br /><small>Ne tapez pas le signe &laquo;<b>%</b>&raquo; dans la boite de taux</small></td>
      </tr>
     </table>
     <br />
     <div align="center"><input type="submit" id="submit" name="submit" value="Créer taux de commission" /></div>
     <input type="hidden" name="comsub" value="TRUE" />
</form>
</fieldset>
<?php
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>