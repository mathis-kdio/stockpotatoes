<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}

require_once('../Connections/conn_intranet.php'); 

if (isset($_POST['confirmation'])) {
  $deleteSQL = ("DELETE FROM stock_activite");
  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error());
  $deleteGoTo = "confirm_2_supp_activite_total.php";
    
header(sprintf("Location: %s", $deleteGoTo));

    
}
?>
<html>
<head>
<title>Confirmation Suprression toutes activit&eacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="45%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="55%"><p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center">&nbsp;</p>
      <p align="center"><strong>Etes vous bien s&ucirc;r de vouloir remettre &agrave; 
        blanc toute la base activit&eacute; de l'&eacute;tablissement ?</strong></p>
      <p align="center"> 
        <input name="Submit2" type="submit" onClick="MM_goToURL('parent','gestion_activite.php');return document.MM_returnValue" value="Non - Abandonner la suppression">
      </p>
      <form name="form1" method="post" action="confirm_1_supp_activite_total.php">
        <div align="center">
          <input name="confirmation" type="hidden" id="confirmation" value="oui">
          <input type="submit" name="Submit" value="Oui - Effacer la base activit&eacute;">
        </div>
      </form></td>
  </tr>
</table>

<p align="center">&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p>&nbsp;</p>
</body>
</html>
