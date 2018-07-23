<?php
//		preslist.php
//		permet l'affichage alphabétique de tous les prestataires

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$page_title = "Nos prestataires - RESTOnet";
$menu = 'm8';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);
?>
<!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//afficher le panier
	include BUSINESS_DIR . 'show_cart.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Nos prestataires</h1>
	
<?php
	include INCLUDE_DIR . 'openboxfront.php';
	echo '<form action="preslist.php" method="post">';
	echo '<p></p><fieldset><legend>Choisissez le type de liste</legend>
	<p><b>Type de sélection : </b><select name="liste">
	<option value="lista">Liste des prestataires par nom des établissements</option>
	<option value="listb">Liste des prestataires par ville</option>
	</select></p>
	<br />
	<div align="center"><input type="submit" name="submit" value="Voir la liste des prestataires" /></div><br /></fieldset>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>';
	include INCLUDE_DIR . 'closeboxfront.php';
	
echo '</div>';

DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>