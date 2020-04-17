<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
$choixcategorie_Rscategorie = "0";
if (isset($_POST['ID_categorie'])) {
  $choixcategorie_Rscategorie = (get_magic_quotes_gpc()) ? $_POST['ID_categorie'] : addslashes($_POST['ID_categorie']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rscategorie = sprintf("SELECT * FROM stock_categorie WHERE stock_categorie.ID_categorie=%s", $choixcategorie_Rscategorie);
$Rscategorie = mysqli_query($conn_intranet, $query_Rscategorie) or die(mysqli_error());
$row_Rscategorie = mysqli_fetch_assoc($Rscategorie);
$totalRows_Rscategorie = mysqli_num_rows($Rscategorie);

$choixcategorie_RsQuiz = "0";
if (isset($_POST['ID_categorie'])) {
  $choixcategorie_RsQuiz = (get_magic_quotes_gpc()) ? $_POST['ID_categorie'] : addslashes($_POST['ID_categorie']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsQuiz = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.categorie_ID=%s", $choixcategorie_RsQuiz);
$RsQuiz = mysqli_query($conn_intranet, $query_RsQuiz) or die(mysqli_error());
$row_RsQuiz = mysqli_fetch_assoc($RsQuiz);
$totalRows_RsQuiz = mysqli_num_rows($RsQuiz);
?>
<html>
<head>
<title>Suppression d'un th&egrave;me &gt; V&eacute;rification</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  <tr valign="top"> 
    <td><img src="../patate.gif" width="253" height="227"></td>
    <td><p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center"><strong>Suppression de la catégorie <?php echo $row_Rscategorie['nom_categorie']; ?></strong></p>
      <p align="center">Le tableau ci-dessous affiche les &eacute;ventuels exercices 
        li&egrave;s &agrave; cette catégorie.</p>
      <p align="center">La suppression cette catégorie entrainera leur r&eacute;affectation 
        dans la catégorie &quot;<strong>Divers</strong>&quot;</p>
      <form name="form1" method="post" action="confirm_supp_categorie.php">
        <div align="center"> 
          <input type="submit" name="Submit3" value="Confirmer la suppression">
          <input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_Rscategorie['ID_categorie'] ?>">
        </div>
      </form>
      <p align="center">&nbsp; </p>
      <p align="center"> 
        <input name="Submit2" type="submit" onClick="MM_goToURL('parent','gestion_categorie.php');return document.MM_returnValue" value="Abandonner">
      </p>
      <p align="center">&nbsp;</p>
      <table border="1" align="center">
        <tr bgcolor="#CCCC99" class="retrait20"> 
          <td> <div align="center"><strong>N&deg;</strong></div></td>
          <td> <div align="center"><strong>Titre de l'exercice</strong></div></td>
          <td> <div align="center"><strong>Fichier</strong></div></td>
          <td> <div align="center"><strong>Auteur</strong></div></td>
        </tr>
        <?php do { ?>
        <tr class="retrait20"> 
          <td><?php echo $row_RsQuiz['ID_quiz']; ?></td>
          <td class="retrait20"><?php echo $row_RsQuiz['titre']; ?></td>
          <td class="retrait20"><?php echo $row_RsQuiz['fichier']; ?></td>
          <td class="retrait20"><?php echo $row_RsQuiz['auteur']; ?></td>
        </tr>
        <?php } while ($row_RsQuiz = mysqli_fetch_assoc($RsQuiz)); ?>
      </table>
      <p align="center">&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($Rscategorie);

mysqli_free_result($RsQuiz);
?>

