<?php
//		menu_admin.php
//		fichier pour créer le menu de la page administration

//on retrouve le fichier de la page
$lapage = basename($_SERVER['PHP_SELF']);

//variable de texte pour id et classe
$act = ' id="actif"';
$sel = ' class="selecter"';
//debut de l'accordion
echo '<div id="accordion">';
//menu profil
echo '<h3';
if (($lapage == 'prof_modif_form.php') || ($lapage == 'prof_mdp_form.php')) {
	echo $act;
}
echo '><a href="#" title="Ce menu gère les informations de mon profil">Mon profil</a></h3>';
echo '<div><a href="prof_modif_form.php"';
if ($lapage == 'prof_modif_form.php') {
	echo $sel;
}
echo ' title="Modifier les informations personnelles de mon profil">Modifier mes détails</a><br />
	<a href="prof_mdp_form.php"';
if ($lapage == 'prof_mdp_form.php') {
	echo $sel;
}
echo ' title="Changer mon mot de passe personnel">Changer mon mot de passe</a><br />
    </div>';
//menu activité
echo '<h3';
if (($lapage == 'activ_general_form.php') || ($lapage == 'activ_jour.php') || ($lapage == 'activ_an.php') || ($lapage == 'activ_audit.php') || ($lapage == 'activ_note.php') || ($lapage == 'activ_part.php')) {
	echo $act;
}
echo ' title="Voir l\'activité en temps réel du site internet"><a href="#">Activité du site</a></h3>
	<div><a href="activ_jour.php"';
if ($lapage == 'activ_jour.php') {
	echo $sel;
}
echo ' title="Voir l\'activité de ce jour">Activité journalière</a><br />	
	<a href="activ_general_form.php"';
if ($lapage == 'activ_general_form.php') {
	echo $sel;
}
echo ' title="Voir l\'ensemble sur le site internet depuis son ouverture">Toutes activités</a><br />
	<a href="activ_note.php"';
if ($lapage == 'activ_note.php') {
	echo $sel;
}
echo ' title="Etablir les factures mensuelles aux prestataires">Etablir factures</a><br />
	<a href="activ_an.php"';
if ($lapage == 'activ_an.php') {
	echo $sel;
}
echo ' title="Voir l\'activité du site par année">Activité annuelle</a><br />
	<a href="activ_part.php"';
if ($lapage == 'activ_part.php') {
	echo $sel;
}
echo ' title="Voir l\'activité du site pour une période donnée">Activité périodique</a><br />
	<a href="activ_audit.php"';
if ($lapage == 'activ_audit.php') {
	echo $sel;
}
echo ' title="Voir les connexions des prestataires">Connexions prestataires</a><br />
	</div>';
