<?php

require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';

$data=MotDePasse::HashMotDePasse('chanas3864');
$sql = "UPDATE prg_user SET userMDPass = '" . $data . "' WHERE niveauID =3";
DatabaseHandler::Execute($sql);
?>
