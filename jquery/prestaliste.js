//fonctions pour la page create_liste_form.php
function AlertSup($id) {
	var gook = 'presta_delete_form.php?prestaid=' + $id;
	var mes = 'Etes vous certains de vouloir supprimer ce prestataire (et de tous ses plats) ?';
	if (confirm(mes)){
		window.location = gook;
	}
}
$(function(){
	
	//fonction grille
	//fonction grille
	$("#plist").jqGrid({
		url:'../business/presta_list.php',
		datatype: 'json',
		mtype: 'POST',
		colNames:['ID','Enseigne', 'Nom','Ville','Activé','Commission','Dernier Login','Modif.'],
		colModel :[ 
		  {name:'prestaID', index:'prestaID', width:35, align:'center'}, 
		  {name:'prestaNom', index:'prestaNom', width:150}, 
		  {name:'nom', index:'nom', width:115}, 
		  {name:'ville', index:'ville', width:185},
		  {name:'prestaActif', index:'prestaActif', width:60, align:'center'}, 
		  {name:'commissionTaux', index:'commissionTaux', width:115, align:'center'},
		  {name:'userLastLogin', index:'userLastLogin', width:100, align:'center'} ,
		  {name:'edit', index:'edit', width:50, align:'center', sortable:false},  
		],    
		pager: '#ppager',
		rowNum:10,
		rowList:[10,20,30],
		sortname: 'prestaNom',
		sortorder: 'asc',
		viewrecords: true,
		height:'auto'
	}); 
	$("#psalist").jqGrid({
		url:'../business/presta_listsa.php',
		datatype: 'json',
		mtype: 'POST',
		colNames:['ID','Enseigne', 'Nom','Ville','Activé','Commission','Dernier Login','Modif.','Suppr.'],
		colModel :[ 
		  {name:'prestaID', index:'prestaID', width:30, align:'center'}, 
		  {name:'prestaNom', index:'prestaNom', width:140}, 
		  {name:'nom', index:'nom', width:115}, 
		  {name:'ville', index:'ville', width:170},
		  {name:'prestaActif', index:'prestaActif', width:60, align:'center'}, 
		  {name:'commissionTaux', index:'commissionTaux', width:95, align:'center'},
		  {name:'userLastLogin', index:'userLastLogin', width:100, align:'center'} ,
		  {name:'edit', index:'edit', width:45, align:'center', sortable:false},  
		  {name:'delete', index:'delete', width:45, align:'center', sortable:false},  
		],    
		pager: '#ppager',
		rowNum:10,
		rowList:[10,20,30],
		sortname: 'prestaNom',
		sortorder: 'asc',
		viewrecords: true,
		height:'auto'
	}); 
});