<?php
//		cltdet.php
//		affiche les détails d'un client
//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_prestataire.php';

//verifier presta logged in
Prestataire::CheckLoggedPresta();
if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['clt']))) {
	$cid = $_GET['clt'];
	$sql = "CALL get_clientdetail_ID(:cID)";
	$param = array(':cID' => $cid);
	$row = DatabaseHandler::GetRow($sql, $param);
	if (!empty($row)) {
		$message = '<b>' . $row['nomClient'] . '</b><br />' . $row['adresse1'] . '<br />';
		if (!is_null($row['adresse2'])) {
			$message .= $row['adresse2'] . '<br />';
		}
		$message .= '<b>' . $row['ville'] . '</b><br />Tél. : ' . PreFormatTelephone($row['adresseTelephone']);
		$title = "Détails client";
	} else {
		$message = 'Une erreur s\'est produite lors de la récupération des coordonnées de ce client.';
		$title = "Erreur";
	}
} else {
	$message = 'Une erreur s\'est produite. Veuillez contacter l\'administrateur de ce site si cela se reproduit.';
	$title = "Erreur";
}
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>';
echo $title;
echo '</title></head>
	<body style="color:#040248;background:#a8f3f8"><h2>'.$title.'</h2><p>';
	echo $message;
	echo '</p>';
	echo '<div style="text-align:center;"><input class="isbutton" name="button" type="button" onclick="javascript:self.close();" value="Fermer" /><br /><br />
	</div>
	</body>
	</html>';
?>
		
