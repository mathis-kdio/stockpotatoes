<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_pass");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_pass");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['classe'])) {
	$classeName = htmlspecialchars($_POST['classe']);
}

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error());

if (isset($classeName)) {
	$query_RsListePass = sprintf("SELECT ID_eleve, nom, prenom, pass FROM stock_eleve WHERE classe = '%s' ORDER BY nom ASC, prenom", $classeName);
	$RsListePass = mysqli_query($conn_intranet, $query_RsListePass) or die(mysqli_error($conn_intranet));
}

$titre_page = "Liste des mots de passe dans une classe";
$meta_description = "Page de la liste des mots de passe dans une classe";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<form name="form2" method="post" action="liste_pass.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="classe" class="col-auto col-form-label">Sélectionner une classe :</label>
		<div class="col-auto">
			<select name="classe" id="select10" class="custom-select">
				<?php
				while ($row_rsClasse = mysqli_fetch_assoc($rsClasse))
				{ ?>
					<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classeName)) { if (!(strcmp($row_rsClasse['classe'], $classeName))) {echo " SELECTED";} }?>><?php echo $row_rsClasse['classe']; ?></option>
					<?php
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit2" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>
<?php 
mysqli_free_result($rsClasse);
if (isset($classeName))
{ ?>
	<div class="row align-items-center justify-content-end bg-info mb-3 py-2">
		<div class="col-auto">
			<button type="submit" name="print" onClick="javascript:window.print()" class="btn btn-primary">Imprimer</button>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr>
					<td>N°</td>
					<td>Nom</td>
					<td>Prénom</td>
					<td>Mot de passe</td>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row_RsListePass = mysqli_fetch_assoc($RsListePass)) 
				{ ?>
					<tr> 
						<td><?php echo $row_RsListePass['ID_eleve']; ?></td>
						<td><?php echo $row_RsListePass['nom']; ?></td>
						<td><?php echo $row_RsListePass['prenom']; ?></td>
						<td><?php echo $row_RsListePass['pass']; ?></td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>
	</div>
	<?php
	mysqli_free_result($RsListePass);
}

require('includes/footerEnseignant.inc.php'); ?>