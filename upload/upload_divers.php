<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Upload')
	{
		header("Location: login_upload.php?cible=upload_divers");
	}
}
else
{
	header("Location: login_upload.php?cible=upload_divers");
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
	return strtr(trim($chaine), $accent, $noaccent); 
} 

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);

$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);

$choixmat_RsTheme = "0";
if (isset($matiereId))
{
	$choixmat_RsTheme = $matiereId;
}
$choixniv_RsTheme = "0";
if (isset($niveauId))
{
	$choixniv_RsTheme = $niveauId;
}

$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE mat_ID = '%s' AND niv_ID = '%s' ORDER BY theme", $choixmat_RsTheme, $choixniv_RsTheme);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error($conn_intranet));
$row_RsTheme = mysqli_fetch_assoc($RsTheme);

$query_RsCategorie= sprintf("SELECT * FROM stock_categorie ORDER BY ID_categorie");
$RsCategorie = mysqli_query($conn_intranet, $query_RsCategorie) or die(mysqli_error($conn_intranet));
$row_RsCategorie = mysqli_fetch_assoc($RsCategorie);

$selection_RsChoixMatiere = "0";
if (isset($matiereId))
{
	$selection_RsChoixMatiere = $matiereId;
}
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $selection_RsChoixMatiere);
$RsChoixMatiere = mysqli_query($conn_intranet, $query_RsChoixMatiere) or die(mysqli_error($conn_intranet));
$row_RsChoixMatiere = mysqli_fetch_assoc($RsChoixMatiere);

if (!Empty($_POST['submit2']))
{
	if ($_POST['titre'] == '')
	{
		echo '<h3 class="text-danger text-center">Il faut donner un titre à votre document</h3>';
	}
	else
	{
		// Ok pour enregistrer
		//enregistrement dans la table
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
		{

			if ((isset($_POST['en_ligne'])) && ($_POST['en_ligne'] == 'O'))
				$en_ligne = 'O';
			else
				$en_ligne = 'N';

			if ((isset($_POST['avec_score'])) && ($_POST['avec_score'] == 'O'))
				$avec_score = 'O';
			else
				$avec_score = 'N';

			if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul'] == 'O'))
				$evaluation_seul = 'O';
			else
				$evaluation_seul = 'N';

			if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul'] == 'O'))
				$avec_score = 'O';

			$query_RsMax = "SELECT MAX(pos_doc) AS resultat FROM stock_quiz";
			$RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error($conn_intranet));
			$row_RsMax = mysqli_fetch_assoc($RsMax);
			$position = $row_RsMax['resultat'] + 1;

			$insertSQL = sprintf("INSERT INTO stock_quiz (titre, fichier, matiere_ID, niveau_ID,theme_ID, categorie_ID, auteur, en_ligne, avec_score, evaluation_seul, cat_doc, type_doc, pos_doc) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
			htmlspecialchars($_POST['titre']), htmlspecialchars($_FILES['fichier']['name']), $matiereId, $niveauId, htmlspecialchars($_POST['theme_ID']), htmlspecialchars($_POST['categorie_ID']), htmlspecialchars($_POST['auteur']), $en_ligne, $avec_score, $evaluation_seul, htmlspecialchars($_POST['cat_doc']), htmlspecialchars($_POST['type_doc']), $position);

			$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));
			mysqli_free_result($RsMax);
		}
		//fin enregistrement ds la table

		$query_RsMaxId_quiz = "SELECT MAX( Id_quiz )  FROM stock_quiz";
		$RsMaxId_quiz = mysqli_query($conn_intranet, $query_RsMaxId_quiz) or die(mysqli_error($conn_intranet));
		$row_RsMaxId_quiz = mysqli_fetch_assoc($RsMaxId_quiz);

		$total = $row_RsMaxId_quiz['MAX( Id_quiz )'];
		mysqli_free_result($RsMaxId_quiz);
		$nom_matiere = sans_accent($row_RsChoixMatiere['nom_mat']);
		$repertoire = '../Exercices/'.$nom_matiere.'/q'.$total;

		if (is_dir($repertoire))
		{
			echo '<span class="text-center">Le dossier ".$repertoire." existait déjà</span>';
		}
		else
		{
			mkdir($repertoire, 0777);
		}
		if ($_FILES['fichier']['tmp_name'] <> '')
		{
			$dossier_destination = $repertoire; 
			$dossier_temporaire = $_FILES['fichier']['tmp_name'];
			$type_fichier = $_FILES['fichier']['type'];
			$nom_fichier = $_FILES['fichier']['name'];
			$erreur= $_FILES['fichier']['error'];
			if ($erreur == 2)
			{
				exit ("Le fichier dépasse la taille de 100 Mo.");
				$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz = '%s'", $total);
				$Result1 = mysqli_query($conn_cahier_de_texte, $deleteSQL) or die(mysqli_error($conn_intranet));
			}
			if ($erreur == 3)
			{
				exit ("Le fichier travail a été partiellement transféré. Envoyez-le à nouveau.");
				$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz = '%s'", $total);
				$Result1 = mysqli_query($conn_cahier_de_texte, $deleteSQL) or die(mysqli_error($conn_intranet));
			}
			if(!move_uploaded_file($dossier_temporaire, $dossier_destination.'/'.$nom_fichier))
			{
				exit("Impossible de copier le fichier ");
				$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz = '%s'", $total);
				$Result1 = mysqli_query($conn_cahier_de_texte, $deleteSQL) or die(mysqli_error($conn_intranet));
			}
			else
			{
				echo '<h3 class="text-danger text-center">Le fichier '.$_FILES['fichier']['name'].' a été envoyé sur le serveur dans le dossier '.$dossier_destination.'</h3>';
			}
		}
	}
}
$titre_page = "Espace Upload - Envoyer un document sur le serveur";
$meta_description = "Page de mise en ligne d'un document sur le serveur";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('include/headerUpload.inc.php');
?>

