<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom']<>'Administrateur')
	{
		header("Location: login_administrateur.php?cible=gestion_matiere_niveau");
	}
} 
else 
{ 
	header("Location: login_administrateur.php?cible=gestion_matiere_niveau");
}

require_once('../Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_GET['matiere_modif_ID'])) {
	$matiereModifId = htmlspecialchars($_GET['matiere_modif_ID']);
}
if (isset($_GET['niveau_modif_ID'])) {
	$niveauModifId = htmlspecialchars($_GET['niveau_modif_ID']);
}
if (isset($_GET['niveau_supp_ID'])) {
	$niveauSuppId = htmlspecialchars($_GET['niveau_supp_ID']);
}
if (isset($_POST['nom_niveau'])) {
	$niveauNom = htmlspecialchars($_POST['nom_niveau']);
}
if (isset($_POST['nom_mat'])) {
	$matiereNom = htmlspecialchars($_POST['nom_mat']);
}

function sans_accent($chaine) 
{ 
	$accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
	$noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
	return strtr(trim($chaine),$accent,$noaccent); 
} 

/*************SUPPRESSION D'UN NIVEAU***************/
if ((isset($_GET['niveau_supp_ID'])) && ($_GET['niveau_supp_ID'] != "")) 
{
	$deleteSQL = sprintf("DELETE FROM stock_niveau WHERE ID_niveau = '%s'", $niveauSuppId);

	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

	header("Location: confirm_supp_niv.php");
}

/*************AJOUT D'UN NIVEAU***************/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form10"))
{
	$query_RsMax = "SELECT MAX(pos_niv) AS resultat FROM stock_niveau ";
	$RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error($conn_intranet));
	$row_RsMax = mysqli_fetch_assoc($RsMax);
	$position = $row_RsMax['resultat'] + 1;

	$insertSQL = sprintf("INSERT INTO stock_niveau (nom_niveau, pos_niv) VALUES ('%s', '%s')", $niveauNom, htmlspecialchars($position));

	$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));

	header("Location: gestion_matiere_niveau.php");
}

/*************AJOUT D'UNE MATIERE ***************/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form9"))
{
	$insertSQL = sprintf("INSERT INTO stock_matiere (nom_mat) VALUES ('%s')", $matiereNom);
	$nom_matiere = sans_accent($matiereNom);
	$repertoire = '../Exercices/'.$nom_matiere;

	$old_umask = umask(0);
	mkdir ($repertoire, 0777);
	umask($old_umask);

	$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));

	header("Location: gestion_matiere_niveau.php");
}
/*************MISE A JOUR NOM NIVEAU***************/
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form8"))
{
	$updateSQL = sprintf("UPDATE stock_niveau SET nom_niveau = '%s' WHERE ID_niveau = '%s'", $niveauNom, htmlspecialchars($_POST['ID_niveau']));

	$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header("Location: gestion_matiere_niveau.php");
}
/*************MISE A JOUR NOM MATIERE***************/
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form7"))
{
	$updateSQL = sprintf("UPDATE stock_matiere SET nom_mat = '%s' WHERE ID_mat = '%s'", $matiereNom, htmlspecialchars($_POST['ID_mat']));

	$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

	header("Location: gestion_matiere_niveau.php");
}

//Mise à jour de l'ordre des niveayx
if ((isset($_POST["MM_nouvel_ordre"])) && ($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre")) {
	$ordre = htmlspecialchars($_POST['ordreNiveaux']);
	$ordre = explode(",", $ordre);

	for ($i = 1; $i <= count($ordre); $i++) {
		$updatePositionsNiveaux = sprintf("UPDATE stock_niveau SET pos_niv = '%s' WHERE ID_niveau = '%s'", $i, $ordre[$i-1]);
		$RsNewPositions = mysqli_query($conn_intranet, $updatePositionsNiveaux) or die(mysqli_error($conn_intranet));
	}
}

$query_RsMatiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error($conn_intranet));
$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);

$query_RsNiveau = "SELECT * FROM stock_niveau ORDER BY pos_niv";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error($conn_intranet));
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysqli_num_rows($RsNiveau);

$colname_RsModifMatiere = "1";
if (isset($matiereModifId))
{
	$colname_RsModifMatiere = $matiereModifId;
}
$query_RsModifMatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $colname_RsModifMatiere);
$RsModifMatiere = mysqli_query($conn_intranet, $query_RsModifMatiere) or die(mysqli_error($conn_intranet));
$row_RsModifMatiere = mysqli_fetch_assoc($RsModifMatiere);

$colname_RsModifNiveau = "1";
if (isset($niveauModifId))
{
	$colname_RsModifNiveau = $niveauModifId;
}
$query_RsModifNiveau = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = '%s'", $colname_RsModifNiveau);
$RsModifNiveau = mysqli_query($conn_intranet, $query_RsModifNiveau) or die(mysqli_error($conn_intranet));
$row_RsModifNiveau = mysqli_fetch_assoc($RsModifNiveau);

$titre_page = "Gestion des matières et des niveaux";
$meta_description = "Page de gestion des matières et des niveaux";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "include/Sortable.js";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');

