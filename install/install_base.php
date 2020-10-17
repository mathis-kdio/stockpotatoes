<?php 
$serveur 	= $_POST['serveur'] ;
$login		= $_POST['login'] ;
$password	= $_POST['password'] ;
$base		= $_POST['base'] ;
$port		= $_POST['port'] ;


$titre_page = "Création de la base de données";
$meta_description = "Essai de création de la base ";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="fonctions.js";
$css_deplus = "";
require('include/fonctions.inc.php');
require('include/header.inc.php');

creer_base($serveur, $login, $password, $base, $retour);

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
							<div class="h3 bg-info text-center p-3" style="margin-top: 50px;"><?php echo $meta_description."<span class=\"badge badge-success\">". $base ."</span>" ?></div>	
						</div>
					</div>
					<div class="jumbotron m-3">
						<blockquote class="p-3">			
							<div class="h4 alert alert-primary m-3 text-center"><?php echo "Résultat : ". $retour ?></div>

							<form Method="POST" Action="install_etape3.php">
								<input type="hidden" id="serveur" name="serveur" size="25" maxlength="80" value="<?php echo $serveur ?>">
								<input type="hidden" id="username" name="login" size="25" maxlength="80" value="<?php echo $login ?>">
								<input type="hidden" id="password" name="password" size="25" maxlength="80" value="<?php echo $password ?>" >
								<input type="hidden" id="base" name="base"  size="25" maxlength="80" value="<?php echo $base ?>">
								<input type="hidden" id="port" name="port"  size="25" maxlength="80" value="<?php echo $port ?>">
								<p class="text-center m-3">
									<button type="submit" name="Submit" class="btn btn-primary">Etape suivante 👉</button>
								</p>
							</form>
						</blockquote>
					</div><!--/.jumbotron -->
				</div><!--/.container -->
			</article>
		</section>
	</div><!-- fin class=col-lg-12 -->
</div><!-- fin class row -->
<?php
require('include/footer.inc.php');
?> 