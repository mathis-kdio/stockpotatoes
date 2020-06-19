<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Upload')
	{
		header("Location: login_upload.php?cible=modif_select");
	}
}
else
{
	header("Location: login_upload.php?cible=modif_select");
}
require_once('../Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}
if (isset($_GET['theme_ID'])) {
	$themeId = htmlspecialchars($_GET['theme_ID']);
}

require_once('../Connections/conn_intranet.php'); 

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);

$query_rsListequiz = "SELECT * FROM stock_quiz WHERE en_ligne = 'N' ORDER BY titre";
$rsListequiz = mysqli_query($conn_intranet, $query_rsListequiz) or die(mysqli_error($conn_intranet));
$row_rsListequiz = mysqli_fetch_assoc($rsListequiz);

$choixmat_rsListeSelectMatiereNiveau = "0";
if (isset($matiereId))
{
	$choixmat_rsListeSelectMatiereNiveau = $matiereId;
}
$choixniv_rsListeSelectMatiereNiveau = "0";
if (isset($niveauId))
{
	$choixniv_rsListeSelectMatiereNiveau = $niveauId;
}
$choixtheme_rsListeSelectMatiereNiveau = "0";
if (isset($themeId))
{
	$choixtheme_rsListeSelectMatiereNiveau = $themeId;
}
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s'  AND niveau_ID = '%s'  AND theme_ID = '%s' ORDER BY titre", $choixmat_rsListeSelectMatiereNiveau, $choixniv_rsListeSelectMatiereNiveau, $choixtheme_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error($conn_intranet));

$colname_rsChoix = "1";
if (isset($matiereId))
{
	$colname_rsChoix = $matiereId;
}
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $colname_rsChoix);
$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error($conn_intranet));
$row_rsChoix = mysqli_fetch_assoc($rsChoix);

$colname_rsChoix2 = "1";
if (isset($niveauId))
{
	$colname_rsChoix2 = $niveauId;
}
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = '%s'", $colname_rsChoix2);
$rsChoix2 = mysqli_query($conn_intranet, $query_rsChoix2) or die(mysqli_error($conn_intranet));
$row_rsChoix2 = mysqli_fetch_assoc($rsChoix2);

$choixniv_RsListeTheme = "0";
if (isset($niveauId))
{
	$choixniv_RsListeTheme = $niveauId;
}
$choixmat_RsListeTheme = "0";
if (isset($matiereId))
{
	$choixmat_RsListeTheme = $matiereId;
}
$query_RsListeTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY theme", $choixmat_RsListeTheme, $choixniv_RsListeTheme);
$RsListeTheme = mysqli_query($conn_intranet, $query_RsListeTheme) or die(mysqli_error($conn_intranet));
$row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme);

$selectheme_RsChoixTheme = "0";
if (isset($themeId))
{
	$selectheme_RsChoixTheme = $themeId;
}
$query_RsChoixTheme = sprintf("SELECT theme FROM stock_theme WHERE ID_theme = '%s'", $selectheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error($conn_intranet));
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);

$titre_page = "Menu d'ajout de fichiers joints";
$meta_description = "Page d'ajout de fichiers joints";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('include/headerUpload.inc.php');
?>

<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Upload</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Menu d'ajout de fichiers joints</p>
			</div>
		</div>
		<div class="container jumbotron">
			<form name="form1" method="GET" action="modif_select.php">
				<div class="form-group row align-items-center justify-content-center">
					<label for="matiere_ID" class="col-auto col-form-label">Matière :</label>
					<div class="col-auto">
						<select name="matiere_ID" id="select2" class="custom-select">
							<?php
							do { ?>
								<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo "SELECTED";} } ?>><?php echo $row_rs_matiere['nom_mat']?></option>
								<?php
							} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)); ?>
						</select>
					</div>
					<label for="niveau_ID" class="col-auto col-form-label">Niveau :</label>
					<div class="col-auto">
						<select name="niveau_ID" id="select" class="custom-select">
							<?php
							do { ?>
								<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
								<?php
							} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)); ?>
						</select>
					</div>
					<div class="col-auto">
						<button type="submit" name="Submit" class="btn btn-primary">Sélectionner</button>
					</div>
				</div>
			</form>
			<?php if (isset($matiereId))
			{ ?>
				<form name="form1" method="GET" action="modif_select.php">
					<div class="form-group row align-items-center justify-content-center">
						<label for="theme_ID" class="col-auto col-form-label">Thème :</label>
						<div class="col-auto">
							<select name="theme_ID" id="select2" class="custom-select">
								<?php
								do { ?>
									<option value="<?php echo $row_RsListeTheme['ID_theme']?>"<?php if (isset($themeId)) { if (!(strcmp($row_RsListeTheme['ID_theme'], $themeId))) {echo "SELECTED";} } ?>><?php echo $row_RsListeTheme['theme']?></option>
									<?php
								} while ($row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme)); ?>
									<option value="0">Divers</option>
							</select>
						</div>
						<div class="col-auto">
							<button type="submit" name="Submit" class="btn btn-primary">Sélectionner</button>
						</div>
					</div>
					<input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $niveauId; ?>">
					<input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $matiereId; ?>">
				</form>
				<?php if (isset($themeId))
				{ ?>
					<h2 class="text-center mb-5">
						<?php
						if ($themeId != 0)
						{
							echo $row_rsChoix['nom_mat'].'-'.$row_rsChoix2['nom_niveau'].'-'.$row_RsChoixTheme['theme'];
						}
						else
						{
							echo $row_rsChoix['nom_mat'].'-'.$row_rsChoix2['nom_niveau'].'-Divers';
						} ?>
					</h2>
					<table class="table table-striped table-bordered table-sm">
						<thead>
							<tr>
								<th scope="col">N°</th>
								<th scope="col">Titre de l'exercice</th>
								<th scope="col">Fichier</th>
								<th scope="col">Auteur</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau))
							{ ?>
								<tr> 
									<td>
										<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
									</td>
									<td>
										<a href="../choix_quiz.php?VAR_fichier=<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>&VAR_ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>&VAR_nom_mat=<?php echo $row_rsChoix['nom_mat']; ?>"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong>
										</a>
									</td>
									<td>
										<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>
									</td>
									<td>
										<?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?>
									</td>
									<td>
										<form name="form2" method="post" action="ajout_fichiers_joints.php">
											<button type="submit" name="Submit3" class="btn btn-primary">Sélectionner</button>
											<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
											<input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $row_rsChoix['ID_mat']; ?>">
										</form>
									</td>
								</tr>
								<?php 
							}?>
						</tbody>
					</table>
				<?php } 
			} ?>
		</div>
	</div>
</div>
<?php
require('include/footerUpload.inc.php');
mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau);
mysqli_free_result($rsListequiz);
mysqli_free_result($rsListeSelectMatiereNiveau);
mysqli_free_result($rsChoix);
mysqli_free_result($rsChoix2);
mysqli_free_result($RsListeTheme);
mysqli_free_result($RsChoixTheme);
?>