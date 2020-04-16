<?php 
if (isset($_POST['pass_upload'])) 
{
include("../Connections/gestion_pass.inc.php");

if ($_POST['pass_upload']==$pass_upload)
{
session_start();
$_SESSION['Sess_nom'] = 'Upload';
header("Location: upload_menu.php");
}
}
?> 
<html>
<head>
<title>Mettre un exercice en ligne</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr> 
    <td><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td><img src="../patate.jpg" width="324" height="39" align="top"> <p><strong>Mettre 
        un document ou un exercice Hotpotatoes en ligne</strong></p>
      <p>&nbsp;</p>
      <form name="form1" method="post" action="login_upload.php">
        <p>&nbsp;</p>
        <blockquote> 
          <p>Entrer votre mot de passe 
            <input name="pass_upload" type="password" id="pass_upload2">
            <input type="submit" name="Submit" value="Envoyer">
          </p>
        </blockquote>
        <p>&nbsp; </p>
      </form>
<SCRIPT>document.form1.pass_upload.focus();</SCRIPT>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p align="right"><a href="../index.php">Accueil StockPotatoes</a> -<a href="../enseignant/login_enseignant.php"> Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
</body>
</html>
