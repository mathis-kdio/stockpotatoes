<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] != 'Enseignant') {
		header("Location: login_enseignant.php?cible=supp_categorie");
	}
}
else {
	header("Location: login_enseignant.php?cible=supp_categorie");
}

require_once('../Connections/conn_intranet.php');

if (isset($_POST['ID_mat'])) {
	$matiereId = htmlspecialchars($_POST['ID_mat']);
}
if (isset($_POST['ID_niv'])) {
	$niveauId = htmlspecialchars($_POST['ID_niv']);
}
if (isset($_POST['ID_categorie'])) {
	$categorieId = htmlspecialchars($_POST['ID_categorie']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['confirm'])) {
	$deleteSQL = sprintf("DELETE FROM stock_categorie WHERE ID_categorie = '%s'", $categorieId);
	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

	$updateSQL = sprintf("UPDATE stock_quiz SET categorie_ID = 0 WHERE categorie_ID = '%s'", $categorieId);
	$Result2 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header(sprintf("Location: supp_categorie_confirm.php?matiere_ID=".$matiereId."&niveau_ID=".$niveauId));
}

$choixcategorie_RsCategorie = "0";
if (isset($categorieId)) {
	$choixcategorie_RsCategorie = $categorieId;
}
$query_RsCategorie = sprintf("SELECT * FROM stock_categorie WHERE ID_categorie = '%s'", $choixcategorie_RsCategorie);
$RsCategorie = mysqli_query($conn_intranet, $query_RsCategorie) or die(mysqli_error($conn_intranet));
$row_RsCategorie = mysqli_fetch_assoc($RsCategorie);

$choixcategorie_RsQuiz = "0";
if (isset($categorieId)) {
	$choixcategorie_RsQuiz = $categorieId;
}
$query_RsQuiz = sprintf("SELECT * FROM stock_quiz WHERE categorie_ID = '%s'", $choixcategorie_RsQuiz);
$RsQuiz = mysqli_query($conn_intranet, $query_RsQuiz) or die(mysqli_error($conn_intranet));

$titre_page = "Suppression d'une catégorie - Vérification";
$meta_description = "Page de vérification de la suppression d'une catégorie";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('includes/headerEnseignant.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<h4>Suppression de la catégorie <?php echo $row_RsCategorie['nom_categorie']; ?></h4>
		<p>Le tableau ci-dessous affiche les éventuels exercices liès à cette catégorie.</p>
		<p>La suppression de la catégorie entrainera leur réaffectation dans la catégorie Divers</p>
		<form name="form1" method="post" action="supp_categorie.php">
			<button type="submit" class="btn btn-primary" name="confirm">Confirmer la suppression</button>
			<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
			<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
			<input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $categorieId; ?>">
		</form>
			
		<a class="btn btn-primary mt-3" href="gestion_categorie.php?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $niveauId;?>#listeCategories" role="button">Abandonner la suppression</a>
		
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

mysqli_free_result($RsCategorie);
mysqli_free_result($RsQuiz); ?>