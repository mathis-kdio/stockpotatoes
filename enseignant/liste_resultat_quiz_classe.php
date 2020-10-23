<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_resultat_quiz_classe");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_resultat_quiz_classe");
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

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));

$query_RsMatiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error($conn_intranet));

$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error($conn_intranet));

if (isset($matiereId) && isset($niveauId)) {
	$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND cat_doc = '2' ORDER BY titre ASC", $matiereId, $niveauId);
	$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error($conn_intranet));
}

if (isset($quizId) && isset($classeName)) {
	$query_RsActiviteClasse = sprintf("SELECT * FROM stock_activite, stock_eleve WHERE stock_activite.quiz_ID = '%s' AND stock_activite.nom_classe = '%s' AND stock_activite.eleve_ID=stock_eleve.ID_eleve ORDER BY stock_eleve.nom, stock_eleve.prenom ", $quizId, $classeName);
	$RsActiviteClasse = mysqli_query($conn_intranet, $query_RsActiviteClasse) or die(mysqli_error($conn_intranet));
	$totalRows_RsActiviteClasse = mysqli_num_rows($RsActiviteClasse);
}

$choix_th_Rs_quiz_choisi = "0";
if (isset($quizId))
{
	$choix_th_Rs_quiz_choisi = $quizId;

	$query_Rs_quiz_choisi = sprintf("SELECT titre, ID_quiz FROM stock_quiz WHERE ID_quiz = '%s'", $choix_th_Rs_quiz_choisi);
	$Rs_quiz_choisi = mysqli_query($conn_intranet, $query_Rs_quiz_choisi) or die(mysqli_error($conn_intranet));
	$row_Rs_quiz_choisi = mysqli_fetch_assoc($Rs_quiz_choisi);
}

$titre_page = "Résultat d'un quiz pour une classe";
$meta_description = "Page du résultat d'un quizz pour une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form2" method="post" action="liste_resultat_quiz_classe.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="classe" class="col-auto col-form-label">Sélectionner une classe :</label>
		<div class="col-auto">
			<select name="classe" id="select10" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir une classe</option>
				<?php
				while ($row_rsClasse = mysqli_fetch_assoc($rsClasse))
				{ ?>
					<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classeName)) { if (!(strcmp($row_rsClasse['classe'], $classeName))) {echo "SELECTED";} }?>><?php echo $row_rsClasse['classe']; ?></option>
						<?php
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit2" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>
<?php if (isset($classeName)) 
{ ?>
	<form name="form4" method="post" action="liste_resultat_quiz_classe.php">
		<div class="form-group row align-items-center justify-content-center">
			<label for="ID_mat" class="col-auto col-form-label">Sélectionner une matière :</label>
			<div class="col-auto">
				<select name="ID_mat" id="select11" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir une matière</option>
					<?php
					while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere)) 
					{ ?>
						<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_RsMatiere['ID_mat'], $matiereId))) {echo "SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
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
						<option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_RsNiveau['ID_niveau'], $niveauId))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
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
	<form name="form1" method="post" action="liste_resultat_quiz_classe.php">
		<div class="form-group row align-items-center justify-content-center">
			<label for="ID_quiz" class="col-auto col-form-label">Sélectionner un quiz :</label>
			<div class="col-auto">
				<select name="ID_quiz" id="select8" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir un quiz</option>
					<?php
					while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz)) 
					{ ?>
						<option value="<?php echo $row_Rsquiz['ID_quiz']?>"<?php if (isset($quizId)) { if (!(strcmp($row_Rsquiz['ID_quiz'], $quizId))) {echo "SELECTED";}} ?>><?php echo $row_Rsquiz['titre']; ?></option>
						<?php
					} ?>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" name="Submit" class="btn btn-primary">Sélectionner</button>
				<input name="ID_mat" type="hidden" id="ID_mat3" value="<?php echo $matiereId; ?>">
				<input name="ID_niveau" type="hidden" id="ID_niveau3" value="<?php echo $niveauId; ?>">
				<input name="classe" type="hidden" id="classe5" value="<?php echo $classeName; ?>">
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
			<form name="form3" method="post" action="export_resultat.php">
				<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $quizId; ?>">
				<input name="classe" type="hidden" id="classe" value="<?php echo $classeName; ?>">
				<button type="submit" name="Submit4" class="btn btn-primary">Exporter au format csv</button>
			</form>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit5" onClick="MM_callJS('javascript:window.print();')" class="btn btn-primary">Imprimer</button>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<th scope="col">N°</th>
					<th scope="col">Nom Prénom</th>
					<th scope="col">Note sur 20</th>
					<th scope="col">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$fichier_log = 'resultats.csv';
				$fp = fopen($fichier_log, "a");
				$chaine = ('Nom;Prenom;Note sur 20;Date'."\n");

				fputs($fp, $chaine);
				$somme = 0;
				while ($row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse))
				{ ?>
					<tr> 
						<th scope="row"><?php echo $row_RsActiviteClasse['eleve_ID']; ?></th>
						<td><?php echo $row_RsActiviteClasse['nom'].' '.$row_RsActiviteClasse['prenom']; ?></td>
						<td><?php echo $row_RsActiviteClasse['score']; ?></td>
						<td><?php echo $row_RsActiviteClasse['debut']; ?></td>
					</tr>
					<?php 
					$chaine_valeur = $row_RsActiviteClasse['nom'].';'.$row_RsActiviteClasse['prenom'].';'.$row_RsActiviteClasse['score'].';'.$row_RsActiviteClasse['debut']."\n"; 
					fputs($fp, $chaine_valeur);

					$somme = $somme + $row_RsActiviteClasse['score'];
				}
				if ($totalRows_RsActiviteClasse != 0)
				{
					$moyenne = round(($somme / $totalRows_RsActiviteClasse), 1);
					fputs($fp, $moyenne);
				}
			 	fclose($fp); ?>
				<tr> 
					<td></td>
					<?php
					if ($totalRows_RsActiviteClasse <> 0)
					{ ?>
						<td><?php echo $totalRows_RsActiviteClasse.' élève(s)';?></td>
						<td>Moyenne : <?php echo $moyenne; ?></td>
						<td></td>
						<?php  
					}
					else 
					{
						echo '<td>Pas encore de résultats pour cet exercice dans cette classe</td><td></td><td></td>';
					} ?>
				</tr>
			</tbody>	
		</table>
	</div>
	<?php
	mysqli_free_result($RsActiviteClasse);
}

require('includes/footerEnseignant.inc.php');

mysqli_free_result($rsClasse);
?>