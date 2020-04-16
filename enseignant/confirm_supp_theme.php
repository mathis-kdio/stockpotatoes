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

if ((isset($_POST['ID_theme'])) && ($_POST['ID_theme'] != "")) {
  $deleteSQL = sprintf("DELETE FROM stock_theme WHERE ID_theme=%s",
                       GetSQLValueString($_POST['ID_theme'], "int"));
  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($deleteSQL, $conn_intranet) or die(mysql_error());

  $updateSQL = sprintf("UPDATE stock_quiz SET theme_ID= 0 WHERE theme_ID=%s",
                       GetSQLValueString($_POST['ID_theme'], "int"));
  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result2 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());



  $deleteGoTo = "gestion_theme.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>

