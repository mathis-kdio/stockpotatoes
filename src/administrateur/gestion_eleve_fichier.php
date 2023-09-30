<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom'] <> 'Administrateur') { 
		header("Location: login_administrateur.php?cible=gestion_eleve_fichier");
	}
} 
else {
	header("Location: login_administrateur.php?cible=gestion_eleve_fichier");
}

require_once('../Connections/conn_intranet.php'); 

if (isset($_POST['classe'])) {
	$classe = htmlspecialchars($_POST['classe']);
}
if (isset($_POST['niveau'])) {
	$niveau = htmlspecialchars($_POST['niveau']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);

//SI ajout d'un fichier
if(isset($_POST['ajoutEleves']) && $_POST['ajoutEleves'] == "1" && isset($classe) && $_POST['randcheck']==$_SESSION['rand']) {
	if (isset($_FILES['fileEleves'])) {
		$row = 0;
		if (($handle = fopen($_FILES['fileEleves']['tmp_name'], "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				$tabEleves[$row] = $data;
				$row++;
			}
			fclose($handle);

			if (!isset($niveau)) {
				$query_NivClasseChoisie = sprintf("SELECT niveau FROM stock_eleve WHERE classe = '%s'", $classe);
				$NivClasseChoisie = mysqli_query($conn_intranet, $query_NivClasseChoisie) or die(mysqli_error($conn_intranet));
				$row_NivClasseChoisie = mysqli_fetch_assoc($NivClasseChoisie);
				$niveau = $row_NivClasseChoisie['niveau'];
			}

			for ($i = 0; $i < $row; $i++) {
				$query_IdentifiantEleve = "SELECT * FROM stock_eleve ORDER BY identifiant";
				$IdentifiantEleve = mysqli_query($conn_intranet, $query_IdentifiantEleve) or die(mysqli_error($conn_intranet));
				$row_IdentifiantEleve = mysqli_fetch_assoc($IdentifiantEleve);

				if (isset($tabEleves[$i][0]) && isset($tabEleves[$i][1]) && $tabEleves[$i][0] != NULL && $tabEleves[$i][1] != NULL) {
					//Générateur identifiants
					$identifiant = strtolower($tabEleves[$i][0] . $tabEleves[$i][1]);
					$idtmp = $identifiant;
					$j = 0;
					do {
						if ($row_IdentifiantEleve['identifiant'] == $idtmp) {
							$j++;
							$idtmp = strtolower($identifiant . $j);
							$query_IdentifiantEleve = "SELECT * FROM stock_eleve ORDER BY identifiant";
							$IdentifiantEleve = mysqli_query($conn_intranet, $query_IdentifiantEleve) or die(mysqli_error($conn_intranet));
							$row_IdentifiantEleve = mysqli_fetch_assoc($IdentifiantEleve);
						}
					} while ($row_IdentifiantEleve = mysqli_fetch_assoc($IdentifiantEleve));
				}
				if (isset($tabEleves[$i][2])) {
					$mdp = $tabEleves[$i][2];
				}
				else {
					$mdp = 'eleve';
				}
				if (isset($tabEleves[$i][0]) && $tabEleves[$i][0] != NULL) {
					$TabResultatEleves[$i][0] = $tabEleves[$i][0];
				}
				else {
					$TabResultatEleves[$i][0] = "Non renseigné";
				}
				if (isset($tabEleves[$i][1]) && $tabEleves[$i][1] != NULL) {
					$TabResultatEleves[$i][1] = $tabEleves[$i][1];
				}
				else {
					$TabResultatEleves[$i][1] = "Non renseigné";
				}
				if (isset($idtmp)) {
					$TabResultatEleves[$i][2] = $idtmp;
				}
				else {
					$TabResultatEleves[$i][2] = "Impossible s'il manque le nom ou le prénom";
				}
				$TabResultatEleves[$i][3] = $mdp;
				$TabResultatEleves[$i][4] = $classe;
				$TabResultatEleves[$i][5] = $niveau;
				$TabResultatEleves[$i][6] = 0;

				if (isset($tabEleves[$i][0]) && isset($tabEleves[$i][1]) && $tabEleves[$i][0] != NULL && $tabEleves[$i][1] != NULL) {
					$insertSQL = sprintf("INSERT INTO stock_eleve (ID_eleve, identifiant, nom, prenom, classe, pass, niveau) VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s')", $idtmp, $tabEleves[$i][0], $tabEleves[$i][1], $classe, $mdp, $niveau);
					//echo "test $i: $insertSQL \n\n";
					$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));
				}
				else {
					$TabResultatEleves[$i][6] = 1;
				}
				unset($idtmp);
			}
		}
		else {
			echo "problème ouverture de fichier";
		}

	}
	else {
		echo "pas de fichier envoyé";
	}
}
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));

$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error($conn_intranet));

