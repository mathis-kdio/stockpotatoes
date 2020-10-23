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

$modif = new Lire('../includes/config.yml');
$modif = $modif->GetTableau();

if ((isset($_POST["demandePassword"])) && ($_POST["demandePassword"] == "1"))
{
	if(isset($_POST['studentPass']))
	{
		$modif['General']['studentPass'] = htmlspecialchars($_POST["studentPass"]);
		new Ecrire('../includes/config.yml', $modif);
	}
}

//Modif Ordre Element NavBar
if ((isset($_POST["ordreNavBar"])) && ($_POST["ordreNavBar"] == "1")) {
	$ordre = htmlspecialchars($_POST['ordreItemsMenu']);
	$ordre = explode(",", $ordre);

	$tabElement = explode (";", $modif['navBar']['espaceEleve']);
	for ($i = 0; $i < count($tabElement); $i++) { 
		$tabElementItem[$i] = explode (",", $tabElement[$i]);
	}

	$resElementNavBar = '';
	for ($i = 0; $i < count($ordre); $i++) { 
		$j = 0;
		while ($tabElementItem[$j][0] != $ordre[$i]) {
			$j++;
		}
		if ($resElementNavBar != "") {
			$resElementNavBar = $resElementNavBar.';';
		}
		$resElementNavBar = $resElementNavBar.''.$i.','.$tabElementItem[$j][1].','.$tabElementItem[$j][2];
	}
	$modif['navBar']['espaceEleve'] = $resElementNavBar;
	new Ecrire('../includes/config.yml', $modif);
}

//Ajouter Element NavBar
if ((isset($_POST["ajoutNavBar"])) && ($_POST["ajoutNavBar"] == "1")) {
	if (isset($_POST['nomElementNavBar']) && $_POST['nomElementNavBar'] != "" && isset($_POST['urlElementNavBar']) && $_POST['urlElementNavBar'] != "") {
		$navBarArray = explode(";", $modif['navBar']['espaceEleve']);
		for ($i = 0; $i < count($navBarArray); $i++) { 
			$navBarArrayElement[$i] = explode (",", $navBarArray[$i]);
		}
		$nbElementNavBar = count($navBarArray);

		if ($navBarArrayElement[0][0] != "") {
			$modif['navBar']['espaceEleve'] = $modif['navBar']['espaceEleve'].';'.$nbElementNavBar.','.htmlspecialchars($_POST['nomElementNavBar']).','.htmlspecialchars($_POST['urlElementNavBar']);
		}
		else {
			$modif['navBar']['espaceEleve'] = '0,'.htmlspecialchars($_POST['nomElementNavBar']).','.htmlspecialchars($_POST['urlElementNavBar']);
		}
		new Ecrire('../includes/config.yml', $modif);
	}
}

//Supprimer Element NavBar
if ((isset($_POST["supprNavBar"])) && ($_POST["supprNavBar"] != "")) {
	$tabElement = explode (";", $modif['navBar']['espaceEleve']);
	for ($i = 0; $i < count($tabElement); $i++) { 
		$tabElementItem[$i] = explode (",", $tabElement[$i]);
	}

	$res = '';
	for ($i = 0; $i < count($tabElement) - 1; $i++) {
		if ($tabElementItem[$i][0] != $_POST["supprNavBar"]) {
			if ($res != "") {
				$res = $res.';';
			}
			$res = $res.''.$i.','.$tabElementItem[$i][1].','.$tabElementItem[$i][2];
		}
	}

	$modif['navBar']['espaceEleve'] = $res;
	new Ecrire('../includes/config.yml', $modif);
}

//Couleur de Stockpotatoes selon niveau et matière
require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));

$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));

if (isset($_POST['matiere_ID'])) {
	$matiereId = htmlspecialchars($_POST['matiere_ID']);
}
if (isset($_POST['niveau_ID'])) {
	$niveauId = htmlspecialchars($_POST['niveau_ID']);
}

