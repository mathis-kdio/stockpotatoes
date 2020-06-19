<?php session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Upload')
	{
		header("Location: login_upload.php");
	}
}
else
{ 
	header("Location: login_upload.php");
}

$titre_page = "Espace Upload";
$meta_description = "Page d'accueil pour mettre en ligne des exercices";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="";
$css_deplus = "style";

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
				<p class="h3 bg-info text-center p-3" style="margin-top: 50px;">Accueil de l'espace Upload</p>
			</div>
		</div>
		<?php
		include("../includes/version.php");
		$versionrecente = file_get_contents('https://stockpotatoes.ovh/version.txt');
		if ($versionrecente != $versioninstallee)
		{ ?>
			<div class="card text-white bg-info mb-3">
				<div class="card-body text-dark">
					<h5 class="card-title text-center">Mise à jour Stockpotatoes disponible</h5>
					<p class="card-text">Vous possédez la version <?php echo $versioninstallee;?> et la version <?php echo $versionrecente;?> est disponible. Si vous êtes l'administrateur rendez-vous dans l'Espace Administrateur pour voir la marche à suivre.</p>
				</div>
			</div>
			<?php
		} ?>
		<div class="container jumbotron">
			<div class="row">
				<div class="col">
					<h3 class="bg-info shadow text-center pb-2 mb-4">Mise en ligne des documents et exercices</h3>
					<div class="list-group">
						<a href="upload_hotpot.php" class="list-group-item list-group-item-action list-group-item-primary">Ajouter un exercice Hotpotatoes</a>
						<a href="modif_select.php" class="list-group-item list-group-item-action list-group-item-primary">Ajouter des fichiers liés à un exercice Hotpotatoes (images, sons...)</a>
						<a href="upload_divers.php" class="list-group-item list-group-item-action list-group-item-primary">Envoyer un document autre (Word, OpenOffice, Pdf, ...)</a>
						<a href="redac_online.php" class="list-group-item list-group-item-action list-group-item-primary">Rédiger directement un document Web et le publier (éditeur)</a>
						<a href="select_online.php" class="list-group-item list-group-item-action list-group-item-primary">Ouvrir un document Web déjà publié et le modifier (éditeur) </a>
						<a href="upload_url.php" class="list-group-item list-group-item-action list-group-item-primary">Créer un lien hypertexte vers un document externe</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('include/footerUpload.inc.php');
?>