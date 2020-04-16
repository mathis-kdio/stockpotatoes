<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php 

require_once('../Connections/conn_intranet.php'); 

function sans_accent($chaine) 
{ 
   $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
   return strtr(trim($chaine),$accent,$noaccent); 
} 

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);

$choix_mat_rsListeSelectMatiereNiveau = "0";
if (isset($_POST['matiere_ID'])) {
  $choix_mat_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
$choix_niv_rsListeSelectMatiereNiveau = "0";
if (isset($_POST['niveau_ID'])) {
  $choix_niv_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_POST['niveau_ID'] : addslashes($_POST['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s AND stock_quiz.en_ligne<>'O' AND stock_quiz.avec_score<>'O' ORDER BY stock_quiz.matiere_ID, stock_quiz.niveau_ID", $choix_mat_rsListeSelectMatiereNiveau,$choix_niv_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error());
$row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysqli_num_rows($rsListeSelectMatiereNiveau);

$colname_rsChoix = "1";
if (isset($_POST['matiere_ID'])) {
  $colname_rsChoix = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat =%s", $colname_rsChoix);
$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error());
$row_rsChoix = mysqli_fetch_assoc($rsChoix);
$totalRows_rsChoix = mysqli_num_rows($rsChoix);

$colname_rsChoix2 = "1";
if (isset($_POST['niveau_ID'])) {
  $colname_rsChoix2 = (get_magic_quotes_gpc()) ? $_POST['niveau_ID'] : addslashes($_POST['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_rsChoix2);
$rsChoix2 = mysqli_query($conn_intranet, $query_rsChoix2) or die(mysqli_error());
$row_rsChoix2 = mysqli_fetch_assoc($rsChoix2);
$totalRows_rsChoix2 = mysqli_num_rows($rsChoix2);
?>
<html>
<head>
<title>Liste des exercices non encore publi&eacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><img src="../patate.jpg" width="324" height="39"></p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php">Espace enseignant</a> - Liste des 
    exercices publi&eacute;s non encore publi&eacute;s en ligne</strong></p>
<p align="right">&nbsp;</p>
<form name="form1" method="post" action="liste_quiz_non_publie.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="31%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (!(strcmp($row_rs_matiere['ID_mat'], $row_rsChoix['ID_mat']))) {echo "SELECTED";} ?>><?php echo $row_rs_matiere['nom_mat']?></option>
            <?php
} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere));
  $rows = mysqli_num_rows($rs_matiere);
  if($rows > 0) {
      mysqli_data_seek($rs_matiere, 0);
	  $row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
  }
?>
          </select>
        </div></td>
      <td width="22%"><div align="center"> 
          <select name="niveau_ID" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (!(strcmp($row_rs_niveau['ID_niveau'], $row_rsChoix2['ID_niveau']))) {echo "SELECTED";} ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
            <?php
} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau));
  $rows = mysqli_num_rows($rs_niveau);
  if($rows > 0) {
      mysqli_data_seek($rs_niveau, 0);
	  $row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
  }
?>
          </select>
        </div></td>
      <td width="47%"><input type="submit" name="Submit" value="Valider"></td>
    </tr>
  </table>
</form>
<?php if (isset($_POST['matiere_ID'])) {  ?>
<table border="1">
  <tr> 
    <td bgcolor="#cccc99"> <div align="center"><strong>N&deg; Ex.</strong></div></td>
    <td bgcolor="#cccc99"> <div align="center"><strong>Titre</strong></div></td>
    <td bgcolor="#cccc99"> <div align="center"><strong>Fichier</strong></div></td>
    <td bgcolor="#cccc99"> <div align="center"><strong>Auteur</strong></div></td>
    <td bgcolor="#cccc99"><div align="center"><strong>En entra&icirc;nement</strong></div></td>
    <td bgcolor="#cccc99"> <div align="center"><strong>En &eacute;valuation</strong></div></td>
  </tr>
  <?php do { 
  $matiere=sans_accent($row_rsChoix['nom_mat']);
  ?>
  <tr> 
    <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
    <td class="retrait20"><a href="<?php echo '../Exercices/'.$matiere.'/q'.$row_rsListeSelectMatiereNiveau['ID_quiz']; ?>/<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></td>
    <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?></td>
    <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?></td>
    <td><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></td>
    <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
  </tr>
  <?php } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
</table>
<?php } ?>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($rs_matiere);

mysqli_free_result($rs_niveau);

mysqli_free_result($rsListeSelectMatiereNiveau);

mysqli_free_result($rsChoix);

mysqli_free_result($rsChoix2);
?>

  