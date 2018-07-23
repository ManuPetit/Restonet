<?php
//		conditions.php
//		page des conditions générales de vente
//ajouter les fichiers d'utilités
require_once 'configs/configs.php';
require_once BUSINESS_DIR . 'cls_error_handler.php';

//preparer le handler d'erreur
ErrorHandler::SetHandler();

$page_title = "Conditions générales de vente de RESTOnet";
$menu = 'm7';
include INCLUDE_DIR . 'header.php';
//necessaire pour retourner à la page après la connection
$_SESSION['lastpage'] = basename($_SERVER['PHP_SELF']);

echo '<!-- COLONNE GAUCHE  -->
    <div id="left">';

include INCLUDE_DIR . 'openboxfront.php';
echo '<h3 class="boitetitleleft">Sommaire</h3>';
?>
<div id="conditions">
	<a href="#haut" title="Voir le préambule de nos conditions générales de vente">Préambule</a>
	<br />
	<a href="#p1" title="Aller à la section objet de nos conditions générales de vente">Étendue du service</a>
	<br />
	<a href="#p2" title="Aller à la section biens et services de nos conditions générales de vente">Tarifs et Garantie </a>
	<br />
	<a href="#p3" title="Aller à la section tarifs de nos conditions générales de vente">Confidentialité</a>
	<br />
	<a href="#p4" title="Aller à la section aire géographique de nos conditions générales de vente">Gratuité</a>
	<br />
	<a href="#p5" title="Aller à la section commandes de nos conditions générales de vente">Carte bancaire</a>
	<br />
	<a href="#p6" title="Aller à la section rétraction de nos conditions générales de vente">Annulation</a>
	<br />
	<a href="#p7" title="Aller à la section paiement de nos conditions générales de vente">Correspondance future</a>
	<br />
	<a href="#p8" title="Aller à la section livraison de nos conditions générales de vente">Commentaires clients</a>
	<br />
	<a href="#p9" title="Aller à la section garantie de nos conditions générales de vente">Déni de responsabilité</a>
	<br />
	<a href="#p10" title="Aller à la section responsabilité de nos conditions générales de vente">Divers</a>
	<br />
</div>
<?php
include INCLUDE_DIR . 'closeboxfront.php';

echo '</div>

<!-- CONTENU  -->
<div id="right">
<h1>Conditions générales d\'utilisation</h1>
<a name="haut" id="haut">&nbsp;</a>';

include INCLUDE_DIR . 'openboxfront.php';
?>
<h3 class="boitetitle">Préambule</h3>
<p>
	Les présentes conditions générales d’utilisation, qui sont susceptibles d’être modifiées de façon ponctuelle, s’appliquent à tous nos services, disponibles directement ou indirectement (par le biais de nos partenaires) en ligne, par e-mail ou par téléphone. En accédant à notre site Internet ou à toute autre plate-forme (désignés ensemble par « le site Internet »), en y effectuant des recherches, en l’utilisant et/ou en y effectuant une réservation, un paiement vous déclarez avoir pris connaissance des présentes conditions générales d’utilisation et de notre charte de confidentialité, en comprendre la portée et les accepter.
</p>
<p>
	Ces pages, leur contenu et leur infrastructure, ainsi que le service de commandes en ligne qui est fourni sur ces pages et par l’intermédiaire de ce site Internet (le « Service ») appartiennent à, sont gérés et sont fournis par RESTOnet. Ils sont uniquement mis à votre disposition pour un usage personnel et non commercial qui demeure soumis aux conditions générales d’utilisation établies ci-dessous.
</p>
<h3 class="boitetitle">Étendue de notre service<a name="p1" id="p1">&nbsp;</a></h3>
<p>
	Par le biais de ce site Internet, nous (RESTOnet et ses partenaires (de distribution) affiliés) fournissons un portail en ligne grâce auquel les restaurants peuvent proposer leurs cartes ou menus, et grâce auquel les visiteurs du site Internet peuvent effectuer une commande dans ces mêmes restaurants. En effectuant une commande par l’intermédiaire de RESTOnet.fr, vous vous engagez dans une relation contractuelle directe avec le restaurant concerné par votre commande. À partir du moment où vous effectuez une commande, nous agissons uniquement en qualité d’intermédiaire entre vous et le restaurant, en lui transmettant les détails de votre commande et en vous envoyant un e-mail de confirmation pour et en son nom.
