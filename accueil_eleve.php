<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['Sess_nom']))
{
	header('Location:login_eleve.php');
}

require_once('Connections/conn_intranet.php');

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}
if (isset($_GET['theme_ID'])) {
	$themeId = htmlspecialchars($_GET['theme_ID']);
}
if (isset($_GET['categorie_ID'])) {
	$categorieId = htmlspecialchars($_GET['categorie_ID']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau ORDER BY ID_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);

$query_rsListequiz = "SELECT * FROM stock_quiz WHERE avec_score = 'O' ORDER BY titre";
$rsListequiz = mysqli_query($conn_intranet, $query_rsListequiz) or die(mysqli_error($conn_intranet));
$row_rsListequiz = mysqli_fetch_assoc($rsListequiz);

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
$choixcategorie_rsListeSelectMatiereNiveau = "0";
if (isset($categorieId)) {
	$choixcategorie_rsListeSelectMatiereNiveau = $categorieId;
}

$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND theme_ID = '%s' AND categorie_ID = '%s' AND avec_score = 'O' ORDER BY pos_doc", $choixmat_rsListeSelectMatiereNiveau, $choixniv_rsListeSelectMatiereNiveau, $choixtheme_rsListeSelectMatiereNiveau, $choixcategorie_rsListeSelectMatiereNiveau);
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

$matListeTheme = 0;
if (isset($matiereId)) {
	$matListeTheme = $matiereId;
}
$nivListeTheme = 0;
if (isset($niveauId)) {
	$nivListeTheme = $niveauId;
}
$today = date("Y-m-d");
$listeTheme = mysqli_prepare($conn_intranet, "SELECT ID_theme, theme FROM stock_theme WHERE mat_ID = ? AND niv_ID = ? AND '$today' >= date_apparition AND date_disparition >= '$today' ORDER BY pos_theme") or exit(mysqli_error($conn_intranet));
mysqli_stmt_bind_param($listeTheme, "ii", $matListeTheme, $nivListeTheme);

$selectheme_RsChoixTheme = 0;
if (isset($themeId)) {
	$selectheme_RsChoixTheme = $themeId;
}

$themeChoisi = mysqli_prepare($conn_intranet, "SELECT theme FROM stock_theme WHERE ID_theme = ?") or exit(mysqli_error($conn_intranet));
mysqli_stmt_bind_param($themeChoisi, "i", $selectheme_RsChoixTheme);
mysqli_stmt_execute($themeChoisi);
mysqli_stmt_bind_result($themeChoisi, $row_RsChoixTheme['theme']);
mysqli_stmt_fetch($themeChoisi);
mysqli_stmt_close($themeChoisi);


$titre_page = "Accueil des élèves";
$meta_description = "Page accueil des élève pour y être évalué";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$css_deplus = "";
require('includes/header.inc.php');


?>
<div class="row">
	<div class="col">
		<h4>Mode Evaluation - Choix de l'exercice<h4>
	</div>
	<div class="col text-right">
		<h2><?php echo $_SESSION['Sess_nom'].'   '.$_SESSION['Sess_prenom'].'   '.$_SESSION['Sess_classe']?></h2>
		<h3><a href="eleve_modif_pass.php">Changer mon mot de passe</a><h3>
	</div>
</div>
<!-- FORM pour le choix de la matière et du niveau-->
<form name="form1" method="GET" action="accueil_eleve.php">
	<div class="row pt-2 pb-2 shadow bg-warning align-items-center">
		<div class="col-2 text-right">
			<h6>Sélectionnez une matière:</h6>
		</div>
		<div class="col-2">
			<select class="form-control" name="matiere_ID" id="select2">
				<?php
				do { ?>
					<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo "SELECTED";} } ?>><?php echo $row_rs_matiere['nom_mat']?></option>
										<?php
				} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)); ?>
			</select>
		</div>
		<div class="col-2 text-right">
			<h6>Puis un niveau:</h6>
		</div>
		<div class="col-2">
			<select class="form-control" name="niveau_ID" id="select">
				<?php
				do {
				?>
					<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";} }?>><?php echo $row_rs_niveau['nom_niveau']?></option>
					<?php
				} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)); ?>
			</select>
		</div>
		<div class="col-2 text-right">
			<h6>Enfin validez:</h6>
		</div>
		<div class="col-2">
			<button type="submit" class="btn btn-primary">Valider</button>
		</div>
	</div>
