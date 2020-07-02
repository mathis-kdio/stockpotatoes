<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Administrateur')
	{ 
		header("Location: login_administrateur.php?cible=gestion_espace_eleve");
	}
} 
else
{
	header("Location: login_administrateur.php?cible=gestion_espace_eleve");
}

require_once('../includes/yml.class.php');

if ((isset($_POST["demandePassword"])) && ($_POST["demandePassword"] == "1"))
{
	if(isset($_POST['studentPass']))
	{
		$configTheme = new Lire('../includes/config.yml');
		$_Theme_ = $configTheme->GetTableau();
		$_Theme_['General']["studentPass"] = htmlspecialchars($_POST["studentPass"]);
		new Ecrire('../includes/config.yml', $_Theme_);
	}
}

$lecture = new Lire('../includes/config.yml');
$lecture = $lecture->GetTableau();

$titre_page = "Gestion de l'espace élève";
$meta_description = "Page de gestion de l'espace élève";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<h5 class="text-center">Les élèves doivent-ils avoir un mot de passe pour accéder à leur espace ?</h5>
<div class="row justify-content-center">
	<div class="col-auto">
		<form method="POST" action="gestion_espace_eleve.php" >
			<div class="form-group text-center">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="studentPass" id="studentPassYes" value="Yes" <?php if(isset($lecture['General']["studentPass"]) && $lecture['General']["studentPass"] == "Yes") echo 'checked'?>>
					<label class="form-check-label" for="studentPassYes">Oui</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="studentPass" id="studentPassNo" value="No" <?php if(isset($lecture['General']["studentPass"]) && $lecture['General']["studentPass"] == "No") echo 'checked'?>>
					<label class="form-check-label" for="studentPassNo">Non</label>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" name="demandePassword" value="1" class="btn btn-primary">Valider les changements</button>
			</div>
		</form>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php');
?>