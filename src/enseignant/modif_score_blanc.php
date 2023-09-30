<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=modif_score_blanc");
	}
}
else
{
	header("Location: login_enseignant.php?cible=modif_score_blanc");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['ID_mat'])) {
	$matiereId = htmlspecialchars($_POST['ID_mat']);
}
if (isset($_POST['ID_niveau'])) {
	$niveauId = htmlspecialchars($_POST['ID_niveau']);
}
if (isset($_POST['ID_quiz'])) {
	$quizId = htmlspecialchars($_POST['ID_quiz']);
}
if (isset($_POST['classe'])) {
	$classeName = htmlspecialchars($_POST['classe']);
}

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));

$query_RsMatiere = "SELECT * FROM stock_matiere";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error($conn_intranet));

$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error($conn_intranet));

if (isset($matiereId) && isset($niveauId)) {
	$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND cat_doc = '2'", $matiereId, $niveauId);
	$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error($conn_intranet));
}

if (isset($classeName) && isset($quizId)) {
	$query_RsActiviteClasse = sprintf("SELECT * FROM stock_activite, stock_eleve WHERE stock_activite.quiz_ID = '%s' AND stock_activite.nom_classe = '%s'  AND stock_activite.eleve_ID = stock_eleve.ID_eleve ORDER BY stock_eleve.nom, stock_eleve.prenom ", $quizId, $classeName);
	$RsActiviteClasse = mysqli_query($conn_intranet, $query_RsActiviteClasse) or die(mysqli_error($conn_intranet));

	$query_Rs_quiz_choisi = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = '%s'", $quizId);
	$Rs_quiz_choisi = mysqli_query($conn_intranet, $query_Rs_quiz_choisi) or die(mysqli_error($conn_intranet));
	$row_Rs_quiz_choisi = mysqli_fetch_assoc($Rs_quiz_choisi);
}

$titre_page = "Effacer les résultats pour un exercice dans une classe";
$meta_description = "Page pour effacer les résultats pour un exercice dans une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form2" method="post" action="modif_score_blanc.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="classe" class="col-auto col-form-label">Sélectionner une classe :</label>
		<div class="col-auto">
			<select name="classe" id="select10" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir une classe</option>
				<?php
				while ($row_rsClasse = mysqli_fetch_assoc($rsClasse))
				{ ?>
					<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classeName)) { if (!(strcmp($row_rsClasse['classe'], $classeName))) {echo " SELECTED";} }?>><?php echo $row_rsClasse['classe']; ?></option>
					<?php
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit2" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>
<?php 
mysqli_free_result($rsClasse);
if (isset($classeName))
{?>
	<form name="form4" method="post" action="modif_score_blanc.php">
		<div class="form-group row align-items-center justify-content-center">
			<label for="ID_mat" class="col-auto col-form-label">Sélectionner une matière :</label>
			<div class="col-auto">
				<select name="ID_mat" id="select11" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir une matière</option>
					<?php
					while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere))
					{ ?>
						<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_RsMatiere['ID_mat'], $matiereId))) {echo " SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
						<?php
					} ?>
				</select>
			</div>
			<label for="ID_niveau" class="col-auto col-form-label">Sélectionner un niveau :</label>
			<div class="col-auto">
				<select name="ID_niveau" id="select7" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir un niveau</option>
					<?php
					while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau))
					{ ?>
						<option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_RsNiveau['ID_niveau'], $niveauId))) {echo " SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
						<?php
					} ?>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" name="Submit3" class="btn btn-primary">Sélectionner</button>
				<input name="classe" type="hidden" id="classe4" value="<?php echo $classeName; ?>">
			</div>
		</div>
	</form>
	<?php
	mysqli_free_result($RsMatiere);
	mysqli_free_result($RsNiveau);
}
if (isset($matiereId) && isset($niveauId))
{ ?>
	<form name="form1" method="post" action="modif_score_blanc.php">
		<div class="form-group row align-items-center justify-content-center">
			<label for="ID_quiz" class="col-auto col-form-label">Sélectionner un quiz :</label>
			<div class="col-auto">
				<select name="ID_quiz" id="select8" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir un quiz</option>
					<?php
					while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz))
					{ ?>
						<option value="<?php echo $row_Rsquiz['ID_quiz']?>"<?php if (isset($quizId)) { if (!(strcmp($row_Rsquiz['ID_quiz'], $quizId))) {echo " SELECTED";}} ?>><?php echo $row_Rsquiz['titre']?></option>
						<?php
					} ?>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" name="Submit" class="btn btn-primary">Sélectionner</button>
				<input name="classe" type="hidden" value="<?php echo $classeName; ?>">
				<input name="ID_mat" type="hidden" value="<?php echo $matiereId; ?>">
				<input name="ID_niveau" type="hidden" value="<?php echo $niveauId; ?>">
			</div>
		</div>
	</form>
	<?php
	mysqli_free_result($Rsquiz);
}
if (isset($quizId))
{ ?>
	<div class="row align-items-center justify-content-end bg-info mb-3 py-2">
		<div class="col-auto">
			<h4><?php echo $row_Rs_quiz_choisi['titre']; ?></h4>
		</div>
		<div class="col-auto">
			<button type="submit" name="print" onClick="javascript:window.print()" class="btn btn-primary">Imprimer</button>
		</div>
	</div>
	<div class="row justify-content-center mb-3">
		<div class="col-auto">		
			<form name="form3" method="post" action="modif_score_blanc_confirm.php">
				<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $quizId; ?>">
				<input name="classe" type="hidden" id="classe" value="<?php echo $classeName; ?>">
				<button type="submit" name="Submit4" class="btn btn-primary">Supprimer les résultats ci-dessous pour cet exercice dans cette classe</button>
			</form>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th scope="col">N° Elève</th>
					<th scope="col">Nom</th>
					<th scope="col">Classe</th>
					<th scope="col">N° Exercice</th>
					<th scope="col">Résultats</th>
					<th scope="col">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				while ($row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse))
				{ ?>
					<tr> 
						<td><?php echo $row_RsActiviteClasse['eleve_ID']; ?></td>
						<td><?php echo $row_RsActiviteClasse['nom']; ?> <?php echo $row_RsActiviteClasse['prenom']; ?></td>
						<td><?php echo $row_RsActiviteClasse['nom_classe']; ?></td>
						<td><?php echo $row_RsActiviteClasse['quiz_ID']; ?></td>
						<td><?php echo $row_RsActiviteClasse['score']; ?></td>
						<td><?php echo $row_RsActiviteClasse['debut']; ?></td>
					</tr>
					<?php 
				} ?>
			</tbody>
		</table>
	</div>
	<?php
	mysqli_free_result($RsActiviteClasse);
}

require('includes/footerEnseignant.inc.php'); ?>