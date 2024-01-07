<?php
session_start();
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom'] <> 'Enseignant') {
		header("Location: login_enseignant.php?cible=liste_resultat_theme_classe");
	}
}
else {
	header("Location: login_enseignant.php?cible=liste_resultat_theme_classe");
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
if (isset($_GET['classe'])) {
	$classeName = htmlspecialchars($_GET['classe']);
}
if (isset($_GET['categorie_ID'])) {
	$categorieId = htmlspecialchars($_GET['categorie_ID']);
}

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));

if (isset($matiereId) && isset($niveauId)) {
	$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY theme ASC", $matiereId, $niveauId);
	$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error($conn_intranet));
}
//CALCUL DES NOTES
if (isset($classeName)) {
	//Liste des activités
	$query_RsActiviteClasse = sprintf("SELECT * FROM stock_activite, stock_quiz, stock_eleve WHERE stock_eleve.classe = '%s' AND stock_eleve.ID_eleve = stock_activite.eleve_ID AND stock_activite.quiz_ID = stock_quiz.ID_quiz ORDER BY stock_activite.eleve_ID,stock_activite.quiz_ID", $classeName, $matiereId);
	$RsActiviteClasse = mysqli_query($conn_intranet, $query_RsActiviteClasse) or die(mysqli_error($conn_intranet));
	
	//Liste des quiz
	if (isset($categorieId)) {
		$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE theme_ID = '%s' AND categorie_ID = '%s' AND cat_doc = '2' ORDER BY pos_doc", $themeId, $categorieId);
	} else {
		$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE theme_ID = '%s' AND cat_doc = '2' ORDER BY pos_doc", $themeId);
	}
	$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error($conn_intranet));
	$totalRows_Rsquiz = mysqli_num_rows($Rsquiz);

	//Liste des élèves
	$query_Rs_Liste_eleve = sprintf("SELECT ID_eleve, nom, prenom FROM stock_eleve WHERE classe = '%s' ORDER BY nom ", $classeName);
	$Rs_Liste_eleve = mysqli_query($conn_intranet, $query_Rs_Liste_eleve) or die(mysqli_error($conn_intranet));

	//Initialisation
	$tab = array();
	$somme_v = array();
	$nb_notes_v = array();
	$somme_h = array();
	$nb_notes_h = array();
	$moy_eleve = array();
	$cumul_moy_theme = 0;
	$nb_moy = 0;

	$numquiz = array();
	$titrequiz = array();
	$i = 0;
	while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz)) {
		$numquiz[] = $row_Rsquiz['ID_quiz'];
		$titrequiz[] = $row_Rsquiz['titre'];
		$somme_v[$i] = 0;
		$nb_notes_v[$i] = 0;
		$i++;
	}

	//Remplissage du tableau
	while ($row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse)) {
		$tab[$row_RsActiviteClasse['eleve_ID']][$row_RsActiviteClasse['quiz_ID']] = $row_RsActiviteClasse['score'];
	}
	mysqli_data_seek($RsActiviteClasse, 0);

	//Calcul des moyennes
	while ($row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve)) {
		$somme_h[$row_Rs_Liste_eleve['ID_eleve']] = 0;
		$nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']] = 0;
		for ($i = 0; $i < $totalRows_Rsquiz; $i++){
			if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]]) && $tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]] != "") {
				$somme_v[$i] = $somme_v[$i] + $tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]];
				$somme_h[$row_Rs_Liste_eleve['ID_eleve']] = $somme_h[$row_Rs_Liste_eleve['ID_eleve']] + $tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]];
				$nb_notes_v[$i] = $nb_notes_v[$i] + 1;
				$nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']] = $nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']] + 1;    
			}
		}

		//Calcul moyenne si au moins une note
		if ($nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']] != 0) {
			$moy_eleve[$row_Rs_Liste_eleve['ID_eleve']] = ($somme_h[$row_Rs_Liste_eleve['ID_eleve']] / $nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']]);
			$cumul_moy_theme = $moy_eleve[$row_Rs_Liste_eleve['ID_eleve']] + $cumul_moy_theme;
			$nb_moy = $nb_moy + 1; 
		} else {
			$moy_eleve[$row_Rs_Liste_eleve['ID_eleve']] = -1;
		}
	}
	mysqli_data_seek($Rs_Liste_eleve, 0);

	//Récupération du nom du thème
	$query_Rs_theme_choisi = sprintf("SELECT * FROM stock_theme WHERE ID_theme = '%s'", $themeId);
	$Rs_theme_choisi = mysqli_query($conn_intranet, $query_Rs_theme_choisi) or die(mysqli_error($conn_intranet));
	$row_Rs_theme_choisi = mysqli_fetch_assoc($Rs_theme_choisi);
}

