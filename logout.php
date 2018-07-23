<?php
// 		logout.php
//		permet la deconnexion d'un client
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_login.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Finally, destroy the session.
session_destroy();

$page_title = "Se déconnecter de RESTOnet";
$menu = 'm6';

include INCLUDE_DIR . 'header.php';
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Vous venez de vous déconnecter de RESTOnet.</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<h3 class="boitetitle">Merci de votre visite...</h3><p>A bientôt sur RESTOnet...</p>';
	include INCLUDE_DIR . 'closeboxfront.php';
	echo '</div>';
	DatabaseHandler::Close();
	include INCLUDE_DIR . 'footer.php';
	?>
