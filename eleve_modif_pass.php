<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['Sess_classe']))
{
	header('Location:login_eleve.php');
}

require_once('includes/yml.class.php');

$lecture = new Lire('includes/config.yml');
$lecture = $lecture->GetTableau();

if (isset($lecture['General']["studentPass"]) && $lecture['General']["studentPass"] == "No") {
	header('Location:login_eleve.php');
}

require_once('Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2"))
{
	if ($_POST['pass1'] == $_POST['pass2'])
	{
		$updateSQL = sprintf("UPDATE stock_eleve SET pass = '%s' WHERE ID_eleve = '%s'", htmlspecialchars($_POST['pass1']), htmlspecialchars($_SESSION['Sess_ID_eleve']));

		$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));

		header('Location:accueil_eleve.php');
	}
	else
	{
		echo '<h3 class="text-danger text-center">Erreur - Vous devez confirmer en retapant EXACTEMENT à l\'identique votre nouveau mot de passe.</h3>';
	}
}

$titre_page = "Espace Elève - Modification de mon mot de passe";
$meta_description = "Page de modification de mon mot de passe pour l'élève";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/header.inc.php');
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Elève</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-info text-center p-3" style="margin-top: 50px;">Modification de mon mot de passe</p>
			</div>
		</div>
		<div class="container jumbotron">
			<h3 class="text-right"><?php echo $_SESSION['Sess_nom'].' '.$_SESSION['Sess_prenom'].' '.$_SESSION['Sess_classe']?></h3>
			<form method="post" name="form2" action="eleve_modif_pass.php">			 
				<div class="form-group form-row justify-content-center">
					<div class="col-auto">
						<label for="pass1">Entrer votre nouveau mot de passe</label>
						<input type="password" class="form-control" id="pass1" name="pass1">
					</div>
				</div>
				<div class="form-group form-row justify-content-center">
					<div class="col-auto">
						<label for="pass2">Confirmer en retapant ce mot de passe</label>
						<input type="password" class="form-control" id="pass2" name="pass2">
					</div>
				</div>
				<div class="form-group text-center">
					<button type="submit" name="submit" class="btn btn-primary">Enregistrer mon nouveau mot de passe</button>
					<input type="hidden" name="MM_update" value="form2">
				</div>
				<div class="form-group text-center">
					<a class="btn btn-primary" href="accueil_eleve.php" role="button">Annuler</a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
require('includes/footer.inc.php');
?>