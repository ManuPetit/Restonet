<html>
	<head>
		<script src="/jquery.min.js"></script>
		<script>
			function setup_country_change() {
				// If #country is changed, then call update_cities()
				
					$('#cp1').change(update_cities);
			}

			function update_cities() {
				var country = $('#cp1').attr('value');
				// Call get_cities.php and when retrieved,
				// call show_cities() with the result.
				$.get('business/villeparcp.php',show_cities);
			}

			function show_cities(res) {
				// Replace contents of #cities with retrieved result
				$('#cities').html(res);
			}

			// Run setup_country_change() when the document is ready
			$(document).ready(setup_country_change);

		</script>
	</head>
	<body>
		<form>
			<table>
				<tr>
					<th>Country</th>
					<td>
					<input type="text" name="cp1" maxlength="5" size="10" />
				</tr>
				<tr>
					<th>cities</th>
					<td id="cities">please choose a country first</td>
				</tr>
			</table>
		</form>
	</body>
</html>