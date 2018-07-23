<!-- Cinquième tab -->
<div id="tabs-5">
	<p>
		Choisissez les horaires d'ouverture pour chaque jour.
		<br/>
		<b>Attention :</b> si un établissement est fermé une journée, n'entrez aucune tranche horaire
	</p>
	<table width="100%" border="1" cellpadding="5px">
		<tr valign="top">
			<th>Jours</th>
			<th>Première plage horaire</th>
			<th>Deuxième plage horaire</th>
		</tr>
		<tr>
			<!-- lundi -->
			<td width="10%">Lundi</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="la1" name="la1">
					<?php
					if (isset($_POST['la1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['la1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="lb1" name="lb1">
					<?php
					if (isset($_POST['lb1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['lb1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['lb1'])){
					echo '<br /><span class="error">'.$errors['lb1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="la2" name="la2">
					<?php
					if (isset($_POST['la2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['la2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="lb2" name="lb2">
					<?php
					if (isset($_POST['lb2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['lb2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['lb2'])){
					echo '<br /><span class="error">'.$errors['lb2'].'</span>';
				}
				?>
			</p></td>
		</tr>
		<!-- mardi -->
		<tr>
			<td width="10%">Mardi</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="ma1" name="ma1">
					<?php
					if (isset($_POST['ma1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['ma1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="mb1" name="mb1">
					<?php
					if (isset($_POST['mb1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['mb1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['mb1'])){
					echo '<br /><span class="error">'.$errors['mb1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="ma2" name="ma2">
					<?php
					if (isset($_POST['ma2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['ma2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="mb2" name="mb2">
					<?php
					if (isset($_POST['mb2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['mb2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['mb2'])){
					echo '<br /><span class="error">'.$errors['mb2'].'</span>';
				}
				?>
			</p></td>
		</tr>
		<!-- mercredi -->
		<tr>
			<td width="10%">Mercredi</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="wa1" name="wa1">
					<?php
					if (isset($_POST['wa1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['wa1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="wb1" name="wb1">
					<?php
					if (isset($_POST['wb1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['wb1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['wb1'])){
					echo '<br /><span class="error">'.$errors['wb1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="wa2" name="wa2">
					<?php
					if (isset($_POST['wa2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['wa2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="wb2" name="wb2">
					<?php
					if (isset($_POST['wb2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['wb2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['wb2'])){
					echo '<br /><span class="error">'.$errors['wb2'].'</span>';
				}
				?>
			</p></td>
		</tr>
		<!-- jeudi -->
		<tr>
			<td width="10%">Jeudi</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="ja1" name="ja1">
					<?php
					if (isset($_POST['ja1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['ja1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="jb1" name="jb1">
					<?php
					if (isset($_POST['jb1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['jb1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['jb1'])){
					echo '<br /><span class="error">'.$errors['jb1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="ja2" name="ja2">
					<?php
					if (isset($_POST['ja2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['ja2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="jb2" name="jb2">
					<?php
					if (isset($_POST['jb2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['jb2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['jb2'])){
					echo '<br /><span class="error">'.$errors['jb2'].'</span>';
				}
				?>
			</p></td>
		</tr>
		<!-- vendredi -->
		<tr>
			<td width="10%">Vendredi</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="va1" name="va1">
					<?php
					if (isset($_POST['va1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['va1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="vb1" name="vb1">
					<?php
					if (isset($_POST['vb1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['vb1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['vb1'])){
					echo '<br /><span class="error">'.$errors['vb1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="va2" name="va2">
					<?php
					if (isset($_POST['va2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['va2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="vb2" name="vb2">
					<?php
					if (isset($_POST['lb2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['vb2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['vb2'])){
					echo '<br /><span class="error">'.$errors['vb2'].'</span>';
				}
				?>
			</p></td>
		</tr>
		<!-- samedi -->
		<tr>
			<td width="10%">Samedi</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="sa1" name="sa1">
					<?php
					if (isset($_POST['sa1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['sa1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="sb1" name="sb1">
					<?php
					if (isset($_POST['sb1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['sb1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['sb1'])){
					echo '<br /><span class="error">'.$errors['sb1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="sa2" name="sa2">
					<?php
					if (isset($_POST['sa2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['sa2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="sb2" name="sb2">
					<?php
					if (isset($_POST['sb2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['sb2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['sb2'])){
					echo '<br /><span class="error">'.$errors['sb2'].'</span>';
				}
				?>
			</p></td>
		</tr>
		<!-- dimanche -->
		<tr>
			<td width="10%">Dimanche</td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="da1" name="da1">
					<?php
					if (isset($_POST['da1'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['da1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="db1" name="db1">
					<?php
					if (isset($_POST['db1'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['db1'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['db1'])){
					echo '<br /><span class="error">'.$errors['db1'].'</span>';
				}
				?>
			</p></td>
			<td width="45%">
			<p>
				De&nbsp;&nbsp;
				<select id="da2" name="da2">
					<?php
					if (isset($_POST['da2'])) {
						echo '<option value="0">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['da2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Début</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				&nbsp;&nbsp;à&nbsp;&nbsp;
				<select id="db2" name="db2">
					<?php
					if (isset($_POST['db2'])) {
						echo '<option value="0">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '"';
							if ($_POST['db2'] == $heure[$i]['plaHorID']) {
								echo ' selected="selected"';
							}
							echo '>' . $heure[$i]['plaHorNom'] . '</option>';
						}
					} else {
						echo '<option value="0" selected="selected">Horaire Fin</option>';
						for ($i = 0; $i < count($heure); $i++) {
							echo '<option value="' . $heure[$i]['plaHorID'] . '">' . $heure[$i]['plaHorNom'] . '</option>';
						}
					}
					?>
				</select>
				<?php
				if (isset($errors['db2'])){
					echo '<br /><span class="error">'.$errors['db2'].'</span>';
				}
				?>
			</p></td>
		</tr>
	</table>
	<p>
		Si vous connaissez une période de fermeture du prestataire, veuillez l'inscrire ci-après :
	</p>
	<label for="condebut">Début de la période de fermeture : </label>
	<input type="text" class="datepicker" name="condebut" size="20" maxlength="10" value="<?php
	if (isset($_POST['condebut']))
		echo $_POST['condebut'];
	?>" />
	<br />
	<br />
	<label for="confin">Début de la période de fermeture : </label>
	<input type="text" class="datepicker" name="confin" size="20" maxlength="10" value="<?php
	if (isset($_POST['confin']))
		echo $_POST['confin'];
	?>" />
	<?php
	if (isset($errors['confin'])){
		echo '<br /><span class="error">'.$errors['confin'].'</span>';
	}
	?>
	<input type="hidden" id="ville_id" name="ville_id" value="<?php
	if (isset($_POST['ville_id']))
		echo $_POST['ville_id'];
	?>" />
	<?php
	//nécessaire pour les villes de livraison
	for ($i = 1; $i < 11; $i++) {
		$cp = 'cp' . $i;
		echo '
	<input type="hidden" id="' . $cp . '" name="' . $cp . '" value="';
		if (isset($_POST[$cp])) {
			echo $_POST[$cp];
		}
		echo '" />
	';
	}
	?>
	<table width="100%" border="0" cellpadding="5px">
		<tr valign="top">
			<td align="left">
			<input class="isbutton" name="formback3" type="button" id="goback3" value="Précédent" />
			</td>
			<td align="right">
			<input type="submit" name="submit" value="Création du prestataire" />
			</td>
		</tr>
	</table>
	<input type="hidden" name="prestasub" value="TRUE" />
</div>
</form> 