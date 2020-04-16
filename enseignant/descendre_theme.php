<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
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
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE ID_theme = %s", $colname_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error());
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);

$temp=$row_RsChoixTheme['pos_theme'];
$updateSQL = sprintf("UPDATE stock_theme SET pos_theme=%s  WHERE ID_theme=%s",
                       GetSQLValueString($_POST['pos_suivant'], "int"),
					   GetSQLValueString($_POST['ID_theme'], "int"));

mysqli_select_db($conn_intranet, $database_conn_intranet);

$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());



$colname_RsChoixTheme2 = "0";
if (isset($_POST['ID_suivant'])) {
  $colname_RsChoixTheme2 = (get_magic_quotes_gpc()) ? $_POST['ID_suivant'] : addslashes($_POST['ID_suivant']);
}  
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixTheme2 = sprintf("SELECT * FROM stock_theme WHERE ID_theme = %s", $colname_RsChoixTheme2);
$RsChoixTheme2 = mysqli_query($conn_intranet, $query_RsChoixTheme2) or die(mysqli_error());
$row_RsChoixTheme2 = mysqli_fetch_assoc($RsChoixTheme2);

$updateSQL2 = sprintf("UPDATE stock_theme SET pos_theme=%s  WHERE ID_theme=%s",
                       GetSQLValueString($temp, "int"),
					   GetSQLValueString($_POST['ID_suivant'], "int"));

mysqli_select_db($conn_intranet, $database_conn_intranet);
$Result2 = mysqli_query($conn_intranet, $updateSQL2) or die(mysqli_error());
  
  

  $updateGoTo = 'gestion_theme.php?matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'];
 
  header(sprintf("Location: %s", $updateGoTo));


mysqli_free_result($RsChoixTheme);
mysqli_free_result($RsChoixTheme2);



?>
