<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Administrateur')
	{ 
		header("Location: login_administrateur.php?cible=gestion_theme");
	}
} 
else
{
	header("Location: login_administrateur.php?cible=gestion_theme");
}

require_once('../includes/yml.class.php');

if ((isset($_POST["changementCouleurs"])) && ($_POST["changementCouleurs"] == "1"))
{
	if(isset($_POST['color_theme_main'], $_POST['color_theme_hover'], $_POST['color_theme_focus']))
	{
		$configTheme = new Lire('../includes/config.yml');
		$_Theme_ = $configTheme->GetTableau();
		$_Theme_['color']["theme"]['main'] = $_POST["color_theme_main"];
		$_Theme_['color']["theme"]['second'] = $_POST["color_theme_second"];
		$_Theme_['color']["theme"]['hover'] = $_POST["color_theme_hover"];
		$_Theme_['color']["theme"]['focus'] = $_POST["color_theme_focus"];
		new Ecrire('../includes/config.yml', $_Theme_);
	}
}

$lecture = new Lire('../includes/config.yml');
$lecture = $lecture->GetTableau();

$titre_page = "Gestion du thème de Stockpotatoes";
$meta_description = "Page de gestion du thème de Stockpotatoes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<h5 class="text-center">Cliquez sur chaque case pour modifier la couleur puis valider</h5>
<div class="row justify-content-center">
	<div class="col-auto">
		<form method="POST" action="gestion_theme.php" >
			<div class="form-group">
				<label for="color_theme_main" class="col-auto col-form-label">Couleur principale :</label>
				<input type="color" name="color_theme_main" class="form-control" <?php if(isset($lecture["color"]["theme"]["main"])) echo ' value="'.$lecture["color"]["theme"]["main"].'"'?>>
			</div>
			<div class="form-group">
				<label for="color_theme_second" class="col-auto col-form-label">Couleur secondaire :</label>
				<input type="color" name="color_theme_second" class="form-control" <?php if(isset($lecture["color"]["theme"]["second"])) echo ' value="'.$lecture["color"]["theme"]["second"].'"'?>>
			</div>
			<div class="form-group">
				<label for="color_theme_hover" class="col-auto col-form-label">Couleur lors du survol :</label>
				<input type="color" name="color_theme_hover" class="form-control" <?php if(isset($lecture["color"]["theme"]["hover"])) echo ' value="'.$lecture["color"]["theme"]["hover"].'"'?>>
			</div>
			<div class="form-group">
				<label for="color_theme_focus" class="col-auto col-form-label">Couleur lors du clic :</label>
				<input type="color" name="color_theme_focus" class="form-control" <?php if(isset($lecture["color"]["theme"]["focus"])) echo ' value="'.$lecture["color"]["theme"]["focus"].'"'?>>
			</div>
			<div class="form-group">
				<button type="submit" name="changementCouleurs" value="1" class="btn btn-primary">Valider les changements</button>
			</div>
		</form>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php');
?>