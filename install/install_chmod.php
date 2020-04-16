<?php
$fichier1='../Exercices/';
chmod($fichier1,0777);
$fichier2='../Connections/';
chmod($fichier2,0777);

?>
<html>
<head>
<title>Modification des droits en &eacute;criture</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p> <img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p>&nbsp;</p>
<p align="center" class="title"><font face="Verdana, Arial, Helvetica, sans-serif">Tentative 
  d'attribution des droits en &eacute;criture via un chmod 777</font></p>
<blockquote> 
  <div align="left">Les &eacute;l&eacute;ments concern&eacute;s sont :</div>
  <ul>
    <li> 
      <div align="left">Le dossier<strong> Exercices </strong></div>
    </li>
    <li> 
      <div align="left">Le fichier <strong>Connections/ gestion_pass.inc.php</strong> 
        (mots de passe)</div>
    </li>
    <li> 
      <div align="left">Le fichier <strong>Connections/ conn_intranet.php</strong> 
        (param&egrave;tres de connection)</div>
    </li>
  </ul>

  <p align="left">En cas de probl&egrave;me, (messages d'erreurs en haut de page), 
    il vous faudra attribuer<strong> ces droits manuellement</strong> ( avec votre 
    outil Ftp par exemple)</p>
</blockquote>
<p align="center"><br>
  <strong><a href="index.php">Retour &agrave; l'&eacute;tape 1</a> - <a href="install_etape2.php">Passer 
  &agrave; l'&eacute;tape 2</a>- </strong></p>
<p align="center"><strong><a href="index.php"><br>
  </a></strong><a href="install_etape2.php"> </a> </p>
<p>&nbsp; </p>
</body>
</html>
