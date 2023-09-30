<?php
session_start();
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] <> 'Enseignant') {
		header("Location: login_enseignant.php?cible=gestion_theme");
	}
}
else {
	header("Location: login_enseignant.php?cible=gestion_theme");
}
require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}

$query_RsMax = "SELECT MAX(pos_theme) AS resultat FROM stock_theme";
$RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error($conn_intranet));
$row_RsMax = mysqli_fetch_assoc($RsMax);
$position = $row_RsMax['resultat'] + 1;

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	$insertSQL = mysqli_prepare($conn_intranet, "INSERT INTO stock_theme (ID_theme, theme, mat_ID, niv_ID, pos_theme) VALUES (?, ?, ?, ?, ?)") or exit (mysqli_error($conn_intranet));
	mysqli_stmt_bind_param($insertSQL, "sssss", htmlspecialchars($_POST['ID_theme']), htmlspecialchars($_POST['theme']), htmlspecialchars($_POST['mat_ID']), htmlspecialchars($_POST['niv_ID']), $position);
	mysqli_stmt_execute($insertSQL);
}

//Mise à jour de l'ordre des thèmes
if ((isset($_POST["MM_nouvel_ordre"])) && ($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre")) {
	$ordre = htmlspecialchars($_POST['ordreThemes']);
	$ordre = explode(",", $ordre);

	for ($i = 1; $i <= count($ordre); $i++) {
		$updatePositionsThemes = sprintf("UPDATE stock_theme SET pos_theme = '%s' WHERE ID_theme = '%s'", $i, $ordre[$i-1]);
		$RsNewPositions = mysqli_query($conn_intranet, $updatePositionsThemes) or die(mysqli_error($conn_intranet));
	}
}

$choixmat_RsTheme = "0";
if (isset($matiereId)) {
	$choixmat_RsTheme = $matiereId;
}
$choixniv_RsTheme = "0";
if (isset($niveauId)) {
	$choixniv_RsTheme = $niveauId;
}
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY pos_theme", $choixmat_RsTheme, $choixniv_RsTheme);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error($conn_intranet));
$row_RsTheme = mysqli_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysqli_num_rows($RsTheme);

$choixmat_RsChoixmatiere = "0";
if (isset($matiereId)) {
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

$titre_page = "Gestion des thèmes d'étude";
$meta_description = "Page gestion des thèmes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "includes/Sortable.js";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form1" method="GET" action="gestion_theme.php">
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
				} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere));
				$rows = mysqli_num_rows($rs_matiere);
				if($rows > 0) 
				{
					mysqli_data_seek($rs_matiere, 0);
					$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
				} ?>
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
				} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau));
				$rows = mysqli_num_rows($rs_niveau);
				if($rows > 0)
				{
					mysqli_data_seek($rs_niveau, 0);
					$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
				} ?>
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
	<form method="post" name="form2" action="gestion_theme.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>">
		<div class="form-group row align-items-center justify-content-center mt-5">
			<label for="theme" class="col-auto col-form-label">Ajouter un thème d'étude à cette matière et à ce niveau:</label>
			<div class="col-auto">
				<input type="text" name="theme" class="form-control" required>
			</div>
			<div class="col-auto">
				<button type="submit" name="submit" class="btn btn-primary">Enregistrer ce nouveau thème d'étude</button>
			</div>
			<input type="hidden" name="ID_theme" value="">
			<input type="hidden" name="mat_ID" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="niv_ID" value="<?php echo $niveauId; ?>">
			<input type="hidden" name="MM_insert" value="form2">
			<input type="hidden" name="ID_mat2" id="ID_mat3" value='<?php echo htmlspecialchars($_POST['ID_mat']);?>'>
		</div>
	</form>
	<h4 class="text-center mt-5" id="listeThemes">Liste des thèmes & Paramétrages</h4>
	<h5 class="text-center">Faire glisser les thèmes pour changer l'ordre</h5>
	<div class="row">
		<div class="col">
			<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
				<div class="col-1">Réordonner</div>
				<div class="col-1">N°</div>
				<div class="col-2">Thèmes d'étude</div>
				<div class="col-1">Supprimer</div>
				<div class="col-2">Modifier</div>
				<div class="col-2">Date d'apparition</div>
				<div class="col-2">Date de disparition</div>
				<div class="col-1">Visibilité actuelle</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div id="sortablelist" class="list-group mb-4" data-id="1">
				<?php 
				if ($totalRows_RsTheme != 0) {
					mysqli_data_seek($RsTheme, 0);		
					$row_RsTheme = mysqli_fetch_assoc($RsTheme);
					do { ?>
						<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_RsTheme['ID_theme']?>">
							<div class="col-1" style="cursor: grab;">
								<img class="position-handle" src="images/move.png" width="19" height="19">
							</div>
							<div class="col-1">
								<?php echo $row_RsTheme['ID_theme']; ?>
							</div>
							<div class="col-2">
								<?php echo $row_RsTheme['theme'];?>
							</div>
							<div class="col-1">
								<form name="form4" method="post" action="supp_theme.php">
									<input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $row_RsTheme['ID_theme']; ?>">
									<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
									<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
									<button type="submit" name="Submit" class="btn btn-primary">Supprimer</button>
								</form>
							</div>
							<div class="col-2">
								<form name="form3" method="post" action="modif_theme.php">
									<input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $row_RsTheme['ID_theme']; ?>">
									<input name="ID_mat" type="hidden" id="ID_mat" value="<?php echo $matiereId; ?>">
									<input name="ID_niv" type="hidden" id="ID_niv" value="<?php echo $niveauId; ?>">
									<button type="submit" name="Submit2" class="btn btn-primary">Modifier</button>
								</form>
							</div>
							<div class="col-2">
								<form name="formapparition" method="post" action="gestion_date_theme.php">
									<div class="form-group row align-items-center justify-content-center">
										<div class="col-auto">
											<input name="formapparition" type="date" class="form-control" value="<?php echo strftime('%Y-%m-%d',strtotime($row_RsTheme['date_apparition']));?>">
										</div>
										<div class="col-auto">
											<button type="submit" name="valider" class="btn btn-primary">Valider</button>															
										</div>
									</div>
									<input type="hidden" name="ID_mat" value="<?php echo $matiereId; ?>">
									<input type="hidden" name="ID_niv" value="<?php echo $niveauId; ?>">
									<input type="hidden" name="ID_theme2" value="<?php echo $row_RsTheme['ID_theme']; ?>">
									<input type="hidden" name="MM_update" value="formapparition">
								</form>
							</div>
							<div class="col-2">
								<form name="formdisparition" method="post" action="gestion_date_theme.php">
									<div class="form-group row align-items-center justify-content-center">
										<div class="col-auto">
											<input name="formdisparition" type="date" class="form-control" value="<?php echo strftime('%Y-%m-%d',strtotime($row_RsTheme['date_disparition']));?>">
										</div>
										<div class="col-auto">
											<button type="submit" name="valider" class="btn btn-primary">Valider</button>
										</div>
									</div>
									<input type="hidden" name="ID_mat" value="<?php echo $matiereId; ?>">
									<input type="hidden" name="ID_niv" value="<?php echo $niveauId; ?>">
									<input type="hidden" name="ID_theme3" value="<?php echo $row_RsTheme['ID_theme']; ?>">
									<input type="hidden" name="MM_update2" value="formdisparition">
								</form>
							</div>
							<div class="col-1">
								<?php
								$today = date("Y-m-d");
								if ($today >= $row_RsTheme['date_apparition'] AND $today <= $row_RsTheme['date_disparition']) {
									echo '<p class="font-weight-bold text-success">visible</p>';
								} 
								else {
									echo '<p class="font-weight-bold text-danger">invisible</p>';
								} ?>
							</div>
						</div>
						<?php 
					} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme));
				} ?>
			</div>
		</div>
	</div>
	<div class="form-group row align-items-center justify-content-center">	
		<form method="post" name="form_nouvel_ordre" action="gestion_theme.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>#listeThemes">
			<div class="col-auto">
				<button type="submit" name="submit_nouvel_ordre" class="btn btn-primary" onclick="setValuesInputOrderList()">Enregistrer le nouvel ordre</button>
			</div>
			<input type="hidden" name="mat_ID" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="niv_ID" value="<?php echo $niveauId; ?>">
			<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre">
			<input type="hidden" id="ordreThemes" name="ordreThemes" value="">
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
			let inputOrdreThemes = document.getElementById('ordreThemes');
			inputOrdreThemes.setAttribute('value', order);
		}
	</script>
	<?php  
}?>

<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($RsTheme);
mysqli_free_result($RsChoixmatiere);
mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau);
?>