<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] != 'Enseignant') {
		header("Location: login_enseignant.php?cible=gestion_categorie");
	}
}
else {
	header("Location: login_enseignant.php?cible=gestion_categorie");
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE stock_categorie SET nom_categorie = '%s' WHERE ID_categorie = '%s'", htmlspecialchars($_POST['nom_categorie']), $categorieId);

	$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header(sprintf("Location: gestion_categorie.php?matiere_ID=".$matiereId."&niveau_ID=".$niveauId."#listeCategories"));
}

$choixcategorie_RsChoixcategorie = "0";
if (isset($categorieId)) {
	$choixcategorie_RsChoixcategorie = $categorieId;
}
$query_RsChoixcategorie = sprintf("SELECT * FROM stock_categorie WHERE ID_categorie = '%s'", $choixcategorie_RsChoixcategorie);
$RsChoixcategorie = mysqli_query($conn_intranet, $query_RsChoixcategorie) or die(mysqli_error($conn_intranet));
$row_RsChoixcategorie = mysqli_fetch_assoc($RsChoixcategorie);

$titre_page = "Modification d'une catégorie";
$meta_description = "Page de modification d'une catégorie";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('includes/headerEnseignant.inc.php');
?>
<div class="row">
	<div class="col text-center">
		<h4>Mofication de la catégorie: "<?php echo $row_RsChoixcategorie['nom_categorie'];?>"</h4>
			<form method="post" name="form1" action="modif_categorie.php">
				<div class="form-group form-row justify-content-center">
					<div class="col-auto">
						<label for="nom_categorie">Modification du libellé de la catégorie de l'étude</label>
						<input type="text" class="form-control" id="nom_categorie" name="nom_categorie" value="<?php echo $row_RsChoixcategorie['nom_categorie']; ?>" required>
					</div>
				</div>
				<button type="submit" class="btn btn-primary mb-2">Mettre à jour l'enregistrement</button>
				<input type="hidden" name="ID_categorie" value="<?php echo $row_RsChoixcategorie['ID_categorie']; ?>">
				<input type="hidden" name="ID_mat" id="ID_mat" value="<?php echo $matiereId; ?>">
				<input type="hidden" name="ID_niv" id="ID_niv" value="<?php echo $niveauId; ?>">
				<input type="hidden" name="MM_update" value="form1">
			</form>
		<a class="btn btn-primary mt-3" href="gestion_categorie.php?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $niveauId;?>#listeCategories" role="button">Abandonner la modification</a>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($RsChoixcategorie); ?>