<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']=='Enseignant') { $_SESSION['Sess_nom']='Upload';}
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>
<?php 
require_once('../Connections/conn_intranet.php'); 
require_once('../Connections/conn_editeur.inc.php'); 

function sans_accent($chaine) 
{ 
   $accent  ="��������������������������������������������������������������"; 
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
   return strtr(trim($chaine),$accent,$noaccent); 
} 

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

mysqli_select_db($conn_intranet), $database_conn_intranet);
$query_RsMaxId_quiz = "SELECT MAX( Id_quiz )  FROM stock_quiz";
$RsMaxId_quiz = mysqli_query($conn_intranet), $query_RsMaxId_quiz) or die(mysqli_error());
$row_RsMaxId_quiz = mysqli_fetch_assoc($RsMaxId_quiz);
$totalRows_RsMaxId_quiz = mysqli_num_rows($RsMaxId_quiz);

mysqli_select_db($conn_intranet), $database_conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysqli_query($conn_intranet), $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);

mysqli_select_db($conn_intranet), $database_conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet), $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);
	
	
$choixmat_RsTheme = "0";
if (isset($_POST['matiere_ID'])) {
  $choixmat_RsTheme = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
$choixniv_RsTheme = "0";
if (isset($_POST['niveau_ID'])) {
  $choixniv_RsTheme = (get_magic_quotes_gpc()) ? $_POST['niveau_ID'] : addslashes($_POST['niveau_ID']);
}
mysqli_select_db($conn_intranet), $database_conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.theme", $choixmat_RsTheme,$choixniv_RsTheme);
$RsTheme = mysqli_query($conn_intranet), $query_RsTheme) or die(mysqli_error());
$row_RsTheme = mysqli_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysqli_num_rows($RsTheme);

$selection_RsChoixMatiere = "0";
if (isset($_POST['matiere_ID'])) {
  $selection_RsChoixMatiere = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
mysqli_select_db($conn_intranet), $database_conn_intranet);
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $selection_RsChoixMatiere);
$RsChoixMatiere = mysqli_query($conn_intranet), $query_RsChoixMatiere) or die(mysqli_error());
$row_RsChoixMatiere = mysqli_fetch_assoc($RsChoixMatiere);
$totalRows_RsChoixMatiere = mysqli_num_rows($RsChoixMatiere);


   // Gestion lors de la soumission du formulaire
 

if (!Empty($_POST['submit2'])) {
if ($_POST['titre']=='') {
 print '<strong><center><font size=5 color="#FF0000">Il faut donner un titre � votre document </font> </center></strong>';
    echo '<BR><hr>';
} else {


 



  if ((isset($_POST['en_ligne'])) && ($_POST['en_ligne']=='O')){$en_ligne='O';} else {$en_ligne='N';}
  if ((isset($_POST['avec_score'])) && ($_POST['avec_score']=='O')){$avec_score='O';} else {$avec_score='N';}
  if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul']=='O')){$evaluation_seul='O';} else {$evaluation_seul='N';}
  if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul']=='O')){$avec_score='O';}
  
  $query_RsMax = "SELECT MAX(pos_doc) AS resultat FROM stock_quiz ";
  $RsMax = mysqli_query($conn_intranet), $query_RsMax) or die(mysqli_error());
  $row_RsMax = mysqli_fetch_assoc($RsMax);
  $position=$row_RsMax['resultat']+1;

  $type_doc=1;
  $insertSQL = sprintf("INSERT INTO stock_quiz (titre, fichier, matiere_ID, niveau_ID,theme_ID, auteur, en_ligne, avec_score, evaluation_seul, cat_doc, type_doc, pos_doc) VALUES (%s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s)",
                       
                       GetSQLValueString($_POST['titre'], "text"),
                       GetSQLValueString($_POST['nom_fichier'], "text"),
                       GetSQLValueString($_POST['matiere_ID'], "text"),
                       GetSQLValueString($_POST['niveau_ID'], "text"),
		               GetSQLValueString($_POST['theme_ID'], "int"),
                       GetSQLValueString($_POST['auteur'], "text"),
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
		               GetSQLValueString($evaluation_seul, "text"),
					   GetSQLValueString($_POST['cat_doc'], "int"),
					   GetSQLValueString($type_doc, "int"),
					   GetSQLValueString($position, "int"));

  mysqli_select_db($conn_intranet), $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet), $insertSQL) or die(mysqli_error());
  mysqli_free_result($RsMax);
  header("Location: upload_menu.php");
}
}

?>
    


<html>
<head>
<title>Cr&eacute;ation d'un lien vers un document externe &gt; Fiche</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Style1 {
	color: #990000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<a href="../index.php"><img src="../patate.gif" width="48" height="44" border="0"></a> 
