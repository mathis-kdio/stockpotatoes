<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Upload')
	{
		header("Location: login_upload.php?cible=ajout_fichiers_joints");
	}
}
else
{
	header("Location: login_upload.php?cible=ajout_fichiers_joints");
}
require_once('../Connections/conn_intranet.php');

mysqli_select_db($conn_intranet, $database_conn_intranet);

if (isset($_POST['matiere_ID'])) {
	$matiereId = htmlspecialchars($_POST['matiere_ID']);
}
if (isset($_POST['ID_quiz'])) {
	$quizId = htmlspecialchars($_POST['ID_quiz']);
}

function sans_accent($chaine) 
{ 
	$accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
	$noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
	return strtr(trim($chaine),$accent,$noaccent); 
} 

$colname_RsChoixQuiz = "1";
if (isset($quizId))
{
	$colname_RsChoixQuiz = $quizId;
}
$query_RsChoixQuiz = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = '%s'", $colname_RsChoixQuiz);
//$query_limit_RsChoixQuiz = sprintf("%s LIMIT %d, %d", $query_RsChoixQuiz, $startRow_RsChoixQuiz, $maxRows_RsChoixQuiz);
//$RsChoixQuiz = mysqli_query($conn_intranet, $query_limit_RsChoixQuiz) or die(mysqli_error($conn_intranet));
$RsChoixQuiz = mysqli_query($conn_intranet, $query_RsChoixQuiz) or die(mysqli_error($conn_intranet));

$row_RsChoixQuiz = mysqli_fetch_assoc($RsChoixQuiz);

$colname_RsChoixMatiere = "1";
if (isset($matiereId)) 
{
	$colname_RsChoixMatiere = $matiereId;
}
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = '%s'", $colname_RsChoixMatiere);
$RsChoixMatiere = mysqli_query($conn_intranet, $query_RsChoixMatiere) or die(mysqli_error($conn_intranet));
$row_RsChoixMatiere = mysqli_fetch_assoc($RsChoixMatiere);

$choixquiz_RsChoixQuiz = "0";
if (isset($quizId))
{
	$choixquiz_RsChoixQuiz = $quizId;
}
$query_RsChoixQuiz = sprintf("SELECT ID_quiz, titre, fichier, matiere_ID, niveau_ID, auteur FROM stock_quiz WHERE ID_quiz = '%s'", $choixquiz_RsChoixQuiz);
$RsChoixQuiz = mysqli_query($conn_intranet, $query_RsChoixQuiz) or die(mysqli_error($conn_intranet));
$row_RsChoixQuiz = mysqli_fetch_assoc($RsChoixQuiz);

$nom_matiere = sans_accent($row_RsChoixMatiere['nom_mat']);
$rep = $nom_matiere.'/q'.$quizId.'/';

// Chargement de la classe
require_once('upload.class.php');

// Instanciation d'un nouvel objet "upload"
$Upload = new UploadClass();

/**
 * Gestion lors de la soumission du formulaire
**/

if (!Empty($_POST['submit']))
{
	// Si vous voulez renommer le fichier...
	//$Upload-> Filename     = 'fichier';
	
	// Si vous voulez ajouter un préfixe au nom du fichier...
	//$Upload-> Prefixe = 'pre_';
	
	// Si vous voulez ajouter un suffixe au nom du fichier...
	//$Upload-> Suffice = '_suf';
	
	// Pour changer le mode d'écriture (entre 0 et 3)
	//$Upload-> WriteMode    = 0;
	
	// Pour filtrer les fichiers par extension
	//$Upload-> Extension = '.gif;.jpg;.jpeg;.bmp;.png';
	
	// Pour filtrer les fichiers par entête
	//$Upload-> MimeType  = 'image/gif;image/pjpeg;image/bmp;image/x-png'; 
	
	// Pour tester la largeur / hauteur d'une image
	//$Upload-> ImgMaxHeight = 200;
	//$Upload-> ImgMaxWidth  = 200;
	//$Upload-> ImgMinHeight = 100;
	//$Upload-> ImgMinWidth  = 100;
	
	// Pour vérifier la page appelante
	//$Upload-> CheckReferer = 'http://mondomaine/mon_chemin/mon_fichier.php';
	
	// Pour générer une erreur si les champs sont obligatoires
	//$Upload-> Required     = false;
	
	// Pour interdire automatiquement tous les fichiers considérés comme "dangereux"
	//$Upload-> SecurityMax  = true;

	// Définition du répertoire de destination
	$rep_complet = '../Exercices/'.htmlspecialchars($_POST['rep']);
	$Upload-> DirUpload = $rep_complet;

	// On lance la procédure d'upload
	$Upload-> Execute();

	// Gestion erreur / succès
	// if ($UploadError) {
	//  print 'Il y a eu une erreur :'; 
	// } else {
	//    print '<strong>Envoi des fichiers effectué avec succès </strong>';
	//        }
}

