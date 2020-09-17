<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] <> 'Enseignant') {
		header("Location: login_enseignant.php?cible=gestion_exos");
	}
}
else {
	header("Location: login_enseignant.php?cible=gestion_exos");
}

require_once('../Connections/conn_intranet.php');

if (isset($_GET['matiere_ID'])) {
	$matId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$nivId = htmlspecialchars($_GET['niveau_ID']);
}
if (isset($_GET['theme_ID'])) {
	$themeId = htmlspecialchars($_GET['theme_ID']);
}

$titre_page = "Confirmation de la suppression d'un exercice";
$meta_description = "Page de confirmation de la suppression d'un exercice";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<div class="text-center">
	<div>
		<p class="text-success font-weight-bold">L'exercice a été supprimé</p>
	</div>
	<div>
		<a class="btn btn-primary" href="gestion_exos.php?matiere_ID=<?php echo $matId; ?>&niveau_ID=<?php echo $nivId; ?>&theme_ID=<?php echo $themeId; ?>" role="button">Retourner sur la page de gestion des exercices</a>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php'); ?>