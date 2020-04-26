<?php
$titre_page = "Stockpotatoes - Le distributeur de patates";
$meta_description = "Le distributeur de patates chaudes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="fonctions.js";
$css_deplus = "";

require('include/fonctions.inc.php');
require('include/header.inc.php');
?>
<div class="row">
	<div class="col-lg-12">
		<section>
			<header>
				<h1><?php echo $titre_page?></h1>
			</header>
			<article>
				<div class="container">
					<div class="row">
						<div class="col-lg-3">
							<img class="img-fluid rounded mx-auto d-block"  src="images/patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
						</div>
						<div class="col-lg-9 align-middle">
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;">Etape 1/5</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						  <ul>
							<li><a href="descriptif.php">Pr&eacute;sentation du produit</a></li>
							<li><a href="config.php">Cot&eacute; enseignant... A lire absolument</a></li>
							<li><a href="https://stockpotatoes.ovh/index.php">T&eacute;l&eacute;chargement et installation - Mise &agrave; jour</a></li>
						  </ul>
					</div><!--/.jumbotron -->
				</div><!--/.container -->
			</article>
		</section>
	</div><!-- fin class=col-lg-12 -->
</div><!-- fin class row -->
<?php
require('include/footer.inc.php');
?>        