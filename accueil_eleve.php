<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['Sess_nom']))
{
	header('Location:login_eleve.php');
}

require_once('Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau ORDER BY stock_niveau.ID_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);

$query_rsListequiz = "SELECT * FROM stock_quiz WHERE stock_quiz.avec_score='O' ORDER BY stock_quiz.titre";

$rsListequiz = mysqli_query($conn_intranet, $query_rsListequiz) or die(mysqli_error());
$row_rsListequiz = mysqli_fetch_assoc($rsListequiz);
$totalRows_rsListequiz = mysqli_num_rows($rsListequiz);

$choixmat_rsListeSelectMatiereNiveau = "0";
if (isset($_GET['matiere_ID'])) {
	$choixmat_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
$choixniv_rsListeSelectMatiereNiveau = "0";
if (isset($_GET['niveau_ID'])) {
	$choixniv_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
$choixtheme_rsListeSelectMatiereNiveau = "0";
if (isset($_GET['theme_ID'])) {
	$choixtheme_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_GET['theme_ID'] : addslashes($_GET['theme_ID']);
}

$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s  AND stock_quiz.theme_ID=%s AND stock_quiz.avec_score='O' ORDER BY stock_quiz.titre", $choixmat_rsListeSelectMatiereNiveau, $choixniv_rsListeSelectMatiereNiveau, $choixtheme_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error($conn_intranet));
$row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysqli_num_rows($rsListeSelectMatiereNiveau);

$colname_rsChoix = "1";
if (isset($_GET['matiere_ID'])) {
	$colname_rsChoix = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}

$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat =%s", $colname_rsChoix);
$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error());
$row_rsChoix = mysqli_fetch_assoc($rsChoix);
$totalRows_rsChoix = mysqli_num_rows($rsChoix);

$colname_rsChoix2 = "1";
if (isset($_GET['niveau_ID'])) {
	$colname_rsChoix2 = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}

$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_rsChoix2);
$rsChoix2 = mysqli_query($conn_intranet, $query_rsChoix2) or die(mysqli_error());
$row_rsChoix2 = mysqli_fetch_assoc($rsChoix2);
$totalRows_rsChoix2 = mysqli_num_rows($rsChoix2);

$choixniv_RsListeTheme = "0";
if (isset($_GET['niveau_ID'])) {
	$choixniv_RsListeTheme = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
$choixmat_RsListeTheme = "0";
if (isset($_GET['matiere_ID'])) {
	$choixmat_RsListeTheme = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}

$today = date("Y-m-d");
$query_RsListeTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s AND '$today' >=stock_theme.date_apparition AND stock_theme.date_disparition >='$today' ORDER BY stock_theme.pos_theme", $choixmat_RsListeTheme,$choixniv_RsListeTheme);
$RsListeTheme = mysqli_query($conn_intranet, $query_RsListeTheme) or die(mysqli_error());
$row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme);
$totalRows_RsListeTheme = mysqli_num_rows($RsListeTheme);

$selectheme_RsChoixTheme = "0";
if (isset($_GET['theme_ID'])) {
	$selectheme_RsChoixTheme = (get_magic_quotes_gpc()) ? $_GET['theme_ID'] : addslashes($_GET['theme_ID']);
}

$query_RsChoixTheme = sprintf("SELECT stock_theme.theme FROM stock_theme WHERE stock_theme.ID_theme=%s", $selectheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error());
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysqli_num_rows($RsChoixTheme);
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Accueil des élèves</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Page accueil des élève pour y être évalué">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body style='background: url("background.jpg")'>
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
			  <a class="navbar-brand" href="#">
			    <img src="patate.gif" width="30" height="30" class="d-inline-block align-top" alt="">
			    Stockpotatoes
			  </a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse" id="navbarNav">
			    <ul class="navbar-nav">
			      <li class="nav-item active">
			        <a class="nav-link" href="#">Accueil <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="index.php">Menu principal</a>
			      </li>
			    </ul>
			  </div>
			</nav>
		</header>
		<div class="container-fluid">
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
								<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_GET['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_GET['matiere_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_matiere['nom_mat']?></option>
													<?php
							} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere));
							$rows = mysqli_num_rows($rs_matiere);
							if($rows > 0)
							{
								mysqli_data_seek($rs_matiere, 0);
								$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
							}?>
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
								<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_GET['niveau_ID'])) { if (isset($_GET['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} } }?>><?php echo $row_rs_niveau['nom_niveau']?></option>
								<?php
							} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau));
							$rows = mysqli_num_rows($rs_niveau);
							if($rows > 0) {
								mysqli_data_seek($rs_niveau, 0);
								$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
							}
							?>
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
			<?php if (isset($_GET['matiere_ID']))
			{ ?>
				<div class="text-center">
					<?php echo '<h3>'.$row_rsChoix['nom_mat'].'</h3>';?>
				</div>
				<div class="row mb-5">
					<div class="col-2">
						<div class="bg-warning shadow rounded">
							<div class="text-center">
								<h3>Thème d'étude</h3>
							</div>
							<div class="text-center">
								<?php 
								do 
								{ ?>
									<a href="accueil_eleve.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=<?php echo $row_RsListeTheme['ID_theme']?>"><?php echo $row_RsListeTheme['theme']?></a><br><br/>
								<?php 
								} while ($row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme));?>
									<a href="accueil_eleve.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=0">Divers</a>
							</div>
						</div>
					</div>
					<div class="col-7 offset-md-1 shadow rounded">
						<div class="row">
							<div class="col text-center">
								<?php
								if (isset($_GET['theme_ID']))
								{
									echo '<h3>'.$row_RsChoixTheme['theme'].'</h3>';
								}
								else
								{
									echo '<h3>Divers</h3>';
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
								<table class="table table-bordered table-striped">
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
													<td>
														<div><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div>
													</td>
													<td>
														<?php 
														if ($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else
														{
															if (isset($_GET['theme_ID']))
															{
																$theme = $_GET['theme_ID'];
															} 
															else
															{
																$theme = 0;
															}
															if ( isset($_GET['matiere_ID']) && isset($_GET['niveau_ID']) )
															{
																$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
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
						<!-- Exercices Hotpotatoes -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Exercices Hotpotatoes<a name="hotpotatoes"></a></strong>
									</div>
								</div>
								<table class="table table-bordered table-striped">
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
												echo '<th scope="col-1"><strong>&nbsp;</strong></th>';
												echo '<th scope="col-1"><strong>N&deg;</strong></th>';
												echo '<th scope="col-1"><strong>Fait</strong></th>';
												echo '<th scope="col-3"><strong>Exercice</strong></th>';
												echo '<th scope="col-1"><strong>Note sur 20</strong></th>';
												echo '<th scope="col-2"><strong>Entrainement</strong></th>';
												echo '<th scope="col-3"><strong>Auteur</strong></th>';
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
												$RsExosFait = mysqli_query($conn_intranet, $query_RsExosFait) or die(mysqli_error());
												$row_RsExosFait = mysqli_fetch_assoc($RsExosFait);
												$totalRows_RsExosFait = mysqli_num_rows($RsExosFait);

												$unique = 'N';?>
										    	<tr>
													<td>
														<?php
														if ($row_rsListeSelectMatiereNiveau['evaluation_seul'] == 'O') 
														{   
															if ($totalRows_RsExosFait <> 0)
															{
																echo '<div>Interro terminée</div>';
																$unique = 'O';
															}
															else
															{
																echo'<div>Interro à faire</div>';
															} 
														}
														else 
														{ 
															if ($totalRows_RsExosFait <> 0)
															{
																echo '<div>Fait</div>';
															}
															else
															{
																echo '<div>Exercice à faire</div>';
															}
														}?>
													</td>
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
																if (isset($_GET['theme_ID']))
																{
																	$theme = $_GET['theme_ID'];
																}
																else
																{
																	$theme = 0;
																}
																if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) )
																{
																	$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
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
						<!-- Autres exercices -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Autres exercices<a name="exercices"></a></strong>
									</div>
								</div>
								<table class="table table-bordered table-striped">
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
													<td>
														<div><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div>
													</td>
													<td>
														<?php 
														if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else 
														{
															if (isset($_GET['theme_ID']))
															{
																$theme = $_GET['theme_ID'];
															}
															else
															{
																$theme = 0;
															}
															$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$_GET['theme_ID'];
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
						<!-- Travail à faire -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Travail à faire<a name="travail"></a></strong>
									</div>
								</div>								
								<table class="table table-bordered table-striped">
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
													<td>
														<div><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div>
													</td>
													<td>
														<?php 
														if($row_rsListeSelectMatiereNiveau['type_doc'] == 1) 
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else
														{
															if (isset($_GET['theme_ID']))
															{
																$theme = $_GET['theme_ID'];
															}
															else
															{
																$theme = 0;
															}
															if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) )
															{
																$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
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
						<!-- Documents annexes -->
						<div class="row mt-2">
							<div class="col">
								<div class="row">
									<div class="col bg-warning text-center">
										<strong>Documents annexes <a name="annexes"></a></strong>
									</div>
								</div>									
								<table class="table table-bordered table-striped">
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
													<td>
														<div><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div>
													</td>
													<td>
														<?php 
														if($row_rsListeSelectMatiereNiveau['type_doc'] == 1)
														{
															$lien = $row_rsListeSelectMatiereNiveau['fichier'];
														} 
														else
														{
															if (isset($_GET['theme_ID']))
															{
																$theme = $_GET['theme_ID'];
															}
															else
															{
																$theme = 0;
															}
															if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) )
															{
																$lien = 'choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
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
					<div class="col-2">
						<!-- Tableau résultats prochainement-->
					</div>
				</div>
			<?php 
			}?>
		<footer class="footer">
		  <div class="row mt-auto py-3 bg-primary">
		    <span class="">Propulsé par <a href="https://stockpotatoes.ovh">Stockpotatoes</a></span>
		  </div>
		</footer>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>  