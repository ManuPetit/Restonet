<?php
// payement.php
//fichier de création du paiement


 session_start();
 
 //mode d'appel
 $PBX_MODE = '1';
 //pour lancement paiement par exécution
 //$PBX_MODE        = '1';    //pour lancement paiement par URL
 //identification
 $PBX_SITE = '1999888';
 $PBX_RANG = '98';
 $PBX_IDENTIFIANT = '3';
 //gestion de la page de connection : paramétrage "invisible"
 $PBX_WAIT = '0';
 $PBX_TXT = "";
 $PBX_BOUTPI = "nul";
 $PBX_BKGD = "white";
 //informations paiement (appel)
 $PBX_TOTAL = $_SESSION['prixTTC'];
 $PBX_DEVISE = '978';
 $PBX_CMD = $_SESSION['cmdid'];
 $PBX_PORTEUR = $_SESSION['email'];
 //informations nécessaires aux traitements (réponse)
 $PBX_RETOUR = "montant:M;ref:R;auto:A;trans:T";
 $PBX_EFFECTUE = "http://www.restonet.fr/reussi.php";
 $PBX_REFUSE = "http://www.restonet.fr/refuse.php";
 $PBX_ANNULE = "http://www.restonet.fr/annule.php";
 //page en cas d'erreur
 $PBX_ERREUR = "http://www.restonet.fr/erreur.php";
 //page retour pour validation
 $PBX_REPONDRE_A = "http://www.restonet.fr/business/validcomde.php";

//lancement paiement par URL
$url="http://www.restonet.fr/cgi-bin/modulev3.cgi?PBX_MODE=$PBX_MODE&PBX_SITE=$PBX_SITE&PBX_RANG=$PBX_RANG&PBX_IDENTIFIANT=$PBX_IDENTIFIANT&PBX_WAIT=$PBX_WAIT&PBX_TXT=$PBX_TXT&PBX_BOUTPI=$PBX_BOUTPI&PBX_BKGD=$PBX_BKGD&PBX_TOTAL=$PBX_TOTAL&PBX_DEVISE=$PBX_DEVISE&PBX_CMD=$PBX_CMD&PBX_PORTEUR=$PBX_PORTEUR&PBX_EFFECTUE=$PBX_EFFECTUE&PBX_REFUSE=$PBX_REFUSE&PBX_ANNULE=$PBX_ANNULE&PBX_ERREUR=$PBX_ERREUR&PBX_RETOUR=$PBX_RETOUR&PBX_REPONDRE_A=$PBX_REPONDRE_A";
 
header("Location: $url");
exit();
?>



