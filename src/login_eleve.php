<?php
require_once('Connections/conn_intranet.php');

require_once('includes/yml.class.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$collog_rsLogin = "1";
if (isset($_POST['log'])) 
{
	$collog_rsLogin = htmlspecialchars($_POST['log']);
}
$colpass_rsLogin = "1";
if (isset($_POST['pass']))
{
	$colpass_rsLogin = htmlspecialchars($_POST['pass']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

$lecture = new Lire('includes/config.yml');
$lecture = $lecture->GetTableau();

if (isset($lecture['General']["studentPass"]) && $lecture['General']["studentPass"] == "No")
{
	$query_rsLogin = sprintf("SELECT * FROM stock_eleve WHERE ID_eleve = '%s'", $collog_rsLogin);
}
else
{
	$query_rsLogin = sprintf("SELECT * FROM stock_eleve WHERE ID_eleve = '%s' AND pass = '%s'", $collog_rsLogin, $colpass_rsLogin);
}
$rsLogin = mysqli_query($conn_intranet, $query_rsLogin) or die(mysqli_error($conn_intranet));
$row_rsLogin = mysqli_fetch_assoc($rsLogin);
$totalRows_rsLogin = mysqli_num_rows($rsLogin);

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));
$row_rsClasse = mysqli_fetch_assoc($rsClasse);

$choix_classe_rsLogin2 = "1";
if (isset($_POST['classe'])) 
{
	$choix_classe_rsLogin2 = htmlspecialchars($_POST['classe']);
}

$query_rsLogin2 = sprintf("SELECT ID_eleve, nom, prenom FROM stock_eleve WHERE classe = '%s' ORDER BY nom", $choix_classe_rsLogin2);
$rsLogin2 = mysqli_query($conn_intranet, $query_rsLogin2) or die(mysqli_error($conn_intranet));
$row_rsLogin2 = mysqli_fetch_assoc($rsLogin2);

$bad_password = 0;
if ((isset($_POST['valider'])) && ($_POST['valider'] == "ok"))
{
	if ($totalRows_rsLogin == '1' || (isset($lecture['General']["studentPass"]) && $lecture['General']["studentPass"] == "No"))
	{
		session_start();
		$_SESSION['Sess_ID_eleve'] = $row_rsLogin['ID_eleve'];
		$_SESSION['Sess_identifiant'] = $row_rsLogin['identifiant'];
		$_SESSION['Sess_nom'] = $row_rsLogin['nom'];
		$_SESSION['Sess_prenom'] = $row_rsLogin['prenom'];
		$_SESSION['Sess_classe'] = $row_rsLogin['classe'];
		$_SESSION['Sess_niveau'] = $row_rsLogin['niveau'];

		$query_rs_matiere = sprintf("SELECT * FROM stock_quiz WHERE niveau_ID = '%s' ORDER BY matiere_ID", $_SESSION['Sess_niveau']);
		$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));
		$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
		if(isset($matiereId)) {
			if(isset($niveauId)) {
				if(isset($themeId)) {
					if(isset($categorieId)) {
						header('Location: accueil_eleve.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$themeId.'&categorie_ID='.$categorieId);
					}
					else {
						header('Location: accueil_eleve.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId.'&theme_ID='.$themeId);
					}
				}
				else {
					header('Location: accueil_eleve.php?matiere_ID='.$matiereId.'&niveau_ID='.$niveauId);
				}
			} else {
				header('Location: accueil_eleve.php?matiere_ID='.$matiereId);
			}
		}
		else {
			header('Location: accueil_eleve.php?matiere_ID='.$row_rs_matiere['matiere_ID'].'&niveau_ID='.$_SESSION['Sess_niveau'].'&Submit=Valider');
		}
	}
	else
	{
		$bad_password = 1;
	}
}
else
{
	$erreurlog = 1;
}

$titre_page = "Identification de l'élève";
$meta_description = "Page login élève pour être évalué";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$css_deplus = "";
require('includes/header.inc.php');

?>
<div class="row mt-3 mx-1 justify-content-center">
	<div class="col-auto py-2 text-center bg-info rounded shadow">
		<h3>Espace Elève - Mode Evaluation - Identification de l'élève</h3>
	</div>
</div>
<div class="row mt-3 mx-1 justify-content-center">
	<div class="col-auto py-2 bg-info rounded shadow">
		<form name="form2" method="post" action="login_eleve.php?<?php if(isset($matiereId)) { echo 'matiere_ID='.$matiereId; } if(isset($niveauId)) { echo '&niveau_ID='.$niveauId; } if(isset($themeId)) { echo '&theme_ID='.$themeId; } if(isset($categorieId)) { echo '&categorie_ID='.$categorieId; }?>">
			<div class="form-group text-center">
				<label for="classe">Sélectionnez votre classe :</label>
				<div class="col-auto">
					<select class="custom-select" name="classe" id="classe" required>
						<option disabled selected value="">Veuillez choisir une classe</option>
						<?php
						do { ?>
							<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";}} ?>>
								<?php echo $row_rsClasse['classe']?>
							</option>
							<?php
						} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)); ?>
					</select>
				</div>
			</div>
			<div class="form-group text-center">
				<button type="submit" name="Submit2" class="btn btn-primary">Valider</button>
			</div>
		</form>
		<?php if (isset($_POST['classe'])) { ?>
			<form name="form1" method="post" action="login_eleve.php?<?php if(isset($matiereId)) { echo 'matiere_ID='.$matiereId; } if(isset($niveauId)) { echo '&niveau_ID='.$niveauId; } if(isset($themeId)) { echo '&theme_ID='.$themeId; } if(isset($categorieId)) { echo '&categorie_ID='.$categorieId; }?>">
				<div class="form-group text-center">
					<label for="log">Sélectionnez votre nom :</label>
					<div class="col-auto">
						<select class="custom-select" name="log" id="log" required>
							<option disabled selected value="">Veuillez choisir un élève</option>
							<?php
							do { ?>
								<option value="<?php echo $row_rsLogin2['ID_eleve']?>">
									<?php echo $row_rsLogin2['nom']." ".$row_rsLogin2['prenom']?>
								</option>
								<?php
							} while ($row_rsLogin2 = mysqli_fetch_assoc($rsLogin2)); ?>
						</select>
					</div>
				</div>
				<?php
				if (isset($lecture['General']["studentPass"]) && $lecture['General']["studentPass"] != "No") {
					if ($bad_password == 1) {
							echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
					} ?>
					<div class="form-group text-center">
						<label for="pass">Tapez votre mot de passe :</label>
						<div class="col-auto">
							<input type="password" class="form-control" name="pass" id="pass" placeholder="Mot de passe" required>
						</div>
					</div>
					<?php 
				} ?>
				<div class="form-group text-center">
					<button type="submit" name="Submit" class="btn btn-primary">Valider</button>
					<input name="valider" type="hidden" id="valider" value="ok">
					<input name="classe" type="hidden" id="classe" value="<?php echo htmlspecialchars($_POST['classe']); ?>">
				</div>
			</form>
		<?php } ?>
	</div>
</div>

<?php
require('includes/footer.inc.php');
?>