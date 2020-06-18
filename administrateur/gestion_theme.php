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
		$_Theme_['color']["theme"]['hover'] = $_POST["color_theme_hover"];
		$_Theme_['color']["theme"]['focus'] = $_POST["color_theme_focus"];
		new Ecrire('../includes/config.yml', $_Theme_);
	}
}


$titre_page = "Gestion du thème de Stockpotatoes";
$meta_description = "Page de gestion du thème de Stockpotatoes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
	<h5>Theme</h5>

	<form method="POST" action="gestion_theme.php">
			<?php $lecture = new Lire('../includes/config.yml');
			$lecture = $lecture->GetTableau()?>
			<label>Couleur principale</label><br>
			<input type="color" name='color_theme_main'<?php if(isset($lecture["color"]["theme"]["main"])) echo ' value="'.$lecture["color"]["theme"]["main"].'"'?>><br><br>
			<label>Couleur lors du survol</label><br>
			<input type="color" name='color_theme_hover'<?php if(isset($lecture["color"]["theme"]["hover"])) echo ' value="'.$lecture["color"]["theme"]["hover"].'"'?>><br><br>
			<label>Couleur lors du clic</label><br>
			<input type="color" name='color_theme_focus'<?php if(isset($lecture["color"]["theme"]["focus"])) echo ' value="'.$lecture["color"]["theme"]["focus"].'"'?>><br><br>

			<button type="submit" name="changementCouleurs" value="1" class="btn btn-primary">Valider les changements</button>
	</form>


<?php
require('include/footerAdministrateur.inc.php');
?>