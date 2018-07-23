<?php
//		annule.php

//		fichier de retour après validation de la commande

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//verifier que la session est bonne
include BUSINESS_DIR . 'retourcheck.php';

$page_title = "Erreur lors de la transaction - RESTOnet";
$menu = 'm9';
include INCLUDE_DIR . 'header.php';
$num_err = $_GET['NUMERR'];
if ($num_err == -1) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : erreur de lecture des param�tres via stin. <br>";
} else if ($num_err == -2) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : erreur d'allocation m�moire. <br>";
} else if ($num_err == -3) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : erreur de lecture des param�tres QUERY_STRING ou CONTENT_LENGTH. <br>";
} else if ($num_err == -4) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_RETOUR, PBX_ANNULE, PBX_REFUSE ou PBX_EFFECTUE sont trop longs (<150 caract�res). <br>";
} else if ($num_err == -5) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : ouverture de fichiers (si PBX_MODE contient 3) : fichier local inexistant, non trouv� ou erreur d'acc�s. <br>";
} else if ($num_err == -6) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : ouverture de fichiers (si PBX_MODE contient 3) : fichier local mal form�, vide ou ligne mal format�e. <br>";
} else if ($num_err == -7) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : Il manque une variable obligatoire. <br>";
} else if ($num_err == -8) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : Une variable num�rique contient un caract�re non num�rique. <br>";
} else if ($num_err == -9) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_SITE contient un num�ro de site qui ne fait pas exactement 7 caract�res. <br>";
} else if ($num_err == -10) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_RANG contient un num�ro de rang qui ne fait pas exactement 2 caract�res. <br>";
} else if ($num_err == -11) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_TOTAL fait plus de 10 ou moins de 3 caract�res num�riques. <br>";
} else if ($num_err == -12) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_LANGUE ou PBX_DEVISE contient un code qui ne fait pas exactement 3 caract�res. <br>";
} else if ($num_err == -16) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_PORTEUR ne contient pas une adresse e-mail valide. <br>";
} else if ($num_err == -17) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_CLE ne contient pas une cl� (mot de passe) valide. <br>";
} else if ($num_err == -18) {
	$meserr = "<center><b><h2>Erreur appel PAYBOX.</h2></center></b><br><br><br> message erreur : PBX_RETOUR : Donn�es � retourner inconnues. <br>";
}

$meserr .= "<b>Num�ro de l'erreur : </b>$num_err\n";
?>
<!-- COLONNE GAUCHE  -->
<div id="left"></div>
<!-- CONTENU  -->
<div id="right">
	<h1>Erreur lors de la transaction</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<p>
		un erreur s'est produite lors de la transaction :
		<?php
		echo $meserr;
		?>
	</p>
	<?php
	include INCLUDE_DIR . 'closeboxfront.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>