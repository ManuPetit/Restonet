<?php
//		client_note.php
//		permet de noter un prestataire
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR .'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

//verifier si un client est connecter
if (!isset($_SESSION['userid']) && !isset($_SESSION['clientid'])) {
	$url = "index.php";
	header("Location: $url");
	exit();
}

//retrouver la liste des presta utilisé par le client
$prestau=array();
$prestau=Client::ReturnPrestaUsedClientID($_SESSION['clientid']);

// la forme a été soumise par changment de note
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	
	for ($p=0;$p<count($prestau);$p++){
		//vérifier que l'on a bien le même id
		if ($prestau[$p]['prestaID']==$_POST['pid'][$p]){
			//vérifier qu'il y a une différence de note
			if ($prestau[$p]['note'] != $_POST['manote'][$p]){
				//affecter la note à la base de données
				if (Client::PutNoteToPresta($_SESSION['clientid'], $_POST['pid'][$p], $_POST['manote'][$p])== TRUE){
					$prestau[$p]['note']=$_POST['manote'][$p];
				}
			}
		}	
	}
}

$page_title = "Je note mes prestataires - RESTOnet";
$menu = 'm5';

include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';
//afficher le panier
include BUSINESS_DIR . 'show_cart.php';
include BUSINESS_DIR . 'show_menuclient.php';
echo '</div>
<!-- CONTENU  -->
<div id="right">
<h1>Je note mes prestataires</h1>';
include INCLUDE_DIR . 'openboxfront.php';
//on vérifie si il y a des presta
if (empty($prestau)){
	echo '<p>Vous n\'avez pas encore utilisé l\'un de nos prestataires (ou bien votre commande n\'a pas encore été livré).</p><p>Vous ne pouvez donc pas encore noter un prestataire.</p>';
}else{
	//on des presta on les affiches
	echo '<form action="client_note.php" method="post">
	<table width="90%" border="0" cellspacing="5" cellpadding="0" align="center">
	<tr valign="top"><td width="80%" align="left"><b>Mes prestataires</b></td><td width="20%" align="center"><b>Ma note</b></td></tr>';
	for ($p=0;$p<count($prestau);$p++){
		//verifier qu'il y a une note
		if (!empty($prestau[$p]['note'])){
			$note =$prestau[$p]['note']; 
		}else{
			$note=0;
		}
		echo '<tr valign="middle"><td width="80%" align="left">'. $prestau[$p]['prestaNom']. '</td>
		<input type="hidden" name="pid[]" value="'. $prestau[$p]['prestaID']. '" />
		<td width="20%" align="center"><select name="manote[]" onChange="this.form.submit();">';
		for ($i=0;$i<6;$i++){
			echo '<option value="'.$i.'"';
			if ($note==$i){
				echo ' selected="selected"';
			}
			echo '>'.$i. ' / 5</option>';
		}
		echo '</select></td></tr>';
	}
	echo '</table>
	</form>';
}

include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>