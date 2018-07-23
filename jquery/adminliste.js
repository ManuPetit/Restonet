// JavaScript Document
//fonction d'alerte de suppression
function AlertSup($id) {
	var gook = 'admin_delete_form.php?adminid=' + $id;
	var mes = 'Etes vous certains de vouloir supprimer cet administrateur ?';
	if (confirm(mes)){
		window.location = gook;
	}
}
//fonctions pour la page create_liste_form.php
$(function(){
	//function accodeon
	$( "#accordion" ).accordion({active:'#actif',autoHeight:false});
	//fonction grille
	$("#list").jqGrid({
		url:'../business/admin_list.php',
		datatype: 'json',
		mtype: 'POST',
		colNames:['ID','Nom', 'Email','Ville','Activé','SuperAdmin','Dernier Login','Modif.','Suppr.'],
		colModel :[ 
		  {name:'adminID', index:'adminID', width:35, align:'center'}, 
		  {name:'nom', index:'nom', width:115}, 
		  {name:'userEmail', index:'userEmail', width:120}, 
		  {name:'ville', index:'ville', width:185},
		  {name:'adminActif', index:'adminActif', width:60, align:'center'}, 
		  {name:'isSuperAdmin', index:'isSuperAdmin', width:90, align:'center'},
		  {name:'userLastLogin', index:'userLastLogin', width:100, align:'center'} ,
		  {name:'edit', index:'edit', width:50, align:'center', sortable:false}, 
		  {name:'delete', index:'delete', width:50, align:'center', sortable:false}, 
		],    
		pager: '#pager',
		rowNum:10,
		rowList:[10,20,30],
		sortname: 'nom',
		sortorder: 'asc',
		viewrecords: true,
		height:'auto'
	}); 
}); 