// JavaScript Document

//fonctions pour la page create_admin_form.php
$(document).ready(function() {
	$('input:submit').button();
	$('#print_button').button();
	$('#envoi_mail').button();
	$('.isbutton').button();
	$('.notenable').button({disabled: true});
	$('#affBut').button();
	$('#affButb').button();
	//fonction pour imprimer
	$('#print_button').click(function() {
		$('#selecttoprint').printElement({
			printMode : 'popup',
			pageTitle : 'Nouvel administrateur'
		});
	});

	//function affectation horaire
	$("#affBut").click(function(){
		var ha = $("#la1").val();
		var hb = $("#lb1").val();
		$("#ma1").val()=ha;
	});
	//fonction pour envoyer email
	$("#envoi_mail").click(function() {
		$("#loading").fadeIn(100).show();
		var to = $("#to").val();
		var subject = $("#subject").val();
		var content = $("#selecttoprint").val();

		var data = "to=" + to + "&subject=" + subject + "&content=" + content;
		$.ajax({
			type : "POST",
			url : "../administration/send_email.php",
			data : data,
			success : function() {

				$("#loading").fadeOut(100).hide();
				$('#message-sent').fadeIn(500).show();

			}
		});
	});
	//fonction autocomplete code postal
	$('#cpville').autocomplete({
		source : '../business/villeparcp.php',
		minLength : 3,
		select : function(event, ui) {
			$('#ville_id').val(ui.item.id);
		}
	});
	//function accodeon
	$("#accordion").accordion({
		active : '#actif',
		autoHeight : false
	});
	//fonction tooltip
	$('.adminToolTip').tipTip();
	//fonction pour ajouter nom au pseudo
	$('#adcreprenom, #adcrenom').blur(function() {
		if($('#adcrepseudo').val().length < 11) {
			var text1 = $('#adcreprenom').val().toLowerCase();
			var text2 = $('#adcrenom').val().toLowerCase();
			if(text1.length > 5) {
				text1 = text1.substring(0, 5);
			}
			if(text2.length > 5) {
				text2 = text2.substring(0, 5);
			}
			$('#adcrepseudo').val(text1 + text2);
		}
	});
	//fonction pour super administrateur
	$('#dialog-super').dialog({
		autoOpen : false,
		modal : true,
		buttons : {
			Ok : function() {
				$(this).dialog('close');
			}
		}
	});
	$('#super').change(function() {
		if($('#super option:selected').val() == 1) {
			$('#dialog-super').dialog('open');
		}
	});
});