//Génération du fichier
function generateResult($classeName, $conn_intranet, $totalRows_Rsquiz, $titrequiz, $numquiz, $tab, $moy_eleve, $nb_notes_v, $somme_v, $nb_moy, $cumul_moy_theme)  {
	$query_Rs_Liste_eleve = sprintf("SELECT ID_eleve, nom, prenom FROM stock_eleve WHERE classe = '%s' ORDER BY nom ", $classeName);
	$Rs_Liste_eleve = mysqli_query($conn_intranet, $query_Rs_Liste_eleve) or die(mysqli_error($conn_intranet));

	//test téléchargement
	$fichier_log = '../Exercices/themeresultats.csv';
	chmod($fichier_log, 0777);
	unlink($fichier_log);
	$fp = fopen($fichier_log, "a");
	$nomprenom = ('N°;Nom Prénom;');
	fwrite($fp, $nomprenom);

	for ($i = 0; $i < $totalRows_Rsquiz; $i++) {
		fwrite($fp, $titrequiz[$i].';');
	}
	fwrite($fp, 'Moy'."\n");

	while ($row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve)) {
		fwrite($fp, $row_Rs_Liste_eleve['ID_eleve'].';'.$row_Rs_Liste_eleve['nom'].' '.$row_Rs_Liste_eleve['prenom'].';');
		for ($i = 0; $i < $totalRows_Rsquiz; $i++) { 
			if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]])) { 
				fwrite($fp, $tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]]);
			}
			else {
				fwrite($fp, ' ');
			}
			fwrite($fp, ';');
		}

		if ($moy_eleve[$row_Rs_Liste_eleve['ID_eleve']] == -1) {
			fwrite($fp, '-');
		}
		else {
			fwrite($fp, number_format($moy_eleve[$row_Rs_Liste_eleve['ID_eleve']], 1, '.', ''));
		}
		fwrite($fp, "\n");
	}

	fwrite($fp, ';Moyenne;');

	for ($i = 0; $i < $totalRows_Rsquiz; $i++) { 
		if ($nb_notes_v[$i] != 0) {
			fwrite($fp, round(($somme_v[$i] / $nb_notes_v[$i]), 1).';');
		}
		else {
			fwrite($fp, '-;');
		}
	}
	if ($nb_moy != 0) {
		fwrite($fp, round(($cumul_moy_theme / $nb_moy), 2));
	}
	fclose($fp);

  return;
}

if ((isset($_GET['Submit4'])) && ($_GET['Submit4'] == "export")) {
	generateResult($classeName, $conn_intranet, $totalRows_Rsquiz, $titrequiz, $numquiz, $tab, $moy_eleve, $nb_notes_v, $somme_v, $nb_moy, $cumul_moy_theme);
	header('Location: ../Exercices/themeresultats.csv');
}

$titre_page = "Résultat aux quiz d'un thème pour une classe";
$meta_description = "Page du résultat aux quiz d'un thème pour une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');

require('../includes/forms/matiere_niveau.inc.php');

