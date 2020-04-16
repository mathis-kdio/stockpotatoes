<?php 
if (isset($_POST['pass_enseignant'])) 
{
include("../Connections/gestion_pass.inc.php");
if ($_POST['pass_enseignant']==$pass_profs)
{
session_start();
$_SESSION['Sess_nom'] = 'Enseignant';
header("Location: accueil_enseignant.php");
}
}
?> 
<html>
<head>
<title>Login Enseignant</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="top"> 
    <td width="38%"><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td width="62%"> <p><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p><strong><a href="../index.php">Accueil Stockpotatoes</a>  - Espace Enseignant</strong></p>
      <p>&nbsp;</p>
      <form name="form1" method="post" action="login_enseignant.php">
        <p>&nbsp;</p>
        <p align="center">Entrer votre mot de passe 
          <input name="pass_enseignant" type="password" id="pass_enseignant">
          <input type="submit" name="Submit" value="Valider">
        </p>
        <p>&nbsp; </p>
      </form>
	 <SCRIPT>document.form1.pass_enseignant.focus();</SCRIPT>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p align="right"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a> - <a href="../upload/login_upload.php">Envoyer un exercice ou un document 
sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>