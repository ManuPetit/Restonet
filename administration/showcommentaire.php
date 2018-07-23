<?php
//		showcommentaire.php
//		affiche un commentaire
//		comm_liste_form.php

//		fichier pour voir la liste de tous les commentaires

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

if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['commid']))) {
	//retrouver le commentaire
	$comm = new Commentaire();
	$comm -> GetCommentaireParID($_GET['commid']);
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['commid']))) {
	$comm = new Commentaire();
	$comm -> GetCommentaireParID($_POST['commid']);
	if ($_POST['actif'] != $comm -> GetCommentaireActif()) {
		//on change la valeur actif du commentaire
		$comm -> SetCommentaireActif($_POST['actif']);
		//on update la base de donnees
		if ($_POST['actif'] == 0) {
			Commentaire::CommentaireSetNonActif($_POST['commid']);
		} else {
			Commentaire::CommentaireSetActif($_POST['commid']);
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php
		if ((isset($comm)) && (!empty($comm))) {
			echo 'Commentaire';
		} else {
			echo 'Erreur';
		}
			?></title>
	</head>
	<body style="background-color:#000;color:#FFF;">
		<?php
		if ((isset($comm)) && (!empty($comm))) {
			echo '<strong>Commentaire de </strong>' . $comm -> GetClientNom() . ' du ' . $comm -> GetCommentaireDate();
			echo '<br /><strong>Enseigne : </strong>' . $comm -> GetPrestaNom();
			echo '<p>&laquo; ' . stripslashes($comm -> GetCommentaire()) . ' &raquo</p>';
			if ($comm -> GetCommentaireLu() == 0) {
				echo '<form action="showcommentaire.php" method="post" accept-charset="utf-8">
<input type="hidden" value="' . $comm -> GetCommentaireID() . '" name="commid" />';
				echo '<label>Souhaitez vous rendre ce commentaire visible sur RESTOnet ?</label>
&nbsp;&nbsp;<select name="actif"><option value="0">Non</option><option value="1">Oui</option></select>
<br /><br /><input type="submit" name="submit" value="Soumettre activation" />
</form>';
			}
			echo '<br /><input name="button" type="button" onclick="javascript:self.close();" value="Fermer la fenêtre" />';
			//on considère que le commentaire a été  lu même si il n'a pas été validé
			$comm -> SetCommentaireLu(1);
			//on met à jour la base de données
			$sql = 'UPDATE prg_commentaire SET comteLu = 1 WHERE comteID = ' . $comm -> GetCommentaireID();
			DatabaseHandler::Execute($sql);
		} else {
			echo 'Une erreur s\'est produite<br /><br /><input name="button" type="button" onclick="javascript:self.close();" value="Fermer" />';
		}
		DatabaseHandler::Close();
		?>
	</body>
</html>
