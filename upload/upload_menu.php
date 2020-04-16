<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']=='Enseignant') { $_SESSION['Sess_nom']='Upload';}
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Envoi de documents sur le serveur</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr> 
    <td><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td><img src="../patate.jpg" width="324" height="39" align="top"> <p><strong>Mise &agrave; disposition  de documents sur le serveur </strong></p>
      <p>&nbsp;</p>
      <ul>
        <li><a href="upload_hotpot.php">Envoyer un exercice Hotpotatoes</a></li>
        <li><a href="modif_select.php">Ajouter des fichiers li&eacute;s &agrave; un exercice Hotpotatoes (images, sons...)</a></li>
        <li><a href="upload_divers.php">Envoyer un document autre ( Word, OpenOffice, Pdf ...)</a></li>
        <li><a href="redac_online.php">R&eacute;diger directement en ligne un document Web et le publier </a>(&eacute;diteur)</li>
        <li><a href="select_online.php">Ouvrir un document Web d&eacute;j&agrave; publi&eacute; et le modifier</a> (&eacute;diteur) </li>
        <li><a href="upload_url.php">Cr&eacute;er un lien hypertexte vers un document externe</a></li>
      </ul>      
    </table>
</table>
<div align="center">
  <p>&nbsp;</p>
  <p align="right"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a>  </p>
</div>
</body>
</html>
