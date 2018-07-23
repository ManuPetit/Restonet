<?php
//			presta_ident.php
//			permet la modification de certains details
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'form.php';
$errors = array();

//verifier presta logged in
Prestataire::CheckLoggedPresta();

//retrouver les détails du prestataire
$presta = new Prestataire();
$presta -> GetPrestaParID($_SESSION['prestaid']);

$page_title = 'Modifier mes détails';
include INCLUDE_DIR . 'prestahead.php';

echo '<h2>Modifier mes détails</h2>';

//verification des données
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['submited']))) {
	//flag de changement
	$flag = FALSE;
	//verif identifiant
	if (trim($_POST['ident']) != $presta -> GetPrestaPseudo()) {
		$resp = $presta -> SetPrestaPseudo($_POST['ident']);
		$flag = TRUE;
		if (!is_null($reps)) {
			$errors['ident'] = $resp;
		}
	}
	//verif téléphone
	if (trim($_POST['tel']) != $presta -> GetPrestaTelephone()) {
		$resp = $presta -> SetPrestaTelephone($_POST['tel']);
		$flag = TRUE;
		if (!is_null($resp)) {
			$errors['tel'] = $resp;
		}
	}
	//verif email
	if (trim($_POST['email']) != $presta -> GetPrestaEmail()) {
		$resp = $presta -> SetPrestaEmail($_POST['email']);
		$flag = TRUE;
		if (!is_null($resp)) {
			$errors['email'] = $resp;
		}
	}

	//si pas d'erreur
	if (empty($errors)) {
		//pas de changement
		if ($flag == FALSE) {
			echo '<p>Aucun de vos détails n\'a été modifié dans la base de données.</p>';
		} else {
			$presta -> UpdatePrestaDetailParPrestataire();
			echo '<p>Vos modifications ont été ajoutées la base de données.</p>';
		}
		include INCLUDE_DIR . 'prestafooter.php';
		exit();
	}
}

//creation de la forme
echo '<p>Vous ne pouvez modifier que les détails suivants. Pour tout autre détails, veuillez contacter l\'administrateur du site RESTOnet.</p>
<fieldset><legend>Modifier vos détails : </legend>
<table width="90%" border="0" cellpadding="5" cellspacing="0" align="center">
<form action="presta_ident.php" method="post" accept-charset="utf-8">
<tr valign="top">
<td width="40%" align="right"><label for="ident"><strong>Mon identifiant de connexion :</strong></td>
<td width="20px" align="center"><img src="../images/css/blueinfo.jpg" width="16" height="16" border="0" title="L\'identifiant est nécessaire pour vous connecter à votre tableau de bord. Il doit avoir entre 3 et 25 caractères alpha-numériques." /></td>
<td>';
create_form_edit('ident', 'text', $errors, 30, 25, $presta -> GetPrestaPseudo());
echo '</td></tr>
<tr valign="top">
<td width="40%" align="right"><label for="tel"><strong>Numéro de téléphone :</strong></td>
<td width="20px" align="center"><img src="../images/css/blueinfo.jpg" width="16" height="16" border="0" title="Entrez le numéro de téléphone de votre établissement sans espace." /></td>
<td>';
create_form_edit('tel', 'text', $errors, 30, 10, $presta -> GetPrestaTelephone());
echo '</td></tr>
<tr valign="top">
<td width="40%" align="right"><label for="email"><strong>Mon adresse email :</strong></td>
<td width="20px" align="center"><img src="../images/css/blueinfo.jpg" width="16" height="16" border="0" title="Cette adresse email est nécessaire en cas d\'oubli de votre mot de passe." /></td>
<td>';
create_form_edit('email', 'text', $errors, 50, 80, $presta -> GetPrestaEmail());
echo '</td></tr>
<tr><td colspan="3" align="center"><br /><input type="submit" name="submit" value="Modifier mes données" /><br /><br /></td></tr>
<input type="hidden" value="TRUE" name="submited" />
</form>';

echo '</table>';
include INCLUDE_DIR . 'prestafooter.php';
