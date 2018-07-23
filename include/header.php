<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="styles/restonet.css" rel="stylesheet" type="text/css" />
		<link href="styles/jquery-ui-1.8.16.front.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery/jquery-1.6.4.min.js"></script>
		<script src="jquery/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="jquery/restofront.js"></script>
		<?php
			if (basename($_SERVER['PHP_SELF'])=='reccmd.php'){
				echo '<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />';
			}
		?>
		<title><?php
		//creation du titre
		if (isset($page_title)) {
			echo $page_title;
		} else {
			echo SITE_NAME;
		}
		echo '</title>';
		echo "\n";
		//balise meta
		if (isset($metaKey)) {
			echo '<meta name="keywords" content="' . $metaKey . '"/>';
		} else {
			echo '<meta name="keywords" content="restonet, livraison, repas, restaurant, commande, ligne, online"/>';
		}
		echo "\n";
		if (isset($metaDesc)) {
			echo '<meta name="description" content="' . $metaDesc . '" />';
		} else {
			echo '<meta name="description" content="RESTOnet, le service de restauration en ligne. Choisissez votre restaurant, commandez votre repas et recevez le chez vous. Vous pouvez également prendre votre repas à l\'établissement pour le déguster chez des amis, et bien entendu, manger sur place. Cliquez, Commandez, Mangez..." />';
		}
		echo "\n";
			?>
	</head>
	<body>
		<div id="wrapper">
			<!-- ENTETE -->
			<div id="entete"></div>
			<!-- Navigation -->
			<div id="dolphincontainer">
				<div id="dolphinnav">
					<ul>
						<?php
						//creation du menu
						echo '<li><a href="index.php" title="Bienvenue sur RESTOnet"';
						if ($menu == 'm1')
							echo ' class="current"';
						echo '><span>Accueil</span></a></li>
			<li><a href="prestataire.php" title="Découvrez nos prestataire"';
						if (($menu == 'm2') || ($menu == 'm8'))
							echo ' class="current"';
						echo '><span>Prestataire</span></a></li>
			<li><a href="about.php" title="Pour en savoir plus sur RESTOnet"';
						if ($menu == 'm3')
							echo ' class="current"';
						echo '><span>Qui sommes-nous ?</span></a></li>
			<li><a href="contact.php" title="Comment contacter RESTOnet"';
						if ($menu == 'm4')
							echo ' class="current"';
						echo '><span>Contact</span></a></li>
			<li><a href="voirpanier.php" title="Cliquez ici pour voir le détail des repas que vous avez mis dans votre panier"';
						if ($menu == 'm9')
							echo ' class="current"';
						echo '><span>Mon panier</span></a></li>
			<li>';
						//on change le menu selon le client est connecté ou pas
						if ((isset($_SESSION['userid'])) && (isset($_SESSION['clientid']))) {
							echo '<a href="moncompte.php" title="Changer les détails de mon compte"';
						} else {
							echo '<a href="inscrire.php" title="Inscrivez-vous gratuitement sur RESTOnet"';
						}
						if ($menu == 'm5')
							echo ' class="current"';
						echo '><span>';
						if ((isset($_SESSION['userid'])) && (isset($_SESSION['clientid']))) {
							echo 'Mon Compte</span></a></li>';
						} else {
							echo 'S\'inscrire</span></a></li>';
						}
						if ((isset($_SESSION['userid'])) && (isset($_SESSION['clientid']))) {
							echo '<li><a href="logout.php" title="Déconnectez-vous du site RESTOnet"';
						} else {
							echo '<li><a href="login.php" title="Connectez-vous au site RESTOnet"';
						}
						if ($menu == 'm6')
							echo ' class="current"';
						echo '><span>';
						if ((isset($_SESSION['userid'])) && (isset($_SESSION['clientid']))) {
							echo 'Déconnexion</span></a></li>';
						} else {
							echo 'Se connecter</span></a></li>';
						}
						?>
					</ul>
				</div>
			</div>