?>
<div class="row">
	<div class="col-6">
		<h4>Gestion des matières</h4>
		<!-----------AJOUT MATIERE------------->
		<form method="post" name="form9" action="gestion_matiere_niveau.php">
			<div class="form-group row align-items-center">
				<label for="nom_mat" class="col-4 col-form-label">Nom de la matière :</label>
				<div class="col-4">
					<input type="text" class="form-control" name="nom_mat" id="nom_mat" required>
				</div>
				<div class="col-4">
					<button type="submit" name="submit" class="btn btn-primary">Créer cette matière</button>
				</div>
			</div>
			<input type="hidden" name="ID_mat" value="">
			<input type="hidden" name="MM_insert" value="form9">
		</form>
		<!-----------SUPPRESSION MATIERE------------->
		<form name="form4" method="POST" action="verif_supp_mat.php">
			<div class="form-group row align-items-center">
				<label for="matiere_supp_ID" class="col-auto col-form-label">Matière :</label>
				<div class="col-auto">
					<select name="matiere_supp_ID" id="select2" class="custom-select" required>
						<option disabled selected value="">Veuillez choisir une matière</option>
						<?php
						do { ?>
							<option value="<?php echo $row_RsMatiere['ID_mat']?>"><?php echo $row_RsMatiere['nom_mat']?></option>
							<?php
						} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere));
						$rows = mysqli_num_rows($RsMatiere);
						if($rows > 0) {
							mysqli_data_seek($RsMatiere, 0);
							$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
						} ?>
					</select>
				</div>
				<div class="col-auto">
					<button type="submit" name="Submit" class="btn btn-primary">Supprimer cette matière</button>
				</div>
			</div>
		</form>
		<!-----------MODIFICATION MATIERE------------->
		<form name="form3" method="get" action="gestion_matiere_niveau.php">
			<div class="form-group row align-items-center">
				<label for="matiere_modif_ID" class="col-auto col-form-label">Matière :</label>
				<div class="col-auto">
					<select name="matiere_modif_ID" id="select" class="custom-select" required>
						<option disabled selected value="">Veuillez choisir une matière</option>
						<?php
						do {  
							?>
							<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($matiereModifId)) { if (!(strcmp($row_RsMatiere['ID_mat'], $matiereModifId))) {echo "SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
							<?php 
						} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere));
						$rows = mysqli_num_rows($RsMatiere);
						if($rows > 0) {
							mysqli_data_seek($RsMatiere, 0);
							$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
						}
						?>
					</select>
				</div>
				<div class="col-auto">
					<button type="submit" name="Submit3" class="btn btn-primary">Modifier cette matière</button>
				</div>
			</div>
		</form>
		<?php  if (isset($matiereModifId))
		{ ?>
			<form method="post" name="form7" action="gestion_matiere_niveau.php">
				<div class="form-group row align-items-center">
					<label for="nom_mat" class="offset-1 col-auto col-form-label">Nom de la matière :</label>
					<div class="col-4">
						<input type="text" name="nom_mat" class="form-control" value="<?php echo $row_RsModifMatiere['nom_mat']; ?>" required>
					</div>
					<div class="col-auto">
						<button type="submit" name="submit3" class="btn btn-primary">Valider</button>
					</div>
				</div>
					<input type="hidden" name="ID_mat" value="<?php echo $row_RsModifMatiere['ID_mat']; ?>">
					<input type="hidden" name="MM_update" value="form7">
			</form>
			<h5 class="text-center text-danger">Attention</h5>
			<p class="text-justify text-danger">Pour cette opération, il vous faudra également modifier manuellement le nom du dossier matière correspondant présent dans le dossier "Exercices" sur le serveur.</p>
		<?php } ?>
		<!-----------LISTE MATIERE------------->
		<h4 class="text-center">Liste des matières</h4>
		<p class="font-italic">Les matières sont classées par ordre alphabétique.</p>
		<div class="row mt-5">
			<div class="col table-responsive">
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr>
							<th scope="col">ID_mat</th>
							<th scope="col">Matière</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						do 
						{ ?>
							<tr> 
								<th scope="row"><?php echo $row_RsMatiere['ID_mat']; ?></th>
								<td><?php echo $row_RsMatiere['nom_mat']; ?></td>
							</tr>
							<?php 
						} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere)); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!---------- NIVEAUX------------>
	<div class="col-6">
		<h4>Gestion des niveaux</h4>
		<!-----------AJOUT NIVEAU------------->
		<form method="post" name="form10" action="gestion_matiere_niveau.php">
			<div class="form-group row align-items-center">
				<label for="nom_niveau" class="col-auto col-form-label">Nom du niveau :</label>
				<div class="col-4">
					<input name="nom_niveau" class="form-control" type="text" id="nom_niveau" required>
				</div>
				<div class="col-auto">
					<button type="submit" name="submit" class="btn btn-primary">Créer ce niveau</button>
				</div>
			</div>
			<input type="hidden" name="ID_niveau" value="">
			<input type="hidden" name="MM_insert" value="form10">
		</form>
		<!-----------SUPPRESSION NIVEAU------------->
		<form name="form5" method="get" action="gestion_matiere_niveau.php">
			<div class="form-group row align-items-center">
				<label for="niveau_supp_ID" class="col-auto col-form-label">Niveau :</label>
				<div class="col-auto">
					<select name="niveau_supp_ID" id="niveau_supp_ID" class="custom-select" required>
						<option disabled selected value="">Veuillez choisir un niveau</option>
						<?php
						do {  
							?>
							<option value="<?php echo $row_RsNiveau['ID_niveau']?>"><?php echo $row_RsNiveau['nom_niveau']?></option>
							<?php
						} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
						$rows = mysqli_num_rows($RsNiveau);
						if($rows > 0) {
							mysqli_data_seek($RsNiveau, 0);
							$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
						} ?>
					</select>
				</div>
				<div class="col-auto">
					<button type="submit" name="Submit2" class="btn btn-primary">Supprimer ce niveau</button>
				</div>
			</div>
		</form>
		<!-----------MODIFICATION NIVEAU------------->
		<form name="form6" method="get" action="gestion_matiere_niveau.php">
			<div class="form-group row align-items-center">
				<label for="niveau_modif_ID" class="col-auto col-form-label">Niveau :</label>
				<div class="col-auto">
					<select name="niveau_modif_ID" id="niveau_modif_ID" class="custom-select" required>
						<option disabled selected value="">Veuillez choisir un niveau</option>
						<?php
						do { 
							?>
							<option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($niveauModifId)) { if (!(strcmp($row_RsNiveau['ID_niveau'], $niveauModifId))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
							<?php 
						} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
						$rows = mysqli_num_rows($RsNiveau);
						if($rows > 0) {
							mysqli_data_seek($RsNiveau, 0);
							$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
						}
						?>
					</select>
				</div>
				<div class="col-auto">
					<button type="submit" name="Submit4" class="btn btn-primary">Modifier ce niveau</button>
				</div>
			</div>
		</form>
		<?php if (isset($niveauModifId)) 
		{ ?>
			<form method="post" name="form8" action="gestion_matiere_niveau.php">
				<div class="form-group row align-items-center">
					<label for="nom_niveau" class="offset-1 col-auto col-form-label">Nom du niveau :</label>
					<div class="col-4">
						<input type="text" class="form-control" name="nom_niveau" value="<?php echo $row_RsModifNiveau['nom_niveau']; ?>" required>
					</div>
					<div class="col-auto">
						<button type="submit" name="submit4" class="btn btn-primary">Valider</button>
					</div>
					<input type="hidden" name="ID_niveau" value="<?php echo $row_RsModifNiveau['ID_niveau']; ?>">
					<input type="hidden" name="MM_update" value="form8">
				</div>
			</form>
		<?php } ?>
		<!-----------LISTE NIVEAU------------->
		<h4 class="text-center">Liste des niveaux</h4>
		<h5 class="text-danger">L'ordre a une importance si vous configurez l'affichage des niveaux selon le niveau de l'élève.</h5>
		<h6>Par exemple, il faut mettre 6e en haut puis 5e en dessous etc.</h6>
		<div class="row">
			<div class="col">
				<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
					<div class="col-3">Réordonner</div>
					<div class="col-4">N°</div>
					<div class="col-5">Nom du niveau</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div id="sortablelist" class="list-group mb-4" data-id="1">
					<?php
					if ($totalRows_RsNiveau != 0) {
						mysqli_data_seek($RsNiveau, 0);
						$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
						do { ?>
							<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_RsNiveau['ID_niveau']?>">
								<div class="col-3" style="cursor: grab;">
									<img class="position-handle" src="include/move.png" width="19" height="19">
								</div>
								<div class="col-4">
									<?php echo $row_RsNiveau['ID_niveau']; ?>
								</div>
								<div class="col-5">
									<?php echo $row_RsNiveau['nom_niveau']; ?>
								</div>
							</div>
							<?php
						} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)); 
					} ?>
				</div>
			</div>
		</div>
		<div class="form-group row align-items-center justify-content-center">	
			<form method="post" name="form_nouvel_ordre" action="gestion_matiere_niveau.php">
				<div class="col-auto">
					<button type="submit" name="submit_nouvel_ordre" class="btn btn-primary" onclick="setValuesInputOrderList()">Enregistrer le nouvel ordre</button>
				</div>
				<input type="hidden" name="mat_ID" value="<?php echo $matiereId; ?>">
				<input type="hidden" name="niv_ID" value="<?php echo $niveauId; ?>">
				<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre">
				<input type="hidden" id="ordreNiveaux" name="ordreNiveaux" value="">
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
				let inputOrdreNiveaux = document.getElementById('ordreNiveaux');
				inputOrdreNiveaux.setAttribute('value', order);
			}
		</script>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php');
mysqli_free_result($RsMatiere);
mysqli_free_result($RsNiveau);
mysqli_free_result($RsModifMatiere);
mysqli_free_result($RsModifNiveau);
?>