<?php
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php echo $meta_description ?>" />
		<meta name="keywords" content="<?php echo $meta_keywords ?>" />
		<meta name="author" content="stockpotatoes" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- Mon CSS -->
		<link rel="stylesheet" type="text/css" media="all" href="include/styleAdministrateur.css" />
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

		<title><?php echo $titre_page ?></title>
	</head>
	<body class="">	
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
				<a class="navbar-brand" href="#">
					<img src="../patate.gif" width="30" height="30" class="d-inline-block align-top" alt="">
					Stockpotatoes
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="accueil_admin">Espace Administrateur</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../index.php">Menu Stockpotatoes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../enseignant/login_enseignant.php">Espace Enseignant</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Espace Upload
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="../upload/login_upload.php">Espace Upload</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="../upload/upload_hotpot.php">Envoyer un exercice Hotpotatoes</a>
								<a class="dropdown-item" href="../upload/modif_select.php">Ajouter des fichiers liés à un exercice Hotpotatoes (images, sons...)</a>
								<a class="dropdown-item" href="../upload/upload_divers.php">Envoyer un document autre ( Word, OpenOffice, Pdf ...)</a>
								<a class="dropdown-item" href="../upload/redac_online.php">Rédiger directement en ligne un document Web et le publier(éditeur)</a>
								<a class="dropdown-item" href="../upload/select_online.php">Ouvrir un document Web déjà publié et le modifier (éditeur)</a>
								<a class="dropdown-item" href="../upload/upload_url.php">Créer un lien hypertexte vers un document externe</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<div class="container">