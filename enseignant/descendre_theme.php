<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php 


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



$colname_RsChoixTheme = "0";
if (isset($_POST['ID_theme'])) {
  $colname_RsChoixTheme = (get_magic_quotes_gpc()) ? $_POST['ID_theme'] : addslashes($_POST['ID_theme']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme = %s", $colname_RsChoixTheme);
$RsChoixTheme = mysql_query($query_RsChoixTheme, $conn_intranet) or die(mysql_error());
$row_RsChoixTheme = mysql_fetch_assoc($RsChoixTheme);

$temp=$row_RsChoixTheme['pos_theme'];
$updateSQL = sprintf("UPDATE stock_theme SET pos_theme=%s  WHERE ID_theme=%s",
                       GetSQLValueString($_POST['pos_suivant'], "int"),
					   GetSQLValueString($_POST['ID_theme'], "int"));

mysql_select_db($database_conn_intranet, $conn_intranet);

$Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());



$colname_RsChoixTheme2 = "0";
if (isset($_POST['ID_suivant'])) {
  $colname_RsChoixTheme2 = (get_magic_quotes_gpc()) ? $_POST['ID_suivant'] : addslashes($_POST['ID_suivant']);
}  
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixTheme2 = sprintf("SELECT * FROM stock_theme WHERE ID_theme = %s", $colname_RsChoixTheme2);
$RsChoixTheme2 = mysql_query($query_RsChoixTheme2, $conn_intranet) or die(mysql_error());
$row_RsChoixTheme2 = mysql_fetch_assoc($RsChoixTheme2);

$updateSQL2 = sprintf("UPDATE stock_theme SET pos_theme=%s  WHERE ID_theme=%s",
                       GetSQLValueString($temp, "int"),
					   GetSQLValueString($_POST['ID_suivant'], "int"));

mysql_select_db($database_conn_intranet, $conn_intranet);
$Result2 = mysql_query($updateSQL2, $conn_intranet) or die(mysql_error());
  
  

  $updateGoTo = 'gestion_theme.php?matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'];
 
  header(sprintf("Location: %s", $updateGoTo));


mysql_free_result($RsChoixTheme);
mysql_free_result($RsChoixTheme2);



?>
