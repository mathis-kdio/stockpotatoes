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

if (isset($_POST['classe'])) {
	$classe = htmlspecialchars($_POST['classe']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['confirmation'])) {
	$deleteSQL = sprintf("DELETE FROM stock_activite WHERE nom_classe = '%s'", $classe);
	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));
	
	header("Location: supp_activite_classe_confirm.php");
}

$titre_page = "Suppression des activités pour une classe";
$meta_description = "Page de suppression des activités pour une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<h4>Etes vous bien sûr de vouloir remettre à blanc toute la base activité de la classe: "<?php echo $classe; ?>"</h4>
			<form name="form1" method="post" action="supp_activite_classe.php">
				<button type="submit" class="btn btn-primary mb-2">Effacer la base activité pour cette classe</button>
				<input name="confirmation" type="hidden" id="confirmation" value="oui">
				<input name="classe" type="hidden" id="classe" value="<?php echo $classe; ?>">
			</form>
		<a class="btn btn-primary mt-3" href="gestion_activite.php" role="button">Abandonner la suppression</a>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php'); ?>