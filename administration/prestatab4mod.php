<!-- Quatrieme tab -->
<div id="tabs-4">
	<p>
		Choisissez au moins un type de livraison par prestataire.
	</p>
	<select id="livraison" name="livraisons[]" class="multiselect" multiple="multiple">
		<?php
		for ($i = 0; $i < count($livrais); $i++) {
			echo '<option value="' . $livrais[$i]['livraisonID'] . '"';
			if (isset($_POST['livraisons'])) {
				foreach ($_POST['livraisons'] as $val) {
					if ($val == $livrais[$i]['livraisonID']) {
						echo ' selected="selected"';
					}
				}
			} else {
				foreach ($mpresta->GetPrestaTypeLivraison() as $val) {
					if ($val == $livrais[$i]['livraisonID']) {
						echo ' selected="selected"';
					}
				}
			}
			echo '>' . $livrais[$i]['livraisonNom'] . '</option>';
		}
		?>
	</select>
	<?php
	if (isset($errors['livraisons'])) {
		echo '<br /><span class="error">' . $errors['livraisons'] . '</span>';
	}
	//pour les villes de livraison
	$lville=array('','','','','','','','','','');
	$i=0;
	foreach ($mpresta->GetVilleLivraisonListe() as $val){
		$lville[$i]= $val;
		$i++;
	}
	?>
	<p>
		Ajouter les villes que votre prestataire souhaite livrer.
	</p>
	<table width="100%" border="0" cellpadding="5px">
		<tr valign="top">
			<td width="50%"><label for="cpville1">Ville 1 : </label>
			<br />
			<?php create_form_edit('cpville1', 'text', $errors, 50, 80,$lville[0]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
			<td><label for="cpville2">Ville 2 : </label>
			<br />
			<?php create_form_edit('cpville2', 'text', $errors, 50, 80,$lville[1]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
		</tr>
		<tr valign="top">
			<td width="50%"><label for="cpville3">Ville 3 : </label>
			<br />
			<?php create_form_edit('cpville3', 'text', $errors, 50, 80,$lville[2]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
			<td><label for="cpville4">Ville 4 : </label>
			<br />
			<?php create_form_edit('cpville4', 'text', $errors, 50, 80,$lville[3]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
		</tr>
		<tr valign="top">
			<td width="50%"><label for="cpville5">Ville 5 : </label>
			<br />
			<?php create_form_edit('cpville5', 'text', $errors, 50, 80,$lville[4]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
			<td><label for="cpville6">Ville 6 : </label>
			<br />
			<?php create_form_edit('cpville6', 'text', $errors, 50, 80,$lville[5]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
		</tr>
		<tr valign="top">
			<td width="50%"><label for="cpville7">Ville 7 : </label>
			<br />
			<?php create_form_edit('cpville7', 'text', $errors, 50, 80,$lville[6]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
			<td><label for="cpville8">Ville 8 : </label>
			<br />
			<?php create_form_edit('cpville8', 'text', $errors, 50, 80,$lville[7]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
		</tr>
		<tr valign="top">
			<td width="50%"><label for="cpville9">Ville 9 : </label>
			<br />
			<?php create_form_edit('cpville9', 'text', $errors, 50, 80,$lville[8]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
			<td><label for="cpville10">Ville 10 : </label>
			<br />
			<?php create_form_edit('cpville10', 'text', $errors, 50, 80,$lville[9]);?>
			<br />
			<small>Entrez le code postal de la ville pour la selectionner</small></td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="5px">
		<tr valign="top">
			<td align="left">
			<input class="isbutton" name="formback2" type="button" id="goback2" value="Précédent" />
			</td>
			<td align="right">
			<input class="isbutton" name="formNext4" type="button" id="goto4" value="Continuer" />
			</td>
		</tr>
	</table>
</div>