<?php
	//		prestatab2check.php
	//		verifie le deuxieme tab
	
	
	//description
	$flag=false;
	$resp=$npresta->SetPrestaDescription($_POST['desc']);
	if(!is_null($resp)){
		$errors['desc']=$resp;
		$flag=TRUE;
	}
	//verifiaction de l'image
	if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))) {
		if (is_uploaded_file($_FILES['img']['tmp_name']) && ($_FILES['img']['error'] == UPLOAD_ERR_OK)) {
			$file = $_FILES['img'];
			$size = ROUND($file['size']/1024);
			if ($size > 5120) {
				$errors['img'] = "<br />Le fichier image est trop volumineux. Taille maximum : 5 Mo!";
				$flag=TRUE;
			}
			$all_mime = array('image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG');
			$all_ext = array ('.jpg', '.gif', 'jpeg');
			$image_info = getimagesize($file['tmp_name']);
			$ext=strtolower(substr($file['name'],-4));
			if ((!in_array($file['type'],$all_mime)) || (!in_array($image_info['mime'], $all_mime)) || (!in_array($ext,$all_ext))) {
				$errors['img'] = "<br />Le fichier t&eacute;l&eacute;charg&eacute; n'est pas un fichier image reconnu par le syst&egrave;me.";
				$flag=TRUE;
			}
			//si pas d'erreur
			if (!array_key_exists('img',$errors)) {
				$newname = (string)sha1($file['name'].uniqid('',true));
				$newname .= ((substr($ext, 0, 1) != '.') ? ".{$ext}" : $ext);
				$dest = IMAGE_PRESTA_DIR .$newname;
				if (move_uploaded_file($file['tmp_name'],$dest)) {
					$_SESSION['img']['new_name'] = $newname;
					$_SESSION['img']['file_name'] = $file['name'];
					echo '<h4>Le fichier image a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; avec succ&eacute;s.</h4>';
					//generer thumbnail
					createthumb($dest,150,150);
					//Détruire l'image original pour garder selement thumbnail
					unlink($dest);
					//ajouter le nom du fichier à l'objet
					$npresta->SetPrestaImage($_SESSION['img']['new_name']);
				} else {
					trigger_error('Le fichier ne pouvait &ecirc;tre d&eacute;plac&eacute;.');
					unlink($file['tmp_name']);
				}
			}
			//		FIN DE		if (!array_key_exists('img',$errors))
		} elseif (!isset($_SESSION['img'])) { // No current or previous uploaded file.
			switch ($_FILES['img']['error']) {
				case 1:
				case 2:
					$errors['img'] = '<br />Le fichier &agrave; t&eacute;l&eacute;charger est trop volumineux.';
					$flag=TRUE;
					break;
				case 3:
					$errors['img'] = '<br />Le fichier n\'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.';
					$flag=TRUE;
					break;
				case 6:
				case 7:
				case 8:
					$errors['img'] = '<br />Le fichier n\'a pas pu &ecirc;tre t&eacute;l&eacute;charg&eacute; &agrave; cause d\'une erreur syst&egrave;me.';
					$flag=TRUE;
					break;
				case 4:
				default: 
					$errors['img'] = '<br />Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.';
					$flag=TRUE;
					break;
			} // End of SWITCH.		
		} 
	}
	//		FIN DE		if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))
	//actif
	$resp=$npresta->SetPrestaActif($_POST['actif']);
	if(!is_null($resp)){
		$errors['actif']=$resp;
		$flag=TRUE;
	}
	//commission
	$resp=$npresta->SetPrestaCommissionID($_POST['commission']);
	if(!is_null($resp)){
		$errors['commission']=$resp;
		$flag=TRUE;
	}
	//valeur d'affichage
	$resp=$npresta->SetPrestaMiseEnValeur($_POST['valeur']);
	if(!is_null($resp)){
		$errors['valeur']=$resp;
		$flag=TRUE;
	}
	//delai
	$resp=$npresta->SetPrestaDelaiPrep($_POST['delai']);
	if(!is_null($resp)){
		$errors['delai']=$resp;
		$flag=TRUE;
	}
	//commaxi
	$resp=$npresta->SetComdeMaxi($_POST['commaxi']);
	if(!is_null($resp)){
		$errors['commaxi']=$resp;
		$flag=TRUE;
	}
	if ($flag==TRUE){
		$errmain[]='Détails';
	}
	?>
	