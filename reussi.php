<?php
//		reussi.php

//		fichier de retour après validation de la commande

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//verifier que la session est bonne
include BUSINESS_DIR . 'retourcheck.php';

$page_title = "Payement confirmé - RESTOnet";
$menu = 'm9';
include INCLUDE_DIR . 'header.php';
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Paiement confirmé</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<p>
		Votre paiement en ligne a été confirmé :
		<?php
		if (isset($_GET['montant'])) {
			$montant = $_GET['montant'] / 100;
			echo "<br><b>Montant : </b>". sprintf("%01.2f",$montant). "€\n";
		}
		if (isset($_GET['ref'])) {
			echo "<br><b>N° commande : </b>" . $_GET['ref'] . "\n";
		}
		if (isset($_GET['trans'])) {
			echo "<br><b>Transaction : </b>" . $_GET['trans'] . "\n";
		}
		?>
	</p>
	<p>
		Merci de votre commande....<br />Un email de confirmation vous a été envoyé.
	</p>
	<?php
	//vider les variables
	unset($_SESSION['lastpage']);
	unset($_SESSION['lastprestapage']);
	unset($_SESSION['curprestid']);
	unset($_SESSION['livre']);
	unset($_SESSION['date']);
	unset($_SESSION['plage']);
	unset($_SESSION['dateCmd']);
	unset($_SESSION['cmdid']);
	unset($_SESSION['prixTTC']);
	
	include INCLUDE_DIR . 'closeboxfront.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>