if (isset($matiereId) && isset($niveauId)) {
	$colorElement = explode (";", $modif['espaceEleve']['color']);
	for ($i = 0; $i < count($colorElement); $i++) { 
		$colorElementItem[$i] = explode (",", $colorElement[$i]);  
	}
	//Pour modification de la couleur, si déjà définie, on remplace les valeures sinon on ajoute à la suite
	if (isset($_POST['changementCouleurs']) && $_POST['changementCouleurs'] == 1) {
		for ($i = 0; $i < count($colorElement); $i++) { 
			if (isset($colorElementItem[$i][0]) && $colorElementItem[$i][0] == $matiereId && isset($colorElementItem[$i][1]) && $colorElementItem[$i][1] == $niveauId) {
				$indexmodif = $i;
				break;
			}
		}
		$modifMain = htmlspecialchars($_POST['color_theme_main']);
		$modifSecond = htmlspecialchars($_POST['color_theme_second']);
		$modifHover = htmlspecialchars($_POST['color_theme_hover']);
		$modifFocus = htmlspecialchars($_POST['color_theme_focus']);

		if (isset($indexmodif)) {
			$colorElementItem[$indexmodif][2] = $modifMain;
			$colorElementItem[$indexmodif][3] = $modifSecond;
			$colorElementItem[$indexmodif][4] = $modifHover;
			$colorElementItem[$indexmodif][5] = $modifFocus;
			$res = '';
			for ($i = 0; $i < count($colorElement); $i++) {
				if ($res != "") {
					$res = $res.';';
				}
				$res = $res.''.$colorElementItem[$i][0].','.$colorElementItem[$i][1].','.$colorElementItem[$i][2].','.$colorElementItem[$i][3].','.$colorElementItem[$i][4].','.$colorElementItem[$i][5];
			}
			$modif['espaceEleve']['color'] = $res;
		}
		else {
			if ($colorElementItem[0][0] != "") {
				$modif['espaceEleve']['color'] = $modif['espaceEleve']['color'].';'.$matiereId.','.$niveauId.','.$modifMain.','.$modifSecond.','.$modifHover.','.$modifFocus;
			}
			else {
				$modif['espaceEleve']['color'] = $matiereId.','.$niveauId.','.$modifMain.','.$modifSecond.','.$modifHover.','.$modifFocus;
			}
		}
		new Ecrire('../includes/config.yml', $modif);
	}

	//Pour affichage, si déjà définie, de la couleur du thème pour ce niveau et cette matière, sinon couleur de base du thème Stockpotatoes.
	$affichage = new Lire('../includes/config.yml');
	$affichage = $affichage->GetTableau();
	$colorElementShow = explode (";", $affichage['espaceEleve']['color']);
	for ($i = 0; $i < count($colorElementShow); $i++) { 
		$colorElementItemShow[$i] = explode (",", $colorElementShow[$i]);  
	}
	for ($i = 0; $i < count($colorElementShow); $i++) { 
		if (isset($colorElementItemShow[$i][0]) && $colorElementItemShow[$i][0] == $matiereId && isset($colorElementItemShow[$i][1]) && $colorElementItemShow[$i][1] == $niveauId) {
			$colormain = $colorElementItemShow[$i][2];
			$colorsecond = $colorElementItemShow[$i][3];
			$colorhover = $colorElementItemShow[$i][4];
			$colorfocus = $colorElementItemShow[$i][5];
			break;
		}
	}
	if (!isset($colormain)) {
		$colormain = $modif["color"]["theme"]["main"];
		$colorsecond = $modif["color"]["theme"]["second"];
		$colorhover = $modif["color"]["theme"]["hover"];
		$colorfocus = $modif["color"]["theme"]["focus"];
	}
}


$lecture = new Lire('../includes/config.yml');
$lecture = $lecture->GetTableau();

