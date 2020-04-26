<?php
$titre_page = "Etape 5 de l'installation de stockpotatoes";
$meta_description = "Installation d'un éditeur HTML en ligne.";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="fonctions.js";
$css_deplus = "";

require('include/fonctions.inc.php');
require_once('../Connections/conn_editeur.inc.php');
require('include/header.inc.php');
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
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;">Etape 5/5</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<p class="h5 bg-dark text-white text-center p-2"><?php echo $meta_description ?></p>
						<form action="install_editeur2.php" method="post" name="parametres">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td>
											<p>
												<strong>Dossier racine </strong><br /> 
												URL de votre serveur. <br /> 
												Laisser vide dans le cas d'un Intranet.<br /> 
												Dans les autres cas, indiquer le chemin complet : http://nom_de_votre_serveur<br /> 
												Chez Free, ce sera par exemple <span style="color: #990000;"><strong>http://votre_login.free.fr</strong></span><br />
												Attention à ne pas mettre de barre oblique à la fin de votre adresse.</p>
										</td>
										<td>
											<p><input id="url_base" maxlength="80" name="url_base" size="40" type="texte" value="<?php echo $url_base ?>" /></p>
										</td>
									</tr>
									<tr>
										<td>
											<p><strong>Nom du chemin des fichiers images</strong><br />
												Cette valeur par défaut convient normalement (convient pour Free notamment)<br />
												Attention si vous avez renommé stockpotatoes.<br />
												Cela deviendra /votre_dossier_stockpotatoes/Exercices/UserFiles/
											</p>
											<p>Attention aux barres obliques (début et fin).</p>
											<p>
												Respecter majuscules et minuscules<br /> 
												Si des problêmes subsistaient, vérifier que vous possédez les droits en écriture sur ce dossier UserFiles et ses sous dossiers.
											</p>
											<p>Vérifiez que le dossier est bien à la racine de votre serveur</p>
											<p>
												Exemple. Si l'adresse du site hébergé sur le serveur académique est <br /> 
												http://www.etab.ac-caen.fr/bsauveur. <br /> 
												Je dois donc mettre dans cette boite de formulaire<br /> 
												/bsauveur/stockpotatoes/Exercices/UserFiles/
											</p>
										</td>
										<td>
											<p><input id="chemin_images" maxlength="80" name="chemin_images" size="40" type="text" value="<?php echo $chemin_images ?>" /></p>
										</td>
									</tr>
									<tr>
										<td>
											<p>
												<strong>Chemin de l'éditeur</strong><br />
												Cette valeur par défaut convient normalement.
											</p>
											<p>
												Respecter majuscules et minuscules<br />
												Attention si vous avez renommé stockpotatoes.<br /> 
												Attention aux barres obliques. (début et fin)
											</p>
										</td>
										<td>
											<p><input id="chemin_editeur" maxlength="80" name="chemin_editeur" size="40" type="text" value="/stockpotatoes/upload/" /></p>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<div align="center">
												<p><input name="verif" type="submit" value="Enregistrer ces paramètres " /></p>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div><!--/.jumbotron -->
				</div><!--/.container -->
			</article>
		</section>
	</div><!-- fin class=col-lg-12 -->
</div><!-- fin class row -->
<?php
require('include/footer.inc.php');
?>
