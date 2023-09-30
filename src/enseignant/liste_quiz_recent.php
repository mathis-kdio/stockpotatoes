<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_quiz_recent");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_quiz_recent");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['matiere_ID'])) {
	$matiereId = htmlspecialchars($_POST['matiere_ID']);
}
if (isset($_POST['niveau_ID'])) {
	$niveauId = htmlspecialchars($_POST['niveau_ID']);
}

function sans_accent($chaine) 
{ 
	 $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
	 $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
	 return strtr(trim($chaine), $accent,$noaccent); 
}

$query_limit_rsListeSelectMatiereNiveau = "SELECT * FROM stock_quiz, stock_matiere, stock_niveau WHERE stock_quiz.matiere_ID = stock_matiere.ID_mat AND stock_quiz.niveau_ID = stock_niveau.ID_niveau ORDER BY stock_quiz.ID_quiz  DESC LIMIT 0, 10";

$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_limit_rsListeSelectMatiereNiveau) or die(mysqli_error($conn_intranet));

$titre_page = "Liste des exercices mis en ligne récemment";
$meta_description = "Page de la liste des exercices mis en ligne récemment";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

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
  			$matiere = sans_accent($row_rsListeSelectMatiereNiveau['nom_mat']); ?>
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
require('includes/footerEnseignant.inc.php');

mysqli_free_result($rsListeSelectMatiereNiveau);
?>