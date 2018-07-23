<?php
//		configs.php

//		fichier principal des configurations du site

//configuration des dossier
define('SITE_ROOT', dirname(dirname(__FILE__)));
define('BUSINESS_DIR', SITE_ROOT . '/business/');
define('INCLUDE_DIR', SITE_ROOT . '/include/');
define('ADMIN_DIR', SITE_ROOT . '/administration/');
define('IMAGE_PRESTA_DIR', SITE_ROOT . '/images/prestataire/');
define('IMAGE_PLAT_DIR', SITE_ROOT . '/images/plat/');

//Nom de défaut du site
define('SITE_NAME', 'RESTOnet : Cliquez... Commandez... Mangez !!!');

//configuration des erreurs true durant le développement
define('IS_WARNING_FATAL', true);
define('DEBUGGING', true);

//Type d'ereurs à reporter
define('ERROR_TYPES', E_ALL);

//settings pour reporter l'erreur par email
define('SEND_ERROR_MAIL', false);
define('ADMIN_ERROR_MAIL', 'epetit@iiidees.com');
define('SENDMAIL_FROM', 'erreurs@restonet.com');
ini_set('sendmail_from', SENDMAIL_FROM);

//par defaut les erreurs ne sont pas loggés dans un fichier
define('LOG_ERRORS', TRUE);
define('LOG_ERROR_FILE', '/public_html/err/errors_log.txt');
//WINDOWS
//define('LOG_ERROR_FILE', '/home/users/errors_log.log');							//LINUX
//Message générique d'erreur à montrer au lieu des infos de debug
define('SITE_GENERIC_ERROR_MESSAGE', '<h1>RESTOnet : erreur !</h1>');

