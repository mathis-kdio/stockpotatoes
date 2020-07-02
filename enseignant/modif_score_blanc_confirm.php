<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=modif_score_blanc_confirm");
	}
}
else
{
	header("Location: login_enseignant.php?cible=modif_score_blanc_confirm");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['ID_quiz']) && isset($_POST['classe']))
{
	$deleteSQL = sprintf("DELETE FROM stock_activite WHERE nom_classe = '%s' AND quiz_ID = '%s'", htmlspecialchars($_POST['classe']), htmlspecialchars($_POST['ID_quiz']));

	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));
}

$titre_page = "Confirmation de l'effaçage les résultats pour un exercice dans une classe";
$meta_description = "Page pour confirmer l'effaçage les résultats pour un exercice dans une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<div class="text-center">
	<h4>Classe : <?php echo $_POST['classe']; ?></h4>
	<h4>Exercice N°<?php echo $_POST['ID_quiz']; ?></h4>
	<h4>Suppression effectuée</h4>
	<a class="btn btn-primary" href="modif_score_blanc.php" role="button">Revenir sur la page de suppression</a>
</div>

<?php
require('includes/footerEnseignant.inc.php');
?>