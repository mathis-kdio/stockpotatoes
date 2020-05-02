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
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');

?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Administrateur</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Gestion des Matières et des Niveaux</p>
			</div>
		</div>
		<div class="container jumbotron">
			<div class="row">
				<div class="col-6">
					<h4>Gestion des matières</h4>
					<!-----------AJOUT MATIERE------------->
					<form method="post" name="form9" action="gestion_matiere_niveau.php">
						<div class="form-group row align-items-center">
							<label for="nom_mat" class="col-4 col-form-label">Nom de la matière :</label>
							<div class="col-4">
								<input type="text" class="form-control" name="nom_mat" id="nom_mat">
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
								<select name="matiere_supp_ID" id="select2" class="custom-select">
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
								<select name="matiere_modif_ID" id="select" class="custom-select">
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
									<input type="text" name="nom_mat" class="form-control" value="<?php echo $row_RsModifMatiere['nom_mat']; ?>">
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
					<table class="table table-striped table-bordered">
					  <thead>
					    <tr>
					      <th scope="col">ID_mat</th>
					      <th scope="col">Matière</th>
					    </tr>
					  </thead>
						<?php 
						do 
						{ ?>
							<tr> 
								<th scope="row"><?php echo $row_RsMatiere['ID_mat']; ?></td>
								<td><?php echo $row_RsMatiere['nom_mat']; ?></td>
							</tr>
							<?php 
						} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere)); ?>
					</table>
				</div>

				<!---------- NIVEAUX------------>
				<div class="col-6">
					<h4>Gestion des niveaux</h4>
					<!-----------AJOUT NIVEAU------------->
					<form method="post" name="form10" action="gestion_matiere_niveau.php">
						<div class="form-group row align-items-center">
							<label for="nom_niveau" class="col-auto col-form-label">Nom du niveau :</label>
							<div class="col-4">
								<input name="nom_niveau" class="form-control" type="text" id="nom_niveau">
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
								<select name="niveau_supp_ID" id="niveau_supp_ID" class="custom-select">
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
								<select name="niveau_modif_ID" id="niveau_modif_ID" class="custom-select">
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
									<input type="text" class="form-control" name="nom_niveau" value="<?php echo $row_RsModifNiveau['nom_niveau']; ?>">
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
					<p class="font-italic">Vous pouvez classer les niveaux avec (<img src="up.gif" width="15" height="10"> et <img src="down.gif" width="15" height="10">)</p>
					<table class="table table-striped table-bordered">
						<thead>
					    <tr>
					      <th scope="col">ID_niveau</th>
					      <th scope="col">Up</th>
					      <th scope="col">Down</th>
					      <th scope="col">Niveaux</th>
					    </tr>
					  </thead>
						<?php 
						$x = 0;
						do 
						{
							$x = $x + 1;
							$tabpos1[$x] = $row_RsNiveau['pos_niv'];
							$tabid1[$x] = $row_RsNiveau['ID_niveau'];
						} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)); 
						if ($totalRows_RsNiveau != 0)
						{
							mysqli_data_seek($RsNiveau,0);		
							$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
							$t1 = $x; 
							$x = 0;
							do
							{
								$x = $x + 1; ?>
								<tr> 
									<th scope="row"><?php echo $row_RsNiveau['ID_niveau']; ?></th>
									<td class="text-center">
										<?php if($x != 1)
										{
											echo '<form name="Remonter" method="post" action="remonter_niveau.php">'; 
											echo '<input name="ID_niveau" type="hidden" id="ID_niveau" value="'.$row_RsNiveau['ID_niveau'].'">'; 
											echo '<input name="ID_precedent" type="hidden" id="ID_precedent" value="'.$tabid1[$x - 1].'">';
											echo '<input name="pos_precedent" type="hidden" id="pos_precedent" value="'.$tabpos1[$x - 1].'">';
											echo '<input name="Remonter" type="hidden" value="Remonter">';
											echo '<input type="image" src="up.gif" alt="Remonter ce niveau">';
											echo '</form>';
										} 
										else 
										{
											echo '&nbsp;';
										}?> 
									</td>
									<td class="text-center">
										<?php if($x != $t1) 
										{
											echo '<form name="Descendre" method="post" action="descendre_niveau.php">';
											echo '<input name="ID_niveau" type="hidden" id="ID_niveau" value="'.$row_RsNiveau['ID_niveau'].'">';
											echo '<input name="ID_suivant" type="hidden" id="ID_suivant" value="'.$tabid1[$x + 1].'">';
											echo '<input name="pos_suivant" type="hidden" id="pos_suivant" value="'.$tabpos1[$x + 1].'">';
											echo '<input name="Descendre" type="hidden" value="Descendre">';
											echo '<input type="image" src="down.gif" alt="Descendre ce niveau">';
											echo '</form>';
										}
										else
										{
											echo '&nbsp;';
										}?>
									</td>
									<td><?php echo $row_RsNiveau['nom_niveau']; ?></td>
								</tr>
								<?php 
							} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)); 
						}?>
					</table>
				</div>
		</div>
<?php
mysqli_free_result($RsMatiere);
mysqli_free_result($RsNiveau);
mysqli_free_result($RsModifMatiere);
mysqli_free_result($RsModifNiveau);
?>