//Connection a la base de données
define('DB_PERSISTENCY', 'true');
define('DB_SERVER', 'db398709468.db.1and1.com');
define('DB_USERNAME', 'dbo398709468');
define('DB_PASSWORD', 'po45lGB1');
define('DB_DATABASE', 'db398709468');
define('PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE);

//le salt appliqué pour le hachage du mot de passe
define('MDP_SALT', '45pmT3EaH48ZwX2J0OmNaqO14MQ69');

//set la locale
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

//demarrage de session
session_start();


if ( false === function_exists('lcfirst') ):
    function lcfirst( $str )
    { return (string)(strtolower(substr($str,0,1)).substr($str,1));}
endif;

//function pour retrouver l'heure en france
function HeureParis() {
	date_default_timezone_set('Europe/Paris');
	return date('Y-m-d H:i:s');
}

//fonction pour additionner du temps
function addTime($hours = 0, $minutes = 0, $seconds = 0, $months = 0, $days = 0, $years = 0) {
	$totalHours = date("H") + $hours;
	$totalMinutes = date("i") + $minutes;
	$totalSeconds = date("s") + $seconds;
	$totalMonths = date("m") + $months;
	$totalDays = date("d") + $days;
	$totalYears = date("Y") + $years;
	$timeStamp = mktime($totalHours, $totalMinutes, $totalSeconds, $totalMonths, $totalDays, $totalYears);
	$myTime = date("Y-m-d H:i:s", $timeStamp);
	return $myTime;
}

//format numero de telephone
function PreFormatTelephone($tel){
	$numero = substr($tel, 0,2).' '.substr($tel, 2,2).substr($tel, 4,2).' '.substr($tel, 6,2).' '.substr($tel, 8,2);
	return $numero;
}

//fonction d'écriture de la date
function PreFormatDate($date) {
	$an = substr($date, 0, 4);
	$mois = substr($date, 5, 2);
	$jour = substr($date, 8, 2);
	$madate = strtotime($date);
	$lejour = get_jour($madate);
	$lemois = get_mois($madate);
	return "le $lejour $jour $lemois $an";
}

//fonction du jour de la semaine en francais en fonction d'une date
function get_jour($unedate) {
	$lejour = date('D', $unedate);
	switch($lejour) {
		case "Sat" :
			$jour = "samedi";
			break;
		case "Sun" :
			$jour = "dimanche";
			break;
		case "Mon" :
			$jour = "lundi";
			break;
		case "Tue" :
			$jour = "mardi";
			break;
		case "Wed" :
			$jour = "mercredi";
			break;
		case "Thu" :
			$jour = "jeudi";
			break;
		case "Fri" :
			$jour = "vendredi";
			break;
	}
	return $jour;
}// FIN de function get_jour($unedate)

//retrouve le mois en français en fonction d'une date
function get_mois($date) {
	//array des mois
	$mois = array(1 => 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');
	$lemois = $mois[date('n', $date)];
	return $lemois;
}// FIN de function get_mois($date)

//This function takes in the current width and height of an image
//and also the max width and height desired.
//It then returns an array with the desired dimensions.
function setWidthHeight($width, $height, $maxwidth, $maxheight) {
	if ($width > $height) {
		if ($width > $maxwidth) {
			//Then you have to resize it.
			//Then you have to resize the height to correspond to the change in width.
			$difinwidth = $width / $maxwidth;
			$height = intval($height / $difinwidth);
			//Then default the width to the maxwidth;
			$width = $maxwidth;
			//Now, you check if the height is still too big in case it was to begin with.
			if ($height > $maxheight) {
				//Rescale it.
				$difinheight = $height / $maxheight;
				$width = intval($width / $difinheight);
				//Then default the height to the maxheight;
				$height = $maxheight;
			}
		} else {
			if ($height > $maxheight) {
				//Rescale it.
				$difinheight = $height / $maxheight;
				$width = intval($width / $difinheight);
				//Then default the height to the maxheight;
				$height = $maxheight;
			}
		}
	} else {
		if ($height > $maxheight) {
			//Then you have to resize it.
			//You have to resize the width to correspond to the change in width.
			$difinheight = $height / $maxheight;
			$width = intval($width / $difinheight);
			//Then default the height to the maxheight;
			$height = $maxheight;
			//Now, you check if the width is still too big in case it was to begin with.
			if ($width > $maxwidth) {
				//Rescale it.
				$difinwidth = $width / $maxwidth;
				$height = intval($height / $difinwidth);
				//Then default the width to the maxwidth;
				$width = $maxwidth;
			}
		} else {
			if ($width > $maxwidth) {
				//Rescale it.
				$difinwidth = $width / $maxwidth;
				$height = intval($height / $difinwidth);
				//Then default the width to the maxwidth;
				$width = $maxwidth;
			}
		}
	}
	$widthheightarr = array("$width", "$height");
	return $widthheightarr;
}// FIN DE 		function setWidthHeight($width, $height, $maxwidth, $maxheight){

//This function creates a thumbnail and then saves it.
function createthumb($img, $constrainw, $constrainh) {
	//Find out the old measurements.
	$oldsize = getimagesize($img);
	//Find an appropriate size.
	$newsize = setWidthHeight($oldsize[0], $oldsize[1], $constrainw, $constrainh);
	//Create a duped thumbnail.
	$exp = explode(".", $img);
	//Check if you need a gif or jpeg.
	if ($exp[1] == "gif") {
		$src = imagecreatefromgif($img);
	} else {
		$src = imagecreatefromjpeg($img);
	}
	//Make a true type dupe.
	$dst = imagecreatetruecolor($newsize[0], $newsize[1]);	
	//Resample it.
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $newsize[0], $newsize[1], $oldsize[0], $oldsize[1]);
	//Create a thumbnail.
	$thumbname = $exp[0] . "_pre." . $exp[1];
	if ($exp[1] == "gif") {
		imagejpeg($dst, $thumbname);
	} else {
		imagejpeg($dst, $thumbname);
	}
	//And then clean up.
	imagedestroy($dst);
	imagedestroy($src);
}	//FIN DE		function createthumb ($img, $constrainw, $constrainh){
?>