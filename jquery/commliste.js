$(function(){
	$("#commlist").jqGrid({
		url:'../business/comm_list.php',
		datatype: 'json',
		mtype: 'POST',
		colNames:['ID','Enseigne', 'Client','Commentaire','Date','Visible','Suppr.'],
		colModel :[ 
		  {name:'comteID', index:'comteID', width:35, align:'center'}, 
		  {name:'prestaNom', index:'prestaNom', width:150}, 
		  {name:'clientNom', index:'clientNom', width:115}, 
		  {name:'comteDescription', index:'comteDescription', width:270},
		  {name:'comteDate', index:'comteDate', width:100, align:'center'}, 
		  {name:'comteActif', index:'comteActif', width:80, align:'center'},
		  {name:'Suppr.', index:'Suppr', width:60, align:'center'} ,
		],    
		pager: '#cpager',
		rowNum:10,
		rowList:[10,20,30],
		sortname: 'prestaNom',
		sortorder: 'asc',
		viewrecords: true,
		height:'auto'
	}); 
});