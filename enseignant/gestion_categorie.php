<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom']<>'Enseignant')
	{
		header("Location: login_enseignant.php?cible=gestion_categorie");
	}
}
else
{
	header("Location: login_enseignant.php?cible=gestion_categorie");
}
require_once('../Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}

$query_RsMax = "SELECT MAX(pos_categorie) AS resultat FROM stock_categorie ";
$RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error($conn_intranet));
$row_RsMax = mysqli_fetch_assoc($RsMax);
$position = $row_RsMax['resultat'] + 1;

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2"))
{
	$insertSQL = sprintf("INSERT INTO stock_categorie (ID_categorie, nom_categorie, mat_ID, niv_ID, pos_categorie) VALUES ('%s', '%s', '%s', '%s', '%s')",
	htmlspecialchars($_POST['ID_categorie']), htmlspecialchars($_POST['categorie']), htmlspecialchars($_POST['mat_ID']), htmlspecialchars($_POST['niv_ID']), htmlspecialchars($position));

	$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));
}

//Mise à jour de l'ordre des Catégories
if ((isset($_POST["MM_nouvel_ordre"])) && ($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre")) {
	$ordre = htmlspecialchars($_POST['ordreCategories']);
	$ordre = explode(",", $ordre);

	for ($i = 1; $i <= count($ordre); $i++) {
		$updatePositionsCategories = sprintf("UPDATE stock_categorie SET pos_categorie = '%s' WHERE ID_categorie = '%s'", $i, $ordre[$i-1]);
		$RsNewPositions = mysqli_query($conn_intranet, $updatePositionsCategories) or die(mysqli_error($conn_intranet));
	}
}

$choixmat_Rscategorie = "0";
if (isset($matiereId))
{
	$choixmat_Rscategorie = $matiereId;
}
$choixniv_Rscategorie = "0";
if (isset($niveauId))
{
	$choixniv_Rscategorie = $niveauId;
}
$query_Rscategorie = sprintf("SELECT * FROM stock_categorie WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY pos_categorie", $choixmat_Rscategorie,$choixniv_Rscategorie);
$Rscategorie = mysqli_query($conn_intranet, $query_Rscategorie) or die(mysqli_error($conn_intranet));
$row_Rscategorie = mysqli_fetch_assoc($Rscategorie);
$totalRows_Rscategorie = mysqli_num_rows($Rscategorie);

$choixmat_RsChoixmatiere = "0";
if (isset($matiereId))
{
	$choixmat_RsChoixmatiere = $matiereId;
}
$query_RsChoixmatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $choixmat_RsChoixmatiere);
$RsChoixmatiere = mysqli_query($conn_intranet, $query_RsChoixmatiere) or die(mysqli_error($conn_intranet));
$row_RsChoixmatiere = mysqli_fetch_assoc($RsChoixmatiere);

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);

$titre_page = "Gestion des catégories";
$meta_description = "Page gestion des catégories";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "includes/Sortable.js";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<form name="form1" method="GET" action="gestion_categorie.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="matiere_ID" class="col-auto col-form-label">Matière :</label>
		<div class="col-auto">
			<select name="matiere_ID" id="select2" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir une matière</option>
				<?php
				do 
				{ ?>
					<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo "SELECTED";} }?>><?php echo $row_rs_matiere['nom_mat']?></option>
					<?php
				} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)); ?>
			</select>
		</div>
		<label for="niveau_ID" class="col-auto col-form-label">Niveau :</label>
		<div class="col-auto">
			<select name="niveau_ID" id="select" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir un niveau</option>
				<?php
				do 
				{ ?>
					<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
					<?php
				} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)); ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit3" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>
