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

$page_title = "Commande annulée - RESTOnet";
$menu = 'm9';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
?>
<!-- COLONNE GAUCHE  -->
<div id="left"></div>
<!-- CONTENU  -->
<div id="right">
	<h1>Transaction annulée</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<p>
		Vous avez souhaité annuler votre commande sur notre banque en ligne.
		<br />
		Veuillez confirmer :
		<table border="0" width="100%">
			<tr>
				<td align="center"><a class="fbutton" href="cancelcmd.php?" title="Cliquez ici pour choisir annuler votre commande" onClick="if(confirm('Etes-vous certain de vouloir annuler votre commande ?')) return true; else return false;">Annuler commande</a><td><td align="center"><a class="fbutton" href="validcmd.php?" title="Cliquez ici pour valider votre commande">Valider commande</a><td>
			</tr>
		</table>
	</p>
	<?php
	include INCLUDE_DIR . 'closeboxfront.php';
	?>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>