<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=gestion_exos");
	}
}
else
{
	header("Location: login_enseignant.php?cible=gestion_exos");
}

require_once('../Connections/conn_intranet.php');

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}
if (isset($_GET['theme_ID'])) {
	$themeId = htmlspecialchars($_GET['theme_ID']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau ORDER BY ID_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);

$query_rsListequiz = "SELECT * FROM stock_quiz WHERE en_ligne = 'O' AND avec_score = 'O' ORDER BY titre";
$rsListequiz = mysqli_query($conn_intranet, $query_rsListequiz) or die(mysqli_error($conn_intranet));
$row_rsListequiz = mysqli_fetch_assoc($rsListequiz);

//Mise à jour de l'ordre
if (
	isset($_POST["MM_nouvel_ordre"]) && (
	($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre_cours") ||
	($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre_hotpotatoes") ||
	($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre_autres") ||
	($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre_travail") ||
	($_POST["MM_nouvel_ordre"] == "form_nouvel_ordre_documents"))
) {
	switch ($_POST["MM_nouvel_ordre"]) {
		case 'form_nouvel_ordre_cours':
			$ordre = htmlspecialchars($_POST['ordreCours']);
			break;
		case 'form_nouvel_ordre_hotpotatoes':
			$ordre = htmlspecialchars($_POST['ordreHotpotatoes']);
			break;
		case 'form_nouvel_ordre_autres':
			$ordre = htmlspecialchars($_POST['ordreAutres']);
			break;
		case 'form_nouvel_ordre_travail':
			$ordre = htmlspecialchars($_POST['ordreTravail']);
			break;
		case 'form_nouvel_ordre_documents':
			$ordre = htmlspecialchars($_POST['ordreDocuments']);
			break;

		default:
			$ordre = 0;
			break;
	}
	$ordre = explode(",", $ordre);

	for ($i = 1; $i <= count($ordre); $i++) {
		$updatePositions = sprintf("UPDATE stock_quiz SET pos_doc = '%s' WHERE ID_quiz = '%s'", $i, $ordre[$i - 1]);
		$RsNewPositions = mysqli_query($conn_intranet, $updatePositions) or die(mysqli_error($conn_intranet));
	}
}

$choixmat_rsListeSelectMatiereNiveau = "0";
if (isset($matiereId)) {
	$choixmat_rsListeSelectMatiereNiveau = $matiereId;
}
$choixniv_rsListeSelectMatiereNiveau = "0";
if (isset($niveauId)) {
	$choixniv_rsListeSelectMatiereNiveau = $niveauId;
}
$choixtheme_rsListeSelectMatiereNiveau = "0";
if (isset($themeId)) {
	$choixtheme_rsListeSelectMatiereNiveau = $themeId;
}
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz, stock_categorie WHERE stock_quiz.matiere_ID = '%s'  AND stock_quiz.niveau_ID = '%s'  AND stock_quiz.theme_ID = '%s' AND stock_quiz.categorie_ID = stock_categorie.ID_categorie ORDER BY stock_quiz.pos_doc, stock_quiz.titre", $choixmat_rsListeSelectMatiereNiveau, $choixniv_rsListeSelectMatiereNiveau,$choixtheme_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error($conn_intranet));
$row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysqli_num_rows($rsListeSelectMatiereNiveau);

$colname_rsChoix = "1";
if (isset($matiereId)) {
	$colname_rsChoix = $matiereId;
}
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $colname_rsChoix);
$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error($conn_intranet));
$row_rsChoix = mysqli_fetch_assoc($rsChoix);

$colname_rsChoix2 = "1";
if (isset($niveauId)) {
	$colname_rsChoix2 = $niveauId;
}
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = '%s'", $colname_rsChoix2);
$rsChoix2 = mysqli_query($conn_intranet, $query_rsChoix2) or die(mysqli_error($conn_intranet));
$row_rsChoix2 = mysqli_fetch_assoc($rsChoix2);

$choixniv_RsListeTheme = "0";
if (isset($niveauId)) {
	$choixniv_RsListeTheme = $niveauId;
}
$choixmat_RsListeTheme = "0";
if (isset($matiereId)) {
	$choixmat_RsListeTheme = $matiereId;
}
$query_RsListeTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY pos_theme", $choixmat_RsListeTheme, $choixniv_RsListeTheme);
$RsListeTheme = mysqli_query($conn_intranet, $query_RsListeTheme) or die(mysqli_error($conn_intranet));
$row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme);

$selectheme_RsChoixTheme = "0";
if (isset($themeId)) {
	$selectheme_RsChoixTheme = $themeId;
}
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme = '%s'", $selectheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error($conn_intranet));
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);
 
$icone[1]='images/link.gif';
$icone[2]='images/patate.gif';
$icone[3]='images/b_edit.png';
$icone[4]='images/html.gif';
$icone[5]='images/word.gif';
$icone[6]='images/xls.gif';
$icone[7]='images/ppt.gif';
$icone[8]='images/pdf.gif';
$icone[9]='images/oopres.gif';
$icone[10]='images/oott.gif';
$icone[11]='images/ootab.gif';
$icone[12]='images/image.gif';
$icone[13]='images/swf.gif';
$icone[14]='images/avi.gif';
$icone[15]='images/avi.gif';
$icone[16]='images/autres.gif';

$titre_page = "Espace Enseignant - Gestion des exercices";
$meta_description = "Page gestion des exercices";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "includes/Sortable.js";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form1" method="GET" action="gestion_exos.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="select2" class="col-auto col-form-label">Sélectionnez une matière</label>
		<div class="col-auto">
			<select class="custom-select" name="matiere_ID" id="select2">
				<?php
				do
				{ ?>
					<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo "SELECTED";}}?>><?php echo $row_rs_matiere['nom_mat']?></option>
					<?php
				} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)); ?>
			</select>
		</div>
		<label for="select" class="col-auto col-form-label">Sélectionnez un niveau</label>
		<div class="col-auto">
			<select class="custom-select" name="niveau_ID" id="select">
				<?php
				do 
				{ ?>
					<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";}}?>><?php echo $row_rs_niveau['nom_niveau']?></option>
					<?php
				} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)); ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit" class="btn btn-primary">Valider</button>
		</div>
	</div>
