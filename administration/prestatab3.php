<!-- Troisème tab -->
<div id="tabs-3">
	<p>
		Vous devez choisir au moins une catégorie pour un prestataire.
	</p>
	<select id="categories" name="categories[]" class="multiselect" multiple="multiple">
		<?php
		for ($i = 0; $i < count($categ); $i++) {
			echo '<option value="' . $categ[$i]['categorieID'] . '"';
			if (isset($_POST['categories'])) {
				foreach ($_POST['categories'] as $val) {
					if ($val == $categ[$i]['categorieID']) {
						echo ' selected="selected"';
					}
				}
			}
			echo '>' . $categ[$i]['categorieNom'] . '</option>';
		}
			?>
		</select>
		<?php
		if (isset($errors['categories'])) {
			echo '<br /><span class="error">' . $errors['categories'] . '</span>';
		}
		?>
		<table width="100%" border="0" cellpadding="5px">
			<tr valign="top">
				<td align="left">
				<input class="isbutton" name="formback1" type="button" id="goback1" value="Précédent" />
				</td>
				<td></td>
				<td align="right">
				<input class="isbutton" name="formNext3" type="button" id="goto3" value="Continuer" />
				</td>
			</tr>
		</table>
</div>