</p>
<p>
	Lors de la prestation de nos services, les informations que nous communiquons se fondent sur les informations que nous donnent les restaurants. Les restaurants se voient donc donner toutes les informations à RESTOnet.fr,  adresse, jours et heures d’ouverture et de fermeture, leur type de cuisine, leur type de prestation (livrer, emporter ou sur place) leur menus ou cartes, leurs tarifs afin d’actualiser le site si nécessaire.Bien que nous nous efforcions de fournir un service de qualité, nous ne pouvons ni vérifier, ni garantir l'exactitude, la précision ou l'exhaustivité des informations, et nous ne pouvons être tenus pour responsables de toute erreur (erreur manifeste ou faute typographique), toute interruption de service (due à une défaillance technique, qu’elle soit temporaire et/ou partielle, panne, réparation, mise à jour, amélioration ou maintenance de notre site Internet ou autre), toute information imprécise, trompeuse ou erronée, ou bien tout manque d’information. Chaque restaurant demeure responsable à tout moment du caractère précis, complet et exact des informations (descriptives) qui le concernent et qui sont affichées sur notre site Internet, y compris de ses tarifs et disponibilités. Notre site Internet ne constitue pas et ne doit pas être considéré comme une quelconque forme de recommandation ou d’approbation de la qualité, du niveau de service ou du classement de chaque restaurant proposé aux visiteurs.
</p>
<p>
	Nos services sont uniquement disponibles pour une utilisation privée et non-commerciale. Vous ne pouvez donc pas revendre, utiliser, copier, surveiller (par exemple, par le biais d’un robot d’indexation ou de captures de données d’écran), afficher, télécharger, reproduire ou établir des liens profonds vers tout contenu ou toute information, tout logiciel et/ou tous produits ou services disponibles sur notre site Internet dans le cadre d’une activité ou d’un objectif commercial ou concurrentiel.
</p>
<h3 class="boitetitle">Tarifs et Garantie du Meilleur Tarif<a name="p2" id="p2">&nbsp;</a></h3>
<p>
	Les tarifs proposés sur notre site Internet sont très compétitifs. Tous les tarifs affichés sur le site Internet RESTOnet.fr sont indiqués selon les choix effectués. Ils comprennent la TVA et toutes les autres taxes (soumises à modification), sauf mention contraire sur notre site Internet ou sur l’e-mail de confirmation de réservation.
</p>
<p>
	Veuillez consulter avec attention les descriptions des cartes, menus, des disponibilités du restaurants et des tarifs pour prendre connaissance de telles conditions avant d’effectuer votre commande.
</p>
<h3 class="boitetitle">Confidentialité des informations<a name="p3" id="p3">&nbsp;</a></h3>
<p>
	RESTOnet.fr  applique une déontologie professionnelle exigeante et s’engage à respecter votre vie privée. À l’exception de la communication de vos nom, adresse e-mail et coordonnées de carte bancaire au service bancaire qui effectuera la transaction pour valider votre commande, et des divulgations d’informations exigées par la loi, nous ne communiquons pas vos informations personnelles à des tiers sans votre consentement. Toutefois, nous nous réservons le droit de divulguer vos informations personnelles à nos partenaires affiliés et à leurs employés (qu’ils soient basés dans l’Union européenne ou en dehors), ainsi qu’à nos employés, nos agents et nos représentants officiels, à qui nous avons autorisé l'accès à ces informations et qui en ont besoin pour assurer notre service pour vous et en votre nom (ce qui comprend les Services Clients et les services internes d’audit et de respect des procédures). 
</p>
<h3 class="boitetitle">Gratuité<a name="p4" id="p4">&nbsp;</a></h3>
<p>
	L’accessibilité et les recherches effectuées sur le site sont gratuites. Nous prélevons sur votre carte bancaire la somme affichée dans votre panier et seulement après validé le cheminement suivant : votre identification, validation de votre panier, paiement effectué par carte bancaire. Un mail de confirmation vous sera envoyé avec toutes les informations bancaires et votre numéro de commande.
</p>
<h3 class="boitetitle">Carte bancaire<a name="p5" id="p5">&nbsp;</a></h3>
<p>
	Les coordonnées de votre carte bancaire sont exigées par le site afin de garantir le paiement de votre commande. De ce fait, nous envoyons directement ces données au service bancaire concerné et nous nous réservons également le droit de vérifier (c’est-à-dire de préautoriser) votre carte bancaire. Afin de protéger et de crypter les données de votre carte bancaire lorsqu’elles transitent par notre site, la technologie standard de sécurité SSL (« Secure Socket Layer ») est employée lors de la prestation de nos services.
</p>
<p>
	Avant d’effectuer votre commande, veuillez consulter avec attention la description de votre panier (votre commande) pour prendre connaissance de telles conditions.
</p>
<p>
	En cas d’utilisation frauduleuse de votre carte bancaire ou d’utilisation non autorisée de celle-ci par des tiers, la plupart des banques et des sociétés émettrices de cartes de crédit couvrent le risque et assument tous les frais résultant de ladite fraude ou utilisation non autorisée, déduction faite d’une franchise éventuelle (généralement fixée à 50 EUR ou l’équivalent dans votre devise locale). Si votre banque ou société de carte de crédit facture cette franchise à la suite d’une transaction non autorisée résultant d’une réservation effectuée sur notre site Internet, nous ne vous remboursons pas ladite franchise. 
</p>
<h3 class="boitetitle">Annulation<a name="p6" id="p6">&nbsp;</a></h3>
<p>
	Veuillez noter que certains tarifs ou offres spéciales ne permettent pas d’annuler ou de modifier la commande. Vous êtes donc invité à prendre connaissance des conditions de chaque offre avant d’effectuer votre commande.
