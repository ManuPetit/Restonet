$(document).ready(function() {
	//function accodeon
	$("#accordion").accordion({
		active : '#actif',
		autoHeight : false
	});
	$('input:submit').button();
	$('.add1').button();
	$('.add2').button();
	$('.add3').button();
	$('.add4').button();
	$('.add5').button();
	$('.isbutton').button();
	//fonction pour créer la page des menus
	$('.add1').click(function() {
		var str = '<li><label>Plat : </label><input type="text" value="" name="plat1[]" size="70" maxlength="120"/>&nbsp;&nbsp;';
		str += '<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
		str += '</li>';
		$('#sites1').append(str);
	});

	$('.add2').click(function() {
		var str = '<li><label>Plat : </label><input type="text" value="" name="plat2[]" size="70" maxlength="120"/>&nbsp;&nbsp;&nbsp;';
		str += '<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
		str += '</li>';
		$('#sites2').append(str);
	});

	$('.add3').click(function() {
		var str = '<li><label>Plat : </label><input type="text" value="" name="plat3[]" size="70" maxlength="120"/>&nbsp;&nbsp;&nbsp;';
		str += '<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
		str += '</li>';
		$('#sites3').append(str);
	});

	$('.add4').click(function() {
		var str = '<li><label>Plat : </label><input type="text" value="" name="plat4[]" size="70" maxlength="120"/>&nbsp;&nbsp;&nbsp;';
		str += '<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
		str += '</li>';
		$('#sites4').append(str);
	});

	$('.add5').click(function() {
		var str = '<li><label>Plat : </label><input type="text" value="" name="plat5[]" size="70" maxlength="120"/>&nbsp;&nbsp;&nbsp;';
		str += '<input type="button" value="Supprimer" class="remove" title="Cliquez ici pour supprimer ce plat du groupe"/>';
		str += '</li>';
		$('#sites5').append(str);
	});

	$('.remove').live('click', function() {
		$(this).parent('li').remove();
	});
});