<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_quiz_avecmodif");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_quiz_avecmodif");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['matiere_ID'])) {
	$matiereId = htmlspecialchars($_POST['matiere_ID']);
}
else if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_POST['niveau_ID'])) {
	$niveauId = htmlspecialchars($_POST['niveau_ID']);
}
else if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}

function sans_accent($chaine) 
{ 
	 $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
	 $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
	 return strtr(trim($chaine), $accent,$noaccent); 
}

if ((isset($_POST["Submit2"])) && ($_POST["Submit2"] == "form2"))
{
	if ($_POST['en_ligne'] == 'O')
	{
		$en_ligne = 'O';
	}
	else
	{
		$en_ligne = 'N';
	}
	if ($_POST['avec_score'] == 'O')
	{
		$avec_score = 'O';
	}
	else
	{
		$avec_score = 'N';
	}
	$updateSQL = sprintf("UPDATE stock_quiz SET avec_score = '%s', en_ligne = '%s' WHERE ID_quiz = '%s' ORDER BY matiere_ID, niveau_ID", $avec_score, $en_ligne, htmlspecialchars($_POST['tablist']));

	$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header('Location: liste_quiz_avecmodif.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId);
}

$query_rs_matiere = "SELECT * FROM stock_matiere";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));

$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));

if (isset($matiereId) && isset($niveauId))
{
	$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' ORDER BY matiere_ID, niveau_ID", $matiereId, $niveauId);
	$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error($conn_intranet));

	$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $matiereId);
	$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error($conn_intranet));
	$row_rsChoix = mysqli_fetch_assoc($rsChoix);
}

$titre_page = "Liste des exercices dans une matière avec modification des modes possible";
$meta_description = "Page de la liste des exercices dans une matière avec modification du mode (entrainement et/ou évaluation)";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form1" method="post" action="liste_quiz_avecmodif.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="matiere_ID" class="col-auto col-form-label">Sélectionner une matière :</label>
		<div class="col-auto">
			<select name="matiere_ID" id="select2" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir une matière</option>
				<?php
				while ($row_RsMatiere = mysqli_fetch_assoc($rs_matiere)) 
				{ ?>
					<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_RsMatiere['ID_mat'], $matiereId))) {echo " SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']; ?></option>
					<?php
				} ?>
			</select>
		</div>
		<label for="niveau_ID" class="col-auto col-form-label">Sélectionner un niveau :</label>
		<div class="col-auto">
			<select name="niveau_ID" id="select" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir un niveau</option>
				<?php
				while ($row_RsNiveau = mysqli_fetch_assoc($rs_niveau)) 
				{ ?>
					<option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_RsNiveau['ID_niveau'], $niveauId))) {echo " SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']; ?></option>
					<?php
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit" class="btn btn-primary">Valider</button>
		</div>
	</div>
</form>

<?php 
if (isset($matiereId) && isset($niveauId))
{ ?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th scope="col">N° Ex.</th>
					<th scope="col">Titre</th>
					<th scope="col">Fichier</th>
					<th scope="col">Auteur</th>
					<th scope="col">En entraînement</th>
					<th scope="col">En évaluation</th>
					<th scope="col"> </th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau))
				{
					$matiere = sans_accent($row_rsChoix['nom_mat']); ?>
					<form name="form2" method="POST" action="liste_quiz_avecmodif.php">
						<tr>
							<td><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></td>
							<td>
								<a href="<?php echo '../Exercices/'.$matiere.'/q'.$row_rsListeSelectMatiereNiveau['ID_quiz']; ?>/<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
							</td>
							<td><?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?></td>
							<td><?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?></td>
							<td>
								<div class="form-check text-center">
								  <input type="checkbox" name="en_ligne" id="en_ligne" value="O" class="form-check-input" <?php if (!(strcmp($row_rsListeSelectMatiereNiveau['en_ligne'], "O"))) {echo " checked ";} ?>>
								</div>
							</td>
							<td>
								<div class="form-check text-center">
									<input type="checkbox" name="avec_score" id="avec_score" value="O" class="form-check-input" <?php if (!(strcmp($row_rsListeSelectMatiereNiveau['avec_score'], "O"))) {echo " checked ";} ?> >
								</div>
							</td>
							<td>
								<button type="submit" name="Submit2" value="form2" class="btn btn-primary">Modifier</button>
								<input type="hidden" name="tablist" id="tablist" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>">
								<input type="hidden" name="matiere_ID" id="matiere_ID" value="<?php echo $matiereId; ?>">
								<input type="hidden" name="niveau_ID" id="niveau_ID" value="<?php echo $niveauId; ?>">
							</td>
						</tr>
					</form>
					<?php
				} ?>
			</tbody>
		</table>
	</div>
	<?php 
	mysqli_free_result($rsListeSelectMatiereNiveau);
	mysqli_free_result($rsChoix);
}

require('includes/footerEnseignant.inc.php');

mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau); ?>