<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="../styles/admin.css" />
		<link rel="stylesheet" href="../styles/jquery-ui-1.8.16.admin.css" />
		<link rel="stylesheet" href="../styles/tipTip.css" />
		<?php
		//on ajoute les css selon la page
		$lapage = basename($_SERVER['PHP_SELF']);
		if (($lapage == 'admin_liste_form.php') || ($lapage == 'presta_liste_form.php') || ($lapage == 'comm_liste_form.php')) {
			echo '<link rel="stylesheet" href="../styles/ui.jqgrid.css" />';
		}
		?>
		<script type="text/javascript" src="../jquery/jquery-1.6.4.min.js"></script>
		<script src="../jquery/jquery-ui-1.8.16.custom.min.js"></script>
		<?php
		if (($lapage == 'platcreatemenu.php') || ($lapage == 'platcreatemenumod.php')) {
			echo '<script type="text/javascript" src="../jquery/createmenu.js"></script>';
		} else {
			echo '
		<script type="text/javascript" src="../jquery/jquery.tipTip.minified.js"></script>
		<script type="text/javascript" src="../jquery/admincreate.js"></script>
		<script type="text/javascript" src="../jquery/jquery.printElement.js"></script>';
		}
		//on ajoute les scripts selon la page
		if ($lapage == 'admin_liste_form.php') {
			echo '<script type="text/javascript" src="../jquery/grid.locale-fr.js"></script>
			<script type="text/javascript" src="../jquery/jquery.jqGrid.min.js"></script>
			<script type="text/javascript" src="../jquery/adminliste.js"></script>';
		}
		if ($lapage == 'presta_liste_form.php') {
			echo '<script type="text/javascript" src="../jquery/grid.locale-fr.js"></script>
			<script type="text/javascript" src="../jquery/jquery.jqGrid.min.js"></script>
			<script type="text/javascript" src="../jquery/prestaliste.js"></script>';
		}
		if ($lapage == 'comm_liste_form.php') {
			echo '<script type="text/javascript" src="../jquery/grid.locale-fr.js"></script>
			<script type="text/javascript" src="../jquery/jquery.jqGrid.min.js"></script>
			<script type="text/javascript" src="../jquery/commliste.js"></script>';
		}
		if (($lapage == 'presta_create_form.php') || ($lapage == 'presta_modif_form.php')) {
			echo '<script type="text/javascript" src="../jquery/additional_methods.min.js"></script>
			<script type="text/javascript" src="../jquery/jquery.validate.min.js"></script>
			<script type="text/javascript" src="../jquery/jquery.ui.datepicker-fr.js"></script>
			<script type="text/javascript" src="../jquery/ui.multiselect.js"></script>
			<script type="text/javascript" src="../jquery/presta.js"></script>';
		}
		if (($lapage == 'plat_delete_form.php') || ($lapage == 'plat_modif_form.php')) {
			echo '<script type="text/javascript" src="../jquery/plat.js"></script>';
		}
		if (($lapage == 'activ_part.php') || ($lapage == 'activ_audit.php') ){
			echo '<script type="text/javascript" src="../jquery/jquery.ui.datepicker-fr.js"></script>';
		}
		?>
		<title><?php
		if (isset($page_title)) {
			echo $page_title . ' - I.A. RESTOnet';
		} else {
			echo 'Interface administrative de RestoNet';
		}
			?></title>
	</head>
	<body>
		<div id="global">
			<div id="entete">
				<h1>Interface administrative</h1>
				<p class="sous-titre">
					propriété de<strong> RestoNet</strong>
				</p>
			</div>
			<!-- #entete -->
			<div id="navigation">
				<?php
				include 'menu_admin.php';
				?>
			</div>
			<!-- #navigation -->
			<div id="contenu">
