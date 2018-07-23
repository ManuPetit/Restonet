<?php
//		tva_create_form.php
//		création d'un taux de TVA les taux de tva sur le système

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

$page_title = "Création d'un nouveau taux de T.V.A.";
include INCLUDE_DIR . 'adminhead.php';

echo '<h2>Création d\'un nouveau taux de T.V.A.</h2>';
//variable pour les erreurs
$errors = array();

//script de validation
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['tvasub']))) {
	$tva = new Tva();
	$resp = $tva -> SetTvaTaux($_POST['tvataux']);
	if (is_null($resp)) {
		//pas d'erreur on crée la nouvelle tva
		$tva -> AddTva();
		echo '<p>Vous avez créer avec succès la T.V.A. suivante : <b>' . $tva -> GetTvaNom() . '</b> dans la base de données.</p>';

		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	} else {
		$errors['tvataux'] = $resp;
	}
}
echo '<p>Indiquez le taux de la nouvelle T.V.A. à créer.</p>';
?>
<fieldset><legend>Entrez le nouveau de T.V.A. que vous souhaitez ajouter :</legend>
  <form action="tva_create_form.php" method="post" accept-charset="utf-8">
  	<table border="0" width="90%" cellpadding="5">
      <tr valign="top">
        <td width="40%" align="right"><label for="tvataux"><strong>Taux de T.V.A. :</strong></label></td>
        <td><?php create_form_input('tvataux', 'text', $errors, 6, 15);?><br /><small>Ne tapez pas le signe &laquo;<b>%</b>&raquo; dans la boite de taux</small></td>
      </tr>
     </table>
     <br />
     <div align="center"><input type="submit" id="submit" name="submit" value="Créer taux de T.V.A." /></div>
     <input type="hidden" name="tvasub" value="TRUE" />
</form>
</fieldset>
<?php
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>