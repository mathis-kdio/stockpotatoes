<?php
$titre_page = "Modification des droits en &eacute;criture";
$meta_description = "Le distributeur de patates chaudes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="../fonctions.js";
$css_deplus = "";
require('include/fonctions.inc.php');
require('include/header.inc.php');

$fichier1='../Exercices/';
//chmod($fichier1,0777);
chmod_R( $fichier1, 0777, 0777);

$fichier2='../Connections/';
//chmod($fichier2,0777);
chmod_R( $fichier2, 0777, 0777);
?>
<div class="row">
	<div class="col-lg-12">
		<section>
			<header>
				<h1><?php echo $titre_page ?></h1>
			</header>
			<article>
				<div class="container">
					<div class="row">
						<div class="col-lg-3">
							<img class="img-fluid rounded mx-auto d-block"  src="images/patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
						</div>
						<div class="col-lg-9 align-middle">
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;">Chmod</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<blockquote>
							<p class="h3 alert alert-secondary text-center">Tentative d'attribution des droits en &eacute;criture via un chmod 777</p>
							<div align="left">Les &eacute;l&eacute;ments concern&eacute;s sont :
								<ul>
									<li>Le dossier<strong> Exercices </strong></li>
									<li>Le fichier <strong>Connections/gestion_pass.inc.php</strong> (mots de passe)</li>
									<li>Le fichier <strong>Connections/conn_intranet.php</strong> (param&egrave;tres de connection)</li>
								</ul>
								<p align="left">En cas de probl&egrave;me, (messages d'erreurs en haut de page), il vous faudra attribuer<strong> ces droits manuellement</strong> (avec votre outil Ftp par exemple)</p>
							</div>
						</blockquote>
						<p align="center">
							<strong><a type="button" class="btn btn-secondary" href="index.php">🖜 Retour &agrave; l'&eacute;tape 1</a> - <a type="button" class="btn btn-secondary" href="install_etape2.php">Passer &agrave; l'&eacute;tape 2 🖝</a></strong>
						</p>
					</div><!--/.jumbotron -->
				</div><!--/.container -->
			</article>
		</section>
	</div><!-- fin class=col-lg-12 -->
</div><!-- fin class row -->
<?php
require('include/footer.inc.php');
?>        