</form>
<!--Une fois la matière et niveau choisis -->
<?php if (isset($matiereId))
{ ?>
	<div class="row mt-2 mb-2">
		<div class="col text-center">
			<h3>Matière actuelle: <?php echo $row_rsChoix['nom_mat']; ?></h3>
		</div>
	</div>
	<div class="row pb-3">
		<div class="col-2">
			<div class="pb-3 bg-warning shadow rounded">
				<div class="text-center">
					<h3>Thème d'étude</h3>
				</div>
				<div class="text-center">
					<?php
					mysqli_stmt_execute($listeTheme);
					mysqli_stmt_bind_result($listeTheme, $row_RsListeTheme['ID_theme'], $row_RsListeTheme['theme']);
					while (mysqli_stmt_fetch($listeTheme))
					{ ?>
						<a href="accueil_eleve.php?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $niveauId; ?>&theme_ID=<?php echo $row_RsListeTheme['ID_theme']?>"><?php echo $row_RsListeTheme['theme']?></a><br><br>
						<?php 
					}
					mysqli_stmt_close($listeTheme);

					//Affiche le thème Divers uniquement s'il y a au moins un doc dedans
					$qTestExoDivers = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND theme_ID = 0", $matiereId, $niveauId);
					$rsTestExoDivers = mysqli_query($conn_intranet, $qTestExoDivers) or die(mysqli_error());
					$nbExosDivers = mysqli_num_rows($rsTestExoDivers);
					if ($nbExosDivers > 0) 
					{
						echo '<a href="accueil_eleve.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID=0">Divers</a>';
					}?>
				</div>
			</div>
		</div>
		<div class="col-7 bg-warning offset-md-1 shadow rounded">
			<div class="row">
				<div class="col text-center">
					<?php
					if (isset($themeId))
					{
						if ($themeId == 0)
							echo '<h3>Divers</h3>';
						else
							echo '<h3>'.$row_RsChoixTheme['theme'].'</h3>';
					}

					$icone[1] = 'enseignant/images/link.gif';
					$icone[2] = 'enseignant/images/patate.gif';
					$icone[3] = 'enseignant/images/b_edit.png';
					$icone[4] = 'enseignant/images/html.gif';
					$icone[5] = 'enseignant/images/word.gif';
					$icone[6] = 'enseignant/images/xls.gif';
					$icone[7] = 'enseignant/images/ppt.gif';
					$icone[8] = 'enseignant/images/pdf.gif';
					$icone[9] = 'enseignant/images/oopres.gif';
					$icone[10] = 'enseignant/images/oott.gif';
					$icone[11] = 'enseignant/images/ootab.gif';
					$icone[12] = 'enseignant/images/image.gif';
					$icone[13] = 'enseignant/images/swf.gif';
					$icone[14] = 'enseignant/images/avi.gif';
					$icone[15] = 'enseignant/images/avi.gif';
					$icone[16] = 'enseignant/images/autres.gif';
					?>
				</div>
			</div>
			<div class="row mb-3 shadow rounded">
				<div class="col text-center">
					<?php
					if(isset($themeId))
					{
						$query_categorie = sprintf("SELECT * FROM stock_quiz, stock_categorie WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND theme_ID = '%s' AND categorie_ID = ID_categorie GROUP BY categorie_ID ", $matiereId, $niveauId, $themeId);
						$Rs_categorie = mysqli_query($conn_intranet, $query_categorie) or die(mysqli_error());
						$row_Rs_categorie = mysqli_fetch_assoc($Rs_categorie);
						if (!isset($categorieId))
						{
							echo "<strong>Veuillez sélectionner une catégorie</strong><br>";
						}
						else
						{
							if ($categorieId != 0)
							{
								$query_categorieSelect = sprintf("SELECT * FROM stock_categorie WHERE ID_categorie = '%s'", $categorieId);
								$Rs_categorieSelect = mysqli_query($conn_intranet, $query_categorieSelect) or die(mysqli_error());
								$row_Rs_categorieSelect = mysqli_fetch_assoc($Rs_categorieSelect);
								echo "<strong>Vous êtes dans la catégorie: ".$row_Rs_categorieSelect['nom_categorie']."</strong><br>";
							}
							else
							{
								echo "<strong>Vous êtes dans la catégorie: Non classés</strong><br>";
							}
						}?>
						<div>
							<?php
							do
							{
								echo '<a href="accueil_eleve.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$themeId.'&categorie_ID='.$row_Rs_categorie['ID_categorie'].'"><strong>'.$row_Rs_categorie['nom_categorie'].'</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;';
							} while ($row_Rs_categorie = mysqli_fetch_assoc($Rs_categorie));

							//Affiche la catégorie Non classés uniquement s'il y a au moins un doc dedans
							$qTestExoNonClasse = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND theme_ID = '%s' AND categorie_ID = 0", $matiereId, $niveauId, $themeId);
							$rsTestExoNonClasse = mysqli_query($conn_intranet, $qTestExoNonClasse) or die(mysqli_error());
							$nbExos = mysqli_num_rows($rsTestExoNonClasse);
							if ($nbExos > 0) 
							{
								echo '<a href="accueil_eleve.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$themeId.'&categorie_ID=0"><strong>Non classés</strong></a>';
							}
						}
						else
						{
							echo "<h2 class='text-center'>Veuillez sélectionner un thème d'étude</h2>";							
						}?>
					</div>
				</div>
			</div>
			<?php
			if (isset($categorieId)) 
			{ ?>
				<div class="row align-items-center">
					<div class="col pt-1 pb-1 bg-warning shadow rounded text-center">
						<a href="#cours">Cours</a> - <a href="#hotpotatoes">Ex. Hotpotatoes</a> - <a href="#exercices">Autres exercices</a> - <a href="#travail">Travail à faire</a> - <a href="#annexes">Documents annexes</a>
					</div>
				</div>
				<!-- Le cours -->
				<div class="row mt-4">
					<div class="col">
						<div class="row">
							<div class="col bg-warning text-center">
								<strong>Le cours<a name="cours"></a></strong>
							</div>
						</div>
						<div class="row">
							<div class="col table-responsive">
								<table class="table table-striped table-bordered table-sm">
									<thead class="thead-light">
										<tr>
											<th scope="col">#</th>
											<th scope="col">Nom du Fichier</th>
											<th scope="col">Type</th>
											<th scope="col">Auteur</th>
										</tr>
									</thead>
									<tbody>
										<?php
										do
										{ 
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 1) 
											{ ?>
												<tr>
													<th scope="row">
														<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
													</th>
													<td>
														<?php 
														if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else
														{
															if (isset($themeId))
															{
																$theme = $themeId;
															} 
															else
															{
																$theme = 0;
															}
															if ( isset($matiereId) && isset($niveauId) )
															{
																$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$theme.'&categorie_ID='.$categorieId; 
															}
														}?>
														<a href="<?php echo $lien;?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
													</td>
													<td>
														<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']]; ?>" width="15" height="15">&nbsp;
													</td>
													<td>
														<?php if ($row_rsListeSelectMatiereNiveau['auteur'] <> '')
														{
															echo $row_rsListeSelectMatiereNiveau['auteur'];
														}
														else
														{
															echo '-';
														} ?>
													</td>
												</tr>
												<?php 
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau));?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- Exercices Hotpotatoes -->
				<div class="row mt-2">
					<div class="col">
						<div class="row">
							<div class="col bg-warning text-center">
								<strong>Exercices Hotpotatoes<a name="hotpotatoes"></a></strong>
							</div>
						</div>
						<div class="row">
							<div class="col table-responsive">
								<table class="table table-striped table-bordered table-sm">
									<thead class="thead-light">
										<tr>
											<?php
											if ($totalRows_rsListeSelectMatiereNiveau <> 0)
											{
												mysqli_data_seek($rsListeSelectMatiereNiveau,0);
											}
											$i = 0;
											do {
												if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 2)
												{
													$i = $i + 1;
												}
											} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
											if ($i <> 0)
											{ 
												echo '<th scope="col"><strong>&nbsp;</strong></th>';
												echo '<th scope="col"><strong>N&deg;</strong></th>';
												echo '<th scope="col"><strong>Fait</strong></th>';
												echo '<th scope="col"><strong>Exercice</strong></th>';
												echo '<th scope="col"><strong>Note sur 20</strong></th>';
												echo '<th scope="col"><strong>Entrainement</strong></th>';
												echo '<th scope="col"><strong>Auteur</strong></th>';
											}
											if ($totalRows_rsListeSelectMatiereNiveau <> 0)
											{
												mysqli_data_seek($rsListeSelectMatiereNiveau,0);
											}?>
										</tr>
									</thead>
									<tbody>
										<?php 
										do
										{
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 2)
											{
												$choixquiz_RsExosFait = "0";
												if (isset($row_rsListeSelectMatiereNiveau['ID_quiz']))
												{
													$choixquiz_RsExosFait = (get_magic_quotes_gpc()) ? $row_rsListeSelectMatiereNiveau['ID_quiz'] : addslashes($row_rsListeSelectMatiereNiveau['ID_quiz']);
												}
												$choixnom_RsExosFait = "0";
												if (isset($_SESSION['Sess_ID_eleve']))
												{
													$choixnom_RsExosFait = (get_magic_quotes_gpc()) ? $_SESSION['Sess_ID_eleve'] : addslashes($_SESSION['Sess_ID_eleve']);
												}

												$query_RsExosFait = sprintf("SELECT * FROM stock_activite WHERE stock_activite.eleve_ID=%s AND stock_activite.quiz_ID=%s", $choixnom_RsExosFait,$choixquiz_RsExosFait);
												$RsExosFait = mysqli_query($conn_intranet, $query_RsExosFait) or die(mysqli_error($conn_intranet));
												$row_RsExosFait = mysqli_fetch_assoc($RsExosFait);
												$totalRows_RsExosFait = mysqli_num_rows($RsExosFait);

												$unique = 'N';?>
												<tr>
													<th scope="row">
														<?php
														if ($row_rsListeSelectMatiereNiveau['evaluation_seul'] == 'O') 
														{   
															if ($totalRows_RsExosFait <> 0)
															{
																echo 'Interro terminée';
																$unique = 'O';
															}
															else
															{
																echo'Interro à faire';
															} 
														}
														else 
														{ 
															if ($totalRows_RsExosFait <> 0)
															{
																echo 'Fait';
															}
															else
															{
																echo 'Exercice à faire';
															}
														}?>
													</th>
													<td>
														<div><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div>
													</td>
													<td>
														<input type="checkbox" name="checkbox" value="checkbox" <?php if ($totalRows_RsExosFait <> 0) { echo " checked"; }?> >
													</td>
													<td>
														<?php 
														if ($unique <> 'O')
														{
															if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
															{
																$lien=$row_rsListeSelectMatiereNiveau['fichier'];
															} 
															else
															{ 
																if (isset($themeId))
																{
																	$theme = $themeId;
																}
																else
																{
																	$theme = 0;
																}
																if ((isset($matiereId)) && (isset($niveauId)) )
																{
																	$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$theme.'&categorie_ID='.$categorieId; 
																} 
															}
															echo '<a href="'.$lien.'"><strong>'.$row_rsListeSelectMatiereNiveau['titre'].'</strong></a>';
														}
														else
														{
															echo '<strong>'.$row_rsListeSelectMatiereNiveau['titre'].'</strong>';
														}?>
													</td>
													<td>
														<div>
															<?php if ($totalRows_RsExosFait <> 0)
															{
																echo $row_RsExosFait['score']."/20";
															}
															else
															{
																echo "&nbsp;";
															}?>
														</div>
													</td>
													<td>
														<div>
															<?php if ($row_rsListeSelectMatiereNiveau['en_ligne'] == 'O')
															{
																echo '<a href="accueil_visiteur.php"><strong>Oui</strong></a>';
															}
															else
															{
																echo '&nbsp;';
															}?>
														</div>
													</td>
													<td>
														<?php if ($row_rsListeSelectMatiereNiveau['auteur'] <> '')
														{
															echo $row_rsListeSelectMatiereNiveau['auteur'];
														}
														else
														{
															echo '&nbsp;';
														} ?>
													</td>
												</tr>
												<?php
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- Autres exercices -->
				<div class="row mt-2">
					<div class="col">
						<div class="row">
							<div class="col bg-warning text-center">
								<strong>Autres exercices<a name="exercices"></a></strong>
							</div>
						</div>
						<div class="row">
							<div class="col table-responsive">
								<table class="table table-striped table-bordered table-sm">
									<thead class="thead-light">
										<tr>
											<th scope="col">#</th>
											<th scope="col">Nom du Fichier</th>
											<th scope="col">Type</th>
											<th scope="col">Auteur</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau <> 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										do
										{ 
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 3) 
											{ ?>
												<tr>
													<th scope="row">
														<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
													</th>
													<td>
														<?php 
														if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else 
														{
															if (isset($themeId))
															{
																$theme = $themeId;
															}
															else
															{
																$theme = 0;
															}
															$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$theme.'&categorie_ID='.$categorieId;
														} ?>
														<a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
													</td>
													<td>
														<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="15" height="15">&nbsp;
													</td>
													<td>
														<?php if ($row_rsListeSelectMatiereNiveau['auteur'] <> '')
														{
															echo $row_rsListeSelectMatiereNiveau['auteur'];
														}
														else
														{
															echo '-';
														} ?>
													</td>
												</tr>
												<?php 
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- Travail à faire -->
				<div class="row mt-2">
					<div class="col">
						<div class="row">
							<div class="col bg-warning text-center">
								<strong>Travail à faire<a name="travail"></a></strong>
							</div>
						</div>
						<div class="row">
							<div class="col table-responsive">							
								<table class="table table-striped table-bordered table-sm">
									<thead class="thead-light">
										<tr>
											<th scope="col">#</th>
											<th scope="col">Nom du Fichier</th>
											<th scope="col">Type</th>
											<th scope="col">Auteur</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau <> 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										do
										{
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 4)
											{ ?>
												<tr>
													<th scope="row">
														<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
													</th>
													<td>
														<?php 
														if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else
														{
															if (isset($themeId))
															{
																$theme = $themeId;
															}
															else
															{
																$theme = 0;
															}
															if ((isset($matiereId)) && (isset($niveauId)) )
															{
																$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$theme.'&categorie_ID='.$categorieId; 
															}
														} ?>
														<a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
													</td>
													<td>
														<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="15" height="15">&nbsp;
													</td>
													<td>
														<?php if ($row_rsListeSelectMatiereNiveau['auteur'] <> '')
														{
															echo $row_rsListeSelectMatiereNiveau['auteur'];
														}
														else
														{
															echo '-';
														} ?>
													</td>
												</tr>
												<?php 
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- Documents annexes -->
				<div class="row mt-2">
					<div class="col">
						<div class="row">
							<div class="col bg-warning text-center">
								<strong>Documents annexes <a name="annexes"></a></strong>
							</div>
						</div>
						<div class="row">
							<div class="col table-responsive">								
								<table class="table table-striped table-bordered table-sm">
									<thead class="thead-light">
										<tr>
											<th scope="col">#</th>
											<th scope="col">Nom du Fichier</th>
											<th scope="col">Type</th>
											<th scope="col">Auteur</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau <> 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										do
										{ 
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 5)
											{ ?>
												<tr>
													<th scope="row">
														<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
													</th>
													<td>
														<?php 
														if($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else
														{
															if (isset($themeId))
															{
																$theme = $themeId;
															}
															else
															{
																$theme = 0;
															}
															if ((isset($matiereId)) && (isset($niveauId)) )
															{
																$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$theme.'&categorie_ID='.$categorieId; 
															} 
														} ?>
														<a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
													</td>
													<td>
														<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="15" height="15">&nbsp;
													</td>
													<td>
														<?php if ($row_rsListeSelectMatiereNiveau['auteur'] <> '')
														{
															echo $row_rsListeSelectMatiereNiveau['auteur'];
														}
														else
														{
															echo '-';
														} ?>
													</td>
												</tr>
											<?php
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="col-2">
			<?php
			if ($selectheme_RsChoixTheme != 0)
			{ ?>
				<h5>Résultats en <?php echo $_SESSION['Sess_classe'];?> pour le thème <?php echo $row_RsChoixTheme['theme'];?></h5>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col">Nom</th>
								<th scope="col">Exercices validés</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$choixclasse_RsLeconBest = 0;
							if (isset($_SESSION['Sess_classe']))
							{
								$choixclasse_RsLeconBest = htmlspecialchars($_SESSION['Sess_classe']);
							}
							$choixtheme_RsChoixTheme = 0;
							if (isset($themeId))
							{
								$choixtheme_RsChoixTheme = $themeId;
							}
							$query_RsLeconBest = sprintf("SELECT nbdenotes, TEMP.eleve_ID, nom, prenom, lastactivity
							FROM stock_eleve
								INNER JOIN (
								SELECT COUNT(ID_activite) AS nbdenotes, MAX(fin) as lastactivity, eleve_ID
								FROM stock_activite
									INNER JOIN stock_quiz
										ON stock_activite.quiz_ID = stock_quiz.ID_quiz
									INNER JOIN stock_eleve
										ON stock_activite.eleve_ID = stock_eleve.ID_eleve
								WHERE stock_activite.nom_classe = '%s'
									AND stock_quiz.theme_ID = '%s'
									AND score = 20
								GROUP BY eleve_ID
								) as TEMP ON TEMP.eleve_ID = stock_eleve.ID_eleve
							ORDER BY `nom` ", $choixclasse_RsLeconBest, $choixtheme_RsChoixTheme);
							$RsLeconBest = mysqli_query($conn_intranet, $query_RsLeconBest) or die(mysqli_error());
							$i = 0;
							while ($row_RsLeconBest = mysqli_fetch_assoc($RsLeconBest))
							{ ?>
								<tr>
									<?php
									echo  '<td>'.$row_RsLeconBest['nom']." ".$row_RsLeconBest['prenom'].'</td>';
									echo  '<td>'." ".$row_RsLeconBest['nbdenotes'].'</td>';	?>
								</tr>
								<?php
							}?>
						</tbody>	
					</table>
				</div>
				<?php 
			}?>
		</div>
	</div>
<?php 
}
require('includes/footer.inc.php');

mysqli_close($conn_intranet);
?>