<form name="form1" method="post" action="upload_divers.php">
	<div class="form-group row align-items-center justify-content-center">
		<label for="matiere_ID" class="col-auto col-form-label">Matière :</label>
		<div class="col-auto">
			<select name="matiere_ID" id="select2" class="custom-select">
				<?php
				do { ?>
					<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo "SELECTED";} }  ?>><?php echo $row_rs_matiere['nom_mat']?></option>
					<?php
				} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)); ?>
			</select>
		</div>
		<label for="niveau_ID" class="col-auto col-form-label">Niveau :</label>
		<div class="col-auto">
			<select name="niveau_ID" id="niveau_ID" class="custom-select">
				<?php
				do { ?>
					<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
					<?php
				} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)); ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" name="Submit" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>
<?php if (isset($matiereId)) 
{ ?>
	<h1 class="text-center mb-5"><?php echo $row_RsChoixMatiere['nom_mat'];?></h1>

	<form method="post" name="form1" id="formulaire" action="upload_divers.php">
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right"> Ce fichier sera dans l'étude du thème:</span>
			</div>
			<div class="col-auto">
				<select class="form-control" name="theme_ID" id="select">
					<option value="value">Selectionnez un thème</option>
					<?php
					do 
					{ ?>
						<option value="<?php echo $row_RsTheme['ID_theme']?>"><?php echo $row_RsTheme['theme']?></option>
						<?php
					} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme)); ?>
				</select>
			</div>
			<div class="col-auto">
				<a class="btn btn-primary" href="../enseignant/gestion_theme.php" role="button">Ajouter un nouveau thème</a>
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Ce fichier sera dans la catégorie:</span>
			</div>
			<div class="col-auto">
				<select class="form-control" name="categorie_ID" id="select">
					<option value="value">Selectionnez une catégorie</option>
					<?php
					do 
					{ ?>
						<option value="<?php echo $row_RsCategorie['ID_categorie']?>"><?php echo $row_RsCategorie['nom_categorie'];?></option>
						<?php
					} while ($row_RsCategorie = mysqli_fetch_assoc($RsCategorie));?>
				</select>
			</div>
			<div class="col-auto">
				<a class="btn btn-primary" href="../enseignant/gestion_categorie.php" role="button">Ajouter une nouvelle catégorie</a>
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Titre du document: <span class="font-weight-bold text-danger">(Obligatoire)</span>:</span>
			</div>
			<div class="col-auto">
				<input type="text" class="form-control" name="titre" placeholder="Titre non utilisé de préférence">
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Ajouter le fichier:</span>
			</div>
			<div class="col-auto">
				<div class="custom-file">
				  <input type="file" class="custom-file-input" name="fichier" id="customFile">
				  <label class="custom-file-label" for="customFile">Veuillez choisir un fichier</label>
				</div>
			</div>
			<input type="hidden" name="MM_insert" value="form1">
			<input type="hidden" name="MAX_FILE_SIZE" value="100000000">
			<input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $matiereId;?>"> 
			<input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $niveauId;?>"> 
			<input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo htmlspecialchars($_POST['nom_mat']);?>"> 
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Ce document est à classer dans:</span>
			</div>
			<div class="col-auto">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cat_doc" id="cat_doc1" value="1" checked>
					<label class="form-check-label" for="cat_doc1">Cours</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cat_doc" id="cat_doc3" value="3">
					<label class="form-check-label" for="cat_doc3">Exercices</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cat_doc" id="cat_doc4" value="4">
					<label class="form-check-label" for="cat_doc4">Travail à faire</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="cat_doc" id="cat_doc5" value="5">
					<label class="form-check-label" for="cat_doc5">Annexes</label>
				</div>
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Nature du document:</span>
			</div>
			<div class="col-auto">
				<select class="form-control" name="type_doc" size="1" id="type_doc">
					<option value="4">Page Web</option>
					<option value="5">Document Word</option>
					<option value="6">Document Excel</option>
					<option value="7">Document Powerpoint</option>
					<option value="8">Document Pdf</option>
					<option value="9">Présentation OpenOffice</option>
					<option value="10">Trait. Texte OpenOffice</option>
					<option value="11">Tableur Open Office</option>
					<option value="12">Image fixe</option>
					<option value="13">Animation</option>
					<option value="14">Audio</option>
					<option value="15">Vidéo</option>
					<option value="16">Autre</option>
				</select>
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Vous pouvez ajouter un auteur:</span>
			</div>
			<div class="col-auto">
				<input type="text" class="form-control" name="auteur" placeholder="Nom de l'auteur">
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Mode Entraînement:</span>
			</div>
			<div class="col-auto">
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" value="O" name="en_ligne" id="en_ligne" checked>
				  <label class="form-check-label" for="en_ligne">
						<span class="font-italic text-danger">Le document peut être vu sans que l'élève soit identifié.</span>
				  </label>
				</div>
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Mode Evaluation:</span>
			</div>
			<div class="col-auto">
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" value="O" name="avec_score" id="avec_score" checked>
				  <label class="form-check-label" for="avec_score">
						<span class="font-italic text-danger">Le document peut être vu par l'élève en s'identifiant</span>
				  </label>
				</div>
			</div>
		</div>
		<div class="form-group form-row justify-content-right align-items-center">
			<div class="col-auto">
				<span class="text-right">Une seule consultation:</span>
			</div>
			<div class="col-auto">
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" value="O" name="evaluation_seul" id="evaluation_seul">
				  <label class="form-check-label" for="evaluation_seul">
						<span class="font-italic text-danger">En mode évaluation, le document ne pourra être vu qu'une seule fois</span>
				  </label>
				</div>
			</div>
		</div>
		<p class="font-italic text-danger">Les paramètres ci-dessus tels que le choix du mode, pourront être modifiés par la suite (voir Espace Enseignant - Gestion des exercices ).</p>
		<div class="form-group text-center">
			<button type="submit" name="submit2" class="btn btn-primary" value="Envoyer votre document sur le serveur">Envoyer votre document sur le serveur</button>
		</div>
	</form>
<?php } ?>

<?php
require('include/footerUpload.inc.php');
mysqli_free_result($rs_matiere);
mysqli_free_result($rs_niveau);
mysqli_free_result($RsTheme);
mysqli_free_result($RsChoixMatiere);
?>