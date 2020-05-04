<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom']<>'Enseignant')
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
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau ORDER BY ID_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);

$query_rsListequiz = "SELECT * FROM stock_quiz WHERE en_ligne='O' AND avec_score='O' ORDER BY titre";
$rsListequiz = mysqli_query($conn_intranet, $query_rsListequiz) or die(mysqli_error());
$row_rsListequiz = mysqli_fetch_assoc($rsListequiz);
$totalRows_rsListequiz = mysqli_num_rows($rsListequiz);

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
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz, stock_categorie WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s  AND stock_quiz.theme_ID=%s AND stock_quiz.categorie_ID = stock_categorie.ID_categorie ORDER BY stock_quiz.pos_doc, stock_quiz.titre", $choixmat_rsListeSelectMatiereNiveau,$choixniv_rsListeSelectMatiereNiveau,$choixtheme_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error());
$row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysqli_num_rows($rsListeSelectMatiereNiveau);

$colname_rsChoix = "1";
if (isset($matiereId)) {
	$colname_rsChoix = $matiereId;
}
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat =%s", $colname_rsChoix);
$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error());
$row_rsChoix = mysqli_fetch_assoc($rsChoix);
$totalRows_rsChoix = mysqli_num_rows($rsChoix);

$colname_rsChoix2 = "1";
if (isset($niveauId)) {
	$colname_rsChoix2 = $niveauId;
}
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_rsChoix2);
$rsChoix2 = mysqli_query($conn_intranet, $query_rsChoix2) or die(mysqli_error());
$row_rsChoix2 = mysqli_fetch_assoc($rsChoix2);
$totalRows_rsChoix2 = mysqli_num_rows($rsChoix2);

$choixniv_RsListeTheme = "0";
if (isset($niveauId)) {
	$choixniv_RsListeTheme = $niveauId;
}
$choixmat_RsListeTheme = "0";
if (isset($matiereId)) {
	$choixmat_RsListeTheme = $matiereId;
}
$query_RsListeTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID=%s AND niv_ID=%s ORDER BY pos_theme", $choixmat_RsListeTheme,$choixniv_RsListeTheme);
$RsListeTheme = mysqli_query($conn_intranet, $query_RsListeTheme) or die(mysqli_error());
$row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme);
$totalRows_RsListeTheme = mysqli_num_rows($RsListeTheme);

