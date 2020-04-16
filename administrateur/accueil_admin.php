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
<p><strong> <a href="../index.php">Accueil Stockpotatoes</a> - Espace Administrateur</strong></p>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="middle" bgcolor="#CCCC99"> 
    <td> <blockquote> 
        <p><a href="gestion_matiere_niveau.php"><strong>Gestion des mati&egrave;res 
          et niveaux</strong></a></p>
      </blockquote></td>
    <td> <blockquote> 
        <p><a href="http://localhost/mysql/"><strong>Acc&egrave;s en intranet 
          &agrave; la base via PhpMyAdmin</strong></a> - ( <a href="aide_phpmyadmin.php">Aide</a>)</p>
      </blockquote></td>
  </tr>
  <tr valign="middle" bgcolor="#CCCC99"> 
    <td> <blockquote> 
        <p><strong><a href="gestion_eleve.php">Gestion des &eacute;l&egrave;ves</a></strong></p>
      </blockquote></td>
    <td> <blockquote> 
        <p><strong><a href="install_param3.php">Gestion des mots de passe</a></strong></p>
      </blockquote></td>
  </tr>
  <tr valign="middle" bgcolor="#CCCC99"> 
    <td><blockquote> 
        <p><a href="gestion_activite.php"><strong>Gestion des activit&eacute;s</strong></a></p>
      </blockquote></td>
    <td><blockquote> 
        <p><a href="../enseignant/config.php"><strong>Param&eacute;trage du Hotpotatoes 
          des enseignants </strong></a></p>
      </blockquote></td>
  </tr>
  <tr valign="middle" bgcolor="#CCCC99"> 
    <td><blockquote> 
        <p><strong><a href="../enseignant/liste_activite.php">Les derni&egrave;res 
          activit&eacute;s</a></strong></p>
      </blockquote></td>
    <td><blockquote> 
        <p><a href="install_param.php"><strong>Param&eacute;trage de la connexion 
          &agrave; la base de donn&eacute;es</strong></a></p>
      </blockquote></td>
  </tr>
  <tr valign="middle" bgcolor="#CCCC99">
    <td><blockquote>
      <p><a href="../enseignant/accueil_enseignant.php"><strong>Espace Enseignant</strong></a> - <a href="../index.php"><strong>Espace El&egrave;ve</strong></a> - <strong> <a href="../documentation.htm" target="_blank">Documentation </a></strong></p>
    </blockquote></td>
    <td><blockquote>
      <p><a href="../install/install_editeur.php"><strong>Param&eacute;trage de l'&eacute;diteur en ligne </strong></a></p>
      <p><a href="aide_editeur.php"><strong>Aide sur le fonctionnement de l'&eacute;diteur</strong></a><br>
      </p>
      </blockquote></td>
  </tr>
  <tr valign="middle" bgcolor="#CCCC99"> 
    <td><blockquote> 
        <p><strong><a href="../upload/upload_menu.php">Envoyer un exercice ou un document</a></strong></p>
      </blockquote></td>
    <td><blockquote> 
        <p><a href="sauvegarde.php"><strong>Sauvegarde de Stockpotatoes</strong></a> </p>
      </blockquote></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