<img src="../patate.jpg" width="324" height="39" align="top"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong><a href="../index.php">Accueil Stockpotatoes</a> -<a href="upload_menu.php"> Envoi de documents</a>      - Cr&eacute;ation d'un lien vers un document externe</strong></td>
    <td><div align="right">
      </div></td>
  </tr>
</table>
<hr>

<p align="center" class="title">Fiche d'enregistrement d'un lien hypertexte </p>
<form name="form1" method="post" action="upload_url.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_POST['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_POST['matiere_ID']))) {echo "SELECTED";} } 
 ?>><?php echo $row_rs_matiere['nom_mat']?></option>
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
      <td width="21%"><div align="center"> 
          <select name="niveau_ID" id="niveau_ID">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_POST['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_POST['niveau_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
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
      <td width="44%"> <input type="submit" name="Submit" value="S&eacute;lectionner"></td>
    </tr>
  </table>
</form>
<?php if (isset($_POST['matiere_ID'])) { ?>
<p align="center"> <strong><font size="6"><?php echo $row_RsChoixMatiere['nom_mat']; ?></font></strong> 
<form method="post" enctype="multipart/form-data" name="form1" id="formulaire" action="upload_url.php">
  <table align="center">
    <tr valign="baseline"> 
      <td width="212" align="right" nowrap>Ce lien est relatif &agrave; l'&eacute;tude 
        du th&egrave;me </td>
      <td width="350"> <select name="theme_ID" id="select">
          <option value="value">Selectionnez un th�me</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RsTheme['ID_theme']?>"><?php echo $row_RsTheme['theme']?></option>
          <?php
} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme));
  $rows = mysqli_num_rows($RsTheme);
  if($rows > 0) {
      mysqli_data_seek($RsTheme, 0);
	  $row_RsTheme = mysqli_fetch_assoc($RsTheme);
  }
?>
        </select> <a href="../enseignant/gestion_theme.php">Ajouter un nouveau 
        th&egrave;me</a></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap>Ce lien est &agrave; classer dans </td>
      <td><table width="459">
          <tr>
            <td><label>
              <input name="cat_doc" type="radio" value="1" checked>
          Cours</label></td>
            <td><label>
              <input type="radio" name="cat_doc" value="3">
          Exercices</label></td>
            <td><label>
              <input type="radio" name="cat_doc" value="4">
          Travail &agrave; faire</label></td>
            <td><label>
              <input type="radio" name="cat_doc" value="5">
          Annexes</label></td>
          </tr>
      </table></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Descriptif du lien<font color="#990000"> <strong>(Obligatoire)</strong></font>:</td>
      <td><input type="text" name="titre" value="" size="100"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Adresse URL du document :</td>
      <td>
<input type="text" name="nom_fichier" value="" size="100">
        <input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $_POST['matiere_ID'] ?>"> 
        <input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $_POST['niveau_ID'] ?>"> 
        <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $_POST['nom_mat'] ?>"> 
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Auteur:</td>
      <td><input type="text" name="auteur" value="" size="50"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Mode Entrainement:</td>
      <td><input name="en_ligne" type="checkbox" id="en_ligne" value="O" checked> 
        <font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>Ce lien  peut &ecirc;tre vu sans que l'&eacute;l&egrave;ve soit identifi&eacute;. 
        </em></font></em></font></em></font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Mode Evaluation</td>
      <td><em> 
        <input name="avec_score" type="checkbox" id="avec_score" value="O" checked>
        <font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>Ce lien peut &ecirc;tre vu</em></font></em></font></em></font><font color="#990000"><em><font color="#990000"><em> par l'&eacute;l&egrave;ve en s'identifiant</em></font> 
        . </em></font></em></td>
    </tr>
    <tr valign="baseline"> 
	  <td nowrap align="right">Un seul essai</td>
      <td><em>
<input name="evaluation_seul" type="checkbox" id="evaluation_seul" value="O">
        <font color="#990000"> <em> <em>En mode &eacute;valuation, <font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>ce lien ne pourra &ecirc;tre vu</em></font></em></font></em></font> qu'une seule fois</em></em></font></em></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td ><font color="#990000"> <em> <font color="#990000"> 
        <em> <em><font color="#990000">Les param&egrave;tres ci-dessus tels que 
        le choix du mode, pourront &ecirc;tre modifi&eacute;s par la suite <br>
        (voir Espace Enseignant - Gestion des exercices ).</font> </em><font color="#990000"><em> 
        </em></font></em></font></em></font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input name="submit2" type="submit" value="Enregistrer votre document sur le serveur"></td>
    </tr>
  </table>
  <div align="center"> </div>
</form>

<?php } ?>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil StockPotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a> - <a href="upload_menu.php">Envoi de documents</a> </p>
</body>
</html>
<?php
mysqli_free_result($RsMaxId_quiz);

mysqli_free_result($rs_matiere);

mysqli_free_result($rs_niveau);

mysqli_free_result($RsTheme);

mysqli_free_result($RsChoixMatiere);
?>

