<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom'] != 'Administrateur') { 
		header("Location: login_administrateur.php?cible=gestion_activite");
	}
} 
else {
	header("Location: login_administrateur.php?cible=gestion_activite");
}

require_once('../Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));

$titre_page = "Gestion des activités";
$meta_description = "Page de gestion des activités";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>

<div class="row justify-content-center">
	<div class="col-auto text-center">
			<h4>Liste des dernières activités</h4>
			<a class="btn btn-primary" href="../enseignant/liste_activite.php" role="button">Liste des dernières activités</a>
	</div>
</div>
<div class="row justify-content-center mt-5">
	<div class="col-auto text-center">
		<h4>Supprimer l'ensemble des activités d'une classe</h4>
		<form name="form2" method="post" action="supp_activite_classe.php">
			<div class="form-group form-row justify-content-center">
				<div class="col-auto">
					<select class="custom-select" name="classe" id="classe" required>
						<option disabled selected value="">Veuillez choisir une classe</option>
						<?php
						while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)) { ?>
							<option value="<?php echo $row_rsClasse['classe']?>"><?php echo $row_rsClasse['classe']?></option>
							<?php
						} ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="Submit" value="Sélectionner la classe">
			</div>
		</form>
	</div>
</div>
<div class="row justify-content-center mt-5">
	<div class="col-auto text-center">
		<h4>Supprimer toute la base activité de l'établissement</h4>
		<p>
			<strong>Attention</strong>, cela efface l'ensemble des scores de tous l'établissement pour tous les exercices. Cette opération peut être utilisée par exemple en début d'année scolaire.
		</p>
		<a class="btn btn-primary" href="supp_activite_total.php" role="button">Vider la table contenant les activités dans la base de donnée</a>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php');

mysqli_free_result($rsClasse); ?>