$titre_page = "Ajouter des élèves à partir d'un fichier";
$meta_description = "Page d'ajout d'élèves à partir d'un fichier";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<div class="row">
	<div class="col">
		<form name="form2" method="post" action="gestion_eleve_fichier.php">
			<div class="form-group row justify-content-center">
				<label class="col-auto col-form-label" for="select2">Sélectionnez une classe :</label>
				<div class="col-auto">
					<select name="classe" id="select2" class="custom-select" required>
						<option disabled selected value="">Veuillez choisir une classe</option>
						<?php
						while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)) { ?>
							<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classe)) { if (!(strcmp($row_rsClasse['classe'], $classe))) {echo " SELECTED";}} ?>><?php echo $row_rsClasse['classe']?></option>
							<?php
						} ?>
					</select>
				</div>
				<div class="col-auto">
					<button type="submit" name="Submit3" class="btn btn-primary">Sélectionner cette classe</button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col">
				<h5>OU créer une classe :</h5>
			</div>
		</div>
		<form name="form2" method="post" action="gestion_eleve_fichier.php">
			<div class="form-group row justify-content-center">
				<label class="col-auto col-form-label" for="select2">nom :</label>
				<div class="col-auto">
					<input type="text" class="form-control" id="select2" name="classe" value="<?php if (isset($classe)) { echo $classe; } ?>" required>
				</div>
				<label class="col-auto col-form-label" for="niveau">niveau :</label>
				<div class="col-auto">
					<select name="niveau" id="niveau" class="custom-select" required>
						<option disabled selected value="">Veuillez chosiir un niveau</option>
						<?php
						while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)) { ?>
							<option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($niveau)) { if (!(strcmp($row_RsNiveau['ID_niveau'], $niveau))) {echo " SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
							<?php
						} ?>
					</select>
				</div>
				<div class="col-auto">
					<button type="submit" name="Submit3" class="btn btn-primary">Créer une classe</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php 
if (isset($classe)) { ?>
	<div class="row justify-content-center">
		<div class="col">
			<p>Cette opération généralement effectuée en début d'année, nécessite la préparation d'un fichier .CSV ayant la structure suivante :</p>
			<div class="row justify-content-center">
				<div class="col-auto">
					<table class="table table-responsive table-sm">
						<tbody>
							<tr>
								<td>Jospin;Lionel</td>
							</tr>
							<tr>
								<td>Chirac;Jacques</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<form method="POST" action="gestion_eleve_fichier.php#TabEleves" enctype="multipart/form-data">
				<div class="form-group row justify-content-center">
					<div class="col-auto">
						<div class="input-group mb-3">
							<div class="custom-file" id="customFile" lang="fr">
								<input type="file" class="custom-file-input" id="fileEleves" name="fileEleves" aria-describedby="inputGroupFile" required>
								<label class="custom-file-label" for="inputGroupFile">Aucun fichier</label>
							</div>
						</div>
					</div>
					<div class="col-auto">
						<input type="hidden" name="classe" value="<?php echo $classe;?>">
						<?php if (isset($niveau)) { ?>
							<input type="hidden" name="niveau" value="<?php echo $niveau;?>">
						<?php } ?>
						<button type="submit" name="ajoutEleves" value="1" class="btn btn-primary">Ajouter les élèves dans ce fichier</button>
					</div>
				</div>
				<?php
					$rand = rand();
					$_SESSION['rand'] = $rand;
				?>
				<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
			</form>
			<p class="text-center">
				Chaque champ doit être délimité par un pont virgule!!!
			</p>
			<ul>
				<li><strong>Champ 1</strong> : Nom</li>
				<li><strong>Champ 2</strong> : Prénom</li>
				<li><strong>Champ 3</strong> : Mot de Passe (optionnel) sinon le mot de passe sera éléve.</li>
			</ul>
			<p>Ne pas faire de retour à la ligne à la fin du dernier enregistrement sinon il y aurait création d'un enregistrement supplémentaire vide.</p>
			<p>Remarque : Le mot de passe par défaut sera "eleve" (sans accent) et pourra être modifié par l'élève lors qu'il se sera connecté à son espace.</p>
			<p>Vous pouvez introduire dans votre fichier texte, le mot de passe. Le fichier aurait alors cette structure :</p>
			<div class="row justify-content-center">
				<div class="col-auto">
					<table class="table table-responsive table-sm">
						<tbody>
							<tr>
								<td>Jospin;Lionel;<span class="text-danger font-weight-bold">D8H6</span></td>
							</tr>
							<tr>
								<td>Chirac;Jacques;<span class="text-danger font-weight-bold">E95X</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php if (isset($TabResultatEleves)) { ?>
				<div class="row justify-content-center" id="TabEleves">
					<div class="col-auto">
						<h5>Listes des élèves ajoutés</h5>
						<table class="table table-responsive">
							<thead>
								<th scope="1">Nom</th>
								<th scope="1">Prénom</th>
								<th scope="1">Identifiant</th>
								<th scope="1">Mot de passe</th>
								<th scope="1">Classe</th>
								<th scope="1">Niveau</th>
							</thead>
							<tbody>
								<?php 
								for ($i=0; $i < $row; $i++) { 
									if ($TabResultatEleves[$i][6] == 0) {
										echo '<tr>';
									} 
									else {
										echo '<tr class="text-danger font-weight-bold">';
									} ?>
										<td><?php echo $TabResultatEleves[$i][0]; ?></td>
										<td><?php echo $TabResultatEleves[$i][1]; ?></td>
										<td><?php echo $TabResultatEleves[$i][2]; ?></td>
										<td><?php echo $TabResultatEleves[$i][3]; ?></td>
										<td><?php echo $TabResultatEleves[$i][4]; ?></td>
										<td><?php echo $TabResultatEleves[$i][5]; ?></td>
									</tr>
									<?php
								} ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
			}?>
		</div>
	</div>
	<?php
	}
require('include/footerAdministrateur.inc.php');
?>