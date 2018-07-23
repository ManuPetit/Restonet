<?php
//		activ_audit.php
//		permet de voir les connexions des prestataires
require_once '../configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_user.php';
require_once BUSINESS_DIR . 'cls_administrateur.php';
require_once BUSINESS_DIR . 'cls_activite.php';

//vérifier admin loggedin
Administrateur::CheckLoggedAdmin();
$errors = array();

//les mois
$lesmois = array(1 => 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');
$page_title = "Connexions prestataires";
include INCLUDE_DIR . 'adminhead.php';
//on retrouve les jours d'activite
$dates = Activite::GetDateActivite();

echo '<h2>Connexions des prestataires</h2>';

if ((isset($_POST['submitted'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
	if (trim($_POST['condebut']) == '') {
		$errors['condebut'] = 'Veuillez choisir une date de début';
	}
	if (trim($_POST['condefin']) == '') {
		$errors['condefin'] = 'Veuillez choisir une date de fin';
	}
	if ((trim($_POST['condebut']) != '') && (trim($_POST['condefin']) != '')) {
		if (Activite::GetTimestamp($_POST['condefin']) <= Activite::GetTimestamp($_POST['condebut'])) {
			$errors['condefin'] = 'Date de fin antérieure à la date début.';
		}
	}
	if (empty($errors)) {
		$iDate = Activite::FormatTimeForAct($_POST['condebut'], FALSE);
		$eDate = Activite::FormatTimeForAct($_POST['condefin'], TRUE);
		$prest = $_POST['presta'];
		if ($prest == 0) {
			$mes1 = ' pour tous les prestataires';
		} else {
			$mes1 = ' pour ' . Activite::GetPrestaNomParID($prest);
		}
		$rows = Activite::GetPrestaAudit($iDate, $eDate, $prest);
		if (!empty($rows)) {
			echo '<p>Activité pour la période du ' . FormatDateSlash($iDate) . ' au ' . FormatDateSlash($eDate) . $mes1 . '.</p>';
			echo '<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">';
			echo '<tr style="font-weight:bold;" bgcolor="#6cff68"><td width="15%" align="center">Date</td><td width="45%" align="center">Enseigne</td><td width="40%" align="center">Action</td></tr>';
			$bg = "#f3d2ac";
			$dc = "#0099da";
			$day = '000000';
			for ($c = 0; $c < count($rows); $c++) {
				$bg = ($bg == '#f3d2ac' ? '#b1f3ac' : '#f3d2ac');
				$cDay = $rows[$c]['tDay'] . ' ' . $lesmois[$rows[$c]['tMonth']] . ' ' . $rows[$c]['tYear'];
				echo '<tr valign="top"><td width="15%"';
				if ($day != $cDay) {
					$day = $cDay;
					$dc = ($dc == '#0099da' ? '#8bb8e5' : '#0099da');
					echo ' bgcolor="' . $dc . '">' . $day;
				} else {
					echo ' bgcolor="' . $dc . '">';
				}
				echo '</td><td width="45%" bgcolor="' . $bg . '">' . $rows[$c]['prestaNom'] . '</td><td width="40%" bgcolor="' . $bg . '">';
				if ($rows[$c]['typeID'] == 5) {
					echo 'Connexion au tableau de bord à ' . Activite::FormatHeure($rows[$c]['tTime']);
				} else {
					echo 'Déconnexion du tableau de bord à ' . Activite::FormatHeure($rows[$c]['tTime']);
				}
				echo '</td></tr>';
			}
			echo '</table>';
			echo '<p></p>';
			DatabaseHandler::Close();
			include INCLUDE_DIR . 'adminfooter.php';
			exit();
		} else {
			echo '<p>Aucune activité enregistrée pour cette période' . $mes1 . '.</p>';
		}
	}
}

if (is_null($dates)) {
	echo '<p>Aucune activité n\'a été enregistrée sur RESTOnet.</p>';
} else {
	//on retrouve la liste des prestataires
	$presta = Activite::GetPrestaListe();
	//mettre les dates du date picker
	$aujourd = date('Y-m-d');
	$mindate = substr($dates['minDate'], 0, 10);
	$diff = abs(strtotime($aujourd) - strtotime($mindate));
	$days = floor($diff / (60 * 60 * 24));
	echo '<script type="text/javascript">
		$(document).ready(function() {
			$.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
			$( ".datepicker" ).datepicker({
				minDate : -' . $days . ',
				maxDate : 0
			});
		});
	</script>';
	echo '<p><fieldset><legend>Selectionnez la période souhaitée</legend><p></p>';
	echo '<form action="activ_audit.php" method="post" accept-charset="utf-8">
	<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
	<tr valign="top"><td wdith="30%">
	<b>Date de début : </b></td>
	<td width="20"><input type="text" class="datepicker" name="condebut" size="20" maxlength="10" value="';
	if (isset($_POST['condebut']))
		echo $_POST['condebut'];
	echo '" />';
	if (isset($errors['condebut'])) {
		echo '<br /><span class="error">' . $errors['condebut'] . '</span>';
	}
	echo '</td>
	<td wdith="30%">
	<b>Date de fin : </b></td>
	<td width="20"><input type="text" class="datepicker" name="condefin" size="20" maxlength="10" value="';
	if (isset($_POST['condefin']))
		echo $_POST['condefin'];
	echo '" />';
	if (isset($errors['condefin'])) {
		echo '<br /><span class="error">' . $errors['condefin'] . '</span>';
	}
	echo '</td></tr>';
	echo '<tr valign="top"><td width="30%"><b>Choix du prestataire :</b></td><td colspan="3"><select name="presta">
	<option value="0">Voir tous les prestataires</option>';
	for ($c = 0; $c < count($presta); $c++) {
		echo '<option value="' . $presta[$c]['prestaID'] . '"';
		if (isset($_POST['presta'])) {
			if ($_POST['presta'] == $presta[$c]['prestaID']) {
				echo ' selected="selected"';
			}
		}
		echo '>' . $presta[$c]['prestaNom'] . '</option>';
	}
	echo '</select>
	</td></tr>';
	echo '</table>
	<br /><div align="center"><input type="submit" name="submit" value="Voir les connexions" /></div>
	<input type="hidden" name="submitted" value="TRUE" /></fieldset>';
}

DatabaseHandler::Close();
include INCLUDE_DIR . 'adminfooter.php';
