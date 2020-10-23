<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('includes/yml.class.php');

$config = new Lire('includes/config.yml');
$config = $config->GetTableau();

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php
		//Check si couleur personnalisée pour cette matière et ce niveau
		if (isset($matiereId) && isset($niveauId)) {
			$colorElementShow = explode (";", $config['espaceEleve']['color']);
			for ($i = 0; $i < count($colorElementShow); $i++) { 
				$colorElementItemShow[$i] = explode (",", $colorElementShow[$i]);
				if (isset($colorElementItemShow[$i][0]) && $colorElementItemShow[$i][0] == $matiereId && isset($colorElementItemShow[$i][1]) && $colorElementItemShow[$i][1] == $niveauId) {
					$colormain = $colorElementItemShow[$i][2];
					$colorsecond = $colorElementItemShow[$i][3];
					$colorhover = $colorElementItemShow[$i][4];
					$colorfocus = $colorElementItemShow[$i][5];
					break;
				}
			}
		}
		if (!isset($colormain)) {
			$colormain = $config["color"]["theme"]["main"];
			$colorsecond = $config["color"]["theme"]["second"];
			$colorhover = $config["color"]["theme"]["hover"];
			$colorfocus = $config["color"]["theme"]["focus"];
		}	?>
		<style>
		:root {
			--color-main: <?=$colormain?>;
			--color-second: <?=$colorsecond?>; 
			--color-hover: <?=$colorhover?>; 
			--color-focus: <?=$colorfocus?>; 
		}
		</style>
			<!-- Required meta tags -->
		<meta name="theme-color" content="<?=$config["color"]["theme"]["main"];?>">
		<meta name="msapplication-navbutton-color" content="<?=$config["color"]["theme"]["main"];?>">
		<meta name="apple-mobile-web-app-statut-bar-style" content="<?=$config["color"]["theme"]["main"];?>">
		<meta name="apple-mobile-web-app-capable" content="<?=$config["color"]["theme"]["main"];?>">

		<meta property="og:title" content="<?=$config['General']['name']?>">
		<meta property="og:type" content="website" />
		<meta property="og:image:alt" content="<?=$config['General']['description']?>">
		<meta property="og:description" content="<?=$config['General']['description']?>">
		<meta property="og:site_name" content="<?=$config['General']['name']?>" />

		<meta name="twitter:title" content="<?=$config['General']['name']?>">
		<meta name="twitter:description" content="<?=$config['General']['description']?>">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php echo $meta_description; ?>" />
		<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
		<meta name="author" content="Stockpotatoes" />

		<link rel="stylesheet" type="text/css" media="all" href="includes/bootstrap.min.css" />

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
					<img src="patate.gif" width="30" height="30" class="d-inline-block align-top" alt="">
					<?php echo $config['General']['name'];?>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="#">Accueil<span class="sr-only">(actuel)</span></a>
						</li>
						<?php
						$str_arr = explode (";", $config['navBar']['espaceEleve']);
						for ($i = 0; $i < count($str_arr); $i++) { 
							$str_arr2[$i] = explode (",", $str_arr[$i]);  
						}
						$i = 0;
						for ($i = 0; $i < count($str_arr); $i++) { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo $str_arr2[$i][2];?>"><?php echo $str_arr2[$i][1];?></a>
							</li>
							<?php
						} ?>
					</ul>
				</div>
			</nav>
		</header>
		<div class="container-fluid">