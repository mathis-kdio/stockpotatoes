<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] != 'Enseignant') {
		header("Location: login_enseignant.php?cible=gestion_categorie");
	}
}
else {
	header("Location: login_enseignant.php?cible=gestion_categorie");
}

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}

$titre_page = "Confirmation de la suppression d'une catégorie";
$meta_description = "Page de confirmation de la suppression d'une catégorie";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<div class="text-center">
	<div>
		<p class="text-success font-weight-bold">La catégorie a été supprimé</p>
	</div>
	<div>
		<a class="btn btn-primary" href="gestion_categorie.php?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $niveauId;?>#listeCategories" role="button">Retourner sur la page de gestion des catégorie</a>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php'); ?>