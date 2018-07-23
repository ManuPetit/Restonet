<?php
	//		presta_modif_form.php
	//		fichier pour modifier un prestataire
	
	//ajouter les fichiers d'utilités
	require_once '../configs/configs.php';
	require_once BUSINESS_DIR . 'cls_error_handler.php';
	
	//preparer le handler d'erreur
	ErrorHandler::SetHandler();
	
	require_once BUSINESS_DIR . 'cls_database_handler.php';
	require_once BUSINESS_DIR . 'cls_user.php';
	require_once BUSINESS_DIR . 'cls_administrateur.php';
	require_once BUSINESS_DIR . 'cls_prestataire.php';
	require_once BUSINESS_DIR . 'cls_motdepasse.php';
	require_once BUSINESS_DIR . 'cls_categorie.php';
	require_once BUSINESS_DIR . 'cls_commission.php';
	require_once BUSINESS_DIR . 'form.php';
	//vérifier admin loggedin
	Administrateur::CheckLoggedAdmin();
	
	$page_title = "Modification d'un prestataire";
	include INCLUDE_DIR . 'adminhead.php';
	
	//on recupère le numéro si on vient de la page presta_liste_form.php
	if ((isset($_GET['prestaid'])) && (is_numeric($_GET['prestaid'])))
	{
		if ($_GET['prestaid'] >0)
		{
			$prestanom=Prestataire::GetNomParID($_GET['prestaid']);
			$id = (int)$_GET['prestaid'];
		}
	}
	//on recupère le numéro si on vient de la page admin_form_form.php
	if ((isset($_POST['prestaid'])) && (is_numeric($_POST['prestaid'])))
	{
		if ($_POST['prestaid'] >0)
		{			
			$prestanom=Prestataire::GetNomParID($_POST['prestaid']);
			$id = (int)$_POST['prestaid'];
		}
	}
	if ((!isset($id)) || (!isset($prestanom)))
	{
		//on n'a pas de prestataire danc on propose le choix
		echo '<h2>Liste des prestataires</h2>';
		$rows = array();
		$rows = Prestataire::GetAllPrestaNomID();
		if (empty($rows))
		{
			echo '<p>Il n\'y a aucun prestataire à modifier, dans la base de données.</p>';
		}else{
			echo '<p>Veuillez choisir le prestataire à modifier :</p>';
			echo '<fieldset><legend>Prestataire : </legend>
			<form action="presta_modif_form.php" method="post" accept-charset="utf-8">
			<select name="prestaid" id="prestaid">
			<option value="0" selected="selected">Veuillez choisir un nom</option>';
			for ($i=0; $i < count($rows); $i++)
			{
				echo '<option value="' . $rows[$i]['prestaID'] . '">' . $rows[$i]['prestaNom'] .'</option>';
			}
			echo '</select>
			<br />
			<div align="center"><input type="submit" name="submit" id="submit" value="Choisir ce prestataire" /></div>
			</form>
			</fieldset>';
		}
	}else{
		//il y a des modif à faire
		echo '<h2>Liste des prestataires</h2>';
		//variable pour les erreurs
		$errors = array();
		$errmain=array();
		//retrouver les differentes commission
		$comm = array();
		$comm = Commission::GetAllCommissionListe();
		//retrouver les differentes valeurs d'affichage
		$valeur = array();
		$valeur = DatabaseHandler::GetAll('CALL get_all_valeur()');
		//creer les valeurs de délai commande
		$delai = array(0 => array('id' => '00:15:00', 'temps' => '00h15'), 1 => array('id' => '00:30:00', 'temps' => '00h30'), 2 => array('id' => '00:45:00', 'temps' => '00h45'), 3 => array('id' => '01:00:00', 'temps' => '01h00'), 4 => array('id' => '01:15:00', 'temps' => '01h15'), 5 => array('id' => '01:30:00', 'temps' => '01h30'), 6 => array('id' => '01:45:00', 'temps' => '01h45'), 7 => array('id' => '02:00:00', 'temps' => '02h00'), 8 => array('id' => '02:15:00', 'temps' => '02h15'), 9 => array('id' => '02:30:00', 'temps' => '02h30'), 10 => array('id' => '02:45:00', 'temps' => '02h45'), 11 => array('id' => '03:00:00', 'temps' => '03h00'));
		//retrouver les categorie
		$categ=array();
		$categ=Categorie::GetCategorieDetail();
		//retrouver les types de livraisons
		$livrais=array();
		$livrais=DatabaseHandler::GetAll('CALL get_all_livraison()');
		//retrouver les plages horaires
		$heure=array();
		$heure=DatabaseHandler::GetAll('CALL get_all_plageheure()');
		//détails du prestataire
		$mpresta = new Prestataire();
		$mpresta->GetPrestaParID($id);
		
		if (isset($_POST['prestamodif'])){
			//on analyse la forme
			include 'prestatab1checkmod.php';
			include 'prestatab2checkmod.php';
			include 'prestatab34checkmod.php';
			include 'prestatab5checkmod.php';
			if(empty($errors)){
				if ($flagpresta==FALSE){
					echo '<p>Aucune modification n\'a été apportée au prestataire : ' . $prestanom . ' dans la base de données.';
					DatabaseHandler::Close();
					include INCLUDE_DIR . 'adminfooter.php';
					exit();
				}else{
					$mpresta->UpdatePrestataire();
					echo '<p>Les modifications ont été apportées au prestataire : ' . $prestanom . ' dans la base de données.';
					//remise à zéro des fichiers
					$_POST = array();
					$_FILES = array();
					unset($file,$_SESSION['img']);
					DatabaseHandler::Close();
					include INCLUDE_DIR . 'adminfooter.php';
					exit();
				}
			}
		}
		//on affiche la forme
		echo '<p>Modifiez les détails de votre prestataire : ' .$prestanom . '</p>';
		if (!empty($errmain)){
			echo '<p><b>Attention : <b>il y a des erreurs aux onglets suivants :<ul>';
			foreach ($errmain as $value) {
				echo '<li>' . $value . '</li>';
			}
			echo '</ul></p>';
		}

?>
<form id="cmxform" method="post" action="presta_modif_form.php" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
	<div id="tabs" style="overflow:hidden;">
		<ul>
			<li>
				<a href="#tabs-1">Identification</a>
			</li>
			<li>
				<a href="#tabs-2">Détails</a>
			</li>
			<li>
				<a href="#tabs-3">Catégorie</a>
			</li>
			<li>
				<a href="#tabs-4">Livraison</a>
			</li>
			<li>
				<a href="#tabs-5">Horaire</a>
			</li>
		</ul>
		<?php
		include 'prestatab1mod.php';
		include 'prestatab2mod.php';
		include 'prestatab3mod.php';
		include 'prestatab4mod.php';
		include 'prestatab5mod.php';
		echo '</div>';
		}
		DatabaseHandler::Close();
		include INCLUDE_DIR . 'adminfooter.php';
		?>