</p>
<p>
	Si vous souhaitez consulter, modifier ou annuler votre commande, veuillez-vous reporter à l’e-mail de confirmation et suivre les instructions qui y sont indiquées. Veuillez noter que chaque annulation peut entraîner des frais. Nous vous conseillons de lire attentivement les conditions d’annulation avant d’effectuer votre commande.
</p>
<h3 class="boitetitle">Correspondance future<a name="p7" id="p7">&nbsp;</a></h3>
<p>
	En effectuant une commande, vous acceptez de recevoir(i) un e-mail de confirmation qui contiendra tous les informations de votre commande. 
</p>
<h3 class="boitetitle">Commentaires clients<a name="p8" id="p8">&nbsp;</a></h3>
<p>
	Vos commentaires peuvent être (a) affichés sur notre site Internet, sur la page du restaurant concerné, dans le seul but d’informer les (futurs) clients de votre opinion sur la qualité en générale du restaurant, sa prestation et (b) utilisé (partiellement ou dans sa totalité) par RESTOnet.fr à sa seule discrétion (à des fins marketing ou promotionnelles ou pour améliorer nos services) sur notre site Internet ou sur des réseaux sociaux, lettres d'information, offres spéciales, applications ou autre moyen utilisé, géré ou contrôlé par RESTOnet. Nous nous réservons le droit de normaliser, refuser ou supprimer tout commentaire à notre seule discrétion.
</p>
<h3 class="boitetitle">Déni de responsabilité<a name="p9" id="p9">&nbsp;</a></h3>
<p>
	Conformément aux limites établies dans les présentes conditions générales d’utilisation et autorisées par la loi, nous ne pouvons être tenus responsables que si vous avez souffert, payé ou subi des dommages directs pouvant être imputés à un défaut de nos obligations dans le cadre de nos services. Ces dommages peuvent s’élever jusqu’au montant cumulé du coût total de commande, tel qu’indiqué dans l’e-mail de confirmation, qu’il s’agisse d’un événement isolé ou d’une série d’événements liés.
</p>
<p>
	Néanmoins et dans la mesure prévue par la loi, ni nous ni nos dirigeants, cadres, employés, représentants, filiales, affiliés, distributeurs, partenaires (de distribution), titulaires de sous-licences, agents ou autres personnes impliquées dans la création, le sponsoring, la promotion ou la mise à disposition du site et de ses contenus, ne pouvons être tenus responsables pour (i) toutes pertes ou tous dommages punitifs, spéciaux, indirects ou consécutifs, perte de production, perte de profit, perte de revenu, perte d’opportunité commerciale, perte ou atteinte à la marque ou à la réputation, ou bien perte du droit à indemnité ; (ii) toute inexactitude liée aux informations (descriptives) du restaurant (y compris ses tarifs, ses disponibilités et son classement) mises à disposition sur notre site Internet ; (iii) tous services fournis ou produits proposés par le restaurant ; (iv) tous dommages, pertes et coûts (punitifs, spéciaux, indirects ou consécutifs) soufferts, subis ou payés par vous, imputables à, découlant de ou liés à l’utilisation de notre site Internet, de l’impossibilité de son utilisation ou de son ralentissement de fonctionnement ; ou (v) tout dommage corporel, décès, dommage aux biens ou autres dommages, pertes ou coûts (directs, indirects, spéciaux, consécutifs ou punitifs) soufferts, subis ou payés par vous, qu’ils soient dus à des actes (légaux), des erreurs, des manquements, une négligence (grave), une faute professionnelle délibérée, des omissions, une inexécution de contrat, des dénaturations des faits, au tort ou à la responsabilité objective attribuable entièrement ou partiellement au restaurant (ses employés, sa direction, ses responsables, ses agents, ses représentants ou ses affiliés), y compris toute annulation (même partielle), surréservation, grève, cas de force majeure ou autre événement indépendant de notre volonté.
</p>
<h3 class="boitetitle">Divers<a name="p10" id="p10">&nbsp;</a></h3>
<p>
	Sauf mention contraire, le logiciel nécessaire pour nos services ou mis à disposition sur notre site Internet et utilisé par ce dernier, ainsi que les droits de propriété intellectuelle (y compris les droits d’auteur) des contenus, informations et matériels de notre site Internet, sont la propriété exclusive de RESTOnet.fr, de ses fournisseurs ou de ses prestataires.
</p>
<p>
	Si l’une des dispositions de ces conditions générales d’utilisation est ou devient invalide, non-exécutoire ou non-contraignante, vous demeurez lié par toutes les autres dispositions établies dans ces conditions. Si tel est le cas, les dispositions invalides devront être appliquées dans les limites possibles de la loi et vous acceptez de vous conformer à des dispositions qui auraient les mêmes effets que les termes invalides, non-exécutoires ou non-contraignants de ces conditions générales d’utilisation.
</p>
<?php
include INCLUDE_DIR . 'closeboxfront.php';
echo '</div>';

include INCLUDE_DIR . 'footer.php';
?>  