$titre_page = "Gestion de l'espace élève";
$meta_description = "Page de gestion de l'espace élève";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "include/Sortable.js";
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
<h5 class="text-center">Personnaliser la barre de navigation de l'espace élève :</h5>
<div class="row justify-content-center">
	<div class="col">
		<div id="sortablelist" class="list-group list-group mb-4" data-id="1">
			<?php
			$str_arr = explode (";", $lecture['navBar']['espaceEleve']);
			for ($i = 0; $i < count($str_arr); $i++) { 
				$str_arr2[$i] = explode (",", $str_arr[$i]);  
			}
			$i = 0;
			if ($str_arr[0] != "") {
				for ($i = 0; $i < count($str_arr); $i++) { ?>
					<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $str_arr2[$i][0]?>">
						<div class="col-1" style="cursor: grab;">
							<img class="position-handle" src="include/move.png" width="19" height="19">
						</div>
						<div class="col-4">
							<?php echo $str_arr2[$i][1];?>
						</div>
						<div class="col-5">
							<?php echo $str_arr2[$i][2];?>
						</div>
						<div class="col-2">
							<form method="post" name="formSupprElementNavBar" action="gestion_espace_eleve.php" class="form-row align-items-center justify-content-center">
								<button type="submit" name="supprNavBar" value="<?php echo $str_arr2[$i][0];?>" class="btn btn-primary">Supprimer</button>
							</form>
						</div>
					</div>
					<?php
				}
			}?>
		</div>
		<div class="form-group row justify-content-center">
			<form method="post" name="formNouvelElementNavBar" action="gestion_espace_eleve.php" class="form-row">
				<div class="col-auto">
					<input type="text" name="nomElementNavBar" class="form-control" placeholder="Nom" required>
				</div>
				<div class="col-auto">
					<input type="text" name="urlElementNavBar" class="form-control" placeholder="URL" required>
				</div>
				<div class="col-auto">
					<button type="submit" name="ajoutNavBar" value="1" class="btn btn-primary">Ajouter un élément dans la barre</button>
				</div>
			</form>
		</div>
		<div class="form-group row justify-content-center">
			<form method="post" name="formNouvelOrdreNavBar" action="gestion_espace_eleve.php" class="form-row">
				<div class="col-auto">
					<button type="submit" name="ordreNavBar" value="1" class="btn btn-primary" onclick="setValuesInputOrderList()">Enregistrer le nouvel ordre</button>
				</div>
				<input type="hidden" id="ordreItemsMenu" name="ordreItemsMenu" value="">
			</form>
		</div>
		<script type="text/javascript">
			var list = Sortable.create(sortablelist, {
				animation: 100,
				group: 'list-1',
				draggable: '.list-group-item',
				handle: '.position-handle',
				sort: true,
				filter: '.sortable-disabled',
				chosenClass: 'active',
			});
			function setValuesInputOrderList() {
				var order = list.toArray();
				let inputOrdreItemsMenu = document.getElementById('ordreItemsMenu');
				inputOrdreItemsMenu.setAttribute('value', order);
			}
		</script>
	</div>
</div>
<h5 class="text-center" id="theme">Personnaliser le thème de l'Espace élève selon la matière et le niveau :</h5>
<form method="post" action="gestion_espace_eleve.php#theme">
	<div class="form-group row align-items-center justify-content-center">
		<label for="matiere_ID" class="col-auto col-form-label">Matière :</label>
		<div class="col-auto">
			<select name="matiere_ID" id="select2" class="custom-select" required>
				<option disabled selected value="">Selectionnez une matière</option>
				<?php
				while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)) { ?>
					<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo " SELECTED";} } ?>><?php echo $row_rs_matiere['nom_mat']?></option>
					<?php
				} ?>
			</select>
		</div>
		<label for="niveau_ID" class="col-auto col-form-label">Niveau :</label>
		<div class="col-auto">
			<select name="niveau_ID" id="niveau_ID" class="custom-select" required>
				<option disabled selected value="">Selectionnez un niveau</option>
				<?php
				 while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)) { ?>
					<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
					<?php
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>
<?php 
if (isset($matiereId) && isset($niveauId)) { ?>
	<div class="row justify-content-center">
		<div class="col-auto">
			<form method="post" action="gestion_espace_eleve.php#theme">
				<div class="form-group">
					<label for="color_theme_main" class="col-auto col-form-label">Couleur principale :</label>
					<input type="color" name="color_theme_main" class="form-control" value="<?php echo $colormain?>">
				</div>
				<div class="form-group">
					<label for="color_theme_second" class="col-auto col-form-label">Couleur secondaire :</label>
					<input type="color" name="color_theme_second" class="form-control" value="<?php echo $colorsecond?>">
				</div>
				<div class="form-group">
					<label for="color_theme_hover" class="col-auto col-form-label">Couleur lors du survol :</label>
					<input type="color" name="color_theme_hover" class="form-control" value="<?php echo $colorhover?>">
				</div>
				<div class="form-group">
					<label for="color_theme_focus" class="col-auto col-form-label">Couleur lors du clic :</label>
					<input type="color" name="color_theme_focus" class="form-control" value="<?php echo $colorfocus?>">
				</div>
				<div class="form-group">
					<button type="submit" name="changementCouleurs" value="1" class="btn btn-primary">Valider les changements</button>
					<input type="hidden" name="matiere_ID" value="<?php echo $matiereId;?>">
					<input type="hidden" name="niveau_ID" value="<?php echo $niveauId;?>">
				</div>
			</form>
		</div>
	</div>
	<?php
}
require('include/footerAdministrateur.inc.php');
?>