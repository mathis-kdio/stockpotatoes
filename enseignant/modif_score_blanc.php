<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?> 
<?php

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error());
$row_rsClasse = mysqli_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysqli_num_rows($rsClasse);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMatiere = "SELECT * FROM stock_matiere";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error());
$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysqli_num_rows($RsMatiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error());
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysqli_num_rows($RsNiveau);

$colname1_Rsquiz = "0";
if (isset($_POST['ID_mat'])) {
  $colname1_Rsquiz = (get_magic_quotes_gpc()) ? $_POST['ID_mat'] : addslashes($_POST['ID_mat']);
}
$colname2_Rsquiz = "0";
if (isset($_POST['ID_niveau'])) {
  $colname2_Rsquiz = (get_magic_quotes_gpc()) ? $_POST['ID_niveau'] : addslashes($_POST['ID_niveau']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s AND stock_quiz.niveau_ID=%s", $colname1_Rsquiz,$colname2_Rsquiz);
$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error());
$row_Rsquiz = mysqli_fetch_assoc($Rsquiz);
$totalRows_Rsquiz = mysqli_num_rows($Rsquiz);

$varquiz_RsActiviteClasse = "0";
if (isset($_POST['ID_quiz'])) {
  $varquiz_RsActiviteClasse = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
$varchoixclasse_RsActiviteClasse = "0";
if (isset($_POST['classe'])) {
  $varchoixclasse_RsActiviteClasse = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsActiviteClasse = sprintf("SELECT * FROM stock_activite,stock_eleve WHERE stock_activite.quiz_ID=%s AND stock_activite.nom_classe='%s'  AND stock_activite.eleve_ID=stock_eleve.ID_eleve ORDER BY stock_eleve.nom, stock_eleve.prenom ", $varquiz_RsActiviteClasse,$varchoixclasse_RsActiviteClasse);
$RsActiviteClasse = mysqli_query($conn_intranet, $query_RsActiviteClasse) or die(mysqli_error());
$row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse);
$totalRows_RsActiviteClasse = mysqli_num_rows($RsActiviteClasse);
?>
<html>
<head>
<title>Effacer les r&eacute;sultats d'un exercice</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body>
<div id="Layer1" style="position:absolute; width:365px; height:162px; z-index:1; left: 499px; top: 9px;"> 
  <p align="left"><img src="../patate.gif" width="120" height="107"> </p>
  <p><img src="../patate.jpg" width="324" height="39" align="top"></p>
  <p><strong><a href="accueil_enseignant.php">Espace Enseignant</a> - Effacer 
    les r&eacute;sultats d'un exercice</strong></p>
</div>
<table width="46%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="50%">&nbsp;</td>
    <td width="50%"><form name="form2" method="post" action="modif_score_blanc.php">
        <div align="right"> 
          <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="17%"> <div align="left"> </div></td>
              <td width="60%"> <select name="classe" id="select10">
                  <option value="classe" <?php if (isset($_POST['classe'])) { if (!(strcmp("classe", $_POST['classe']))) {echo "SELECTED";} }?>>Sélectionner 
                  votre classe</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) {if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";} }?>><?php echo $row_rsClasse['classe']?></option>
                  <?php
} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
  $rows = mysqli_num_rows($rsClasse);
  if($rows > 0) {
      mysqli_data_seek($rsClasse, 0);
	  $row_rsClasse = mysqli_fetch_assoc($rsClasse);
  }
?>
                </select> </td>
              <td width="11%"> <div align="left"> </div></td>
              <td width="12%"> <div align="left"> 
                  <input type="submit" name="Submit2" value="Validez">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>
  <?php  if (isset($_POST['classe'])) {?>
  <tr> 
    <td height="63"></td>
    <td><form name="form4" method="post" action="modif_score_blanc.php">
        <div align="right"> 
          <table width="71%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="36%"><div align="left"> 
                  <select name="ID_mat" id="select11">
                    <option value="ID_mat" <?php if (isset($_POST['ID_mat'])) { if (!(strcmp("ID_mat", $_POST['ID_mat']))) {echo "SELECTED";}} ?>>Sélectionnez 
                    la matière</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($_POST['ID_mat'])) { if (!(strcmp($row_RsMatiere['ID_mat'], $_POST['ID_mat']))) {echo "SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
                    <?php
} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere));
  $rows = mysqli_num_rows($RsMatiere);
  if($rows > 0) {
      mysqli_data_seek($RsMatiere, 0);
	  $row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
  }
