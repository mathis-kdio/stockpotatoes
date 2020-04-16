<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Confirmation Suppression</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="45%"><img src="../patate.gif" width="253" height="227"> </td>
    <td width="55%"><p align="center"><strong><img src="../patate.jpg" width="324" height="39" align="top"></strong></p>
      <p align="center">&nbsp;</p>
      <p align="center"><strong>La r&eacute;initialisation de l'ensemble de la 
        base activit&eacute; &agrave; &eacute;t&eacute; effectu&eacute;e</strong></p>
      <p>&nbsp;</p>
      <p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
        Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
      <p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
</td>
  </tr>
</table>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
