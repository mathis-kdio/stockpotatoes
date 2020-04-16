<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php
include("../Connections/conn_intranet.php");
?>
<html>
<head>
<title>Paramètres de connexion à la base de donnée</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><img src="../patate.gif" width="54" height="46"> <img src="../patate.jpg" width="324" height="39" align="top"> 
</p>
<p><b><a href="accueil_admin.php">Espace Administrateu</a>r - Param&eacute;trages 
  de la connexion &agrave; la base de donn&eacute;es</b> </p>
<form name="parametres" method="post" action="install_param2.php">
  <table border="0" align="center" cellspacing="3" cellpadding="5">
    <br>
    <tr> 
      <td colspan="2" align="center"><div align="left"><br>
          <br>
          <br>
        </div></td>
    </tr>
    <tr> 
      <td width="50%"><b>Serveur MySQL:</b><br>
        Adresse IP ou URL de votre serveur de bases de données MySQL. La valeur 
        localhost conviendra dans le cas d'un Intranet</td>
      <td width="50%"><input type="texte" name="serveur" size="25" maxlength="80" value="<?php  echo $hostname_conn_intranet ?>"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Nom d'utilisateur MySQL :</b></td>
      <td width="50%"><input type="text" name="login" size="25" maxlength="80" value="<?php  echo $username_conn_intranet ?>"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Mot de passe MySQL :</b></td>
      <td width="50%"> <input type="password" name="password" size="25" maxlength="80" value="<?php  echo $password_conn_intranet ?>"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Nom de la base de données :</b></td>
      <td width="50%"> <input name="base" type="text" id="base"  size="25" maxlength="80" value="<?php  echo $database_conn_intranet ?>"></td>
    </tr>
    <tr> 
      <td colspan="2"><br> <br></td>
    </tr>
    <tr> 
      <td colspan="2" align="center"><input type="submit" name="verif" value="Enregistrer ces param&egrave;tres" ></td>
    </tr></tr>
  </table>
</form>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
</body>
</html>
