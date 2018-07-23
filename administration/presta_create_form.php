<?php
//		presta_create_form.php

//		fichier pour la création d'un nouvel administrateur

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'cls_categorie.php';
require_once BUSINESS_DIR . 'cls_commission.php';
require_once BUSINESS_DIR . 'form.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();

$page_title = "Création d'un prestataire";
include INCLUDE_DIR . 'adminhead.php';

//variable pour les erreurs
$errors = array();
$errmain=array();
//retrouver les differentes commission
$comm = array();
$comm = Commission::GetAllCommissionListe();
//retrouver les differentes valeurs d'affichage
$valeur = array();
$valeur = DatabaseHandler::GetAll('CALL get_all_valeur()');
//creer les valeurs de délai commande
$delai = array(0 => array('id' => '00:15:00', 'temps' => '00h15'), 1 => array('id' => '00:30:00', 'temps' => '00h30'), 2 => array('id' => '00:45:00', 'temps' => '00h45'), 3 => array('id' => '01:00:00', 'temps' => '01h00'), 4 => array('id' => '01:15:00', 'temps' => '01h15'), 5 => array('id' => '01:30:00', 'temps' => '01h30'), 6 => array('id' => '01:45:00', 'temps' => '01h45'), 7 => array('id' => '02:00:00', 'temps' => '02h00'), 8 => array('id' => '02:15:00', 'temps' => '02h15'), 9 => array('id' => '02:30:00', 'temps' => '02h30'), 10 => array('id' => '02:45:00', 'temps' => '02h45'), 11 => array('id' => '03:00:00', 'temps' => '03h00'));
//retrouver les categorie
$categ=array();
$categ=Categorie::GetCategorieDetail();
//pas de prestataire, on ne peut pas continuer
if (empty($categ)) {
	echo '<h2>Création d\'un nouveau prestataire</h2>';
	echo '<p>Il n\'y a aucune catégorie de restaurant dans la base de données. Vous ne pouvez pas encore créer de prestataire.<br /><br />Créer d\'abord vos catégories, puis revenez ici pour entrer vos plats.</p>';
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
	exit();
}
//retrouver les types de livraisons
$livrais=array();
$livrais=DatabaseHandler::GetAll('CALL get_all_livraison()');
//retrouver les plages horaires
$heure=array();
$heure=DatabaseHandler::GetAll('CALL get_all_plageheure()');
/*
echo '<pre>';
print_r($heure);
echo  '</pre>';
exit();
 */
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['prestasub'])))
{
	$npresta = new Prestataire();
	include 'prestatab1check.php';
	include 'prestatab2check.php';
	include 'prestatab34check.php';
	include 'prestatab5check.php';
	if(empty($errors)){
		//pas d'erreur on peut donc sauvegarder
		$mdpasse=MotDePasse::MakePassword(12);
		$npresta->SetPrestaMotDePasse($mdpasse);
		$npresta->SavePrestaDetails();
		$rowh = $npresta->RetourneListeHoraire();
		//récapitulatif
		$message = '<h1>Bienvenue sur RESTOnet</h1>
		<p>Vous trouverez ci-après les détails dont vous aurez besoin pour vous connecter à l\'interface prestataire de RESTOnet.</p>
		<p><b>Votre nom :</b> ' . $npresta->GetPrestaNom();
		$message .= '<br /><b>Votre prénom :</b> ' . $npresta->GetPrestaPrenom();
		$message .= '<br /><b>Votre enseigne commercial :</b> ' . $npresta->GetPrestaNomCommercial();
		$message .= '<br /><b>Identenfiant de connexion :</b> ' . $npresta->GetPrestaPseudo();
		$message .= '<br /><b>Mot de passe de connexion :</b> ' . $mdpasse . '<br />(il est recommandé de changer ce mot de passe lors de votre première connexion à RESTOnet)';
		$message .= '<br /><b>Votre adresse email :</b> ' . $npresta->GetPrestaEmail();
		if (!is_null($rowh)){
			$message .= '<br /><b>Vos horaires d\'ouverture :</b><ul>';
			foreach($rowh as $val){
				$message .= '<li>' . $val .'</li>';
			}
			$message .= '</ul>';
		}
		$message .= '</p><p>Vous pouvez modifier tous vos détails une fois connecté à l\'interface prestataire de RESTOnet en allant dans le menu &laquo;Mon profil&raquo;.</p>
		<p>Bienvenue dans le réseau RESTOnet,<br />Laetitia</p>';
		//creation fichiers pour envoi email
		$filtext = ADMIN_DIR . 'temp/text'.$mdpasse . '.log';
		$filmail = ADMIN_DIR . 'temp/mail'.$mdpasse . '.log';
		$fh=fopen($filtext, 'w');
		fwrite($fh, $message);
		fclose($fh);
		$fe=fopen($filmail, 'w');
		fwrite($fe, $npresta->GetPrestaEmail());
		fclose($fe);
		//affichage
		echo '<h2>Creation d\'un nouveau prestataire</h2><p>La création du nouveau prestataire est terminée.</p><p>Voici ses détails :</p>';
		echo '<fieldset><div id="selecttoprint">';
		//message sur page web
		echo $message .	'</div></fieldset><p />';
		//bouton d'action
		echo '<div id="print_button" title="Cliquez ic pour imprimer ce document à transmettre au nouveau prestataire.">Imprimer</div>&nbsp;&nbsp;
		<a href="send_mail.php?m='.$mdpasse.'" class="isbutton">Envoyer email</a><div style="display: none;" id="loading"><img src="../images/css/loading.gif" /> <font color="#FF0000">Envoi en cours...</font></div>
		<div style="display: none;" id="message-sent"><font color="#000000">Message envoyé !</font></div>';
		//remise à zéro des fichiers
		$_POST = array();
		$_FILES = array();
		unset($file,$_SESSION['img']);
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		exit();
	}
}

?>
<h2>Création d'un prestataire</h2>
<p>Entrez les détails de votre prestataire</p>
<?php
if (!empty($errmain)){
	echo '<p><b>Attention : <b>il y a des erreurs aux onglets suivants :<ul>';
	foreach ($errmain as $value) {
		echo '<li>' . $value . '</li>';
	}
	echo '</ul></p>';
}
?>
<form id="cmxform" method="post" action="presta_create_form.php" accept-charset="utf-8" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<div id="tabs" style="overflow:hidden;">
	<ul>
		<li><a href="#tabs-1">Identification</a></li>
		<li><a href="#tabs-2">Détails</a></li>
		<li><a href="#tabs-3">Catégorie</a></li>
		<li><a href="#tabs-4">Livraison</a></li>
		<li><a href="#tabs-5">Horaire</a></li>
	</ul>
	<?php
	include 'prestatab1.php';
	include 'prestatab2.php';
	include 'prestatab3.php';
	include 'prestatab4.php';
	include 'prestatab5.php';
	?>	

</div>
<?php
	//fermer la database
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'adminfooter.php';
?>
