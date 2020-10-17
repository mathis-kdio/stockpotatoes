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

require_once('../Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['confirmation'])) {
	$deleteSQL = sprintf(("DELETE FROM stock_activite"));
	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));
		
	header("Location: supp_activite_total_confirm.php");
}

$titre_page = "Suppression de toutes les activités";
$meta_description = "Page de suppression de toutes les activités";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<h4>Etes vous bien sûr de vouloir remettre à blanc toutes les activités de l'établissement</h4>
		<form name="form1" method="post" action="supp_activite_total.php">
			<button type="submit" class="btn btn-primary mb-2">Effacer la base activité</button>
			<input type="hidden" name="confirmation" id="confirmation" value="oui">
		</form>
		<a class="btn btn-primary mt-3" href="gestion_activite.php" role="button">Abandonner la suppression</a>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php'); ?>