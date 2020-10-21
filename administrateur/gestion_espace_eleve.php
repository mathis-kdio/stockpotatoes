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
<?php
require('include/footerAdministrateur.inc.php');
?>