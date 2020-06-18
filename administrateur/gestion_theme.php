<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Administrateur')
	{ 
		header("Location: login_administrateur.php?cible=theme");
	}
} 
else
{
	header("Location: login_administrateur.php?cible=theme");
}

$titre_page = "Gestion du thème de Stockpotatoes";
$meta_description = "Page de gestion du thème de Stockpotatoes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>

			<form method="POST" action="?&action=themeColor" class="row">
				<div class="col-sm-6">
					<h5>Theme</h5>
					<?php $lecture = new Lire('../include/config.yml');
					$lecture = $lecture->GetTableau()?>
					<label>Couleur principale</label><br>
					<input type="color" name='color_theme_main'<?php if(isset($lecture["color"]["theme"]["main"])) echo ' value="'.$lecture["color"]["theme"]["main"].'"'?>><br><br>
					<label>Couleur lors du survol</label><br>
					<input type="color" name='color_theme_hover'<?php if(isset($lecture["color"]["theme"]["hover"])) echo ' value="'.$lecture["color"]["theme"]["hover"].'"'?>><br><br>
					<label>Couleur lors du clic</label><br>
					<input type="color" name='color_theme_focus'<?php if(isset($lecture["color"]["theme"]["focus"])) echo ' value="'.$lecture["color"]["theme"]["focus"].'"'?>><br><br>
				</div>
				<input type="submit" class="btn btn-success" value="Valider les changements">
			</form>


<?php
require('include/footerAdministrateur.inc.php');
?>