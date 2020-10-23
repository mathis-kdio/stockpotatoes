<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../includes/yml.class.php');

$config = new Lire('../includes/config.yml');
$config = $config->GetTableau();

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<style>
		:root {
			--color-main: <?=$config["color"]["theme"]["main"]?>;
			--color-second: <?=$config["color"]["theme"]["second"]?>; 
			--color-hover: <?=$config["color"]["theme"]["hover"]?>; 
			--color-focus: <?=$config["color"]["theme"]["focus"]?>; 
		}
		</style>
		<style>
			.custom-file-input ~ .custom-file-label:lang(fr)::after {
				content: "Choisir...";
			}
		</style>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php echo $meta_description ?>" />
		<meta name="keywords" content="<?php echo $meta_keywords ?>" />
		<meta name="author" content="stockpotatoes" />

    	<link rel="stylesheet" type="text/css" media="all" href="../includes/bootstrap.min.css" />
		<!-- Mon CSS -->
		<link rel="stylesheet" type="text/css" media="all" href="include/styleUpload.css" />
		<!--Ajout d'une à trois feuille(s) de style et/ou d'un à trois script(s) en fonction de l'exo -->
		<?php
		// 1
		if (isset($css_deplus) && $css_deplus!="" )
		{
		 echo "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"" .$css_deplus. "\" />\n";
		}
		if (isset($js_deplus) && $js_deplus!="" )
		{
		 echo "\t<script type=\"text/javascript\" src=\"".$js_deplus."\"></script>\n";
		}
		?>

		<title>Espace Upload - <?php echo $titre_page ?></title>
	</head>
	<body class="">	
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
				<a class="navbar-brand" href="#">
					<img src="../includes/imgNavBar.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
					<?php echo $config['General']['name'];?>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="upload_menu.php">Espace Upload</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../index.php">Menu Stockpotatoes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../administrateur/login_administrateur.php">Espace Administrateur</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../enseignant/login_enseignant.php">Espace Enseignant</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Espace Upload
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="upload_menu.php">Espace Upload</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="upload_hotpot.php">Envoyer un exercice Hotpotatoes</a>
								<a class="dropdown-item" href="modif_select.php">Ajouter des fichiers liés à un exercice Hotpotatoes (images, sons...)</a>
								<a class="dropdown-item" href="upload_divers.php">Envoyer un document autre ( Word, OpenOffice, Pdf ...)</a>
								<a class="dropdown-item" href="redac_online.php">Rédiger directement en ligne un document Web et le publier(éditeur)</a>
								<a class="dropdown-item" href="select_online.php">Ouvrir un document Web déjà publié et le modifier (éditeur)</a>
								<a class="dropdown-item" href="upload_url.php">Créer un lien hypertexte vers un document externe</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<div class="container">
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
							<p class="h3 bg-info text-center p-3" style="margin-top: 50px;"><?php echo $titre_page; ?></p>
						</div>
					</div>
					<div class="container jumbotron">