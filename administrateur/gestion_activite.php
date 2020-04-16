<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsSupTotalActivite = "SELECT * FROM stock_activite";
$RsSupTotalActivite = mysqli_query($conn_intranet, $query_RsSupTotalActivite) or die(mysqli_error());
$row_RsSupTotalActivite = mysqli_fetch_assoc($RsSupTotalActivite);
$totalRows_RsSupTotalActivite = mysqli_num_rows($RsSupTotalActivite);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error());
$row_rsClasse = mysqli_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysqli_num_rows($rsClasse);
?>
<html>
<head>
<title>Gestion des activit&eacute;s</title>
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
<p><img src="../patate.gif" width="54" height="50"> <img src="../patate.jpg" width="324" height="39" align="top"> 
</p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_admin.php">Espace Administrateu</a>r - Gestion des 
    activit&eacute;s</strong></p>
<p>&nbsp;</p>
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="10">
  <tr valign="top"> 
    <td><p class="title">Liste des derni&egrave;res activit&eacute;s</p>
      <blockquote> 
        <p> 
          <input name="Submit2" type="submit" onClick="MM_goToURL('parent','../enseignant/liste_activite.php');return document.MM_returnValue" value="Lister les derni&egrave;res activit&eacute;s">
        </p>
      </blockquote>
      <p>&nbsp;</p></td>
  </tr>
  <tr valign="top"> 
    <td> <p class="title">Supprimer l'ensemble des activit&eacute;s d'une classe</p>
      <form name="form2" method="post" action="confirm_1_supp_activite_classe.php">
        <blockquote> 
          <p id="classe" name="classe"> 
            <select name="classe" id="classe">
              <?php
do {  
?>
              <option value="<?php echo $row_rsClasse['classe']?>"><?php echo $row_rsClasse['classe']?></option>
              <?php
} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
  $rows = mysqli_num_rows($rsClasse);
  if($rows > 0) {
      mysqli_data_seek($rsClasse, 0);
	  $row_rsClasse = mysqli_fetch_assoc($rsClasse);
  }
?>
            </select>
            <input type="submit" name="Submit" value="S&eacute;lectionner la classe">
          </p>
        </blockquote>
      </form>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
  <tr valign="top"> 
    <td> <p class="title">Supprimer toute la base activit&eacute; de l'&eacute;tablissement</p>
      <form name="form1" action="">
        <blockquote> 
          <p align="left"><strong>Attention</strong>, cela efface l'ensemble des 
            scores de tous l'&eacute;tablissement pour tous les exercices. Cette 
            op&eacute;ration peut &ecirc;tre utilis&eacute;e par exemple en d&eacute;but 
            d'ann&eacute;e scolaire.</p>
          <div align="left"> 
            <input name="suptotal" type="submit" id="suptotal" onClick="MM_goToURL('parent','confirm_1_supp_activite_total.php');return document.MM_returnValue" value="Supprimer la base  &quot;Activit&eacute;s&quot;">
          </div>
        </blockquote>
      </form>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
      <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($RsSupTotalActivite);

mysqli_free_result($rsClasse);
?>

