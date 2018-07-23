<?php
//		menu_client.php
//		fichier pour créer le menu de la page client

//on retrouve le fichier de la page
$lapage = basename($_SERVER['PHP_SELF']);

//variable de texte pour id et classe
$act = ' id="actif"';
$sel = ' class="selecter"';

//debut de l'accordion
echo '<div id="accordion">';

//menu profil
echo '<h3';
if (($lapage == 'prof_mod.php') || ($lapage == 'prof_mdp.php')) {
	echo $act;
}
echo '><a href="#" title="Ce menu gère les informations de mon profil">Mon profil</a></h3>';
echo '<div><a href="prof_mod.php';
if ($lapage == 'prof_mod.php') {
	echo $sel;
}
echo ' title="Modifier les informations personnelles de mon profil">Mes détails</a><br />
	<a href="prof_mdp.php"';
if ($lapage == 'prof_mdp.php') {
	echo $sel;
}
echo ' title="Changer mon mot de passe personnel">mot de passe</a><br />
    </div>';
	
//menu adresse
echo '<h3';
if (($lapage == 'add_list.php') || ($lapage == 'add_mod.php') || ($lapage == 'addadresse.php')) {
	echo $act;
}
echo '><a href="#" title="Ce menu gère mes adresses">Mes adresses</a></h3>';
echo '<div><a href="add_list.php';
if (($lapage == 'add_list.php') || ($lapage == 'add_mod.php')){
	echo $sel;
}
echo ' title="Voir la liste de toutes mes adresses">Mes adresses</a><br />
	<a href="addadresse.php"';
if ($lapage == 'addadresse.php') {
	echo $sel;
}
echo ' title="Entrez une nouvelle adresse">Nouvelle adresse</a><br />
    </div>';
	


//fin de accordion
echo '</div>
	<div align="center"><br /><a href="logout.php" class="cbutton" title="Cliquez ici pour vous déconnecter de RESTOnet">Déconnexion</a></div><br />';
?>