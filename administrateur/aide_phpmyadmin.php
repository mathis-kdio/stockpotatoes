<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Aide PhpMyAdmin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="34%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="66%"> <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center">&nbsp;</p>
      <p align="center" class="title"><font face="Arial, Helvetica, sans-serif">Aide 
        Acc&egrave;s via PhpMyAdmin</font></p>
      <p>Le lien <a href="http://localhost/mysql/"><strong>Acc&egrave;s en intranet 
        &agrave; la base via PhpMyAdmin</strong></a> ne fonctionne qu'en intranet. 
        Il permet de lancer PhpMyAdmin pour un serveur install&eacute; par defaut 
        tel EasyPhp.</p>
      <p>Il pointe vers http://localhost/mysql/</p>
      <p>Si vous utilisez Free, vous devez aller &agrave; l'adresse <a href="http://sql.free.fr">http://sql.free.fr</a> 
        puis saisir votre login et mot de passe.</p>
      <p> <font color="#990000"><strong>Attention !</strong></font></p>
      <p><font color="#990033"><strong>PhpMyAdmin doit rester un outil de contr&ocirc;le 
        en cas de probl&egrave;mes. Supprimer des enregistrements peut cr&eacute;er 
        des incoh&eacute;rences entre les tables et les fichiers du dossier Exercices. 
        </strong></font></p>
      <p align="right"><a href="accueil_admin.php">Retour</a></p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
