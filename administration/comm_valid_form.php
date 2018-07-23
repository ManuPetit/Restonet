<?php
//		comm_valid_form.php

//		fichier pour valider les commentaires

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_commentaire.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Validation des commentaires";
include INCLUDE_DIR . 'adminhead.php';
if ((isset($_POST['validsub'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')){
	if($_POST['actif']==0){
		Commentaire::CommentaireSetNonActif($_POST['commid']);
	}else{
		Commentaire::CommentaireSetActif($_POST['commid']);
	}
	//on change commentaire à lu
	$sql = 'UPDATE prg_commentaire SET comteLu = 1 WHERE comteID = ' . $_POST['commid'];
	DatabaseHandler::Execute($sql);
}
$rows = array();
$rows = Commentaire::GetCommentaireNonLu();
if (!empty($rows)) {
		$sql = 'SELECT COUNT(*) FROM prg_commentaire WHERE comteLu = 0';
		$count = DatabaseHandler::GetOne($sql);
		echo '<h2>Validation des commentaires</h2>';
		echo '<p>Il y a en tout <b>' . $count . ' commentaire';
		if ($count>1){
			echo 's';
		}
		echo '</b> en attente de validation.</p><p>Lisez ce commentaire pour le valider
		<fieldset><legend>Commentaire de <b>' . $rows[0]['clientNom'] . '</b> en date du ' . date("d/m/Y", strtotime($rows[0]['comteDate'])) . '</legend>';
		echo '<p><strong>Enseigne concernée : </strong>' . $rows[0]['prestaNom'] . '</p>';
		echo '<p><strong>Commentaire : </strong><br />' .stripslashes($rows[0]['comteDescription']) . '</p>';
		echo '<form action="comm_valid_form.php" method="post" accept-charset="utf-8">
		<input type="hidden" name="commid" value="' . $rows[0]['comteID'] .'" />';
		echo '<p><strong>Souhaitez vous afficher ce commentaire sur RESTOnet ? <select name="actif"><option value="0" selected="selected">Non</option><option value="1">Oui</option></select>';
		echo '</p><div align="center"><input type="submit" name="submit" value="Valider le commentaire pour ' . $rows[0]['prestaNom'] .'" />
		<input type="hidden" name="validsub" value="TRUE" />';
		echo '</div></form>';
		echo '</fieldset>';
	
} else {
	echo '<h2>Validation des commentaires</h2><p>Il n\'y a aucun commentaire a validé dans la base de données.</p>';
}
//fermer la database
DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
?>
