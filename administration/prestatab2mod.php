<!-- Deuxième tab -->
<div id="tabs-2">
	<table width="100%" border="0" cellpadding="5px">
		<tr valign="top">
			<td width="40%" align="right"><label for="desc">Description :</label></td>
			<td></td>
			<td><?php create_form_edit('desc', 'textarea2', $errors, 40, 10000, $mpresta -> GetPrestaDescription());?></td>
		</tr>
		<tr valign="top">
			<td align="right" width="40%"><label for="img">Fichier image &agrave; t&eacute;l&eacute;charger :</label></td>
			<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Image : </b><br />L'ajout d'une image est falcutatif.<br />Les fichiers acceptés sont de type *.gif et *.jpg.<br />La taille maximum du fichier est de 5Mo.<br />Le fichier sera automatiquement mis à l'échelle pour être inclus dans le site internet." /></td>
			<td><?php
			echo '<input type="file" size="50" name="img" id="img"';
			if (array_key_exists('img', $errors)) {
				echo ' class="error" /><span class="error">' . $errors['img'] . '</span>';
			} else {
				echo ' />';
				if (isset($_SESSION['img'])) {
					echo "<br />Actuellement '" . $_SESSION['img']['file_name'] . "'";
				}
			}
			?><br /><small>(optionnel)</small><br /><small>Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo.</small><?php
			if (($mpresta -> GetPrestaImage() != '') && (!isset($_SESSION['img']))) {
				echo '<p>L\'image actuelle est la suivante :</p><p><img src="';
				echo '../images/prestataire/' . $mpresta -> GetPrestaImage();
				echo '" title="image représentant ' . $mpresta -> GetPrestaNom() . ' sur le site RESTOnet" border="0" alt="image représentant ' . $mpresta -> GetPrestaNom();
				echo ' sur le site RESTOnet" /></p>';
			}
			?></td>
		</tr>
		<tr valign="top">
			<td width="40%" align="right"><label for="actif">Prestataire actif : </label></td>
			<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>ATTENTION : </b><br />Il est recommandé de ne pas activé le prestataire tant que ses plats n'ont pas été ajoutés à la base de données." /></td>
			<td>
			<select name="actif">
				<?php
				if (isset($_POST['actif'])) {
					if ($_POST['actif'] == 1) {
						echo '<option value="1" selected="selected">Oui</option>
<option value="0">Non</option>';
					} else {
						echo '<option value="1">Oui</option>
<option value="0" selected="selected">Non</option>';
					}
				} else {
					if ($mpresta -> GetPrestaActif() == 1) {
						echo '<option value="1" selected="selected">Oui</option>
<option value="0">Non</option>';
					} else {
						echo '<option value="1">Oui</option>
<option value="0" selected="selected">Non</option>';
					}
				}
				?>
			</select></td>
		</tr>
		<tr valign="top">
			<td width="40%" align="right"><label for="commission">Taux de commission : </label></td>
			<td></td>
			<td>
			<select name="commission">
				<?php
				if (isset($_POST['commission'])) {
					for ($i = 0; $i < count($comm); $i++) {
						if ($comm[$i]['commissionID'] == $_POST['commission']) {
							echo '<option value="' . $comm[$i]['commissionID'] . '" selected="selected">' . $comm[$i]['commissionNom'] . '</option>';
						} else {
							echo '<option value="' . $comm[$i]['commissionID'] . '">' . $comm[$i]['commissionNom'] . '</option>';
						}
					}
				} else {
					for ($i = 0; $i < count($comm); $i++) {
						echo '<option value="' . $comm[$i]['commissionID'] . '"';
						if ($comm[$i]['commissionID'] == $mpresta -> GetPrestaCommissionID()) {
							echo ' selected="selected"';
						}
						echo '>' . $comm[$i]['commissionNom'] . '</option>';
					}
				}
				?>
			</select></td>
		</tr>
		<tr valign="top">
			<td width="40%" align="right"><label for="valeur">Choix d'affichage : </label></td>
			<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Affichage : </b><br />Ce choix permet de mettre en valeur un prestataire, selon l'option choisie." /></td>
			<td>
			<select name="valeur">
				<?php
				if (isset($_POST['valeur'])) {
					for ($i = 0; $i < count($valeur); $i++) {
						if ($valeur[$i]['valeurID'] == $_POST['valeur']) {
							echo '<option value="' . $valeur[$i]['valeurID'] . '" selected="selected">' . $valeur[$i]['valeurNom'] . '</option>';
						} else {
							echo '<option value="' . $valeur[$i]['valeurID'] . '">' . $valeur[$i]['valeurNom'] . '</option>';
						}
					}
				} else {
					for ($i = 0; $i < count($valeur); $i++) {
						echo '<option value="' . $valeur[$i]['valeurID'] . '"';
						if ($valeur[$i]['valeurID'] == $mpresta -> GetPrestaMiseEnValeur()) {
							echo ' selected="selected"';
						}
						echo '>' . $valeur[$i]['valeurNom'] . '</option>';
					}
				}
				?>
			</select></td>
		</tr>
		<tr valign="top">
			<td width="40%" align="right"><label for="delai">Délai de préparation de la commande : </label></td>
			<td></td>
			<td>
			<select name="delai">
				<?php
				if (isset($_POST['delai'])) {
					for ($i = 0; $i < count($delai); $i++) {
						if ($delai[$i]['id'] == $_POST['delai']) {
							echo '<option value="' . $delai[$i]['id'] . '" selected="selected">' . $delai[$i]['temps'] . '</option>';
						} else {
							echo '<option value="' . $delai[$i]['id'] . '">' . $delai[$i]['temps'] . '</option>';
						}
					}
				} else {
					for ($i = 0; $i < count($delai); $i++) {
						echo '<option value="' . $delai[$i]['id'] . '"';
						if ($delai[$i]['id'] == $mpresta -> GetPrestaDelaiPrep()) {
							echo ' selected="selected"';
						}
						echo '>' . $delai[$i]['temps'] . '</option>';
					}
				}
				?>
			</select></td>
		</tr>
		<tr valign="top">
			<td width="40%" align="right"><label for="commaxi">Nombre maxi de commande :</label></td>
			<td><img src="../images/css/greeninfo2.jpg" width="16" height="16" border="0" class="adminToolTip" title="<b>Maximum : </b><br />Choisissez le nombre maximun de commande du prestataire par tranche horaire." /></td>
			<td>
			<select name="commaxi">
				<?php
				if (isset($_POST['commaxi'])) {
					for ($i = 15; $i > 0; $i--) {
						if ($_POST['commaxi'] == $i) {
							echo '<option value="' . $i . '" selected="selected">' . $i . ' commandes</option>';
						} else {
							echo '<option value="' . $i . '">' . $i . ' commandes</option>';
						}
					}
				} else {
					for ($i = 15; $i > 0; $i--) {
						if ($i == $mpresta -> GetComdeMaxi()) {
							echo '<option value="' . $i . '" selected="selected">' . $i . ' commandes</option>';
						} else {
							echo '<option value="' . $i . '">' . $i . ' commandes</option>';
						}
					}
				}
				?>
			</select></td>
		</tr>
		<tr valign="top">
			<td align="left">
			<input class="isbutton" name="formback0" type="button" id="goback0" value="Précédent" />
			</td>
			<td></td>
			<td align="right">
			<input class="isbutton" name="formNext2" type="button" id="goto2" value="Continuer" />
			</td>
		</tr>
	</table>
</div>