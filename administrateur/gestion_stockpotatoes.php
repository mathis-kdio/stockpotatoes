<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom'] <> 'Administrateur') { 
		header("Location: login_administrateur.php?cible=gestion_stockpotatoes");
	}
} 
else {
	header("Location: login_administrateur.php?cible=gestion_stockpotatoes");
}

require_once('../includes/yml.class.php');

if ((isset($_POST["changementNom"])) && ($_POST["changementNom"] == "1")) {
	if(isset($_POST['nom'])) {
		$configName = new Lire('../includes/config.yml');
		$_Name_ = $configName->GetTableau();
		$_Name_['General']['name'] = htmlspecialchars($_POST["nom"]);
		new Ecrire('../includes/config.yml', $_Name_);
	}
}

if ((isset($_POST["changementCouleurs"])) && ($_POST["changementCouleurs"] == "1")) {
	if(isset($_POST['color_theme_main'], $_POST['color_theme_hover'], $_POST['color_theme_focus'])) {
		$configTheme = new Lire('../includes/config.yml');
		$_Theme_ = $configTheme->GetTableau();
		$_Theme_['color']["theme"]['main'] = htmlspecialchars($_POST["color_theme_main"]);
		$_Theme_['color']["theme"]['second'] = htmlspecialchars($_POST["color_theme_second"]);
		$_Theme_['color']["theme"]['hover'] = htmlspecialchars($_POST["color_theme_hover"]);
		$_Theme_['color']["theme"]['focus'] = htmlspecialchars($_POST["color_theme_focus"]);
		new Ecrire('../includes/config.yml', $_Theme_);
	}
}

if ((isset($_POST["changementImage"])) && ($_POST["changementImage"] == "1")) {
	$target_file = "../includes/imgNavBar.jpg";
	$uploadOk = 1;
	// Check if image file is a actual image or fake image
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	}
	else {
		echo "Le fichier n'est pas une image.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	if($imageFileType != "jpg") {
		echo "Désolé, seul le format JPG est accepté.";
		$uploadOk = 0;
	}
	if ($uploadOk == 0) {
		echo "Désolé, ne fichier n'a pas pu être envoyé.";
	// if everything is ok, try to upload file
	}
	else {
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		}
		else {
			echo "Désolé, il y a eu un problème lors de l'envoi.";
		}
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
<h5 class="text-center">Nom du site :</h5>
<div class="row justify-content-center">
	<div class="col-auto">
		<form method="POST" action="gestion_stockpotatoes.php" >
			<div class="form-group">
				<label for="nom" class="col-auto col-form-label">Nom (Remplacera "stockpotatoes" dans la barre de navigation):</label>
				<input type="text" name="nom" class="form-control" <?php if(isset($lecture["General"]["name"])) echo 'value="'.$lecture["General"]["name"].'"';?> required>
			</div>
			<div class="form-group text-center">
				<button type="submit" name="changementNom" value="1" class="btn btn-primary">Valider les changements</button>
			</div>
		</form>
	</div>
</div>
<h5 class="text-center">Cliquez sur chaque case pour modifier la couleur puis valider :</h5>
<div class="row justify-content-center">
	<div class="col-auto">
		<form method="POST" action="gestion_stockpotatoes.php" >
			<div class="form-group">
				<label for="color_theme_main" class="col-auto col-form-label">Couleur principale :</label>
				<input type="color" name="color_theme_main" class="form-control" <?php if(isset($lecture["color"]["theme"]["main"])) echo ' value="'.$lecture["color"]["theme"]["main"].'"'?> required>
			</div>
			<div class="form-group">
				<label for="color_theme_second" class="col-auto col-form-label">Couleur secondaire :</label>
				<input type="color" name="color_theme_second" class="form-control" <?php if(isset($lecture["color"]["theme"]["second"])) echo ' value="'.$lecture["color"]["theme"]["second"].'"'?> required>
			</div>
			<div class="form-group">
				<label for="color_theme_hover" class="col-auto col-form-label">Couleur lors du survol :</label>
				<input type="color" name="color_theme_hover" class="form-control" <?php if(isset($lecture["color"]["theme"]["hover"])) echo ' value="'.$lecture["color"]["theme"]["hover"].'"'?> required>
			</div>
			<div class="form-group">
				<label for="color_theme_focus" class="col-auto col-form-label">Couleur lors du clic :</label>
				<input type="color" name="color_theme_focus" class="form-control" <?php if(isset($lecture["color"]["theme"]["focus"])) echo ' value="'.$lecture["color"]["theme"]["focus"].'"'?> required>
			</div>
			<div class="form-group text-center">
				<button type="submit" name="changementCouleurs" value="1" class="btn btn-primary">Valider les changements</button>
			</div>
		</form>
	</div>
</div>
<h5 class="text-center">Image dans la barre de navigation :</h5>
<div class="row justify-content-center">	
	<div class="col-auto">
		<form method="POST" action="gestion_stockpotatoes.php" enctype="multipart/form-data">
			<div class="form-group text-center">
				<h6>Image actuelle :</h6>
				<img src="../includes/imgNavBar.jpg" width="30" height="30">
			</div>
			<div class="form-group">
				<h6 class="text-center">L'image sera affichée en 30*30 :</h6>
				<h6 class="text-center">(Le changement peut mettre du temps à s'effectuer selon le navigateur)</h6>
				<div class="custom-file">
					<input type="file" class="custom-file-input" name="image" id="customFile" accept=".jpg,.JPG" required>
					<label class="custom-file-label" for="customFile">Image en .JPG uniquement</label>
				</div>
			</div>
			<div class="form-group text-center">
				<button type="submit" name="changementImage" value="1" class="btn btn-primary">Valider les changements</button>
			</div>
		</form>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php');
?>