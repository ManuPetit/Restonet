<?php
//fichier pour faire test sur database

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
//require_once BUSINESS_DIR . 'cls_local.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';
require_once BUSINESS_DIR . 'fonctions.php';

$page_title = "Bienvenue sur RESTOnet";
$menu = 'm1';
include INCLUDE_DIR . 'header.php';
?><!-- COLONNE GAUCHE  -->
<div id="left">
	<?php
	//affiche la carte france
	include BUSINESS_DIR . 'francemap.php';
	?>
</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Bienvenue sur RESTOnet</h1>
	<?php
	include INCLUDE_DIR . 'openboxfront.php';
	?>
	<p>
		Bienvenue sur notre site. Vous allez pouvoir découvrir de nombreux restaurateurs qui vous proposeront de commander leurs plats.
	</p>
	<p>
		Vous pourrez soit aller manger dans leur établissement, aller chercher le plat ou vous faire livrer.
	</p>
	<?php
	include INCLUDE_DIR . 'closeboxfront.php';
	?>

	<h1>A découvrir...</h1>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?php
		echo '<tr><td class="topleft"></td><td class="topmid"></td><td class="topright"></td><td width="10px"></td><td class="topleft"></td><td class="topmid"></td><td class="topright"></td></tr>';
		echo '<tr><td class="midleft"></td><td class="midmid">';
		$prestaid = 3;
		include BUSINESS_DIR . 'boite_presta_front.php';
		echo '</td><td class="midright"></td><td width="10px"></td><td class="midleft"></td><td class="midmid">';
		$prestaid = 13;
		include BUSINESS_DIR . 'boite_presta_front.php';
		echo '</td><td class="midright"></td></tr><tr><td class="botleft"></td><td class="botmid"></td><td class="botright"></td><td width="10px"></td><td class="botleft"></td><td class="botmid"></td><td class="botright"></td></tr>';
		echo '<tr height="10px"><td colspan="7"></td></tr>';
		echo '<tr><td class="topleft"></td><td class="topmid"></td><td class="topright"></td><td width="10px"></td><td class="topleft"></td><td class="topmid"></td><td class="topright"></td></tr>';
		echo '<tr><td class="midleft"></td><td class="midmid">';
		$prestaid = 9;
		include BUSINESS_DIR . 'boite_presta_front.php';
		echo '</td><td class="midright"></td><td width="10px"></td><td class="midleft"></td><td class="midmid">';
		$prestaid = 10;
		include BUSINESS_DIR . 'boite_presta_front.php';
		echo '</td><td class="midright"></td></tr><tr><td class="botleft"></td><td class="botmid"></td><td class="botright"></td><td width="10px"></td><td class="botleft"></td><td class="botmid"></td><td class="botright"></td></tr>';
		echo '<tr height="10px"><td colspan="7"></td></tr>';
		?>
	</table>
</div>
<?php
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>