//menu administrateur
if ($_SESSION['issuper'] == 1) {
	echo '<h3';
	if (($lapage == 'admin_create_form.php') || ($lapage == 'admin_modif_form.php') || ($lapage == 'admin_delete_form.php') || ($lapage == 'admin_liste_form.php')) {
		echo $act;
	}
	echo ' title="Ce menu gère toutes les informations relatives aux administrateurs de RESTOnet"><a href="#">Administrateurs</a></h3>
		<div><a href="admin_liste_form.php"';
	if ($lapage == 'admin_liste_form.php') {
		echo $sel;
	}
	echo ' title="Voir la liste de tous les administrateurs">Liste des administrateurs</a><br />
		<a href="admin_create_form.php"';
	if ($lapage == 'admin_create_form.php') {
		echo $sel;
	}
	echo ' title="Créer un nouvel administrateur">Créer administrateur</a><br />
		<a href="admin_modif_form.php"';
	if ($lapage == 'admin_modif_form.php') {
		echo $sel;
	}
	echo ' title="Modifier les détails d\'un administrateur">Modifier administrateur</a><br />
		<a href="admin_delete_form.php"';
	if ($lapage == 'admin_delete_form.php') {
		echo $sel;
	}
	echo ' title="Supprimer un administrateur de RESTOnet">Suppression</a><br />
		</div>';
}
//menu catégories
if ($_SESSION['issuper'] == 1) {
	echo '<h3';
	if (($lapage == 'cat_create_form.php') || ($lapage == 'cat_modif_form.php') || ($lapage == 'cat_delete_form.php') || ($lapage == 'cat_liste_form.php')) {
		echo $act;
	}
	echo ' title="Ce menu gère toutes les informations relatives aux catégories des restaurants proposés sur RESTOnet"><a href="#">Catégories restaurants</a></h3>
		<div><a href="cat_liste_form.php"';
	if ($lapage == 'cat_liste_form.php') {
		echo $sel;
	}
	echo ' title="Voir la liste de toutes les catégories">Liste complète</a><br />
		<a href="cat_create_form.php"';
	if ($lapage == 'cat_create_form.php') {
		echo $sel;
	}
	echo ' title="Créer une nouvelle catégorie">Nouvelle catégorie</a><br />
		<a href="cat_modif_form.php"';
	if ($lapage == 'cat_modif_form.php') {
		echo $sel;
	}
	echo ' title="Modifier les détails d\'une catégorie">Modifier catégorie</a><br />
		<a href="cat_delete_form.php"';
	if ($lapage == 'cat_delete_form.php') {
		echo $sel;
	}
	echo ' title="Supprimer une categorie de RESTOnet">Suppression de catégorie</a><br />
		</div>';
}
//Menu commentaires
echo '<h3';
if (($lapage == 'comm_liste_form.php') || ($lapage == 'comm_valid_form.php')) {
	echo $act;
}
echo ' title="Ce menu gère les actions relatives aux comentaires des clients de RESTOnet"><a href="#">Commentaires clients</a></h3>
	<div><a href="comm_liste_form.php"';
if ($lapage == 'comm_liste_form.php') {
	echo $sel;
}
echo ' title="Voir tous les commentaires des clients de RESTOnet">Liste</a><br />
	<a href="comm_valid_form.php"';
if ($lapage == 'comm_valid_form.php') {
	echo $sel;
}
echo ' title="Valider les derniers commentaires avant parution sur le site">Validation</a><br />
	</div>';
//menu option comptable
if ($_SESSION['issuper'] == 1) {
	echo '<h3';
	if (($lapage == 'tva_create_form.php') || ($lapage == 'tva_delete_form.php') || ($lapage == 'tva_modif_form.php') || ($lapage == 'tva_liste_form.php') || ($lapage == 'tcom_create_form.php') || ($lapage == 'tcom_modif_form.php') || ($lapage == 'tcom_delete_form.php') || ($lapage == 'tcom_liste_form.php')) {
		echo $act;
	}
	echo ' title="Ce menu gère toutes les informations relatives aux taux de T.V.A. et aux taux de commissions applicable sur RESTOnet"><a href="#">Options comptables</a></h3>
		<div><b class="bvert">T.V.A.</b><br />
		<a href="tva_liste_form.php"';
	if ($lapage == 'tva_liste_form.php') {
		echo $sel;
	}
	echo ' title="Voir la liste des tous les taux de T.V.A.">Liste T.V.A.</a><br />
		<a href="tva_create_form.php"';
	if ($lapage == 'tva_create_form.php') {
		echo $sel;
	}
	echo ' title="Créer un nouveau taux de T.V.A.">Nouveau taux T.V.A.</a><br />
		<a href="tva_modif_form.php"';
	if ($lapage == 'tva_modif_form.php') {
		echo $sel;
	}
	echo ' title="Modifier un taux de T.V.A.">Modifier taux T.V.A.</a><br />
		<a href="tva_delete_form.php"';
	if ($lapage == 'tva_delete_form.php') {
		echo $sel;
	}
	echo ' title="Supprimer un taux de T.V.A.">Supprimer taux T.V.A.</a><br />
		<br /><b class="bvert">Commissions</b><br />
		<a href="tcom_liste_form.php"';
	if ($lapage == 'tcom_liste_form.php') {
		echo $sel;
	}
	echo ' title="Voir la liste des tous les taux de commission">Liste commission</a><br />
		<a href="tcom_create_form.php"';
	if ($lapage == 'tcom_create_form.php') {
		echo $sel;
	}
	echo ' title="Créer un nouveau taux de commission">Nouvelle commission.</a><br />
		<a href="tcom_modif_form.php"';
	if ($lapage == 'tcom_modif_form.php') {
		echo $sel;
	}
	echo ' title="Modifier un taux de commission">Modifier commission</a><br />
		<a href="tcom_delete_form.php"';
	if ($lapage == 'tcom_delete_form.php') {
		echo $sel;
	}
	echo ' title="Supprimer un taux de commission">Supprimer commission</a><br />
		</div>';
}
//menu plats
echo '<h3';
if (($lapage == 'plat_liste_form.php') || ($lapage == 'plat_create_form.php') || ($lapage == 'plat_modif_form.php') || ($lapage == 'platcreatemenu.php') || ($lapage == 'platcreatemenumod.php') || ($lapage == 'plat_delete_form.php')) {
	echo $act;
}
echo ' title="Ce menu gère toutes les informations relatives aux plats proposés sur RESTOnet"><a href="#">Plats</a></h3>
	<div><a href="plat_liste_form.php"';
