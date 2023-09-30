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

if (isset($_POST['ID_quiz'])) {
	$quizId = htmlspecialchars($_POST['ID_quiz']);
}
if (isset($_POST['ID_mat'])) {
	$matId = htmlspecialchars($_POST['ID_mat']);
}
if (isset($_POST['ID_niv'])) {
	$nivId = htmlspecialchars($_POST['ID_niv']);
}
if (isset($_POST['ID_theme'])) {
	$themeId = htmlspecialchars($_POST['ID_theme']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

function effacer($fichier) {
	if (file_exists($fichier)) {
		chmod($fichier,0777);
		if (is_dir($fichier)) {
			$id_dossier = opendir($fichier); 
			while($element = readdir($id_dossier)) {
				if ($element != "." && $element != "..")
				unlink($fichier."/".$element);
			}
			closedir($id_dossier);
			rmdir($fichier);
		}
		else {
			delete($fichier);
		}
	}
}

$query_RsMat = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $matId);
$RsMat = mysqli_query($conn_intranet, $query_RsMat) or die(mysqli_error($conn_intranet));
$row_RsMat = mysqli_fetch_assoc($RsMat);

$query_RsNiv = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = '%s'", $nivId);
$RsNiv = mysqli_query($conn_intranet, $query_RsNiv) or die(mysqli_error($conn_intranet));
$row_RsNiv = mysqli_fetch_assoc($RsNiv);

$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme = '%s'", $themeId);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error($conn_intranet));
$row_RsTheme = mysqli_fetch_assoc($RsTheme);

if ((isset($quizId)) && ($quizId != "")) {

	$choixquiz_RsQuiz = "0";
	if (isset($quizId)) {
		$choixquiz_RsQuiz = $quizId;
	}
	$query_RsQuiz = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = '%s'", $choixquiz_RsQuiz);
	$RsQuiz = mysqli_query($conn_intranet, $query_RsQuiz) or die(mysqli_error($conn_intranet));
	$row_RsQuiz = mysqli_fetch_assoc($RsQuiz);


	if (isset($_POST['confirm'])) {
		$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz = '%s'", $quizId);
		$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

		$repertoire = '../Exercices/'.$row_RsMat['nom_mat'].'/q'.$quizId;
		effacer($repertoire);

		$deleteGoTo = "";
		header("Location: supp_quiz_confirm.php?matiere_ID=".$matId."&niveau_ID=".$nivId."&theme_ID=".$themeId);

	}
}

$titre_page = "Suppression d'un exercice";
$meta_description = "Page de suppression d'un exercice";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<div class="text-center">
	<p>
		Vous avez demandé la suppression de l'exercice:<br>
		<span class="text-danger font-weight-bold">N°<?php echo $quizId.' '.$row_RsQuiz['titre']; ?></span><br>
		dans la matière: <?php echo $row_RsMat['nom_mat'];?> et le thème: <?php echo $row_RsTheme['theme'];?>
	</p>
	<form name="form1" method="post" action="supp_quiz.php">
		<button type="submit" name="confirm" class="btn btn-primary">Confirmer la suppression</button>
		<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $quizId;?>">
		<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matId;?>">
		<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $nivId;?>">
		<input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $themeId;?>">
	</form>
	<br>
	<a class="btn btn-primary" href="gestion_exos.php?matiere_ID=<?php echo $matId; ?>&niveau_ID=<?php echo $nivId; ?>&theme_ID=<?php echo $themeId; ?>" role="button">Abandonner et retourner à la gestion des exercices</a>
</div>

<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($RsQuiz); ?>