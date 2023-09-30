<?php
session_start();
session_destroy();

$titre_page = "Accueil Stockpotatoes";
$meta_description = "Page principale de Stockpotatoes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$css_deplus = "";
require('includes/header.inc.php');
?>
<div class="row mt-3">
	<div class="col bg-info text-center shadow">
		<h3>Stockpotatoes: Le distributeur de patates chaudes!</h3>
	</div>
</div>
<div class="row mt-3 mb-3 justify-content-center">
	<div class="col-8 pt-2 pb-2 ">
		<div class="list-group">
			<a href="login_eleve.php" class="list-group-item list-group-item-action list-group-item-primary">Accès à l'espace Elève - Evaluation</a>
			<a href="accueil_visiteur.php" class="list-group-item list-group-item-action list-group-item-primary">Accès à l'espace Visiteur - Entrainement</a>
			<a href="upload/login_upload.php" class="list-group-item list-group-item-action list-group-item-primary">Envoyer un exercice ou un document sur le serveur</a>
			<a href="administrateur/login_administrateur.php" class="list-group-item list-group-item-action list-group-item-primary">Accès à l'espace Administrateur</a>
			<a href="enseignant/login_enseignant.php" class="list-group-item list-group-item-action list-group-item-primary">Accès à l'espace Enseignant</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col bg-info text-center shadow">
		<?php 
		include("includes/version.php"); ?>
		<h4>Version : <?php echo $versioninstallee;?></h4>
	</div>  
</div>
</section>
<?php
require('includes/footer.inc.php');
?>