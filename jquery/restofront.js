// JavaScript Document

//fonctions pour la page create_admin_form.php
$(document).ready(function() {
	$('input:submit').button();
	$('a.fbutton').button();
	$('.cbutton').button();
	$('a.nbutton').button({disabled: true});
	$('.cmd').button();
	$('.mcmd').button();
	//variable de selection du premier tab
	var tabSelect = {
		selected : 0
	};
	//mettre le premier tab en route
	$("#tabs").tabs(tabSelect);
	//function pour passer le nombre de plat en base de donnée
	$(".cmd").click(function() {
		var i = $(".cmd").index(this);
		var id = $(".menu:eq(" + i + ")").val();
		var qt = $(".qte:eq(" + i + ")").val();
		$.ajax({
			type : "POST",
			url : "business/addtocart.php",
			dataType : 'json',
			data : "menuid=" + id + "&qte=" + qt,
			success : function(resp) {
				var t = resp.nbr;
				var a = resp.amt;
				if(t == 0) {
					$('.items').html("Votre panier est vide.");
					$('.panier').attr('src', 'images/common/paniervide.jpg');
				} else if(t == 1) {
					$('.items').html("Dans votre panier : " + t + " plat.<br />Montant panier : " + a + "&euro;.");
					$('.panier').attr('src', 'images/common/panierplein.jpg');
				} else if(t > 1) {
					$('.items').html("Dans votre panier : " + t + " plats.<br />Montant panier : " + a + "&euro;.");
					$('.panier').attr('src', 'images/common/panierplein.jpg');
				}
			},
			error : function(request, status, error) {
				alert('Il n\'a pas été possible d\'ajouter ce plat à la commande. Si le problème persiste, veuillez contacter l\'administrateur du site.');
			}
		});
	});
	$(".mcmd").click(function() {
		var i = $(".mcmd").index(this);
		var id = $(".mmenu:eq(" + i + ")").val();
		var qt = $(".mqte:eq(" + i + ")").val();
		$.ajax({
			type : "POST",
			url : "business/addtocartformenu.php",
			dataType : 'json',
			data : "menuid=" + id + "&qte=" + qt,
			success : function(data) {
				window.location.href = data.redirect;
			},
			error : function(request, status, error) {
				alert('Il n\'a pas été possible d\'ajouter ce plat à la commande. Si le problème persiste, veuillez contacter l\'administrateur du site.');
			}
		});
	});
	
	//function autocomplete pour code postal
	$('#cp1').autocomplete({
			source: 'business/villeparcp.php',
			minLength: 3,
			select: function(event, ui) {
				$('#cp').val(ui.item.id);
			}
	});
	
	//préparation du datepicker
	$.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
	$( ".datepicker" ).datepicker({
		minDate : 0
	} );
	//menu accordeon
	$("#accordion").accordion({
		active : '#actif',
		autoHeight : false
	});
});
