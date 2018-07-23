<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
		//refresh de la page des commandes du jour
		$lapage = basename($_SERVER['PHP_SELF']);
		if ($lapage == 'presta_cmd_jour.php'){
			echo '<meta http-equiv="refresh" content="120" >';
		}
		?>
		<link rel="stylesheet" type="text/css" href="../styles/presta.css" />
		<link rel="stylesheet" href="../styles/jquery-ui-1.8.18.presta.css" />
		<script type="text/javascript" src="../jquery/jquery-1.6.4.min.js"></script>
		<script src="../jquery/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="../jquery/tableau.js"></script>
		<?php
		if ($lapage == 'presta_cmd_livre.php') {
			echo '<link rel="stylesheet" href="../styles/ui.jqgrid.css" />
			<script type="text/javascript" src="../jquery/grid.locale-fr.js"></script>
			<script type="text/javascript" src="../jquery/jquery.jqGrid.min.js"></script>';
		}
		if (($lapage == 'platcreatemenu.php') || ($lapage == 'platcreatemenumod.php')) {
			echo '<script type="text/javascript" src="../jquery/createmenu.js"></script>';
		} 	
		?>
		<title><?php
		//retrouver le nom du prestataire
		$nom = Prestataire::GetEnseigne($_SESSION['prestaid']);
		if (isset($page_title)) {
			echo $page_title . ' - ' . $nom . ' sur RESTOnet';
		} else {
			echo $nom . ' sur RESTOnet';
		}
			?></title>
	</head>
	<body>
		<div id="global">
			<div id="entete">
				<h1>Tableau de bord : <?php echo $nom; ?></h1>
				<p class="sous-titre">
					propriété de<strong> RestoNet</strong>
				</p>
			</div>
			<!-- #entete -->
			<div id="navigation">
				<?php
				include 'menu_presta.php';
				?>
			</div>
			<!-- #navigation -->
			<div id="contenu">
