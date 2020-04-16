<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Suppression d'un exercice &gt; Confirmation</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="40%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="60%"><div align="center">
        <p><img src="../patate.jpg" width="324" height="39" align="top"></p>
        <p>&nbsp;</p>
        <form name="form1" method="post" action="">
          <div align="center"> 
            <p><strong><br>
              L'exercice a &eacute;t&eacute; supprim&eacute;</strong></p>
            <p>&nbsp;</p>
          </div>
        </form>
        <p><a href="gestion_exos.php"><strong>Retour Gestion des exercices</strong></a></p>
        <p><a href="../index.php"><strong>Accueil Stockpotatoes</strong></a> - <strong><a href="accueil_enseignant.php">Espace Enseignant</a></strong></p>
        <p><strong><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
              sur le serveur</a></strong></p>
    </div></td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