if ($lapage == 'plat_liste_form.php') {
	echo $sel;
}
echo ' title="Voir la liste des tous les plats">Liste</a><br />
	<a href="plat_create_form.php"';
if (($lapage == 'plat_create_form.php') || ($lapage == 'platcreatemenu.php')) {
	echo $sel;
}
echo ' title="Créer un nouveau plat">Création</a><br />
	<a href="plat_modif_form.php"';
if (($lapage == 'plat_modif_form.php')|| ($lapage == 'platcreatemenumod.php')) {
	echo $sel;
}
echo ' title="Modifier les détails d\'un plat">Modification</a><br />';
if ($_SESSION['issuper'] == 1) {
	//on rajoute suppression pour super admin
	echo '<a href="plat_delete_form.php"';
	if ($lapage == 'plat_delete_form.php') {
		echo $sel;
	}
	echo ' title="Supprimer un prestataire de RESTOnet, ainsi que ses plats">Suppression</a><br />';
}
echo '</div>';
//menu prestataire
echo '<h3';
if (($lapage == 'presta_liste_form.php') || ($lapage == 'presta_create_form.php') || ($lapage == 'presta_modif_form.php') || ($lapage == 'presta_delete_form.php')) {
	echo $act;
}
echo ' title="Ce menu gère toutes les informations relatives aux prestataires de RESTOnet"><a href="#">Prestataires</a></h3>
	<div><a href="presta_liste_form.php"';
if ($lapage == 'presta_liste_form.php') {
	echo $sel;
}
echo ' title="Voir la liste des tous les prestataires">Liste</a><br />
	<a href="presta_create_form.php"';
if ($lapage == 'presta_create_form.php') {
	echo $sel;
}
echo ' title="Créer un nouveau prestataire">Création</a><br />
	<a href="presta_modif_form.php"';
if ($lapage == 'presta_modif_form.php') {
	echo $sel;
}
echo ' title="Modifier les détails d\'un prestataire">Modification</a><br />';
if ($_SESSION['issuper'] == 1) {
	//on rajoute suppression pour super admin
	echo '<a href="presta_delete_form.php"';
	if ($lapage == 'presta_delete_form.php') {
		echo $sel;
	}

	echo ' title="Supprimer un prestataire de RESTOnet, ainsi que ses plats">Suppression</a><br />';
}
echo '</div>';

//fin de accordion
echo '</div>
	<div align="center"><br /><a href="logout.php" class="isbutton" title="Cliquez ici pour vous déconnecter de l\'interface administrative de RESTOnet">Se déconnecter</a></div>';
?>
