// JavaScript Document

//fonctions pour le tableau de bord des prestataires
$(document).ready(function() {
	//bouton
	$('.isbutton').button();
	$('input:submit').button();
	//function accodeon
	$("#accordion").accordion({
		active : '#actif',
		autoHeight : false
	});
	//fonction grille
	$("#list").jqGrid({
		url:'../business/presta_livre.php',
		datatype: 'json',
		mtype: 'POST',
		colNames:['Date','Numéro commande','Nom client','Details'],
		colModel :[ 
		  {name:'comDateLivre', index:'comDateLivre', width:150, align:'center'}, 
		  {name:'comNumero', index:'comNumero', width:180, align:'center'}, 
		  {name:'nomClient', index:'nomClient', width:290}, 
		  {name:'detail', index:'detail', width:200, sortable:false},
		],    
		pager: '#pager',
		rowNum:10,
		rowList:[10,20,30],
		sortname: 'comDateLivre',
		sortorder: 'desc',
		viewrecords: true,
		height:'auto'
	}); 
});