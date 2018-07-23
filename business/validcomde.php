<?php
//validcomde.php
//fichier de validation de paiement
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_shop.php';

 $querystring=$_SERVER['QUERY_STRING'];
 //log de retour de commande pour vérification
 $log = '../err/err.log';

 $date = date('Y-m-d H:i:s');
 $mes = "   |  Date:  ".$date. " -> ".$querystring."\r\n";
 error_log($mes, 3, $log);




//procedure de validation
//on retrouve les détails de la requête
$parts = explode("&", $querystring);
print_r($parts);
for ($p = 0; $p < count($parts); $p++) {
	$auto = strpos($parts[$p], "auto");
	if ($auto !== false) {
		$autoNumber = substr($parts[$p], 5, strlen($parts[$p]) - 4);
	}
	$cmd = strpos($parts[$p], "ref");
	if ($cmd !== false) {
		$cmdNumber = substr($parts[$p], 4, 11);
	}
	$trans = strpos($parts[$p], "trans");
	if ($trans !== false) {
		$transNumber = substr($parts[$p], 6, strlen($parts[$p]) - 4);
	}
}
//vérifier si on a un numéro d'autorisation et faire la mise à jour des fichiers
if (isset($autoNumber)){
	Shop::ValidationCommandeBanque($autoNumber, $transNumber, $cmdNumber);
	//on lit les details du fichier log
	$log = SITE_ROOT . '/factmp/' . $cmdNumber . '.log';
	$fh=fopen($log,'r');
	$details=array();
	while (!feof($fh)){
		$details[]=fgets($fh,256);
	}
	fclose($fh);
	//on met à jour les disponibilité horaire
	$lespresta=array();
	$lespresta=Shop::GetAllPrestaFromCommande($cmdNumber);
	//mettre à jour les horaires
	for ($lp=0;$lp<count($lespresta);$lp++){
		Shop::UpdatePrestaDisponibilité($lespresta[$lp]['prestaID'], $cmdNumber);
		shop::AjouterPrestaFacture($lespresta[$lp]['prestaID']);
	}
	//on vide le cart
	Shop::DeleteCartItemFromCartUserID($details[0]);
	//envoyer email confirmation
	$commandeNumero=$cmdNumber;
	$IsEmail = true;
	include BUSINESS_DIR. 'create_facture.php';
	//détruire le fichier log
	unlink($log);
}
?>