/**
 * Création du formulaire
 **/

// Pour limiter la taille d'un fichier (exprimée en ko) - 1024 soit 1 Mo par defaut
//$Upload-> MaxFilesize  = '1024';

// Pour ajouter des attributs aux champs de type file
$Upload-> FieldOptions = 'style="border-color:black;border-width:1px;"';

// Pour indiquer le nombre de champs désiré
$Upload-> Fields       = 6;

// Initialisation du formulaire
$Upload-> InitForm();

$titre_page = "Espace Upload - Envoi de fichiers joints à un exercice (image, son, vidéo... )";
$meta_description = "Page d'envoi de fichiers joints à un exercice (image, son, vidéo... )";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('include/headerUpload.inc.php');
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Upload</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Envoi de fichiers joints à un exercice (image, son, vidéo... )</p>
			</div>
		</div>
		<div class="container jumbotron">
			<div class="row">
				<div class="col-4">
					<h4>Fichier sélectionné</h4>
					<table class="table table-striped table-bordered table-sm">
						<tr> 
							<td>N° :</td>
							<td><?php echo $row_RsChoixQuiz['ID_quiz']; ?></td>
						</tr>
						<tr> 
							<td>Titre :</td>
							<td><?php echo $row_RsChoixQuiz['titre']; ?></td>
						</tr>
						<tr> 
							<td>Fichier :</td>
							<td><?php echo $row_RsChoixQuiz['fichier']; ?></td>
						</tr>
						<tr> 
							<td>Auteur :</td>
							<td><?php echo $row_RsChoixQuiz['auteur']; ?></td>
						</tr>
					</table>
				</div>
				<div class="col-4">
					<h4>Fichier(s) déjà joint(s)</h4>
					<table class="table table-striped table-bordered table-sm">
						<?php
						$nom_matiere = sans_accent($row_RsChoixMatiere['nom_mat']);
						$repertoire_list = '../Exercices/'.$nom_matiere.'/q'.$quizId.'/';

						$dir = opendir($repertoire_list);

						while ($f = readdir($dir))
						{
							if(is_file($repertoire_list.$f))
							{
							 	$chemin = $repertoire_list.$f;
							 	//chmod($chemin,0777);?>
							 	<tr>
									<td><?php echo $f;?></td>
									<td><?php echo filesize($repertoire_list.$f)." octets";?></td>
								</tr>
								<?php
							}
						}
						closedir($dir); ?>
					</table>
				</div>
				<div class="col-4">
					<h4>Nouveaux fichiers joints à envoyer</h4>
					<form method="post" name="formulaire" id="formulaire" action="ajout_fichiers_joints.php">
						<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $quizId;?>"> 
						<input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $matiereId;?>"> 
						<input name="rep" type="hidden" id="rep" value="<?php echo $rep;?>"> 
						<?php
						// Affichage du champ MAX_FILE_SIZE
						print $Upload-> Field[0];
						?>

						<div class="form-group">
							<div class='custom-file'>
								<?php print $Upload-> Field[1];?>
								<label class="custom-file-label" for="userfile[]">Cliquer pour ajouter une fichier</label>
							</div>
						</div>
						<div class="form-group">
							<div class='custom-file'>
								<?php print $Upload-> Field[2];?>
								<label class="custom-file-label" for="userfile[]">Cliquer pour ajouter une fichier</label>
							</div>
						</div>
						<div class="form-group">
							<div class='custom-file'>
								<?php print $Upload-> Field[3];?>
								<label class="custom-file-label" for="userfile[]">Cliquer pour ajouter une fichier</label>
							</div>
						</div>
						<div class="form-group">
							<div class='custom-file'>
								<?php print $Upload-> Field[4];?>
								<label class="custom-file-label" for="userfile[]">Cliquer pour ajouter une fichier</label>
							</div>
						</div>
						<div class="form-group">
							<div class='custom-file'>
								<?php print $Upload-> Field[5];?>
								<label class="custom-file-label" for="userfile[]">Cliquer pour ajouter une fichier</label>
							</div>
						</div>
						<div class="form-group">
							<div class='custom-file'>
								<?php print $Upload-> Field[6];?>
								<label class="custom-file-label" for="userfile[]">Cliquer pour ajouter une fichier</label>
							</div>
						</div>
						<div class="form-group text-center">
							<button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
						</div>
					</form>
				</div>
			</div>
			<p class="text-center">Les fichiers sont enregistrés sur le serveur dans le dossier : <?php echo $rep; ?></p>
		</div>
	</div>
</div>
<?php
require('include/footerUpload.inc.php');
mysqli_free_result($RsChoixQuiz);
mysqli_free_result($RsChoixMatiere); ?>