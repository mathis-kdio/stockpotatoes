<?php
$titre_page = "Licence attribuée aux logiciels et divers matériaux";
$meta_description = "Licence attribuée aux logiciels et divers matériaux mis en ligne (exercices, leçons etc.)";
$meta_keywords = "license";
// Ajouter ou non une feuille de style et/ou un script commun à tous les types d'exo
$js_deplus="";
$css_deplus = "";
require('include/fonctions.inc.php');
require('include/header.inc.php');
?>
<div class="row">
	<div class="col-lg-12">
		<section>
			<header>
        <h1><?php echo $titre_page ?></h1>
			</header>
			<article>
			
				<div class="row">
				  <div class="col-lg-2"></div>
					<div class="col-lg-8">
						<div class="card p-1 m-3 mx-auto d-block" style="width: 80%;">
							<img src="images/cc_licence.png" class="card-img-top" alt="licence">
							  <div class="card-body">
								<h2 class="card-title">Licence :</h2>
								<p class="h4 card-text text-center">Ce site et le contenu mis à disposition sont sous licence Creative Commons 3.0 France</p>
								<p class="h2 card-text text-center p-3 mb-2 bg-dark text-white">Attribution </p>
								<p class="h4 card-text text-center">🖝 Pas d’Utilisation Commerciale</p> 
								<p class="h4 card-text text-center">🖝 Partage dans les Mêmes Conditions </p>
								<p class="h5 card-text text-center">c'est à dire :</p> 
								<p>
									★ Ce site et le contenu (logiciels compris) ne peuvent pas faire l'objet d'une utilisation commerciale<br />
									★ Ce site et le contenu (logiciels compris) peuvent être modifiés et partagés à condition que&nbsp;:<br />
									➡ l'auteur soit cité<br />
									➡ le partage se fasse dans les mêmes conditions de licence.<br />
								</p>
								<p class="text-center">
									Utilisez le lien suivant pour voir une copie complète de cette licence : <b>http://creativecommons.org/licenses/by-nc-sa/3.0/fr/</b><br />
									<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/fr/" class="btn btn-primary m-3 ">Go</a>
								</p>
							  </div>
						</div>
					</div><!-- lg-8 -->
					<div class="col-lg-2"></div>
				</div><!-- row -->
      
      </article>
		</section>
	</div>
</div>
<?php
require('includefooter.inc.php');
?>