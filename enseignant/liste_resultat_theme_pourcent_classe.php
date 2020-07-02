<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_resultat_theme_pourcent_classe");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_resultat_theme_pourcent_classe");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['ID_mat'])) {
	$matiereId = htmlspecialchars($_POST['ID_mat']);
}
if (isset($_POST['ID_niveau'])) {
	$niveauId = htmlspecialchars($_POST['ID_niveau']);
}
if (isset($_POST['classe'])) {
	$classeName = htmlspecialchars($_POST['classe']);
}

$query_rsClasse = "SELECT ID_eleve, nom, prenom, classe, niveau FROM stock_eleve GROUP BY classe ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));

$query_RsMatiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error($conn_intranet));

$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error($conn_intranet));

if (isset($classeName) && isset($niveauId) && isset($matiereId))
{
	$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY theme", $matiereId, $niveauId);
	$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error($conn_intranet));

	$query_Rs_Liste_eleve = sprintf("SELECT ID_eleve, nom, prenom FROM stock_eleve WHERE classe = '%s' ORDER BY nom", $classeName);
	$Rs_Liste_eleve = mysqli_query($conn_intranet, $query_Rs_Liste_eleve) or die(mysqli_error($conn_intranet));

	$themeid = array();
	$theme = array();
	while ($row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme)) 
	{
		$themeid[] = $row_RsChoixTheme['ID_theme'];
		$theme[] = $row_RsChoixTheme['theme'];
	}


	$query_Rsmoyenne = sprintf("SELECT COUNT(ID_activite) AS nombre20, ID_eleve, theme_ID FROM stock_activite INNER JOIN stock_eleve ON stock_activite.eleve_ID = stock_eleve.ID_eleve INNER JOIN stock_quiz ON stock_activite.quiz_ID = stock_quiz.ID_quiz INNER JOIN stock_theme ON stock_quiz.theme_ID = stock_theme.ID_theme WHERE score = 20 GROUP BY ID_eleve, theme_ID");
	$Rsmoyenne = mysqli_query($conn_intranet, $query_Rsmoyenne) or die(mysqli_error($conn_intranet));

	$query_Rsquiz = sprintf("SELECT COUNT(ID_quiz) AS nombrequiz, theme_ID FROM stock_quiz WHERE avec_score = 'O' GROUP BY theme_ID");
	$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error($conn_intranet));
	$totalRows_Rsquiz = mysqli_num_rows($Rsquiz);

	$tab = array();
	while ($row_Rsmoyenne = mysqli_fetch_assoc($Rsmoyenne))
	{ 
		$tab[$row_Rsmoyenne['ID_eleve']][$row_Rsmoyenne['theme_ID']] = $row_Rsmoyenne['nombre20'];
	}

	while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz))
	{
		$totaltheme[$row_Rsquiz['theme_ID']] = $row_Rsquiz['nombrequiz'];
	}

}

function generateResult($classeName, $conn_intranet, $totalRows_Rsquiz, $theme, $themeid, $tab, $totaltheme)
{
	$query_Rs_Liste_eleve = sprintf("SELECT ID_eleve, nom, prenom FROM stock_eleve WHERE classe = '%s' ORDER BY nom ", $classeName);
	$Rs_Liste_eleve = mysqli_query($conn_intranet, $query_Rs_Liste_eleve) or die(mysqli_error($conn_intranet));

	//test téléchargement
	$fichier_log = '../Exercices/resultats_themes_pourcent.csv';
	chmod($fichier_log, 0777);
	unlink($fichier_log);
	$fp = fopen($fichier_log,"a");

	fwrite($fp, 'Nom Prénom;');

	for ($i = 0; $i < $totalRows_Rsquiz; $i++)
	{
		$listethemes = $theme[$i]."  ".'(N'.$themeid[$i].');';
		fwrite($fp, $listethemes);
	}
	
	fwrite($fp, "\n");
	while ($row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve))
	{
		$listeeleves = $row_Rs_Liste_eleve['nom'].' '.$row_Rs_Liste_eleve['prenom'].';';
		fwrite($fp, $listeeleves);
		$i = 0;

		for ($i = 0; $i < $totalRows_Rsquiz; $i++)
		{
			if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$themeid[$i]])) 
			{
				$total = ($tab[$row_Rs_Liste_eleve['ID_eleve']][$themeid[$i]] / $totaltheme[$themeid[$i]] * 100); 
				fwrite($fp, number_format($total));
			}
			else
			{
				fwrite($fp, '0');
			}
			fwrite($fp, ';');
		}
		fwrite($fp, "\n");
	}
	fclose($fp);

  return;
}

