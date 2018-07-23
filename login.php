<?php
//		login.php

//		fichier de connexion

//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';
require_once BUSINESS_DIR . 'cls_database_handler.php';
require_once BUSINESS_DIR . 'cls_login.php';
require_once BUSINESS_DIR . 'cls_motdepasse.php';
require_once BUSINESS_DIR . 'form.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$page_title = "Se connecter à RESTOnet";
$menu = 'm6';
$errors = array();
if (isset($_POST['logsub'])) {
	//verification des inputs
	if (!empty($_POST['ident'])) {
		if (preg_match('/^[a-zA-Z0-9 éèàçâêîôûùëïö]{3,25}$/i', trim($_POST['ident']))) {
			$ident = trim($_POST['ident']);
		} else {
			$errors['ident'] = 'Caractères invalides. Resaisissez votre identifiant.';
		}
	} else {
		$errors['ident'] = 'Vous devez entrer votre identifiant';
	}
	if (!empty($_POST['mdpas'])) {
		if (preg_match('/^[a-zA-Z0-9]{5,20}$/i', trim($_POST['mdpas']))) {
			$mpass = trim($_POST['mdpas']);
		} else {
			$errors['mdpas'] = 'Votre mot de passe ne peut contenir que des lettres (minuscules ou majuscules) et des chiffres,<br />et doit faire entre 5 et 20 caractères.';
		}
	} else {
		$errors['mdpas'] = 'Vous devez entrer votre mot de passe';
	}
	if (empty($errors)) {
		//on a pas d'erreur donc on va essayer de se logger
		$response = Login::CheckLogin($ident, $mpass);
		if ($response == 'admin') {
			$url = 'administration/index.php';
			header("Location: $url");
			exit();
		}else if ($response == 'presta') {
			$url = 'prestataire/index.php';
			header("Location: $url");
			exit();
		}else if ($response == 'client') {
			if (isset($_SESSION['lastpage'])) {
				$url = $_SESSION['lastpage'];
			} else {
				$url = 'index.php';
			}
			header("Location: $url");
			exit();
		} else {
			$errors['mdpas'] = $response;
		}
	}
}
include INCLUDE_DIR . 'header.php';
?>
<!-- COLONNE GAUCHE  -->

<div id="left">
  <?php
//afficher le panier
include BUSINESS_DIR . 'show_cart.php';
//affiche la carte france
include BUSINESS_DIR . 'francemap.php';
?>
</div>

<!-- CONTENU  -->
<div id="right">
  <h1>Connectez-vous à RESTOnet</h1>
  <div class="restcorn_t">
    <div class="restcorn_l">
      <div class="restcorn_r">
        <div class="restcorn_b">
          <div class="restcorn_tl">
            <div class="restcorn_tr">
              <div class="restcorn_bl">
                <div class="restcorn_br">
                  <div class="restcorn">
                  <p />
                    <fieldset>
                      <legend>Entrez vos détails de connexion :</legend>
                      <form action="login.php" method="post" accept-charset="utf-8">
                        <table border="0" width="90%" cellpadding="5">
                          <tr valign="top">
                            <td width="40%" align="right"><label for="ident"><strong>Identifiant de connexion :</strong></label></td>
                            <td><?php create_form_input('ident', 'text', $errors, 45, 25);?></td>
                          </tr>
                          <tr valign="top">                          
                            <td width="40%" align="right"><label for="mdpas"><strong>Mot de passe :</strong></label></td>
                            <td><?php create_form_input('mdpas', 'password', $errors, 45, 25);?></td>
                          </tr>
                          <tr valign="top">
                          <td width="40%" align="right">
                          <input type="submit" name="submit" id="submit" value="Se connecter" title="Cliquez ici pour vous connecter" />
                          </td>
                          <td>
                          <?php
						if (isset($_POST['logatt'])) {
							if ($_POST['logatt'] > 2) {
								//lien pour retrouver son mot de passe
								echo '<a class="fbutton" href="pass_reco.php" title="Cliquez ici si vous ne vous souvenez plus de votre mot de passe">Mot de passe oublié</a>';
							}
						}
						  ?>
                          </td></tr>
                        </table>
                      <div align="center">                        
                        <input type="hidden" name="logsub" id="logsub" value="TRUE" />
                        <input type="hidden" name="logatt" id="logatt" value="<?php
						if (isset($_POST['logatt'])) {
							$log = $_POST['logatt'] + 1;
							echo $log;
						} else {
							echo '1';
						}
					?>" />
                      </div>
                      </form>
                    </fieldset>
                    <p />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include INCLUDE_DIR . 'footer.php';
?>
