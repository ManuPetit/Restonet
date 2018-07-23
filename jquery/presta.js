// JavaScript Document
//fonctions pour la page create_admin_form.php
$(document).ready(function() {
	//variable de selection du premier tab
	var tabSelect = {
		selected : 0,
		disabled : [1, 2, 3, 4]
	};
	//mettre le premier tab en route
	$("#tabs").tabs(tabSelect);	
	$(".multiselect").multiselect({sortable: false, searchable: false});
	//add regex validator
	$.validator.addMethod("regex", function(value, element, regexp) {
		var check = false;
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	}, "<br />Certains caractères de cette entrée sont invalides");
	
	//préparation du datepicker
	$.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
	$( ".datepicker" ).datepicker({
		minDate : 0
	} );
	//fonction pour ajouter nom au pseudo
	$('#firstname, #lastname').blur(function() {
		if($('#username').val().length < 11) {
			var text1 = $('#firstname').val().toLowerCase();
			var text2 = $('#lastname').val().toLowerCase();
			if(text1.length > 5) {
				text1 = text1.substring(0, 5);
			}
			if(text2.length > 5) {
				text2 = text2.substring(0, 5);
			}
			$('#username').val(text1 + text2);
		}
	});
	
	//fonction autocomplete code postal
	$('#cpville1').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp1').val(ui.item.id);
			}
	});
	$('#cpville2').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp2').val(ui.item.id);
			}
	});
	$('#cpville3').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp3').val(ui.item.id);
			}
	});
	$('#cpville4').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp4').val(ui.item.id);
			}
	});
	$('#cpville5').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp5').val(ui.item.id);
			}
	});
	$('#cpville6').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp6').val(ui.item.id);
			}
	});
	$('#cpville7').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp7').val(ui.item.id);
			}
	});
	$('#cpville8').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp8').val(ui.item.id);
			}
	});
	$('#cpville9').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp9').val(ui.item.id);
			}
	});
	$('#cpville10').autocomplete({
			source: '../business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp10').val(ui.item.id);
			}
	});
	// validate signup form on keyup and submit
	var v = $("#cmxform").validate({
		rules : {
			enseigne : {
				required : true,
				minlength : 2,
				maxlength : 100,
				regex : "^[a-zA-Z0-9 éèàçâêîôûùëïö\'-,]{3,100}$"
			},
			firstname : {
				required : true,
				minlength : 2,
				maxlength : 25
			},
			lastname : {
				required : true,
				minlength : 2,
				maxlength : 45
			},
			username : {
				required : true,
				minlength : 2,
				maxlength : 25
			},
			email : {
				required : true,
				email : true
			},
			adresse1 : {
				required : true,
				maxlength : 60,
				regex : "^[a-zA-Z0-9 éèàçâêîôûùëïö\'-,]{1,60}$"
			},
			adresse2 : {
				regex : "^[a-zA-Z0-9 éèàçâêîôûùëïö\'-,]{0,60}$"
			},
			cpville :{
				required:true
			},
			telephone : {
				required : true,
				minlength:10,
				maxlength:10,
				digits:true
			},
			desc :{
				required:true,
				minlength:3,
				maxlength:10000
			}	
		},
		messages : {
			enseigne : {
				required : "<br />Ce champs ne peut pas être vide",
				minlength : "<br />L'enseigne doit avoir au moins deux lettres",
				maxlength : "<br />L'enseignene peut pas faire plus de 100 lettres"
			},
			firstname : {
				required : "<br />Ce champs ne peut pas être vide",
				minlength : "<br />Le prénom doit avoir au moins deux lettres",
				maxlength : "<br />Le prénom ne peut pas faire plus de 25 lettres"
			},
			lastname : {
				required : "<br />Ce champs ne peut pas être vide",
				minlength : "<br />Le nom doit avoir au moins deux lettres",
				maxlength : "<br />Le nom ne peut pas faire plus de 45 lettres"
			},
			username : {
				required : "<br />Ce champs ne peut pas être vide",
				minlength : "<br />L'identifiant doit avoir au moins 3 caractères",
				maxlength : "<br />L'identifiant ne peut pas faire plus de 25 caractères"
			},
			email : {
				required : "<br />Ce champs ne peut pas être vide",
				email : "<br />Veuillez entrer une adresse email valide"
			},
			adresse1 : {
				required : "<br />Ce champs ne peut pas être vide",
				maxlength : "<br />L'identifiant ne peut pas faire plus de 60 caractères"
			},
			cpville:{
				required :"<br />Ce champs ne peut pas être vide"
			},
			telephone : {
				required : "<br />Ce champs ne peut pas être vide",
				minlength:"<br/>Le numéro de téléphone doit faire 10 chiffres",
				maxlength:"<br/>Le numéro de téléphone ne peut faire que 10 chiffres",
				digits :"<br />Seul des chiffres sont autorisés"
			},
			desc :{
				required :"<br />Ce champs ne peut pas être vide",
				minlength :"<br />Votre description est trop courte",
				maxlength:"<br />Votre description est trop longue"
			}
		}
	});
	
	$("#goback0").click(function(){
		$("#tabs").tabs("select",0);
	});
	$("#goback1").click(function(){
		$("#tabs").tabs("select",1);
	});
	$("#goback2").click(function(){
		$("#tabs").tabs("select",2);
	});
	$("#goback3").click(function(){
		$("#tabs").tabs("select",3);
	});
	$("#goto1").click(function(){
		if (v.form()){
			$("#tabs").tabs("option","disabled",[2,3,4]);
			$("#tabs").tabs("select",1);
		}
	});
	$("#goto2").click(function(){
		if (v.form()){
			$("#tabs").tabs("option","disabled",[3,4]);
			$("#tabs").tabs("select",2);
		}
	});
	$("#goto3").click(function(){
		if (v.form()){
			$("#tabs").tabs("option","disabled",[4]);
			$("#tabs").tabs("select",3);
		}
	});
	$("#goto4").click(function(){
		if (v.form()){
			$("#tabs").tabs("option","disabled",[]);
			$("#tabs").tabs("select",4);
		}
	});
});
