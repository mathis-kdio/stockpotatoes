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
		<link rel="stylesheet" type="text/css" media="all" href="includes/style.css" />
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
					<img src="images/patate.gif" width="30" height="30" class="d-inline-block align-top" alt="">
					Stockpotatoes
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
					    <li class="nav-item active">
					        <a class="nav-link" href="index.php">Accueil de l'installation <span class="sr-only">(current)</span></a>
					    </li>
					    <li class="nav-item">
					    	<a class="nav-link" href="licence.php">Licence</a>
						</li>
				    </ul>
				</div>
			</nav>
		</header>
		<div class="container">