<?php
//		show_menuclient.php
//		permet l'affichage du menu client
//on retrouve le fichier de la page
$lapage = basename($_SERVER['PHP_SELF']);

//variable de texte pour id et classe
$act = ' id="actif"';
$sel = ' class="selecter"';
//debut de l'accordion
echo '<div id="accordion">';
//menu données
echo '<h3';
if (($lapage == 'client_modif.php') || ($lapage == 'client_mdp.php')) {
	echo $act;
}
echo '><a href="#" title="Ce menu gère les données personnelles de mon compte">Mes données personnelles</a></h3>';
echo '<div><a href="client_modif.php"';
if ($lapage == 'client_modif.php') {
	echo $sel;
}
echo ' title="Modifier les informations personnelles de votre compte">Données personnelles</a><br />
	<a href="client_mdp.php"';
if ($lapage == 'client_mdp.php') {
	echo $sel;
}
echo ' title="Changer votre mot de passe personnel">Changer mon mot de passe</a><br />
    </div>';
	
//menu commandes
echo '<h3';
if (($lapage == 'client_cmd.php') ) {
	echo $act;
}
echo '><a href="#" title="Ce menu vous permet de voir toutes vos commandes">Mes commandes</a></h3>';
echo '<div><a href="client_cmd.php"';
if ($lapage == 'client_cmd.php') {
	echo $sel;
}
echo ' title="Visualiser l\'ensemble de vos commandes">Voir mes commandes</a><br />
    </div>';
//menu commentaire
echo '<h3';
if (($lapage == 'client_com.php') || ($lapage == 'client_note.php') || ($lapage == 'client_comm_ger.php')) {
	echo $act;
}
echo '><a href="#" title="Ce menu vous permet de voir vos commentaires et vos notes">Mes notes et commentaires</a></h3>';
echo '<div><a href="client_note.php"';
if ($lapage == 'client_note.php') {
	echo $sel;
}
echo ' title="Attribuez une note à un des prestataires que vous avez utilisé">Noter prestataire</a><br />
	<a href="client_com.php"';
if ($lapage == 'client_com.php') {
	echo $sel;
}

echo ' title="Faites un commentaire sur un prestataire que vous avez utilisé">Faire commentaire</a><br />
	<a href="client_comm_ger.php"';
if ($lapage == 'client_comm_ger.php') {
	echo $sel;
}

echo ' title="Voir ou supprimer des commentaires que vous avez fait">Gérer commentaire</a><br />
    </div>';
//fin de accordion
echo '</div>
	<div align="center"><br /><a href="logout.php" class="fbutton" title="Cliquez ici pour vous déconnecter de l\'interface administrative de RESTOnet">Se déconnecter</a><br /><br /></div>';
?>