if (isset($matiereId) && isset($niveauId)) { ?>
	<form name="form1" method="GET">
		<div class="form-group row align-items-center justify-content-center">
			<label for="theme_ID" class="col-auto col-form-label">Sélectionner un thème :</label>
			<div class="col-auto">
				<select name="theme_ID" id="select8" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir un thème</option>
					<?php
					while ($row_RsTheme = mysqli_fetch_assoc($RsTheme)) { ?>
						<option value="<?php echo $row_RsTheme['ID_theme']?>"<?php if (isset($themeId)) { if (!(strcmp($row_RsTheme['ID_theme'], $themeId))) {echo " SELECTED";}} ?>><?php echo $row_RsTheme['theme']; ?></option>
						<?php
					} ?>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary">Sélectionner</button>
				<input type="hidden" name="matiere_ID" value="<?php echo $matiereId; ?>">
				<input type="hidden" name="niveau_ID" value="<?php echo $niveauId; ?>">
			</div>
		</div>
	</form>
	<?php
}
if (isset($themeId)) { ?>
	<form name="form2" method="GET">
		<div class="form-group row align-items-center justify-content-center">
			<label for="classe" class="col-auto col-form-label">Sélectionner une classe :</label>
			<div class="col-auto">
				<select name="classe" id="select10" class="custom-select" required>
					<option disabled selected value="">Veuillez choisir une classe</option>
					<?php
					while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)) { ?>
						<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classeName)) { if (!(strcmp($row_rsClasse['classe'], $classeName))) {echo " SELECTED";} }?>><?php echo $row_rsClasse['classe']; ?></option>
						<?php
					} ?>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary">Sélectionner</button>
				<input type="hidden" name="matiere_ID" value="<?php echo $matiereId; ?>">
				<input type="hidden" name="niveau_ID" value="<?php echo $niveauId; ?>">
				<input type="hidden" name="theme_ID" value="<?php echo $themeId; ?>">
			</div>
		</div>
	</form>
	<?php 
}
if (isset($classeName)) {

	require('../includes/forms/categorie.inc.php'); ?>

	<div class="row align-items-center justify-content-end bg-info mb-3 py-2">
		<div class="col-auto">
			<h4><?php echo $row_Rs_theme_choisi['theme']; ?></h4>
		</div>
		<div class="col-auto">
			<form name="form3" method="GET">
				<button type="submit" name="Submit4" id="Submit4" class="btn btn-primary" value="export">Exporter au format csv</button>
				<input type="hidden" name="matiere_ID" value="<?php echo $matiereId; ?>">
				<input type="hidden" name="niveau_ID" value="<?php echo $niveauId; ?>">
				<input type="hidden" name="classe" value="<?php echo $classeName; ?>">
				<input type="hidden" name="theme_ID" value="<?php echo $themeId; ?>">
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
					<th scope="col">N°</th>
					<th scope="col">Nom Prénom</th>
						<?php
						for ($i = 0; $i < $totalRows_Rsquiz; $i++) {
							echo '<th scope="col">'.$titrequiz[$i].'<br>(N° '.$numquiz[$i].')</th>';
						} ?>
					<th scope="col">Moyenne</th>
				</tr>
			</thead>
			<tbody>
				<?php				
				while ($row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve)) { ?>
					<tr> 
						<th scope="row"><?php echo $row_Rs_Liste_eleve['ID_eleve']; ?></th>
						<td><?php echo $row_Rs_Liste_eleve['nom'].' '.$row_Rs_Liste_eleve['prenom']; ?></td>
						<?php
						for ($i = 0; $i < $totalRows_Rsquiz; $i++) {
							if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]])) {
								echo '<td>'.$tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]].'</td>';
							}
							else {
								echo '<td></td> ';
							}
						} ?>
						<td>
							<?php
							//Affichage moyenne de l'élève
							if ($moy_eleve[$row_Rs_Liste_eleve['ID_eleve']] == -1) {
								echo '-';
							} else {
								echo number_format($moy_eleve[$row_Rs_Liste_eleve['ID_eleve']], 1, ',', '');
							}?>
						</td>
					</tr>
					<?php
				}
				//Ligne des moyennes en bas du tableau		
				?>
				<tr>
					<td>-</td>
					<td>Moyenne :</td>
					<?php
					for ($i = 0; $i < $totalRows_Rsquiz; $i++) {
						if ($nb_notes_v[$i] != 0) {
							echo '<td>'.round(($somme_v[$i] / $nb_notes_v[$i]), 1).'</td>';
						} else {
							echo '<td>-</td>';
						}
					}?>
					<td>
						<?php
						//moyenne générale
						if ($nb_moy != 0) {
							echo round(($cumul_moy_theme / $nb_moy), 2);
						} ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php
	mysqli_free_result($Rsquiz);
	mysqli_free_result($RsActiviteClasse);
	mysqli_free_result($Rs_Liste_eleve);
	mysqli_free_result($Rs_theme_choisi);
}

require('includes/footerEnseignant.inc.php'); ?>