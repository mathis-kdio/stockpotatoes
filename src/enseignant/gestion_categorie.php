<?php
session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') {
		header("Location: login_enseignant.php?cible=gestion_categorie");
	}
} else {
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
if (isset($_GET['categorie_ID'])) {
	$categorieId = htmlspecialchars($_GET['categorie_ID']);
}

$query_RsMax = "SELECT MAX(pos_categorie) AS resultat FROM stock_categorie ";
$RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error($conn_intranet));
$row_RsMax = mysqli_fetch_assoc($RsMax);
$position = $row_RsMax['resultat'] + 1;

if (isset($_POST["MM_insert"]) && ($_POST["MM_insert"] == "form2")) {
	$nom_categorie = htmlspecialchars($_POST['categorie']);
	if (isset($_POST['categorie_ID']) && $_POST['categorie_ID'] != '') {
		$categorie_mere_id = htmlspecialchars($_POST['categorie_ID']);
		$insertSQL = mysqli_prepare($conn_intranet, "INSERT INTO stock_categorie (nom_categorie, mat_ID, niv_ID, pos_categorie, categorie_mere_ID) VALUES (?, ?, ?, ?, ?)") or exit (mysqli_error($conn_intranet));
		mysqli_stmt_bind_param($insertSQL, "siiii", $nom_categorie, $matiereId, $niveauId, $position, $categorie_mere_id);
	} else {
		$insertSQL = mysqli_prepare($conn_intranet, "INSERT INTO stock_categorie (nom_categorie, mat_ID, niv_ID, pos_categorie) VALUES (?, ?, ?, ?)") or exit (mysqli_error($conn_intranet));
		mysqli_stmt_bind_param($insertSQL, "siii", $nom_categorie, $matiereId, $niveauId, $position);
	}
	mysqli_stmt_execute($insertSQL);
}

//Mise à jour de l'ordre des Catégories
if (isset($_POST["MM_nouvel_ordre"]) && ($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre")) {
	$ordre = htmlspecialchars($_POST['ordreCategories']);
	$ordre = explode(",", $ordre);

	for ($i = 1; $i <= count($ordre); $i++) {
		$updatePositionsCategories = sprintf("UPDATE stock_categorie SET pos_categorie = '%s' WHERE ID_categorie = '%s'", $i, $ordre[$i-1]);
		$RsNewPositions = mysqli_query($conn_intranet, $updatePositionsCategories) or die(mysqli_error($conn_intranet));
	}
}

$choixmat_rs_categorie = isset($matiereId) ? $matiereId : "0";
$choixniv_rs_categorie = isset($niveauId) ? $niveauId : "0";
if (isset($categorieId)) {
	$query_rs_categorie = sprintf("SELECT * FROM stock_categorie WHERE mat_ID = '%s' AND niv_ID = '%s' AND categorie_mere_ID = '%s' ORDER BY pos_categorie", $choixmat_rs_categorie, $choixniv_rs_categorie, $categorieId);
} else {
	$query_rs_categorie = sprintf("SELECT * FROM stock_categorie WHERE mat_ID = '%s' AND niv_ID = '%s' AND categorie_mere_ID IS NULL ORDER BY pos_categorie", $choixmat_rs_categorie,$choixniv_rs_categorie);
}
$rs_categorie = mysqli_query($conn_intranet, $query_rs_categorie) or die(mysqli_error($conn_intranet));

if (isset($categorieId)) {
	$selectSQL = mysqli_prepare($conn_intranet, "SELECT nom_categorie FROM stock_categorie WHERE ID_categorie = ?") or exit (mysqli_error($conn_intranet));
	mysqli_stmt_bind_param($selectSQL, "i", $categorieId);
	mysqli_stmt_execute($selectSQL);
	mysqli_stmt_bind_result($selectSQL, $categorieMere);
	mysqli_stmt_fetch($selectSQL);
	mysqli_stmt_close($selectSQL);
}

$titre_page = "Gestion des catégories";
$meta_description = "Page gestion des catégories";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "includes/Sortable.js";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');

require('../includes/forms/matiere_niveau.inc.php');

if (isset($categorieId)) { ?>
	<h5 class="text-center">Catégories appartenant à : <?php echo $categorieMere;?></h5>
	<?php
}

if (isset($matiereId)) { ?>
	<form method="post" name="form2" action="gestion_categorie.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?><?php echo isset($categorieId) ? '&categorie_ID='.$categorieId : ''; ?>">
		<div class="form-group row align-items-center justify-content-center mt-5">
			<label for="categorie" class="col-auto col-form-label">Ajouter cette catégorie à cette matière et à ce niveau :</label>
			<div class="col-auto">
				<input type="text" name="categorie" class="form-control" required>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary">Enregistrer cette nouvelle catégorie</button>
			</div>
			<input type="hidden" name="matiere_ID" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="niveau_ID" value="<?php echo $niveauId; ?>">
			<?php
			if (isset($categorieId)) {
				echo '<input type="hidden" name="categorie_ID" value="'.$categorieId.'">';
			}
			?>
			<input type="hidden" name="MM_insert" value="form2">
		</div>
	</form>
	<h4 class="text-center mt-5" id="listeCategories">Liste des catégories & Paramétrages</h4>
	<h5 class="text-center">Faire glisser les catégories pour changer l'ordre</h5>
	<div class="row">
		<div class="col">
			<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
				<div class="col-1">Réordonner</div>
				<div class="col-2">N°</div>
				<div class="col-3">Catégorie d'étude</div>
				<div class="col-2">Supprimer</div>
				<div class="col-2">Modifier</div>
				<div class="col-2">Sous-catégories</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div id="sortablelist" class="list-group mb-4" data-id="1">
				<?php
				if (mysqli_num_rows($rs_categorie) != 0) {
					while ($row_rs_categorie = mysqli_fetch_assoc($rs_categorie)) { ?>
						<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_rs_categorie['ID_categorie']?>">
							<div class="col-1" style="cursor: grab;">
								<img class="position-handle" src="images/move.png" width="19" height="19">
							</div>
							<div class="col-2">
								<?php echo $row_rs_categorie['ID_categorie']; ?>
							</div>
							<div class="col-3">
								<?php echo $row_rs_categorie['nom_categorie']; ?>
							</div>
							<div class="col-2">
								<form name="form4" method="post" action="supp_categorie.php">
									<input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_rs_categorie['ID_categorie']; ?>">
									<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
									<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
									<button type="submit" class="btn btn-danger">Supprimer</button>
								</form>
							</div>
							<div class="col-2">
								<form name="form3" method="post" action="modif_categorie.php">
									<input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_rs_categorie['ID_categorie']; ?>">
									<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
									<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
									<button type="submit" class="btn btn-primary">Modifier</button>
								</form>
							</div>
							<div class="col-2">
								<form name="form4" method="get" action="gestion_categorie.php">
									<input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $matiereId; ?>">
									<input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $niveauId; ?>">
									<input name="categorie_ID" type="hidden" id="categorie_ID" value="<?php echo $row_rs_categorie['ID_categorie']; ?>">
									<button type="submit" class="btn btn-primary">Gérer les sous-catégories</button>
								</form>
							</div>
						</div>
						<?php
					}
				} ?>
			</div>
		</div>
	</div>
	<div class="form-group row align-items-center justify-content-center">	
		<form method="post" name="form_nouvel_ordre" action="gestion_categorie.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>#listeCategories">
			<div class="col-auto">
				<button type="submit" class="btn btn-primary" onclick="setValuesInputOrderList()">Enregistrer le nouvel ordre</button>
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

mysqli_free_result($rs_categorie);
?>