<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=gestion_theme");
	}
}
else
{
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2"))
{
	$insertSQL = sprintf("INSERT INTO stock_theme (ID_theme, theme, mat_ID, niv_ID, pos_theme) VALUES ('%s', '%s', '%s', '%s', '%s')",
	htmlspecialchars($_POST['ID_theme']), htmlspecialchars($_POST['theme']), htmlspecialchars($_POST['mat_ID']), htmlspecialchars($_POST['niv_ID']), $position);

	$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));
}

$choixmat_RsTheme = "0";
if (isset($matiereId))
{
	$choixmat_RsTheme = $matiereId;
}
$choixniv_RsTheme = "0";
if (isset($niveauId))
{
	$choixniv_RsTheme = $niveauId;
}
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY pos_theme", $choixmat_RsTheme, $choixniv_RsTheme);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error($conn_intranet));
$row_RsTheme = mysqli_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysqli_num_rows($RsTheme);

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


$titre_page = "Gestion des thèmes d'étude";
$meta_description = "Page gestion des thèmes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form1" method="GET" action="gestion_theme.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="matiere_ID" class="col-auto col-form-label">Matière :</label>
		<div class="col-auto">
			<select name="matiere_ID" id="select2" class="custom-select">
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
			<select name="niveau_ID" id="select" class="custom-select">
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
		<div class="col-auto">
			<h5>
				<?php 
				if (isset($matiereId)) 
				{ 
					echo 'Matière actuelle: '.$row_RsChoixmatiere['nom_mat'];
				} ?>
			</h5>
		</div>
	</div>
</form>
<?php
if (isset($matiereId)) 
{ ?>
	<form method="post" name="form2" action="gestion_theme.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>">
		<div class="form-group row align-items-center justify-content-center mt-5">
			<label for="theme" class="col-auto col-form-label">Ajouter un thème d'étude à cette matière et à ce niveau:</label>
			<div class="col-auto">
				<input type="text" name="theme" class="form-control">
			</div>
			<div class="col-auto">
				<button type="submit" name="submit" class="btn btn-primary">Enregistrer ce nouveau thème d'étude</button>
			</div>
			<input type="hidden" name="ID_theme" value="">
			<input type="hidden" name="mat_ID" value="<?php echo $matiereId; ?>">
			<input type="hidden" name="niv_ID" value="<?php echo $niveauId; ?>">
			<input type="hidden" name="MM_insert" value="form2">
			<input type="hidden" name="ID_mat2" id="ID_mat3" value="<?php echo htmlspecialchars($_POST['ID_mat']);?>">
		</div>
	</form>
	<h4 class="text-center mt-5">Liste des thèmes & Paramétrages</h4>
	<div class="row mt-5">
		<div class="col table-responsive">
			<table class="table table-striped table-bordered table-sm">
				<thead>
					<tr>
						<th scope="col">N°</th>
						<th scope="col"></th>
						<th scope="col"></th>
						<th scope="col">Thème d'étude</th>
						<th scope="col"></th>
						<th scope="col"></th>
						<th scope="col">Date d'apparition</th>
						<th scope="col">Date de disparition</th>
						<th scope="col">Visibilité actuelle</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$x = 0;
					do
					{
						$x = $x + 1;
						$tabpos1[$x] = $row_RsTheme['pos_theme'];
						$tabid1[$x] = $row_RsTheme['ID_theme'];
					} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme)); 
				  if ($totalRows_RsTheme != 0)
					{
						mysqli_data_seek($RsTheme, 0);		
						$row_RsTheme = mysqli_fetch_assoc($RsTheme);
						$t1 = $x;
						$x = 0;
						do
						{
							$x = $x + 1;?>
							<tr> 
								<th scope="row"><?php echo $row_RsTheme['ID_theme']; ?></th>
								<td>
									<?php 
									if($x != 1) 
									{
										echo '<form name="Remonter" method="post" action="remonter_theme.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'">';
										echo '<input name="niveau_ID" type="hidden" id="niveau_ID" value="'.$niveauId.'">';
										echo '<input name="ID_theme" type="hidden" id="ID_theme" value="'.$row_RsTheme['ID_theme'].'">';
										echo '<input name="ID_precedent" type="hidden" id="ID_precedent" value="'.$tabid1[$x - 1].'">';
										echo '<input name="pos_precedent" type="hidden" id="pos_precedent" value="'.$tabpos1[$x - 1].'">';
										echo '<input name="Remonter" type="hidden" value="Remonter">';
										echo '<input type="image" src="images/up.gif" alt="Remonter ce thème">';
										echo '</form>';
									}
									else
									{
										echo '&nbsp;';
									}?>	
								</td>
								<td>
									<?php
									if($x != $t1)
									{
										echo '<form name="Descendre" method="post" action="descendre_theme.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'">';
										echo '<input name="ID_theme" type="hidden" id="ID_theme" value="'.$row_RsTheme['ID_theme'].'">';
										echo '<input name="ID_suivant" type="hidden" id="ID_suivant" value="'.$tabid1[$x + 1].'">';
										echo '<input name="pos_suivant" type="hidden" id="pos_suivant" value="'.$tabpos1[$x + 1].'">';
										echo '<input name="Descendre" type="hidden" value="Descendre">';
										echo '<input type="image" src="images/down.gif" alt="Descendre ce thème">';
										echo '</form>';
									} 
									else
									{
										echo '&nbsp;';
									}?>	
								</td>
								<td>
									<?php echo $row_RsTheme['theme'];?>
								</td>
								<td> 
									<form name="form4" method="post" action="verif_supp_theme.php">
										<input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $row_RsTheme['ID_theme']; ?>">
										<button type="submit" name="Submit" class="btn btn-primary">Supprimer</button>
									</form>
								</td>
								<td> 
									<form name="form3" method="post" action="modif_theme.php">
										<input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $row_RsTheme['ID_theme']; ?>">
										<button type="submit" name="Submit2" class="btn btn-primary">Modifier</button>
									</form>
								</td>
								<td>
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
								</td>
								<td>
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
								</td>
								<td>
									<?php
									$today = date("Y-m-d");
									if ($today >= $row_RsTheme['date_apparition'] AND $today <= $row_RsTheme['date_disparition']) 
									{
										echo '<p class="font-weight-bold text-success">visible</p>';
									} 
									else
									{
										echo '<p class="font-weight-bold text-danger">invisible</p>';
									} ?>
								</td>
							</tr>
							<?php 
						} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme));
					} ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php  
}?>

<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($RsTheme);
mysqli_free_result($RsChoixmatiere);
mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau);
?>