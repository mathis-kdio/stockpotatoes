<?php 
if (isset($_POST['pass_administrateur'])) 
{
include("../Connections/gestion_pass.inc.php");
if ($_POST['pass_administrateur']==$pass_admin)
{
session_start();
$_SESSION['Sess_nom'] ='Administrateur';
header("Location: accueil_admin.php");
}
}
?> 
<html>
<head>
<title>Login Administrateur</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="top"> 
    <td width="38%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="62%"> <p><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p><strong>Espace administrateur</strong></p>
      <form name="form1" method="post" action="login_administrateur.php">
        <p>&nbsp;</p>
        <p align="center">Entrer votre mot de passe 
          <input name="pass_administrateur" type="password" id="pass_administrateur">
          <input type="submit" name="Submit" value="Valider">
        </p>
        <p>&nbsp; </p>
      </form>
	  <SCRIPT>document.form1.pass_administrateur.focus();</SCRIPT>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace 
  Enseignant</a> </p>
<p align="center"><a href="../upload/login_upload.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
