<?php
//		get_plat.php
//		retrouve une liste de plats

//ajouter les fichiers d'utilités
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_plat.php';
//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();
$str = 'Veuillez d\'abord choisir un prestataire';
if((isset($_GET['prestaid'])) && (is_numeric($_GET['prestaid']))&& ($_SERVER['REQUEST_METHOD']=='GET')){
	$sql = 'CALL get_plat_prestaID(:pID)';
	$param = array(':pID'=>$_GET['prestaid']);
	$rows = DatabaseHandler::GetAll($sql,$param);
	if (!empty($rows)){
		$str='<select name="plat"><option value="">Choisissez un plat dans la liste</option>';
		for ($i=0;$i<count($rows);$i++){
			$str .= '<option value="'. $rows[$i]['platID'].'">' . $rows[$i]['platNom'] . '</option>';
		}
		$str .= '</select>';
	}
}
echo $str;
?>