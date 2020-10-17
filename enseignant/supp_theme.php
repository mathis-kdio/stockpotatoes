<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] != 'Enseignant') {
		header("Location: login_enseignant.php?cible=gestion_theme");
	}
}
else {
	header("Location: login_enseignant.php?cible=gestion_theme");
}

require_once('../Connections/conn_intranet.php');

if (isset($_POST['ID_mat'])) {
	$matiereId = htmlspecialchars($_POST['ID_mat']);
}
if (isset($_POST['ID_niv'])) {
	$niveauId = htmlspecialchars($_POST['ID_niv']);
}
if (isset($_POST['ID_theme'])) {
	$themeId = htmlspecialchars($_POST['ID_theme']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['confirm'])) {
	$deleteSQL = sprintf("DELETE FROM stock_theme WHERE ID_theme = '%s'", $themeId);
	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

	$updateSQL = sprintf("UPDATE stock_quiz SET theme_ID = 0 WHERE theme_ID = '%s'", $themeId);
	$Result2 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header(sprintf("Location: supp_theme_confirm.php?matiere_ID=".$matiereId."&niveau_ID=".$niveauId));
}

$choixtheme_RsTheme = "0";
if (isset($themeId)) {
	$choixtheme_RsTheme = $themeId;
}
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme = '%s'", $choixtheme_RsTheme);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error($conn_intranet));
$row_RsTheme = mysqli_fetch_assoc($RsTheme);

$choixtheme_RsQuiz = "0";
if (isset($themeId)) {
	$choixtheme_RsQuiz = $themeId;
}
$query_RsQuiz = sprintf("SELECT * FROM stock_quiz WHERE theme_ID = '%s'", $choixtheme_RsQuiz);
$RsQuiz = mysqli_query($conn_intranet, $query_RsQuiz) or die(mysqli_error($conn_intranet));

$titre_page = "Suppression d'un thème - Vérification";
$meta_description = "Page de vérification de la suppression d'un thème";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('includes/headerEnseignant.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<h4>Suppression du thème <?php echo $row_RsTheme['theme']; ?></h4>
		<p>Le tableau ci-dessous affiche les éventuels exercices liès à ce thème.</p>
		<p>La suppression du thème entrainera leur réaffectation dans le thème Divers</p>
		<form name="form1" method="post" action="supp_theme.php">
			<button type="submit" class="btn btn-primary" name="confirm">Confirmer la suppression</button>
			<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
			<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
			<input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $themeId; ?>">
		</form>
			
		<a class="btn btn-primary mt-3" href="gestion_theme.php?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $niveauId;?>#listeThemes" role="button">Abandonner la suppression</a>
		
		<table class="table table-sm table-bordered mt-3">
			<thead>
				<tr> 
					<th scope="col">N°</th>
					<th scope="col">Titre de l'exercice</th>
					<th scope="col">Fichier</th>
					<th scope="col">Auteur</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row_RsQuiz = mysqli_fetch_assoc($RsQuiz)) { ?>
					<tr>
						<th scope="row"><?php echo $row_RsQuiz['ID_quiz']; ?></th>
						<td><?php echo $row_RsQuiz['titre']; ?></td>
						<td><?php echo $row_RsQuiz['fichier']; ?></td>
						<td><?php echo $row_RsQuiz['auteur']; ?></td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>
	</div>
</div>

<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($RsTheme);
mysqli_free_result($RsQuiz); ?>