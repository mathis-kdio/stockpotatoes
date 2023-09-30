<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] != 'Administrateur') {
		header("Location: login_administrateur.php?cible=gestion_activite");
	}
}
else {
	header("Location: login_administrateur.php?cible=gestion_activite");
}

$titre_page = "Confirmation de la suppression de toutes les activités";
$meta_description = "Page de confirmation de la suppression de toutes les activités";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<div>
			<p class="text-success font-weight-bold">La réinitialisation de l'ensemble de la base activité à été effectuée</p>
		</div>
		<div>
			<a class="btn btn-primary" href="gestion_activite.php" role="button">Retourner sur la page de gestion des activités</a>
		</div>
	</div>
</div>

<?php
require('include/footerAdministrateur.inc.php'); ?>