<?php
session_start();
//session_destroy();
unset($_SESSION['Sess_nom']);
unset($_SESSION['Sess_prenom']);
unset($_SESSION['Sess_classe']);
unset($_SESSION['Sess_ID_eleve']);
unset($_SESSION['Sess_ID_quiz']);
unset($_SESSION['matiere_ID']);
unset($_SESSION['niveau_ID']);
unset($_SESSION['theme_ID']);
unset($_SESSION['nom_mat']);
?>
<html>
<head>
<title>Stockpotatoes - Le distributeur de patates</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Style1 {font-size: xx-small}
-->
</style>
</head>
<body>
<p><img src="patate.gif" width="253" height="227"> </p>
<div id="Layer1" style="position:absolute; width:353px; height:115px; z-index:1; left: 363px; top: 111px;"> 
  <p align="center" class="title"> <font face="Arial, Helvetica, sans-serif">Le 
    distributeur de patates chaudes</font></p>
  <p class="big">&nbsp;</p>
  <ul>
    <li class="big"><a href="login_eleve.php">Acc&egrave;s aux documents en mode identifi&eacute; - Evaluation</a></li>
    <li class="big"><a href="accueil_visiteur.php"> Acc&egrave;s aux documents en mode visiteur - Entrainement</a></li>
    <li><a href="upload/login_upload.php">Envoyer un exercice ou un document sur 
      le serveur</a></li>
    <li class="big"><a href="administrateur/login_administrateur.php">Administrateur</a></li>
    <li class="big"><a href="enseignant/login_enseignant.php">Enseignant</a></li>
  </ul>
  <p>&nbsp;</p>
</div>
<div id="Layer2" style="position:absolute; width:200px; height:47px; z-index:2; left: 362px; top: 46px;"><img src="patate.jpg" width="324" height="39" align="top"></div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="right"><span class="Style1">Ver 3 Alpha 1 - 04/04/2020</span></div>
</body>
</html>
