<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Espace Administrateur</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p> <a href="../index.php"><img src="../patate.gif" width="53" height="45" border="0"></a> 
  <img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p><strong> <a href="../index.php">Accueil Stockpotatoes</a> - <a href="accueil_admin.php">Espace Administrateur</a> - Sauvegarde des exercices et de la base </strong></p>
<blockquote>
  <blockquote>
    <blockquote>
      <p>1 - Faire une copie des dossiers<strong> Exercices</strong> et<strong> Connections</strong></p>
      <p>2 - Faire une sauvegarde de votre base de donn&eacute;es. Pour cela, avec  PhpMyAdmin, cliquer sur Exporter puis en bas de page cocher <strong>Transmettre</strong> et en fin cliquer sur <strong>Ex&eacute;cuter</strong>. Mettre le fichier obtenu bien au chaud avec les dossiers Exercices et Connections.</p>
      <p>Evidemment, renouveler l'op&eacute;ration aussi souvent que possible. </p>
    </blockquote>
  </blockquote>
</blockquote>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