if ((isset($_POST['Submit4'])) && ($_POST['Submit4'] == "export"))
{
	generateResult($classeName, $conn_intranet, $totalRows_Rsquiz, $theme, $themeid, $tab, $totaltheme);
	header('Location: ../Exercices/resultats_themes_pourcent.csv');
}


$titre_page = "Résultats en % par thème pour une classe";
$meta_description = "Page du résultats en % par thème pour une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<form name="form2" method="post" action="liste_resultat_theme_pourcent_classe.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="classe" class="col-auto col-form-label">Sélectionner une classe :</label>
		<div class="col-auto">
			<select name="classe" id="select10" class="custom-select">
				<?php
				while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)) 
				{ ?>
					<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classeName)) { if (!(strcmp($row_rsClasse['classe'], $classeName))) {echo " SELECTED";} }?>><?php echo $row_rsClasse['classe']; ?></option>
					<?php
				} ?>
			</select>
		</div>
		<label for="ID_mat" class="col-auto col-form-label">Sélectionner une matière :</label>
		<div class="col-auto">
			<select name="ID_mat" id="select11" class="custom-select">
				<?php
				while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere)) 
				{ ?>
					<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_RsMatiere['ID_mat'], $matiereId))) {echo " SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
					<?php
				} ?>
			</select>
		</div>
		<label for="ID_niveau" class="col-auto col-form-label">Sélectionner un niveau :</label>
		<div class="col-auto">
			<select name="ID_niveau" id="select7" class="custom-select">
				<?php
				while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)) 
				{ ?>
					<option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_RsNiveau['ID_niveau'], $niveauId))) {echo " SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
					<?php
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit2" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>

<?php
if (isset($classeName) && isset($niveauId) && isset($matiereId))
{ ?>
	<div class="row align-items-center justify-content-end bg-info mb-3 py-2">
		<div class="col-auto">
			<form name="form3" method="post" action="liste_resultat_theme_pourcent_classe.php">
				<button type="submit" name="Submit4" id="Submit4" class="btn btn-primary" value="export">Exporter au format csv</button>
				<input name="ID_mat" type="hidden" id="ID_mat3" value="<?php echo $matiereId; ?>">
				<input name="ID_niveau" type="hidden" id="ID_niveau3" value="<?php echo $niveauId; ?>">
				<input name="classe" type="hidden" id="classe5" value="<?php echo $classeName; ?>">
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
						<th scope="col">Nom - Prénom</th>
						<?php
						for ($i = 0; $i < $totalRows_Rsquiz; $i++)
						{
							echo '<th scope="col">'.$theme[$i].'  '.'( N°'.$themeid[$i].')</th>';
						}
						?>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve))
				{ ?>
					<tr>
						<td><?php echo $row_Rs_Liste_eleve['nom'].' '.$row_Rs_Liste_eleve['prenom'];?></td>
						<?php
						for ($i = 0; $i < $totalRows_Rsquiz; $i++)
						{
							if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$themeid[$i]])) 
							{
								$total = ($tab[$row_Rs_Liste_eleve['ID_eleve']][$themeid[$i]] / $totaltheme[$themeid[$i]] * 100); 
								$totalf = number_format($total);
								if (0 < $totalf && $totalf < 50) {
									echo '<td bgcolor="#ff140c">'.$totalf;
								}
								if (50 <= $totalf &&  $totalf < 75) {
									echo '<td bgcolor="#ffd133">'.$totalf;
								}
								if (75 <= $totalf &&  $totalf < 100) {
									echo '<td bgcolor="#78a419">'.$totalf;
								}
								if ($totalf >= 100) {
									echo '<td bgcolor="#317324">'.$totalf;
								}                 
							}
							else
							{ 
								echo '<td bgcolor="#ff140c">0';
							}
							echo "</td>";
						}?>
					</tr>
				<?php
				}?>
			</tbody>
		</table>
	</div>

	<?php
	mysqli_free_result($Rsquiz);
	mysqli_free_result($Rs_Liste_eleve);
}

require('includes/footerEnseignant.inc.php');

mysqli_free_result($rsClasse);
mysqli_free_result($RsMatiere);
mysqli_free_result($RsNiveau); ?>