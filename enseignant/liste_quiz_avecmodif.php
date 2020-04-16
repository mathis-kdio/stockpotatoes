<?php 

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  if ($_POST['en_ligne']=='O'){$en_ligne='O';} else {$en_ligne='N';}
  if ($_POST['avec_score']=='O'){$avec_score='O';} else {$avec_score='N';}
  $updateSQL = sprintf("UPDATE stock_quiz SET avec_score=%s, en_ligne=%s WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s ORDER BY stock_quiz.matiere_ID, stock_quiz.niveau_ID",
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
					   GetSQLValueString($_POST['matiere_ID'], "text"),
					   GetSQLValueString($_POST['niveau_ID'], "text")
					   );

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());
echo $updateSQL;
  $updateGoTo = "liste_quiz_avecmodif.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 header(sprintf("Location: %s", $updateGoTo));
}
?>

<?php 



mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere";
$rs_matiere = mysql_query($query_rs_matiere, $conn_intranet) or die(mysql_error());
$row_rs_matiere = mysql_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysql_num_rows($rs_matiere);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysql_query($query_rs_niveau, $conn_intranet) or die(mysql_error());
$row_rs_niveau = mysql_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysql_num_rows($rs_niveau);

$choix_mat_rsListeSelectMatiereNiveau = "0";
if (isset($_POST['matiere_ID'])) {
  $choix_mat_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
$choix_niv_rsListeSelectMatiereNiveau = "0";
if (isset($_POST['niveau_ID'])) {
  $choix_niv_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_POST['niveau_ID'] : addslashes($_POST['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s ORDER BY stock_quiz.matiere_ID, stock_quiz.niveau_ID", $choix_mat_rsListeSelectMatiereNiveau,$choix_niv_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysql_query($query_rsListeSelectMatiereNiveau, $conn_intranet) or die(mysql_error());
$row_rsListeSelectMatiereNiveau = mysql_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysql_num_rows($rsListeSelectMatiereNiveau);

$colname_rsChoix = "1";
if (isset($_POST['matiere_ID'])) {
  $colname_rsChoix = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat =%s", $colname_rsChoix);
$rsChoix = mysql_query($query_rsChoix, $conn_intranet) or die(mysql_error());
$row_rsChoix = mysql_fetch_assoc($rsChoix);
$totalRows_rsChoix = mysql_num_rows($rsChoix);

$colname_rsChoix2 = "1";
if (isset($_POST['niveau_ID'])) {
  $colname_rsChoix2 = (get_magic_quotes_gpc()) ? $_POST['niveau_ID'] : addslashes($_POST['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_rsChoix2);
$rsChoix2 = mysql_query($query_rsChoix2, $conn_intranet) or die(mysql_error());
$row_rsChoix2 = mysql_fetch_assoc($rsChoix2);
$totalRows_rsChoix2 = mysql_num_rows($rsChoix2);
?>
<html>
<head>
<title>Liste des quiz - Changement des paramètres</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
while ($row_rsListeSelectMatiereNiveau = mysql_fetch_assoc($rsListeSelectMatiereNiveau)) 
{        
//echo ($row_rsListeSelectMatiereNiveau[en_ligne]).'<BR>';

}
?>
<p><img src="../patate.gif" width="62" height="44"> <img src="../patate.jpg" width="324" height="39"></p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a></strong><strong> - </strong><strong><a href="accueil_enseignant.php">Espace enseignan</a>t - Liste des 
    exercices avec modification du mode (entrainement et/ou &eacute;valuation)</strong></p>
<p align="right">&nbsp;</p>
<form name="form1" method="post" action="liste_quiz_avecmodif.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (!(strcmp($row_rs_matiere['ID_mat'], $row_rsChoix['ID_mat']))) {echo "SELECTED";} ?>><?php echo $row_rs_matiere['nom_mat']?></option>
            <?php
} while ($row_rs_matiere = mysql_fetch_assoc($rs_matiere));
  $rows = mysql_num_rows($rs_matiere);
  if($rows > 0) {
      mysql_data_seek($rs_matiere, 0);
	  $row_rs_matiere = mysql_fetch_assoc($rs_matiere);
  }
?>
          </select>
        </div></td>
      <td width="24%"><div align="center"> 
          <select name="niveau_ID" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (!(strcmp($row_rs_niveau['ID_niveau'], $row_rsChoix2['ID_niveau']))) {echo "SELECTED";} ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
            <?php
} while ($row_rs_niveau = mysql_fetch_assoc($rs_niveau));
  $rows = mysql_num_rows($rs_niveau);
  if($rows > 0) {
      mysql_data_seek($rs_niveau, 0);
	  $row_rs_niveau = mysql_fetch_assoc($rs_niveau);
  }
?>
          </select>
        </div></td>
      <td width="41%"><input type="submit" name="Submit" value="Valider"></td>
    </tr>
  </table>
</form>
<?php if (isset($_POST['matiere_ID'])) { ?>
<form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <table border="1">
    <tr> 
      <td><div align="center"><strong>N&deg; Ex.</strong></div></td>
      <td><div align="center"><strong>Titre</strong></div></td>
      <td><div align="center"><strong>Fichier</strong></div></td>
      <td><div align="center"><strong>Auteur</strong></div></td>
      <td><div align="center"><strong>En entrainement</strong></div></td>
      <td><div align="center"><strong>En &eacute;valuation</strong></div></td>
      <td>&nbsp;</td>
    </tr>
    <?php do { 
	 $matiere=sans_accent($row_rsListeSelectMatiereNiveau['nom_mat']);
	 ?>
    <tr> 
      <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
      <td class="retrait20"><a href="<?php echo '../Exercices/'.$matiere.'/q'.$row_rsListeSelectMatiereNiveau['ID_quiz']; ?>/<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></td>
      <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?></td>
      <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?></td>
      <td> 
        <div align="center"> 
          <input <?php if (!(strcmp($row_rsListeSelectMatiereNiveau['en_ligne'],"O"))) {echo "checked";} ?> name="en_ligne" type="checkbox" id="en_ligne" value="checkbox">
        </div></td>
      <td> 
        <div align="center"> 
          <input <?php if (!(strcmp($row_rsListeSelectMatiereNiveau['avec_score'],"O"))) {echo "checked";} ?> name="avec_score" type="checkbox" id="avec_score" value="checkbox">
        </div></td>
    </tr>
    <?php } while ($row_rsListeSelectMatiereNiveau = mysql_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
  </table>
  <p> 
    <input name="tablist" type="hidden" id="tablist" value="<?php echo $rsListeSelectMatiereNiveau?>">
    <input type="submit" name="Submit2" value="Modifier">
  </p>
  <input type="hidden" name="MM_update" value="form2">
</form>
<?php } ?>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_matiere);

mysql_free_result($rs_niveau);

mysql_free_result($rsListeSelectMatiereNiveau);

mysql_free_result($rsChoix);

mysql_free_result($rsChoix2);
?>

  