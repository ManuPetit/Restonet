<?php

//		form.php

//		fichier d'aide pour les formes

//fonction pour creer les differents type d'input
function create_form_input($name, $type, $errors, $size = 0, $maxlength = 0) {
	$value = false;
	//verification que l'on a une valuer
	if (isset($_POST[$name])) {
		$value = $_POST[$name];
	}

	//verifier le type d'input
	if (($type == 'text') || ($type == 'password')) {
		echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" size="' . $size . '" maxlength="' . $maxlength . '"';
		if ($value) {
			echo ' value="' . stripslashes($value) . '"';
		}
		if (array_key_exists($name, $errors)) {
			echo ' class="error" /><br /><span class="error"> ' . $errors[$name] . '</span>';
		} else {
			echo ' />';
		}
	} elseif ($type == 'textarea') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="error">' . $errors[$name] . '</span>';
		}
		echo '<textarea name="' . $name . '" id="' . $name . '" rows="5" cols="60"';
		if (array_key_exists($name, $errors)) {
			echo ' class="error">';
		} else {
			echo '>';
		}
		if ($value) {
			echo stripslashes($value);
		}
		echo '</textarea>';
	} elseif ($type == 'textarea2') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="error">' . $errors[$name] . '</span>';
		}
		echo '<textarea name="' . $name . '" id="' . $name . '" rows="5" cols="60"';
		if (array_key_exists($name, $errors)) {
			echo ' class="error">';
		} else {
			echo '>';
		}
		if ($value) {
			echo stripslashes($value);
		}
		echo '</textarea>';
	} elseif ($type == 'textarea3') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="error">' . $errors[$name] . '</span>';
		}
		echo '<textarea name="' . $name . '" id="' . $name . '" rows="2" cols="40"';
		if (array_key_exists($name, $errors)) {
			echo ' class="error">';
		} else {
			echo '>';
		}
		if ($value) {
			echo stripslashes($value);
		}
		echo '</textarea>';
	}
}

//		FIN DE		function create_form_input($name,$type,$errors,$size=0,$maxlength=0)

//fonction pour creer les differents type d'input à editer
function create_form_edit($name, $type, $errors, $size = 0, $maxlength = 0, $origin = '') {
	$value = false;
	//verification que l'on a une valuer
	if (isset($_POST[$name])) {
		$value = $_POST[$name];
	} else {
		$value = $origin;
	}

	//verifier le type d'input
	if (($type == 'text') || ($type == 'password')) {
		echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" size="' . $size . '" maxlength="' . $maxlength . '"';
		if ($value) {
			echo ' value="' . stripslashes($value) . '"';
		}
		if (array_key_exists($name, $errors)) {
			echo ' class="error" /><br /><span class="error"> ' . $errors[$name] . '</span>';
		} else {
			echo ' />';
		}
	} elseif ($type == 'textarea') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="error">' . $errors[$name] . '</span>';
		}
		echo '<textarea name="' . $name . '" id="' . $name . '" rows="5" cols="60"';
		if (array_key_exists($name, $errors)) {
			echo ' class="error">';
		} else {
			echo '>';
		}
		if ($value) {
			echo stripslashes($value);
		}
		echo '</textarea>';
	} elseif ($type == 'textarea2') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="error">' . $errors[$name] . '</span>';
		}
		echo '<textarea name="' . $name . '" id="' . $name . '" rows="5" cols="60"';
		if (array_key_exists($name, $errors)) {
			echo ' class="error">';
		} else {
			echo '>';
		}
		if ($value) {
			echo stripslashes($value);
		}
		echo '</textarea>';
	} elseif ($type == 'textarea3') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="error">' . $errors[$name] . '</span>';
		}
		echo '<textarea name="' . $name . '" id="' . $name . '" rows="2" cols="40"';
		if (array_key_exists($name, $errors)) {
			echo ' class="error">';
		} else {
			echo '>';
		}
		if ($value) {
			echo stripslashes($value);
		}
		echo '</textarea>';
	}
}

//		FIN DE		function create_form_edit($name,$type,$errors,$size=0,$maxlength=0,$origin='')
