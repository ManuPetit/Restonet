function setup_country_change() {
	// If #country is changed, then call update_cities()
	$('#presta').change(update_cities);
}

function update_cities() {
	var country = $('#presta').attr('value');
	// Call get_cities.php and when retrieved,
	// call show_cities() with the result.
	$.get('get_plat.php?prestaid=' + country, show_cities);
}

function show_cities(res) {
	// Replace contents of #cities with retrieved result
	$('#plat').html(res);
}


$(document).ready(setup_country_change);