</form>
<?php if (isset($matiereId))
{ ?>
	<div class="row mt-2 mb-2">
		<div class="col text-center">
			<h3>Matière actuelle: <?php echo $row_rsChoix['nom_mat']; ?></h3>
		</div>
	</div>

	<form name="form2" method="GET" action="gestion_exos.php">
		<div class="form-group row align-items-center justify-content-center">
			<label for="select3" class="col-auto col-form-label">Sélectionnez un thème :</label>
			<div class="col-auto">
				<select class="custom-select" name="theme_ID" id="select3">
					<?php
					do { ?>
						<option value="<?php echo $row_RsListeTheme['ID_theme']?>"<?php if (isset($themeId)) { if (!(strcmp($row_RsListeTheme['ID_theme'], $themeId))) {echo "SELECTED";}}?>><?php echo $row_RsListeTheme['theme']?></option>
						<?php
					} while ($row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme)); ?>
					<option value="0" <?php if (!isset($themeId) || $themeId == 0) { echo "selected";} ?>>Divers</option>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" name="Submit" class="btn btn-primary">Valider</button>
			</div>
		</div>
		<input type="hidden" name="matiere_ID" value="<?php echo $matiereId; ?>">
		<input type="hidden" name="niveau_ID" value="<?php echo $niveauId; ?>">
	</form>

	<div class="row">
		<div class="col-12">
			<div class="row">
				<div class="col text-center">
					<?php
					if (isset($themeId) && $themeId != 0)
					{
						echo '<h3>'.$row_RsChoixTheme['theme'].'</h3>';
					}
					else
					{
						echo '<h3>Divers</h3>';
					}
					?>
					<div class="row align-items-center">
						<div class="col pt-1 pb-1 shadow rounded text-center">
							<a href="#cours">Cours</a> - <a href="#hotpotatoes">Ex. Hotpotatoes</a> - <a href="#exercices">Autres exercices</a> - <a href="#travail">Travail à faire</a> - <a href="#annexes">Documents annexes</a>
						</div>
					</div>
				</div>
			</div>
			<!-- LE COURS -->
			<?php
			if ($totalRows_rsListeSelectMatiereNiveau != 0) {	
				mysqli_data_seek($rsListeSelectMatiereNiveau, 0);
			} ?>
			<div class="row mt-2">
				<div class="col">
					<h5 class="font-weight-bold text-center" id="cours">Le cours</h5>
					<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
						<div class="col-1">Réordonner</div>
						<div class="col-1">N°</div>
						<div class="col-2">Titre</div>
						<div class="col-1">Catégorie</div>
						<div class="col-1">Fichier</div>
						<div class="col-1">Auteur</div>
						<div class="col-1">Entr.</div>
						<div class="col-1">Eval.</div>
						<div class="col-1">Note</div>
						<div class="col-1">Supprimer</div>
						<div class="col-1">Modifier</div>
					</div>
					<div class="row">
						<div class="col">
							<div id="sortablelistCours" class="list-group mb-4" data-id="1">
								<?php
								while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)) {
									if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 1) { ?>
										<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']?>">
											<div class="col-1" style="cursor: grab;">
												<img class="position-handle" src="images/move.png" width="19" height="19">
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
												<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']]; ?>" width="19" height="19">
											</div>              
											<div class="col-2">
												<?php 
												if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$lien = $row_rsListeSelectMatiereNiveau['fichier'];
												} 
												else {
													$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
												} ?>
												<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
											</div>
											<div class="col-1">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '') {
													echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php 
												if($row_rsListeSelectMatiereNiveau['type_doc'] != 1) {
													echo $row_rsListeSelectMatiereNiveau['fichier'];
												}
												else {
													echo 'Lien hypertexte';
												}?>
											</div>
											<div class="col-1">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['auteur'] != '') {
													echo $row_rsListeSelectMatiereNiveau['auteur'];
												}
												else {
													echo '-';
												}?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
											</div>
											<div class="col-1">
												<form name="formsup1" method="post" action="supp_quiz.php">
													<div align="center">
														<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
														<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
														<input name="boutonsup1" type="hidden" value="Supprimer">
														<input type="image" src="images/delete.gif" alt="Supprimer un document">
													</div>
												</form>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$redirection = 'misajour_url.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2) {
													$redirection = 'misajour_hotpot.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3) {
													$redirection = 'misajour_online.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3) {
													$redirection = 'misajour_divers.php';
												}?>
												<form name="formmod1" method="post" action="<?php echo $redirection; ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
													<div>
														<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID']; ?>">         
														<input name="boutonmod1" type="hidden" value="Modifier">
														<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document"> 
													</div>
												</form>
											</div>
										</div>
										<?php
									}
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center justify-content-center">	
				<form method="post" name="form_nouvel_ordre_cours" action="gestion_exos.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>&theme_ID=<?php echo $themeId; ?>#cours">
					<div class="col-auto">
						<button type="submit" name="submit_nouvel_ordre_cours" class="btn btn-primary" onclick="setValuesInputOrderListCours()">Enregistrer le nouvel ordre des cours</button>
					</div>
					<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre_cours">
					<input type="hidden" id="ordreCours" name="ordreCours" value="">
				</form>
			</div>
			<script type="text/javascript">
				let listCours = Sortable.create(sortablelistCours, {
					animation: 100,
					group: 'list-1',
					draggable: '.list-group-item',
					handle: '.position-handle',
					sort: true,
					filter: '.sortable-disabled',
					chosenClass: 'active',
				});
				function setValuesInputOrderListCours() {
					let order = listCours.toArray();
					let inputOrdreCours = document.getElementById('ordreCours');
					inputOrdreCours.setAttribute('value', order);
				}
			</script>
			<!-- HOTPOTATOES -->
			<?php 
			if ($totalRows_rsListeSelectMatiereNiveau != 0) {
				mysqli_data_seek($rsListeSelectMatiereNiveau, 0);
			} ?>
			<div class="row mt-2">
				<div class="col">
					<h5 class="font-weight-bold text-center" id="hotpotatoes">Exercices Hotpotatoes</h5>
					<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
						<div class="col-1">Réordonner</div>
						<div class="col-1">N°</div>
						<div class="col-2">Titre</div>
						<div class="col-1">Catégorie</div>
						<div class="col-1">Fichier</div>
						<div class="col-1">Auteur</div>
						<div class="col-1">Entr.</div>
						<div class="col-1">Eval.</div>
						<div class="col-1">Note</div>
						<div class="col-1">Supprimer</div>
						<div class="col-1">Modifier</div>
					</div>
					<div class="row">
						<div class="col">
							<div id="sortablelistHotpotatoes" class="list-group mb-4" data-id="1">
									<?php
									do {
										if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 2) { ?>
										<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']?>">
												<div class="col-1" style="cursor: grab;">
													<!--<span class="position-handle badge badge-dark">14</span>-->
													<img class="position-handle" src="images/move.png" width="19" height="19">
												</div>
												<div class="col-1">
													<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
													<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
												</div>						
												<div class="col-2">
													<?php 
													if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
														$lien = $row_rsListeSelectMatiereNiveau['fichier'];
													} 
													else {
														$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
													} ?>
													<a href="<?php echo $lien ; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
												</div>
												<div class="col-1">
													<?php 
													if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '') {
														echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
													}
													else {
														echo '-';
													}?>
												</div>		  
												<div class="col-1">
													<?php
													if($row_rsListeSelectMatiereNiveau['type_doc'] != 1) {
														echo $row_rsListeSelectMatiereNiveau['fichier'];
													}
													else {
														echo 'Lien hypertexte';
													}?>
												</div>
												<div class="col-1">
													<?php if ($row_rsListeSelectMatiereNiveau['auteur'] != '') {
														echo $row_rsListeSelectMatiereNiveau['auteur'];
													}
													else {
														echo '-';
													} ?>
												</div>
												<div class="col-1">
													<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
												</div>
												<div class="col-1">
													<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
												</div>
												<div class="col-1">
													<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
												</div>
												<div class="col-1">
													<form name="formsup2" method="post" action="supp_quiz.php">
														<div align="center">
															<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
															<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
															<input name="boutonsup2" type="hidden" value="Supprimer">
															<input type="image" src="images/delete.gif" alt="Supprimer un document">
														</div>
													</form>
												</div>
												<div class="col-1">
													<?php	 
													if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
														$redirection = 'misajour_url.php';
													}
													if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2) {
														$redirection = 'misajour_hotpot.php';
													}
													if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3) {
														$redirection = 'misajour_online.php';
													}
													if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3) {
														$redirection = 'misajour_divers.php';
													}
													?>
													<form name="formmod2" method="post" action="<?php echo $redirection;?>?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
														<div align="center">
															<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID']; ?>">
															<input name="boutonmod2" type="hidden" value="Modifier">
															<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
														</div>
													</form>
												</div>
										</div>
											<?php 
										}
									} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group align-items-center justify-content-center">	
				<form method="post" name="form_nouvel_ordre_hotpotatoes" action="gestion_exos.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>&theme_ID=<?php echo $themeId; ?>#hotpotatoes">
					<div class="col-auto">
						<button type="submit" name="submit_nouvel_ordre_Hotpotatoes" class="btn btn-primary" onclick="setValuesInputOrderListHotpotatoes()">Enregistrer le nouvel ordre des exos Hotpotatoes</button>
					</div>
					<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre_hotpotatoes">
					<input type="hidden" id="ordreHotpotatoes" name="ordreHotpotatoes" value="">
				</form>
			</div>
			<script type="text/javascript">
				let listHotpotatoes = Sortable.create(sortablelistHotpotatoes, {
					animation: 100,
					group: 'list-2',
					draggable: '.list-group-item',
					handle: '.position-handle',
					sort: true,
					filter: '.sortable-disabled',
					chosenClass: 'active',
				});
				function setValuesInputOrderListHotpotatoes() {
					let order = listHotpotatoes.toArray();
					let inputOrdreHotpotatoes = document.getElementById('ordreHotpotatoes');
					inputOrdreHotpotatoes.setAttribute('value', order);
				}
			</script>
			<!-- Autres exercices 3 -->
			<?php 
			if ($totalRows_rsListeSelectMatiereNiveau != 0) {
				mysqli_data_seek($rsListeSelectMatiereNiveau, 0);
			} ?>
			<div class="row mt-2">
				<div class="col">
					<h5 class="font-weight-bold text-center" id="exercices">Autres exercices - TP</h5>
					<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
						<div class="col-1">Réordonner</div>
						<div class="col-1">N°</div>
						<div class="col-2">Titre</div>
						<div class="col-1">Catégorie</div>
						<div class="col-1">Fichier</div>
						<div class="col-1">Auteur</div>
						<div class="col-1">Entr.</div>
						<div class="col-1">Eval.</div>
						<div class="col-1">Note</div>
						<div class="col-1">Supprimer</div>
						<div class="col-1">Modifier</div>
					</div>
					<div class="row">
						<div class="col">
							<div id="sortablelistAutres" class="list-group mb-4" data-id="1">
								<?php
								do {	
									if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 3) { ?>
										<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']?>">
											<div class="col-1" style="cursor: grab;">
												<img class="position-handle" src="images/move.png" width="19" height="19">
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
												<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
											</div>
											<div class="col-2">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$lien = $row_rsListeSelectMatiereNiveau['fichier'];
												} 
												else {
													$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
												} ?>
												<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '') {
													echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php
												if($row_rsListeSelectMatiereNiveau['type_doc'] != 1) {
													echo $row_rsListeSelectMatiereNiveau['fichier'];
												}
												else {
													echo 'Lien hypertexte';
												}?>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['auteur'] != '') {
													echo $row_rsListeSelectMatiereNiveau['auteur'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
											</div>
											<div class="col-1">
												<form name="formsup3" method="post" action="supp_quiz.php">
													<div align="center">
														<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
														<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
														<input name="boutonsup3" type="hidden" value="Supprimer">
														<input type="image" src="images/delete.gif" alt="Supprimer un document">
													</div>
												</form>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$redirection = 'misajour_url.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2) {
													$redirection = 'misajour_hotpot.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3) { 
													$redirection = 'misajour_online.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3) { 
													$redirection = 'misajour_divers.php';
												} ?>
												<form name="formmod3" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
													<div align="center">
														<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
														<input name="boutonmod3" type="hidden" value="Modifier">
														<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
													</div>
												</form>
											</div>
										</div>
										<?php 
									}
								} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group align-items-center justify-content-center">	
				<form method="post" name="form_nouvel_ordre_autres" action="gestion_exos.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>&theme_ID=<?php echo $themeId; ?>#exercices">
					<div class="col-auto">
						<button type="submit" name="submit_nouvel_ordre_autres" class="btn btn-primary" onclick="setValuesInputOrderListAutres()">Enregistrer le nouvel ordre des autres documents</button>
					</div>
					<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre_autres">
					<input type="hidden" id="ordreAutres" name="ordreAutres" value="">
				</form>
			</div>
			<script type="text/javascript">
				let listAutres = Sortable.create(sortablelistAutres, {
					animation: 100,
					group: 'list-3',
					draggable: '.list-group-item',
					handle: '.position-handle',
					sort: true,
					filter: '.sortable-disabled',
					chosenClass: 'active',
				});
				function setValuesInputOrderListAutres() {
					let order = listAutres.toArray();
					let inputOrdreAutres = document.getElementById('ordreAutres');
					inputOrdreAutres.setAttribute('value', order);
				}
			</script>
			<!-- Travail à faire 4 -->
			<?php
			if ($totalRows_rsListeSelectMatiereNiveau != 0) {	
				mysqli_data_seek($rsListeSelectMatiereNiveau, 0);
			} ?>
			<div class="row mt-2">
				<div class="col">
					<h5 class="font-weight-bold text-center" id="travail">Travail à faire</h5>
					<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
						<div class="col-1">Réordonner</div>
						<div class="col-1">N°</div>
						<div class="col-2">Titre</div>
						<div class="col-1">Catégorie</div>
						<div class="col-1">Fichier</div>
						<div class="col-1">Auteur</div>
						<div class="col-1">Entr.</div>
						<div class="col-1">Eval.</div>
						<div class="col-1">Note</div>
						<div class="col-1">Supprimer</div>
						<div class="col-1">Modifier</div>
					</div>
					<div class="row">
						<div class="col">
							<div id="sortablelistTravail" class="list-group mb-4" data-id="1">
								<?php
								do {
									if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 4) {?>
										<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']?>">
											<div class="col-1" style="cursor: grab;">
												<img class="position-handle" src="images/move.png" width="19" height="19">
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
												<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
											</div>
											<div class="col-2">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$lien = $row_rsListeSelectMatiereNiveau['fichier'];
												} 
												else {
													$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
												} ?>
												<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '') {
													echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php
												if($row_rsListeSelectMatiereNiveau['type_doc'] != 1) {
													echo $row_rsListeSelectMatiereNiveau['fichier'];
												}
												else {
													echo 'Lien hypertexte';
												}?>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['auteur'] != '') {
													echo $row_rsListeSelectMatiereNiveau['auteur'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
											</div>
											<div class="col-1">
												<form name="formsup4" method="post" action="supp_quiz.php">
													<div align="center">
														<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
														<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
														<input name="boutonsup4" type="hidden" value="Supprimer">
														<input type="image" src="images/delete.gif" alt="Supprimer un document">
													</div>
												</form>
											</div>
											<div class="col-1">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$redirection = 'misajour_url.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2) {
													$redirection = 'misajour_hotpot.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3) {
													$redirection = 'misajour_online.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3) {
													$redirection = 'misajour_divers.php';
												}	?>
												<form name="formmod4" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
													<div align="center">
														<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
														<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
														<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
													</div>
												</form>
											</div>
										</div>
										<?php 
									}
								} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group align-items-center justify-content-center">	
				<form method="post" name="form_nouvel_ordre_travail" action="gestion_exos.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>&theme_ID=<?php echo $themeId; ?>#travail">
					<div class="col-auto">
						<button type="submit" name="submit_nouvel_ordre_travail" class="btn btn-primary" onclick="setValuesInputOrderListTravail()">Enregistrer le nouvel ordre du travail à faire</button>
					</div>
					<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre_travail">
					<input type="hidden" id="ordreTravail" name="ordreTravail" value="">
				</form>
			</div>
			<script type="text/javascript">
				let listTravail = Sortable.create(sortablelistTravail, {
					animation: 100,
					group: 'list-4',
					draggable: '.list-group-item',
					handle: '.position-handle',
					sort: true,
					filter: '.sortable-disabled',
					chosenClass: 'active',
				});
				function setValuesInputOrderListTravail() {
					let order = listTravail.toArray();
					let inputOrdreTravail = document.getElementById('ordreTravail');
					inputOrdreTravail.setAttribute('value', order);
				}
			</script>
			<!-- Documents annexes 5 -->
			<?php
			if ($totalRows_rsListeSelectMatiereNiveau != 0)
			{
				mysqli_data_seek($rsListeSelectMatiereNiveau, 0);
			} ?>
			<div class="row mt-2">
				<div class="col">
					<h5 class="font-weight-bold text-center" id="annexes">Documents annexes</h5>
					<div class="d-flex bg-white p-3 text-center overflow-auto overflow-auto">
						<div class="col-1">Réordonner</div>
						<div class="col-1">N°</div>
						<div class="col-2">Titre</div>
						<div class="col-1">Catégorie</div>
						<div class="col-1">Fichier</div>
						<div class="col-1">Auteur</div>
						<div class="col-1">Entr.</div>
						<div class="col-1">Eval.</div>
						<div class="col-1">Note</div>
						<div class="col-1">Supprimer</div>
						<div class="col-1">Modifier</div>
					</div>
					<div class="row">
						<div class="col">
							<div id="sortablelistDocuments" class="list-group mb-4" data-id="1">
								<?php
								do {
									if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 5) { ?>
										<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']?>">
											<div class="col-1" style="cursor: grab;">
												<img class="position-handle" src="images/move.png" width="19" height="19">
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
												<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
											</div>			
											<div class="col-2">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$lien = $row_rsListeSelectMatiereNiveau['fichier'];
												} 
												else {
												$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
												} ?>
												<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '') {
													echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php
												if ($row_rsListeSelectMatiereNiveau['type_doc'] != 1) {
													echo $row_rsListeSelectMatiereNiveau['fichier'];
												}
												else {
													echo 'Lien hypertexte';
												}?>
											</div>
											<div class="col-1">
												<?php 
												if ($row_rsListeSelectMatiereNiveau['auteur'] != '') {
													echo $row_rsListeSelectMatiereNiveau['auteur'];
												}
												else {
													echo '-';
												} ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
											</div>
											<div class="col-1">
												<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
											</div>
											<div class="col-1">
												<form name="formsup5" method="post" action="supp_quiz.php">
													<div align="center">
														<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
														<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
														<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
														<input name="boutonsup5" type="hidden" value="Supprimer">
														<input type="image" src="images/delete.gif" alt="Supprimer un document">
													</div>
												</form>
											</div>
											<div class="col-1">
												<?php	 
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) {
													$redirection = 'misajour_url.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2) {
													$redirection = 'misajour_hotpot.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3) {
													$redirection = 'misajour_online.php';
												}
												if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3) {
													$redirection = 'misajour_divers.php';
												}
												?>
												<form name="formmod5" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
													<div align="center">
														<input name="boutonmod5" type="hidden" value="Modifier">
														<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
													</div>
												</form>
											</div>
										</div>
										<?php 
									}
								} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row form-group align-items-center justify-content-center">	
				<form method="post" name="form_nouvel_ordre_documents" action="gestion_exos.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>&theme_ID=<?php echo $themeId; ?>#annexes">
					<div class="col-auto">
						<button type="submit" name="submit_nouvel_ordre_documents" class="btn btn-primary" onclick="setValuesInputOrderListDocuments()">Enregistrer le nouvel ordre des documents annexes</button>
					</div>
					<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre_documents">
					<input type="hidden" id="ordreDocuments" name="ordreDocuments" value="">
				</form>
			</div>
			<script type="text/javascript">
				let listDocuments = Sortable.create(sortablelistDocuments, {
					animation: 100,
					group: 'list-5',
					draggable: '.list-group-item',
					handle: '.position-handle',
					sort: true,
					filter: '.sortable-disabled',
					chosenClass: 'active',
				});
				function setValuesInputOrderListDocuments() {
					let order = listDocuments.toArray();
					let inputOrdreDocuments = document.getElementById('ordreDocuments');
					inputOrdreDocuments.setAttribute('value', order);
				}
			</script>
		</div>
	</div>
	<?php
}?>

<?php
require('includes/footerEnseignant.inc.php');

mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau);
mysqli_free_result($rsListequiz);
mysqli_free_result($rsListeSelectMatiereNiveau);
mysqli_free_result($rsChoix);
mysqli_free_result($rsChoix2);
mysqli_free_result($RsListeTheme);
mysqli_free_result($RsChoixTheme);
?>