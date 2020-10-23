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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE stock_theme SET theme = '%s' WHERE ID_theme = '%s'", htmlspecialchars($_POST['theme']), $themeId);

	$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header(sprintf("Location: gestion_theme.php?matiere_ID=".$matiereId."&niveau_ID=".$niveauId."#listeThemes"));
}

$choixtheme_RsChoixTheme = "0";
if (isset($themeId)) {
	$choixtheme_RsChoixTheme = $themeId;
}
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme = '%s'", $choixtheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error($conn_intranet));
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);

$titre_page = "Modification d'un thème";
$meta_description = "Page de modification d'un thème";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('includes/headerEnseignant.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<h4>Mofication du thème: "<?php echo $row_RsChoixTheme['theme'];?>"</h4>
		<form method="post" name="form1" action="modif_theme.php">
			<div class="form-group form-row justify-content-center">
				<div class="col-auto">
					<label for="theme">Modification du libellé du thème de l'étude</label>
					<input type="text" class="form-control" id="theme" name="theme" value="<?php echo $row_RsChoixTheme['theme']; ?>" required>
				</div>
			</div>
			<button type="submit" class="btn btn-primary mb-2">Mettre à jour l'enregistrement</button>
			<input type="hidden" name="ID_theme" value="<?php echo $row_RsChoixTheme['ID_theme']; ?>">
			<input type="hidden" name="ID_mat" id="ID_mat" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="ID_niv" id="ID_niv" value="<?php echo $niveauId; ?>">
			<input type="hidden" name="MM_update" value="form1">
		</form>
		<a class="btn btn-primary mt-3" href="gestion_theme.php?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $niveauId;?>#listeThemes" role="button">Abandonner la modification</a>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($RsChoixTheme); ?>