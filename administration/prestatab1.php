<!-- Premier tab -->
		<div id="tabs-1">
			<table width="100%" border="0" cellpadding="5px">
				<tr valign="top">
					<td width="40%" align="right"><label for="enseigne">Enseigne commerciale :</label></td>
	        		<td></td>
	        		<td><?php create_form_input('enseigne', 'text', $errors, 50, 100);?></td>
      			</tr>    
				<tr valign="top">
					<td width="40%" align="right"><label for="firstname">Pr&eacute;nom du prestataire :</label></td>
	        		<td></td>
	        		<td><?php create_form_input('firstname', 'text', $errors, 40, 25);?></td>
      			</tr>      			
				<tr valign="top">
					<td width="40%" align="right"><label for="lastname">Nom du prestataire :</label></td>
	        		<td></td>
	        		<td><?php create_form_input('lastname', 'text', $errors, 40, 45);?></td>
      			</tr>
      			<tr valign="top">
					<td width="40%" align="right"><label for="username">Identifiant :</label></td>
	        		<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Identifiant :</b><br />Il est nécessaire pour se connecter à l'interface des prestataire de RESTOnet.<br />Vous pouvez utiliser celui qui a été auto-générer par le système ou, entrer celui de votre choix." /></td>
	        		<td><?php create_form_input('username', 'text', $errors, 40, 25);?></td>
      			</tr>      			
				<tr valign="top">
					<td width="40%" align="right"><label for="email">Adresse email :</label></td>
	        		<td></td>
	        		<td><?php create_form_input('email', 'text', $errors, 40, 45);?></td>
      			</tr>
      			<tr valign="top">
      				<td width="40%" align="right"><label for="adresse1">Première ligne d'adresse :</label></td>
      				<td></td>
      				<td><?php create_form_input('adresse1', 'text', $errors, 50, 80);?></td>
				</tr>
				<tr valign="top">
					<td width="40%" align="right"><label for="adresse2">Deuxième ligne d'adresse :</label></td>
					<td></td>
					<td><?php create_form_input('adresse2', 'text', $errors, 50, 80);?>
					<br />
					<small>(Optionnel)</small></td>
				</tr>
				<tr valign="top">
					<td width="40%" align="right"><label for="cpville">Ville : </label></td>
					<td></td>
					<td><?php create_form_input('cpville', 'text', $errors, 50, 80);?>
					<br />
					<small>Entrez le code postal de la ville pour la selectionner</small></td>
				</tr>
				<tr valign="top">
					<td width="40%" align="right"><label for="telephone">Numéro de téléphone :</label></td>
					<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Téléphone : </b>Seulement les chiffres. Pas d'espaces entre les chiffres." /></td>
					<td><?php create_form_input('telephone', 'text', $errors, 20, 10);?></td>
				</tr>
				<tr valign="top">
					<td align="left"></td>
					<td></td>
					<td align="right"><input class="isbutton" name="formNext1" type="button" id="goto1" value="Continuer" /></td>
				</tr>
			</table>
		</div>