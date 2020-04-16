<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Aide Editeur FCEDITOR</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="28%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="72%"> <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center">&nbsp;</p>
      <p align="center" class="title"><font face="Arial, Helvetica, sans-serif">Aide sur le focntionnement de l'
        Editeur</font></p>
      <p>L'&eacute;diteur int&eacute;gr&eacute; est <a href="http://www.fckeditor.net">FckEditor</a>. Son adaptation pour Stockpotatoes est expliqu&eacute;e ci-dessous. </p>
      <p class="subtitle">Comment se fait un enregistrement ?</p>
      <ul>
        <li>L'utilisateur clique sur <strong>Enregistrer ce document </strong></li>
        <li>L'insertion de texte, de liens et d'images a g&eacute;n&egrave;r&eacute; du code HTML qui est enregistr&eacute; dans le fichier temporaire <strong>Exercices/temp.htm</strong></li>
        <li>Les images int&eacute;gr&eacute;es dans le document sont encore pr&eacute;sentes dans le dossier<strong> Exercices/UserFiles/Image</strong></li>
        <li>Ce chemin relatif est alors supprim&eacute; dans le code Html. </li>
        <li>L'utilisateur remplit la fiche d'enregistrement et la valide.</li>
        <li>Le fichier <strong>Exercices/temp.htm</strong> est  copi&eacute; dans le dossier Mati&egrave;re correspondant et les images pr&eacute;sentes dans <strong>Exercices/UserFiles/Image</strong> sont alors d&eacute;plac&eacute;es dans ce dossier.</li>
        <li>Rq : Les smiley ne sont pas copi&eacute;s et gardent leur liens relatifs. A &eacute;viter donc ... </li>
        <li>Lors d'une modification de document, le processus inverse est effectu&eacute;.</li>
        <li>Copie du fichier sous le nom <strong>temp.htm</strong>, copie des images dans <strong>Exercices/UserFiles/Image</strong>, modification du code pour remettre les chemins des dossiers temporaires... </li>
      </ul>      <p>&nbsp; </p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace 
  Enseignant</a> -<a href="login_administrateur.php"> Espace Administrateur</a></p>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
