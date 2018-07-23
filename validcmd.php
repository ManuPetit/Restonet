<?php
//			validcmd.php
//	fichier de validation final de la commande
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'form.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_client.php';
require_once BUSINESS_DIR . 'cls_shop.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();
$errors = array();
//verifier que l'on a des données
if ((!isset($_SESSION['uniid'])) || (!isset($_SESSION['curprestid'])) || (!isset($_SESSION['clientid'])) || (!isset($_SESSION['livre'])) || (!isset($_SESSION['date'])) || (!isset($_SESSION['plage']))) {
	$url = "index.php";
	header("Location: $url");
	exit();
}
$page_title = "Finalisation de ma commande - RESTOnet";
$menu = 'm9';
include INCLUDE_DIR . 'header.php';
echo '<!-- COLONNE GAUCHE  -->
<div id="left">';

echo '</div>
<!-- CONTENU  -->
<div id="right">
	<h1>Finalisation de ma commande</h1>';
//préparation du data pour la commande
//heure locale
$dateCmd = HeureParis();
$_SESSION['dateCmd'] = $dateCmd;
// on vérifie si la commande existe
if (!isset($_SESSION['cmdid'])) {
	//commencer la transaction
	DatabaseHandler::SetBeginTransaction();
	try {
		//creation numéro de commande
		$cmdNum = Shop::GetNumeroCommande($dateCmd);
		//récupération adresse defaut
		$cltAdr = Client::GetDefaultAdresse($_SESSION['clientid']);
		//retrouver ID de la commande et creation entete cmd
		$cmdID = Shop::CreateCommande($cmdNum, $_SESSION['clientid'], $_SESSION['dateCmd'], $_SESSION['livre'], $cltAdr, $_SESSION['date'], $_SESSION['plage']);
		//ajouter les details de la commande
		Shop::CreateCommandeDetail($_SESSION['uniid'], $cmdID);
		$cmdOk = TRUE;
		$_SESSION['cmdid'] = $cmdNum;
		DatabaseHandler::CommitTransaction();
	} catch(PDOException $e) {
		DatabaseHandler::RoolbackTransaction();
		DatabaseHandler::Close();
		trigger_error($e -> getMessage(), E_USER_ERROR);
	}
}
include INCLUDE_DIR . 'openboxfront.php';
include BUSINESS_DIR . 'cls_facture.php';
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';
DatabaseHandler::Close();
include INCLUDE_DIR . 'footer.php';
?>