$selectheme_RsChoixTheme = "0";
if (isset($themeId)) {
	$selectheme_RsChoixTheme = $themeId;
}
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme=%s", $selectheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error());
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysqli_num_rows($RsChoixTheme);
 
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
$js_deplus="";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Enseignant</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Gestion des exercices</p>
			</div>
		</div>
		<div class="container jumbotron">
			<form name="form1" method="GET" action="gestion_exos.php">
				<div class="form-group row align-items-center justify-content-center">
					<label for="select2" class="col-auto col-form-label">Sélectionnez une matière</label>
					<div class="col-auto">
						<select class="form-control" name="matiere_ID" id="select2">
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
						<select class="form-control" name="niveau_ID" id="select">
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
				<div class="row pb-3">
					<div class="col-2">
						<div class="pb-3 bg-warning shadow rounded">
							<div class="text-center">
								<h3>Thème d'étude</h3>
							</div>
							<div class="text-center">
								<?php 
								do 
								{ ?>
									<a href="gestion_exos.php?matiere_ID=<?php echo $matiereId?>&niveau_ID=<?php echo $matiereId?>&theme_ID=<?php echo $row_RsListeTheme['ID_theme']?>"><?php echo $row_RsListeTheme['theme']?></a><br><br>
									<?php 
								} while ($row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme)); ?>
								<a href="gestion_exos.php?matiere_ID=<?php echo $matiereId?>&niveau_ID=<?php echo $niveauId?>&theme_ID=0">Divers</a>
							</div>
						</div>
					</div>
					<div class="col-9 offset-md-1 bg-warning shadow rounded">
						<div class="row">
							<div class="col text-center">
								<?php
								if (isset($themeId))
								{
									echo '<h3>'.$row_RsChoixTheme['theme'].'</h3>';
								}
								else
								{
									echo '<h3>Divers</h3>';
								}
								?>
								<div class="row align-items-center">
									<div class="col pt-1 pb-1 bg-warning shadow rounded text-center">
										<a href="#cours">Cours</a> - <a href="#hotpotatoes">Ex. Hotpotatoes</a> - <a href="#exercices">Autres exercices</a> - <a href="#travail">Travail à faire</a> - <a href="#annexes">Documents annexes</a>
									</div>
								</div>
							</div>
						</div>
						<!-- LE COURS -->
						<div class="row mt-4">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Le cours<a name="cours"></a></strong>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-sm">
										<?php
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{	
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;
										do
										{
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 1) 
											{
												$x = $x+1;
												$tabpos1[$x] = $row_rsListeSelectMatiereNiveau['pos_doc'];
												$tabid1[$x] = $row_rsListeSelectMatiereNiveau['ID_quiz'];
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 

										$t1 = $x;
										if ($x != 0)
										{ ?>
											<thead class="thead-light">
												<tr>
													<th scope="col">N&deg;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">Titre</th>
													<th scope="col">Catégorie</th>
													<th scope="col">Fichier</th>
													<th scope="col">Auteur</th>
													<th scope="col">Entr.</th>
													<th scope="col">Eval.</th>
													<th scope="col">Note</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<?php
										}
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{	
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;?>
										<tbody>
											<?php 
											do
											{
												if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 1)
												{
													$x = $x + 1;
													?>
													<tr>
														<th scope="row">
															<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
														</th>
														<td>
															<?php if($x!=1) 
															{ ?>
																<?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
																<?php echo $matiereId; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
																<?php echo $tabid1[$x-1] ?>
																<?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
																<?php echo $tabpos1[$x-1] ?>
																<?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
																<?php echo ' </form>';
															} 
															else
															{
																echo '&nbsp;';
															}?>
														</td>
														<td>
															<?php if($x!=$t1)
															{ ?>            
																<?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
																<?php echo $matiereId ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
																<?php echo $tabid1[$x+1] ?>
																<?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
																<?php echo $tabpos1[$x+1] ?>
																<?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
																<?php echo ' </form>';
															}
															else
															{
																echo '&nbsp;';
															}?>	
														</td>
														<td>
															<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']]; ?>" width="19" height="19">
														</td>              
														<td>
																<?php 
																if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
																{
																	$lien=$row_rsListeSelectMatiereNiveau['fichier'];
																} 
																else
																{
																	$lien='../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
																} ?>
																<a href="<?php echo $lien ; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
														</td>
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['nom_categorie'] !='')
															{
																echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
															}
															else
															{
																echo '-';
															} ?>
														</td>
														<td>
															<?php 
															if($row_rsListeSelectMatiereNiveau['type_doc'] != 1)
															{
																echo $row_rsListeSelectMatiereNiveau['fichier'];
															}
															else
															{
																echo 'Lien hypertexte';
															}?>
														</td>
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['auteur'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['auteur'];
															}
															else
															{
																echo '-';
															}?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
														</td>
														<td>
															<form name="formsup1" style="margin:0px" method="post" action="supp_quiz.php">
																<div align="center">
																	<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
																	<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
																	<input name="boutonsup1" type="hidden" value="Supprimer">
																	<input type="image" src="images/delete.gif" alt="Supprimer un document">
																</div>
															</form>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
															{
																$redirection = 'misajour_url.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2)
															{
																$redirection = 'misajour_hotpot.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3)
															{
																$redirection = 'misajour_online.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3)
															{
																$redirection = 'misajour_divers.php';
															}?>
															<form style="margin:0px" name="formmod1" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
																<div align="center">
																	<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">                    
																	<input name="boutonmod1" type="hidden" value="Modifier">
																	<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
																</div>
															</form>
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
						<!-- HOTPOTATOES -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Exercices Hotpotatoes<a name="hotpotatoes"></a></strong>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-sm">
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;
										do {
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 2) 
											{
												$x = $x + 1;
												$tabpos2[$x] = $row_rsListeSelectMatiereNiveau['pos_doc'];
												$tabid2[$x] = $row_rsListeSelectMatiereNiveau['ID_quiz'];
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
										$t2 = $x; 
										if ($x != 0) 
										{ ?>
											<thead class="thead-light">
												<tr>
													<th scope="col">N&deg;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">Titre</th>
													<th scope="col">Catégorie</th>
													<th scope="col">Fichier</th>
													<th scope="col">Auteur</th>
													<th scope="col">Entr.</th>
													<th scope="col">Eval.</th>
													<th scope="col">Note</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<?php
										}
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{	
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;?>
										<tbody>
											<?php
											do
											{
												if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 2)
												{
													$x = $x + 1; ?>
													<tr>
														<th scope="row">
															<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
														</th>
														<td>
															<?php 
															if($x != 1)
															{ ?>
																<?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
																<?php echo $matiereID; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
																<?php echo $tabid2[$x-1] ?>
																<?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
																<?php echo $tabpos2[$x-1] ?>
																<?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
																<?php echo ' </form>';
															}
															else
															{
																echo '&nbsp;';
															}?>
														</td>
														<td>
															<?php 
															if ($x != $t2)
															{ ?>            
																<?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
																<?php echo $matiereId; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
																<?php echo $tabid2[$x+1] ?>
																<?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
																<?php echo $tabpos2[$x+1] ?>
																<?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
																<?php echo ' </form>';
															}
															else
															{
																echo '&nbsp;';
															}?>	
														</td>
														<td>
															<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
														</td>						
														<td>
															<?php 
															if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
															{
																$lien = $row_rsListeSelectMatiereNiveau['fichier'];
															} 
															else
															{
																$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
															} ?>
															<a href="<?php echo $lien ; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
														</td>
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
															}
															else
															{
																echo '-';
															}?>
														</td>		  
														<td>
															<?php
															if($row_rsListeSelectMatiereNiveau['type_doc'] != 1)
															{
																echo $row_rsListeSelectMatiereNiveau['fichier'];
															}
															else
															{
																echo 'Lien hypertexte';
															}?>
														</td>
														<td>
															<?php if ($row_rsListeSelectMatiereNiveau['auteur'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['auteur'];
															}
															else 
															{
																echo '-';
															} ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
														</td>
														<td>
															<form name="formsup2" style="margin:0px" method="post" action="supp_quiz.php">
																<div align="center">
																	<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
																	<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
																	<input name="boutonsup2" type="hidden" value="Supprimer">
																	<input type="image" src="images/delete.gif" alt="Supprimer un document">
																</div>
															</form>
														</td>
														<td>
															<?php	 
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
															{
																$redirection = 'misajour_url.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2)
															{
																$redirection = 'misajour_hotpot.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3)
															{
																$redirection = 'misajour_online.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3)
															{
																$redirection = 'misajour_divers.php';
															}
															?>
															<form style="margin:0px" name="formmod2" method="post" action="<?php echo $redirection;?>?matiere_ID=<?php echo $matiereId;?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
																<div align="center">
																	<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID']; ?>">
																	<input name="boutonmod2" type="hidden" value="Modifier">
																	<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
																</div>
															</form>
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
						<!-- Autres exercices 3 -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Autres exercices - TP<a name="exercices"></a></strong>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-sm">
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;
										do {
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 3) 
											{
												$x = $x + 1;
												$tabpos3[$x] = $row_rsListeSelectMatiereNiveau['pos_doc'];
												$tabid3[$x] = $row_rsListeSelectMatiereNiveau['ID_quiz'];
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
										$t3 = $x;
										if ($x != 0)
										{ ?>
											<thead class="thead-light">
												<tr>
													<th scope="col">N&deg;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">Titre</th>
													<th scope="col">Catégorie</th>
													<th scope="col">Fichier</th>
													<th scope="col">Auteur</th>
													<th scope="col">Entr.</th>
													<th scope="col">Eval.</th>
													<th scope="col">Note</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<?php
										}
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{	
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x=0; ?>
										<tbody>
											<?php
											do
											{	
												if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 3)
												{
													$x = $x + 1; ?>
													<tr>
														<th scope="row">
															<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
														</th>
														<td>
															<?php if($x!=1)
															{ ?>            
																<?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
																<?php echo $matiereId; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
																<?php echo $tabid3[$x-1] ?>
																<?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
																<?php echo $tabpos3[$x-1] ?>
																<?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
																<?php echo ' </form>';
															} 
															else
															{
																echo '&nbsp;';
															}?>
														</td>
														<td>
															<?php
															if($x != $t3)
															{ ?>            
																<?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
																<?php echo $matiereId; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
																<?php echo $tabid3[$x+1] ?>
																<?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
																<?php echo $tabpos3[$x+1] ?>
																<?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
																<?php echo ' </form>';
															}
															else
															{
																echo '&nbsp;';
															}?>	
														</td>
														<td>
															<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
														</td>
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
															{
																$lien = $row_rsListeSelectMatiereNiveau['fichier'];
															} 
															else
															{
																$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
															} ?>
															<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
														</td>
														<td class="retrait20">
															<?php
															if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
															}
															else
															{
																echo '-';
															} ?>
														</td>			  
														<td>
															<?php
															if($row_rsListeSelectMatiereNiveau['type_doc'] != 1)
															{
																echo $row_rsListeSelectMatiereNiveau['fichier'];
															}
															else
															{
																echo 'Lien hypertexte';
															}?>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['auteur'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['auteur'];
															}
															else
															{
																echo '-';
															} ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
														</td>
														<td>
															<form name="formsup3" style="margin:0px" method="post" action="supp_quiz.php">
																<div align="center">
																	<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
																	<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
																	<input name="boutonsup3" type="hidden" value="Supprimer">
																	<input type="image" src="images/delete.gif" alt="Supprimer un document">
																</div>
															</form>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
															{
																$redirection = 'misajour_url.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2)
															{
																$redirection = 'misajour_hotpot.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3)
															{ 
																$redirection = 'misajour_online.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3)
															{ 
																$redirection = 'misajour_divers.php';
															}
															?>
															<form style="margin:0px" name="formmod3" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
																<div align="center">
																	<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
																	<input name="boutonmod3" type="hidden" value="Modifier">
																	<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
																</div>
															</form>
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
						<!-- Travail à faire 4 -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Travail à faire<a name="travail"></a></strong>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-sm">
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;
										do
										{
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 4) 
											{
												$x = $x + 1;
												$tabpos4[$x] = $row_rsListeSelectMatiereNiveau['pos_doc'];
												$tabid4[$x] = $row_rsListeSelectMatiereNiveau['ID_quiz'];
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
										$t4 = $x;
										if ($x != 0)
										{ ?>
											<thead class="thead-light">
												<tr>
													<th scope="col">N&deg;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">Titre</th>
													<th scope="col">Catégorie</th>
													<th scope="col">Fichier</th>
													<th scope="col">Auteur</th>
													<th scope="col">Entr.</th>
													<th scope="col">Eval.</th>
													<th scope="col">Note</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<?php
										}
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{	
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0; ?>
										<tbody>
											<?php
											do
											{
												if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 4) 
												{
													$x = $x + 1; 
													?>
													<tr>
														<th scope="row">
															<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
														</th>
														<td>
															<?php if($x != 1) 
															{ ?>            
																<?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
																<?php echo $matiereId; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
																<?php echo $tabid4[$x-1] ?>
																<?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
																<?php echo $tabpos4[$x-1] ?>
																<?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
																<?php echo ' </form>';
															} 
															else
															{
																echo '&nbsp;';
															}
															?>
														</td>
														<td>
															 <?php 
															 if($x != $t4)
															 { ?>            
																<?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
																<?php echo $matiereId ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
																<?php echo $tabid4[$x+1] ?>
																<?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
																<?php echo $tabpos4[$x+1] ?>
																<?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
																<?php echo ' </form>';
															}
															else
															{
																echo '&nbsp;';
															}?>	
														</td>
														<td>
															<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
														</td>
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
															{
																$lien = $row_rsListeSelectMatiereNiveau['fichier'];
															} 
															else
															{
																$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
															} ?>
															<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
															}
															else
															{
																echo '-';
															} ?>
														</td>
														<td>
															<?php
															if($row_rsListeSelectMatiereNiveau['type_doc'] != 1)
															{
																echo $row_rsListeSelectMatiereNiveau['fichier'];
															}
															else
															{
																echo 'Lien hypertexte';
															}?>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['auteur'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['auteur'];
															}
															else
															{
																echo '-';
															} ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
														</td>
														<td>
															<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
														</td>
														<td>
															<form name="formsup4" style="margin:0px" method="post" action="supp_quiz.php">
																<div align="center">
																	<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
																	<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
																	<input name="boutonsup4" type="hidden" value="Supprimer">
																	<input type="image" src="images/delete.gif" alt="Supprimer un document">
																</div>
															</form>
														</td>
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
															{
																$redirection = 'misajour_url.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2)
															{
																$redirection = 'misajour_hotpot.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3)
															{
																$redirection = 'misajour_online.php';
															}
															if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3)
															{
																$redirection = 'misajour_divers.php';
															}	?>
															<form style="margin:0px" name="formmod4" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
																<div align="center">
																	<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
																	<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
																	<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
																</div>
															</form>
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
						<!-- Documents annexes 5 -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Documents annexes <a name="annexes"></a></strong>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-sm">
										<?php 
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0;
										do
										{
											if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 5) 
											{
												$x = $x + 1;
												$tabpos5[$x] = $row_rsListeSelectMatiereNiveau['pos_doc'];
												$tabid5[$x] = $row_rsListeSelectMatiereNiveau['ID_quiz'];
											}
										} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
										$t5=$x;
										if ($x != 0)
										{ ?>
											<thead class="thead-light">
												<tr>
													<th scope="col">N&deg;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">Titre</th>
													<th scope="col">Catégorie</th>
													<th scope="col">Fichier</th>
													<th scope="col">Auteur</th>
													<th scope="col">Entr.</th>
													<th scope="col">Eval.</th>
													<th scope="col">Note</th>
													<th scope="col">&nbsp;</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<?php
										}
										if ($totalRows_rsListeSelectMatiereNiveau != 0)
										{
											mysqli_data_seek($rsListeSelectMatiereNiveau,0);
										}
										$x = 0; ?>
										<tbody>
											<?php
											do
											{ 	
												if ($row_rsListeSelectMatiereNiveau['cat_doc'] == 5)
												{
													$x = $x + 1; ?>
													<tr>
														<th scope="row">
															<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>
														</th>
														<td>
															<?php 
															if($x != 1) 
															{ ?>            
																<?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
																<?php echo $matiereId; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
																<?php echo $tabid5[$x-1] ?>
																<?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
																<?php echo $tabpos5[$x-1] ?>
																<?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
																<?php echo ' </form>';
															} 
															else
															{
																echo '&nbsp;';
															} ?>
														</td>
														<td>
															<?php 
															if($x != $t5)
															{ ?>            
																<?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
																<?php echo $matiereID; ?>
																<?php echo '&niveau_ID=';?>
																<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
																<?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
																<?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
																<?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
																<?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
																<?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
																<?php echo $tabid5[$x+1] ?>
																<?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
																<?php echo $tabpos5[$x+1] ?>
																<?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
																<?php echo ' </form>';
															}
															else
															{
																echo '&nbsp;';
															} ?>	
														</td>
														<td>
															<img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">
														</td>				
														<td>
															<?php 
															if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
															{
																$lien = $row_rsListeSelectMatiereNiveau['fichier'];
															} 
															else
															{
															$lien = '../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
															} ?>
															<a href="<?php echo $lien; ?>" target="_blank"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['nom_categorie'] != '')
															{
																echo $row_rsListeSelectMatiereNiveau['nom_categorie'];
															}
															else
															{
																echo '-';
															} ?>
														</td>
														<td>
															<?php
															if ($row_rsListeSelectMatiereNiveau['type_doc'] != 1)
															{
																echo $row_rsListeSelectMatiereNiveau['fichier'];
															}
															else
															{
																echo 'Lien hypertexte';
															}?>
														</td>
															<td>
																<?php 
																if ($row_rsListeSelectMatiereNiveau['auteur'] != '')
																{
																	echo $row_rsListeSelectMatiereNiveau['auteur'];
																}
																else
																{
																	echo '-';
																} ?>
															</td>
															<td>
																<?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?>
															</td>
															<td>
																<?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?>
															</td>
															<td>
																<?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?>
															</td>
															<td>
																<form name="formsup5" style="margin:0px" method="post" action="supp_quiz.php">
																	<div align="center">
																		<input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
																		<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
																		<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
																		<input name="boutonsup5" type="hidden" value="Supprimer">
																		<input type="image" src="images/delete.gif" alt="Supprimer un document">
																	</div>
																</form>
															</td>
															<td>
																<?php	 
																if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
																{
																	$redirection = 'misajour_url.php';
																}
																if ($row_rsListeSelectMatiereNiveau['type_doc'] == 2)
																{
																	$redirection = 'misajour_hotpot.php';
																}
																if ($row_rsListeSelectMatiereNiveau['type_doc'] == 3)
																{
																	$redirection = 'misajour_online.php';
																}
																if ($row_rsListeSelectMatiereNiveau['type_doc'] > 3)
																{
																	$redirection = 'misajour_divers.php';
																}
																?>
																<form style="margin:0px" name="formmod5" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $matiereId; ?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
																	<div align="center">
																		<input name="boutonmod5" type="hidden" value="Modifier">
																		<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
																	</div>
																</form>
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
				</div>
				<?php
			}?>
		</div>
	</div>
</div>
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