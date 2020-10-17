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
<h5 class="text-center">Personnaliser la barre de navigation de l'espace élève:</h5>
<div class="row justify-content-center">
	<div class="col-auto">
		<div id="sortablelist" class="list-group list-group-horizontal mb-4" data-id="1">
			<?php 
				do { ?>
					<div class="list-group-item d-flex align-items-center justify-content-between text-center overflow-auto" data-id="<?php echo $row_RsTheme['ID_theme']?>">
						<div class="col-1" style="cursor: grab;">
							<img class="position-handle" src="images/move.png" width="19" height="19">
						</div>
						<div class="col-1">
							<?php echo $row_RsTheme['ID_theme']; ?>
						</div>
						<div class="col-2">
							<?php echo $row_RsTheme['theme'];?>
						</div>
					</div>
					<?php 
				} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme)); ?>
		</div>
		<div class="form-group row align-items-center justify-content-center">	
			<form method="post" name="form_nouvel_ordre" action="gestion_espace_eleve.php">
				<div class="col-auto">
					<button type="submit" name="submit_nouvel_ordre" class="btn btn-primary" onclick="setValuesInputOrderList()">Enregistrer le nouvel ordre</button>
				</div>
				<input type="hidden" name="MM_nouvel_ordre" value="form_nouvel_ordre">
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