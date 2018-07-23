<?php
//		prestatab5check.php
//		vérification du 5ème tab

//verification des horaires
$horaires = array();
$horaires[0] = array('jour' => 1, 'debut' => 0, 'fin' => 0);
$horaires[1] = array('jour' => 1, 'debut' => 0, 'fin' => 0);
$horaires[2] = array('jour' => 2, 'debut' => 0, 'fin' => 0);
$horaires[3] = array('jour' => 2, 'debut' => 0, 'fin' => 0);
$horaires[4] = array('jour' => 3, 'debut' => 0, 'fin' => 0);
$horaires[5] = array('jour' => 3, 'debut' => 0, 'fin' => 0);
$horaires[6] = array('jour' => 4, 'debut' => 0, 'fin' => 0);
$horaires[7] = array('jour' => 4, 'debut' => 0, 'fin' => 0);
$horaires[8] = array('jour' => 5, 'debut' => 0, 'fin' => 0);
$horaires[9] = array('jour' => 5, 'debut' => 0, 'fin' => 0);
$horaires[10] = array('jour' => 6, 'debut' => 0, 'fin' => 0);
$horaires[11] = array('jour' => 6, 'debut' => 0, 'fin' => 0);
$horaires[12] = array('jour' => 7, 'debut' => 0, 'fin' => 0);
$horaires[13] = array('jour' => 7, 'debut' => 0, 'fin' => 0);
$flag = FALSE;
//lundi
if (isset($_POST['la1']) && ($_POST['la1'] > 0)) {
	if ((isset($_POST['lb1'])) && ($_POST['lb1'] < $_POST['la1'])) {
		$errors['lb1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[0]['debut'] = $_POST['la1'];
		$horaires[0]['fin'] = $_POST['lb1'];
	}
}
if ((isset($_POST['la2'])) && ($_POST['la2'] > 0) && ($_POST['la2'] >= $_POST['lb1']) && ($_POST['lb1'] != 0)) {
	if ((isset($_POST['lb2'])) && ($_POST['lb2'] < $_POST['la2'])) {
		$errors['lb2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[1]['debut'] = $_POST['la2'];
		$horaires[1]['fin'] = $_POST['lb2'];
	}
} elseif (($_POST['la2'] != 0) && ($_POST['lb2'] != 0)) {
	$errors['lb2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
//mardi
if (isset($_POST['ma1']) && ($_POST['ma1'] > 0)) {
	if ((isset($_POST['mb1'])) && ($_POST['mb1'] < $_POST['ma1'])) {
		$errors['mb1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[2]['debut'] = $_POST['ma1'];
		$horaires[2]['fin'] = $_POST['mb1'];
	}
}
if ((isset($_POST['ma2'])) && ($_POST['ma2'] > 0) && ($_POST['ma2'] >= $_POST['mb1']) && ($_POST['mb1'] != 0)) {
	if ((isset($_POST['mb2'])) && ($_POST['mb2'] < $_POST['ma2'])) {
		$errors['mb2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[3]['debut'] = $_POST['ma2'];
		$horaires[3]['fin'] = $_POST['mb2'];
	}
} elseif (($_POST['ma2'] != 0) && ($_POST['mb2'] != 0)) {
	$errors['mb2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
//mercredi
if (isset($_POST['wa1']) && ($_POST['wa1'] > 0)) {
	if ((isset($_POST['wb1'])) && ($_POST['wb1'] < $_POST['wa1'])) {
		$errors['wb1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[4]['debut'] = $_POST['wa1'];
		$horaires[4]['fin'] = $_POST['wb1'];
	}
}
if ((isset($_POST['wa2'])) && ($_POST['wa2'] > 0) && ($_POST['wa2'] >= $_POST['wb1']) && ($_POST['wb1'] != 0)) {
	if ((isset($_POST['wb2'])) && ($_POST['wb2'] < $_POST['wa2'])) {
		$errors['wb2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[5]['debut'] = $_POST['wa2'];
		$horaires[5]['fin'] = $_POST['wb2'];
	}
} elseif (($_POST['wa2'] != 0) && ($_POST['wb2'] != 0)) {
	$errors['wb2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
//jeudi
if (isset($_POST['ja1']) && ($_POST['ja1'] > 0)) {
	if ((isset($_POST['jb1'])) && ($_POST['jb1'] < $_POST['ja1'])) {
		$errors['jb1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[6]['debut'] = $_POST['ja1'];
		$horaires[6]['fin'] = $_POST['jb1'];
	}
}
if ((isset($_POST['ja2'])) && ($_POST['ja2'] > 0) && ($_POST['ja2'] >= $_POST['jb1']) && ($_POST['jb1'] != 0)) {
	if ((isset($_POST['jb2'])) && ($_POST['jb2'] < $_POST['ja2'])) {
		$errors['jb2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[7]['debut'] = $_POST['ja2'];
		$horaires[7]['fin'] = $_POST['jb2'];
		$horaires[] = array('jour' => 4, 'debut' => $_POST['ja2'], 'fin' => $_POST['jb2']);
	}
} elseif (($_POST['ja2'] != 0) && ($_POST['jb2'] != 0)) {
	$errors['jb2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
//vendredi
if (isset($_POST['va1']) && ($_POST['va1'] > 0)) {
	if ((isset($_POST['vb1'])) && ($_POST['vb1'] < $_POST['va1'])) {
		$errors['vb1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[8]['debut'] = $_POST['va1'];
		$horaires[8]['fin'] = $_POST['vb1'];
		$horaires[] = array('jour' => 5, 'debut' => $_POST['va1'], 'fin' => $_POST['vb1']);
	}
}
if ((isset($_POST['va2'])) && ($_POST['va2'] > 0) && ($_POST['va2'] >= $_POST['vb1']) && ($_POST['vb1'] != 0)) {
	if ((isset($_POST['vb2'])) && ($_POST['vb2'] < $_POST['va2'])) {
		$errors['vb2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[9]['debut'] = $_POST['va2'];
		$horaires[9]['fin'] = $_POST['vb2'];
		$horaires[] = array('jour' => 5, 'debut' => $_POST['va2'], 'fin' => $_POST['vb2']);
	}
} elseif (($_POST['va2'] != 0) && ($_POST['vb2'] != 0)) {
	$errors['vb2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
//samedi
if (isset($_POST['sa1']) && ($_POST['sa1'] > 0)) {
	if ((isset($_POST['sb1'])) && ($_POST['sb1'] < $_POST['sa1'])) {
		$errors['sb1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[10]['debut'] = $_POST['sa1'];
		$horaires[10]['fin'] = $_POST['sb1'];
		$horaires[] = array('jour' => 6, 'debut' => $_POST['sa1'], 'fin' => $_POST['sb1']);
	}
}
if ((isset($_POST['sa2'])) && ($_POST['sa2'] > 0) && ($_POST['sa2'] >= $_POST['sb1']) && ($_POST['sb1'] != 0)) {
	if ((isset($_POST['sb2'])) && ($_POST['sb2'] < $_POST['sa2'])) {
		$errors['sb2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[11]['debut'] = $_POST['sa2'];
		$horaires[11]['fin'] = $_POST['sb2'];
		$horaires[] = array('jour' => 6, 'debut' => $_POST['sa2'], 'fin' => $_POST['sb2']);
	}
} elseif (($_POST['sa2'] != 0) && ($_POST['sb2'] != 0)) {
	$errors['sb2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
//dimanche
if (isset($_POST['da1']) && ($_POST['da1'] > 0)) {
	if ((isset($_POST['db1'])) && ($_POST['db1'] < $_POST['da1'])) {
		$errors['db1'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[12]['debut'] = $_POST['da1'];
		$horaires[12]['fin'] = $_POST['db1'];
	}
}
if ((isset($_POST['da2'])) && ($_POST['da2'] > 0) && ($_POST['da2'] >= $_POST['db1']) && ($_POST['db1'] != 0)) {
	if ((isset($_POST['db2'])) && ($_POST['db2'] < $_POST['da2'])) {
		$errors['db2'] = 'Horaire non cohérent';
		$flag = TRUE;
	} else {
		$horaires[13]['debut'] = $_POST['da2'];
		$horaires[13]['fin'] = $_POST['db2'];
	}
} elseif (($_POST['da2'] != 0) && ($_POST['db2'] != 0)) {
	$errors['db2'] = 'Horaire non cohérent avec première plage';
	$flag = TRUE;
}
if ($flag == FALSE) {
	//pas d'erreur on peut passer la variable horaire
	if (!empty($horaires)) {
		$resp = $mpresta -> CompareHoraires($horaires);
		if ($resp=TRUE){
			$flagpresta=TRUE;
		}
	} else {
		$errors['lb1'] = 'Vous devez choisir des horaires d\'ouverture';
		$flag = TRUE;
	}
}
//congé
if ((isset($_POST['condebut'])) && (trim($_POST['condebut']) != '')) {
	$mpresta -> SetCongeDebut($_POST['condebut']);
	$flagpresta=TRUE;
} elseif ((isset($_POST['confin'])) && (trim($_POST['confin']) != '')) {
	$errors['confin'] = 'Début de congé non mentionée';
	$flag = TRUE;
}
if ((isset($_POST['confin'])) && (trim($_POST['confin']) != '')) {
	$resp = $mpresta -> SetCongeFin($_POST['confin']);
	$flagpresta=TRUE;
	if (!is_null($resp)) {
		$errors['confin'] = $resp;
		$flag = TRUE;
	}
} elseif ((isset($_POST['condebut'])) && (trim($_POST['condebut']) != '')) {
	$errors['confin'] = 'Fin de congé non mentionée';
	$flag = TRUE;
}
if ($flag == TRUE) {
	$errmain[] = 'Horaire';
}
?>