<?php
if (isset($matiereId))
{ ?>
	<div class="row mt-2">
		<div class="col text-center">
			<h3>Matière actuelle: <?php echo $row_RsChoixmatiere['nom_mat']; ?></h3>
		</div>
	</div>
	<form method="post" name="form2" action="gestion_categorie.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>">
		<div class="form-group row align-items-center justify-content-center mt-5">
			<label for="categorie" class="col-auto col-form-label">Ajouter cette catégorie à cette matière et à ce niveau :</label>
			<div class="col-auto">
				<input type="text" name="categorie" class="form-control" required>
			</div>
			<div class="col-auto">
				<button type="submit" name="submit" class="btn btn-primary">Enregistrer cette nouvelle catégorie</button>
			</div>
			<input type="hidden" name="ID_categorie" value="">
			<input type="hidden" name="mat_ID" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="niv_ID" value="<?php echo $niveauId; ?>">
			<input type="hidden" name="MM_insert" value="form2">
		</div>
	</form>
	<h4 class="text-center mt-5" id="listeCategories">Liste des catégories & Paramétrages</h4>
	<h5 class="text-center">Faire glisser les thèmes pour changer l'ordre</h5>
	<div class="row">
		<div class="col">
			<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
				<div class="col-1">Réordonner</div>
				<div class="col-2">N°</div>
				<div class="col-3">Catégorie d'étude</div>
				<div class="col-3">Supprimer</div>
				<div class="col-3">Modifier</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div id="sortablelist" class="list-group mb-4" data-id="1">
				<?php
				if ($totalRows_Rscategorie != 0) {
					mysqli_data_seek($Rscategorie, 0);
					$row_Rscategorie = mysqli_fetch_assoc($Rscategorie);
					do { ?>
						<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_Rscategorie['ID_categorie']?>">
							<div class="col-1" style="cursor: grab;">
								<img class="position-handle" src="images/move.png" width="19" height="19">
							</div>
							<div class="col-2">
								<?php echo $row_Rscategorie['ID_categorie']; ?>
							</div>
							<div class="col-3">
								<?php echo $row_Rscategorie['nom_categorie']; ?>
							</div>
							<div class="col-3">
								<form name="form4" method="post" action="supp_categorie.php">
									<input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_Rscategorie['ID_categorie']; ?>">
									<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
									<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
									<button type="submit" name="Submit" class="btn btn-primary">Supprimer</button>
								</form>
							</div>
							<div class="col-3">
								<form name="form3" method="post" action="modif_categorie.php">
									<input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_Rscategorie['ID_categorie']; ?>">
									<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
									<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
									<button type="submit" name="Submit2" class="btn btn-primary">Modifier</button>
								</form>
							</div>
						</div>
						<?php
					} while ($row_Rscategorie = mysqli_fetch_assoc($Rscategorie));
				} ?>
			</div>
		</div>
	</div>
	<div class="form-group row align-items-center justify-content-center">	
		<form method="post" name="form_nouvel_ordre" action="gestion_categorie.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>#listeCategories">
			<div class="col-auto">
				<button type="submit" name="submit_nouvel_ordre" class="btn btn-primary" onclick="setValuesInputOrderList()">Enregistrer le nouvel ordre</button>
			</div>
			<input type="hidden" name="mat_ID" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="niv_ID" value="<?php echo $niveauId; ?>">
			<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre">
			<input type="hidden" id="ordreCategories" name="ordreCategories" value="">
		</form>
	</div>
	<script type="text/javascript">
		var list = Sortable.create(sortablelist, {
			animation: 100,
			group: 'list-1',
			draggable: '.list-group-item',
			handle: '.position-handle',
			sort: true,
			filter: '.sortable-disabled',
			chosenClass: 'active',
		});
		function setValuesInputOrderList() {
			var order = list.toArray();
			let inputOrdreCategories = document.getElementById('ordreCategories');
			inputOrdreCategories.setAttribute('value', order);
		}
	</script>
	<?php
}

require('includes/footerEnseignant.inc.php');

mysqli_free_result($Rscategorie);
mysqli_free_result($RsChoixmatiere);
mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau); ?>