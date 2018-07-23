<?php
//		menu_presta.php
//		fichier pour créer le menu de la page prestaire

//on retrouve le fichier de la page
$lapage = basename($_SERVER['PHP_SELF']);

//variable de texte pour id et classe
$act = ' id="actif"';
$sel = ' class="selecter"';
//debut de l'accordion
echo '<div id="accordion">';
//menu profil
echo '<h3';
if (($lapage == 'presta_ident.php') || ($lapage == 'presta_mdp_form.php')) {
	echo $act;
}
echo '><a href="#" title="Ce menu gère les informations de mon profil">Mon profil</a></h3>';
echo '<div><a href="presta_ident.php"';
if ($lapage == 'presta_ident.php') {
	echo $sel;
}
echo ' title="Modifier mes données personnelles">Modifier mes détails</a><br />
	<a href="presta_mdp_form.php"';
if ($lapage == 'presta_mdp_form.php') {
	echo $sel;
}
echo ' title="Changer mon mot de passe personnel">Changer mon mot de passe</a><br />
    </div>';
//menu commandes
echo '<h3';
if (($lapage == 'presta_cmd_jour.php') || ($lapage == 'presta_cmd_livre.php') || ($lapage == 'presta_cmd_plan.php') || ($lapage == 'presta_cmd_det.php')) {
	echo $act;
}
echo '><a href="#" title="Afficher mes commandes">Mes commandes</a></h3>';
echo '<div><a href="presta_cmd_jour.php"';
if ($lapage == 'presta_cmd_jour.php') {
	echo $sel;
}
echo ' title="Voir mes commandes du jour">Commandes du jour</a><br />
	<a href="presta_cmd_livre.php"';
if ($lapage == 'presta_cmd_livre.php') {
	echo $sel;
}
echo ' title="Voir toutes mes commandes livrées">Commandes livrées</a><br />
	<a href="presta_cmd_plan.php"';
if ($lapage == 'presta_cmd_plan.php') {
	echo $sel;
}
echo ' title="Voir le planning des commandes">Planning commande</a><br />
	<a href="presta_cmd_det.php"';
if ($lapage == 'presta_cmd_det.php') {
	echo $sel;
}
echo ' title="Voir les détails d\'une commande">Détails d\'une commande</a><br />
    </div>';
//menu plats
echo '<h3';
if (($lapage == 'plat_liste_form.php') || ($lapage == 'plat_create_form.php') || ($lapage == 'plat_modif_form.php') || ($lapage == 'platcreatemenu.php') || ($lapage == 'platcreatemenumod.php') || ($lapage == 'plat_delete_form.php')) {
	echo $act;
}
echo ' title="Ce menu gère toutes les informations relatives aux plats que vous proposez sur RESTOnet"><a href="#">Mes plats</a></h3>
	<div><a href="plat_liste_form.php"';
if ($lapage == 'plat_liste_form.php') {
	echo $sel;
}
echo ' title="Voir la liste des tous mes plats">Liste</a><br />
	<a href="plat_create_form.php"';
if (($lapage == 'plat_create_form.php') || ($lapage == 'platcreatemenu.php')) {
	echo $sel;
}
echo ' title="Créer un nouveau plat">Création</a><br />
	<a href="plat_modif_form.php"';
if (($lapage == 'plat_modif_form.php')|| ($lapage == 'platcreatemenumod.php')) {
	echo $sel;
}
echo ' title="Modifier les détails d\'un plat">Modification</a><br />	
	<a href="plat_delete_form.php"';
	if ($lapage == 'plat_delete_form.php') {
		echo $sel;
	}
	echo ' title="Supprimer des plats">Suppression</a><br />';
echo '</div>';
//menu chiffre
echo '<h3';
if (($lapage == 'presta_ca.php') || ($lapage == 'presta_clt.php') || ($lapage == 'presta_pos.php')) {
	echo $act;
}
echo '><a href="#" title="Afficher mes commandes">Mes chiffres</a></h3>';
echo '<div><a href="presta_ca.php"';
if ($lapage == 'presta_ca.php') {
	echo $sel;
}
echo ' title="Voir mon chiffre d\'affaire">Chiffre d\'affaire</a><br />
	<a href="presta_clt.php"';
if ($lapage == 'presta_clt.php') {
	echo $sel;
}
echo ' title="Voir chiffre généré par client">Chiffre par client</a><br />
	<a href="presta_pos.php"';
if ($lapage == 'presta_pos.php') {
	echo $sel;
}
echo ' title="Voir ma position par rapport aux autres prestataires">Classement prestataire</a><br />
    </div>';
	//menu note
echo '<h3';
if (($lapage == 'presta_clt_note.php') || ($lapage == 'presta_clt_comm.php')) {
	echo $act;
}
echo '><a href="#" title="Afficher mes commandes">Retour clients</a></h3>';
echo '<div><a href="presta_clt_note.php"';
if ($lapage == 'presta_clt_note.php') {
	echo $sel;
}
echo ' title="Voir les notes attribuées par mes clients">Notes des clients</a><br />
	<a href="presta_clt_comm.php"';
if ($lapage == 'presta_clt_comm.php') {
	echo $sel;
}
echo ' title="Voir les commentaires laissés par mes clients">Commentaires clients</a><br />
    </div>';
//fin de accordion
echo '</div>
	<div align="center"><br /><a href="logout.php" class="isbutton" title="Cliquez ici pour vous déconnecter de l\'interface administrative de RESTOnet">Se déconnecter</a></div>';
?>
    