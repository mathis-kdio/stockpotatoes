<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php
include("../Connections/gestion_pass.inc.php");
?>


<html>
<head>
<title>Gestion des mots de passe</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><a href="../index.php"><img src="../patate.gif" width="54" height="46" border="0"></a> 
  <img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p><b>Gestion des mots de passe</b></p>
<form name="parametres" method="post" action="install_param4.php">
  <table border="0" align="center" cellspacing="3" cellpadding="5">
    <br>
    <tr> 
      <td width="50%"><b>Envoi de fichiers sur le serveur</b><br> </td>
      <td width="50%"><input name="pass_upload" type="texte" id="pass_upload" value="<?php  echo $pass_upload ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Espace Enseignant</b></td>
      <td width="50%"><input name="pass_profs" type="text" id="pass_profs" value="<?php  echo $pass_profs ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Espace administrateur</b></td>
      <td width="50%"> <input name="pass_admin" type="text" id="pass_admin" value="<?php  echo $pass_admin?>" size="25" maxlength="80" ></td>
    </tr>
    <tr> 
      <td colspan="2" align="center"><input type="submit" name="verif" value="Enregistrer ces mots de passe" ></td>
    </tr></tr>
  </table>
</form>
<p align="center">&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
</body>
</html>