?>
                  </select>
                </div></td>
              <td width="14%"><div align="left"> 
                  <select name="ID_niveau" id="select7">
                    <option value="ID_niveau" <?php if (isset($_POST['ID_niveau'])) { if (!(strcmp("ID_niveau", $_POST['ID_niveau']))) {echo "SELECTED";} }?>>Selectionnez 
                    le niveau</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($_POST['ID_niveau'])) { if (!(strcmp($row_RsNiveau['ID_niveau'], $_POST['ID_niveau']))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
                    <?php
} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
  $rows = mysqli_num_rows($RsNiveau);
  if($rows > 0) {
      mysqli_data_seek($RsNiveau, 0);
	  $row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
  }
?>
                  </select>
                </div></td>
              <td width="50%"><div align="left"> 
                  <input name="classe" type="hidden" id="classe4" value="<?php echo $_POST['classe']?>">
                  <input type="submit" name="Submit3" value="Validez">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>
  <?php  if (isset($_POST['ID_mat'])) { ?>
  <tr> 
    <td></td>
    <td><form name="form1" method="post" action="modif_score_blanc.php">
        <div align="right"> 
          <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="17%"><div align="left"> 
                  <input name="ID_mat" type="hidden" id="ID_mat3" value="<?php echo $_POST['ID_mat']?>">
                  <input name="ID_niveau" type="hidden" id="ID_niveau3" value="<?php echo $_POST['ID_niveau']?>">
                  <input name="classe" type="hidden" id="classe5" value="<?php echo $_POST['classe']?>">
                </div></td>
              <td width="60%"> <div align="left"> 
                  <select name="ID_quiz" id="select8">
                    <option value="ID_quiz" <?php if (isset($_POST['ID_quiz'])) { if (!(strcmp("ID_quiz", $_POST['ID_quiz']))) {echo "SELECTED";} }?>>Sélectionnez 
                    votre quiz</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_Rsquiz['ID_quiz']?>"<?php if (isset($_POST['ID_quiz'])) { if (!(strcmp($row_Rsquiz['ID_quiz'], $_POST['ID_quiz']))) {echo "SELECTED";} }?>><?php echo $row_Rsquiz['titre']?></option>
                    <?php
} while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz));
  $rows = mysqli_num_rows($Rsquiz);
  if($rows > 0) {
      mysqli_data_seek($Rsquiz, 0);
	  $row_Rsquiz = mysqli_fetch_assoc($Rsquiz);
  }
?>
                  </select>
                </div></td>
              <td width="11%"><div align="left"></div></td>
              <td width="12%"> <div align="left"> 
                  <input type="submit" name="Submit" value="Valider">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>
</table>
<?php if (isset($_POST['ID_quiz'])) { ?>
<p align="right"> 
  <SCRIPT LANGUAGE="JavaScript">
<!-- Begin
if (window.print) {
document.write('<form><FONT FACE="Arial,Helvetica"><FONT SIZE=2><FONT COLOR="#000000">Cliquez pour imprimer cette page    '
+ '<input type=button name=print value="Imprimer" '
+ 'onClick="javascript:window.print()">     </form>');
}
// End -->
</script>
</p>
<p align="left">&nbsp;</p>
<form name="form3" method="post" action="modif_score_blanc_confirm.php">
  <div align="center">
    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $_POST['ID_quiz']?>">
    <input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
    <input type="submit" name="Submit4" value="Supprimer les enregistrements de  r&eacute;sultats ci-dessous pour cet exercice dans cette classe">
  </div>
</form>
<p align="left">&nbsp;</p>
<table border="1" align="center">
  <tr bgcolor="#cccc99"> 
    <td><div align="center"><strong>N&deg; El&egrave;ve</strong></div></td>
    <td><div align="center"><strong>Nom</strong></div></td>
    <td><div align="center"><strong>Classe</strong></div></td>
    <td><div align="center"><strong>N&deg; Exercice</strong></div></td>
    <td><div align="center"><strong>R&eacute;sultats</strong></div></td>
    <td><div align="center"><strong>Date</strong></div></td>
  </tr>
  <?php do { ?>
  <tr> 
    <td ><?php echo $row_RsActiviteClasse['eleve_ID']; ?></td>
    <td><?php echo $row_RsActiviteClasse['nom']; ?> <?php echo $row_RsActiviteClasse['prenom']; ?></td>
    <td><?php echo $row_RsActiviteClasse['nom_classe']; ?></td>
    <td><?php echo $row_RsActiviteClasse['quiz_ID']; ?></td>
    <td><?php echo $row_RsActiviteClasse['score']; ?></td>
    <td><?php echo $row_RsActiviteClasse['debut']; ?></td>
  </tr>
  <?php } while ($row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse)); ?>
</table>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<?php } } }?>
</body>
</html>
<?php
mysqli_free_result($rsClasse);
mysqli_free_result($RsMatiere);
mysqli_free_result($RsNiveau);
mysqli_free_result($Rsquiz);
mysqli_free_result($RsActiviteClasse);
?>

