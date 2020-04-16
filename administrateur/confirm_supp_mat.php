<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Confirmation Suppression</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="42%"><img src="../patate.gif" width="226" height="232"></td>
    <td width="58%"> 
      <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p>&nbsp;</p>
      <form name="form1" method="post" action="">
        <div align="center"> 
          <p><strong><br>
            La mati&egrave;re &eacute;t&eacute; supprim&eacute;e</strong> </p>
          <p>&nbsp;</p>
        </div>
      </form>
      <p>&nbsp;</p>
      <p align="center"><a href="accueil_admin.php">Accueil administrateur</a></p>
      <p align="center"><a href="gestion_matiere_niveau.php">Gestion des niveaux 
        et mati&egrave;res</a></p>
      <p align="center"><a href="gestion_eleve.php">Gestion des &eacute;l&egrave;ves</a></p>
      <p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
        Enseignant</a></p>
      <p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
      <p>&nbsp;</p>
      <p></p>
</td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
