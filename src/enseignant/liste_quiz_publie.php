<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_quiz_publie");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_quiz_publie");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_GET['matiere_ID'])) {
	$matiereId = htmlspecialchars($_GET['matiere_ID']);
}
if (isset($_GET['niveau_ID'])) {
	$niveauId = htmlspecialchars($_GET['niveau_ID']);
}

function sans_accent($chaine) { 
	$accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
	$noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
	return strtr(trim($chaine), $accent,$noaccent); 
}

if (isset($matiereId) && isset($niveauId)) {
	$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE matiere_ID = '%s' AND niveau_ID = '%s' AND en_ligne = 'O' ORDER BY matiere_ID, niveau_ID", $matiereId, $niveauId);
	$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error($conn_intranet));

	$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $matiereId);
	$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error($conn_intranet));
	$row_rsChoix = mysqli_fetch_assoc($rsChoix);
}

$titre_page = "Liste des exercices publiés dans une matière";
$meta_description = "Page de la liste des exercices publiés dans une matière";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');

require('../includes/forms/matiere_niveau.inc.php');

if (isset($matiereId) && isset($niveauId)) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-sm">
			<thead>
				<tr> 
					<th scope="col">N° Ex.</th>
					<th scope="col">Titre</th>
					<th scope="col">Fichier</th>
					<th scope="col">Auteur</th>
					<th scope="col">En entraînement</th>
					<th scope="col">En évaluation</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau))
				{ 
					$matiere = sans_accent($row_rsChoix['nom_mat']); ?>
					<tr> 
						<td><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></td>
						<td>
							<a href="<?php echo '../Exercices/'.$matiere.'/q'.$row_rsListeSelectMatiereNiveau['ID_quiz']; ?>/<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>"><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></a>
						</td>
						<td><?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?></td>
						<td><?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?></td>
						<td><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></td>
						<td><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></td>
					</tr>
					<?php
				}?>
			</tbody>
		</table>
	</div>
	<?php
	mysqli_free_result($rsListeSelectMatiereNiveau);
	mysqli_free_result($rsChoix);
}

require('includes/footerEnseignant.inc.php');
?>