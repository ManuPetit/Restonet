<!-- Premier tab -->
		<div id="tabs-1">
			<table width="100%" border="0" cellpadding="5px">
				<tr valign="top">
					<td width="40%" align="right"><label for="enseigne">Enseigne commerciale :</label></td>
	        		<td></td>
	        		<td><?php create_form_edit('enseigne', 'text', $errors, 50, 100,$mpresta->GetPrestaNomCommercial());?></td>
      			</tr>    
				<tr valign="top">
					<td width="40%" align="right"><label for="firstname">Pr&eacute;nom du prestataire :</label></td>
	        		<td></td>
	        		<td><?php create_form_edit('firstname', 'text', $errors, 40, 25,$mpresta->GetPrestaPrenom());?></td>
      			</tr>      			
				<tr valign="top">
					<td width="40%" align="right"><label for="lastname">Nom du prestataire :</label></td>
	        		<td></td>
	        		<td><?php create_form_edit('lastname', 'text', $errors, 40, 45,$mpresta->GetPrestaNom());?></td>
      			</tr>
      			<tr valign="top">
					<td width="40%" align="right"><label for="username">Identifiant :</label></td>
	        		<td></td>
	        		<td><?php echo '<input type ="text" size="40" name="username" readonly="readonly" class="readonly" value="' . $mpresta->GetPrestaPseudo() . '" />';
						echo '<br /><small>Ce champs ne peut être changé que par le titulaire du compte.</small>';
						?></td>
      			</tr>      			
				<tr valign="top">
					<td width="40%" align="right"><label for="email">Adresse email :</label></td>
	        		<td></td>
	        		<td><?php echo '<input type ="text" size="40" name="email" readonly="readonly" class="readonly" value="' . $mpresta->GetPrestaEmail() . '" />';
						echo '<br /><small>Ce champs ne peut être changé que par le titulaire du compte.</small>';
						?></td>
      			</tr>
      			<tr valign="top">
      				<td width="40%" align="right"><label for="adresse1">Première ligne d'adresse :</label></td>
      				<td></td>
      				<td><?php create_form_edit('adresse1', 'text', $errors, 50, 80,$mpresta->GetPrestaAdresse1());?></td>
				</tr>
				<tr valign="top">
					<td width="40%" align="right"><label for="adresse2">Deuxième ligne d'adresse :</label></td>
					<td></td>
					<td><?php create_form_edit('adresse2', 'text', $errors, 50, 80,$mpresta->GetPrestaAdresse2());?>
					<br />
					<small>(Optionnel)</small></td>
				</tr>
				<tr valign="top">
					<td width="40%" align="right"><label for="cpville">Ville : </label></td>
					<td></td>
					<td><?php create_form_edit('cpville', 'text', $errors, 50, 80,$mpresta->GetVilleEtCP());?>
					<br />
					<small>Entrez le code postal de la ville pour la selectionner</small></td>
				</tr>
				<tr valign="top">
					<td width="40%" align="right"><label for="telephone">Numéro de téléphone :</label></td>
					<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Téléphone : </b>Seulement les chiffres. Pas d'espaces entre les chiffres." /></td>
					<td><?php create_form_edit('telephone', 'text', $errors, 20, 10,$mpresta->GetPrestaTelephone());?></td>
				</tr>
				<tr valign="top">
					<td align="left"></td>
					<td></td>
					<td align="right"><input class="isbutton" name="formNext1" type="button" id="goto1" value="Continuer" /></td>
				</tr>
			</table>
		</div>