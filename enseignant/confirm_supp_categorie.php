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

if ((isset($_POST['ID_categorie'])) && ($_POST['ID_categorie'] != ""))
{
  $deleteSQL = sprintf("DELETE FROM stock_categorie WHERE ID_categorie=%s",
                       GetSQLValueString($_POST['ID_categorie'], "int"));
  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

  $updateSQL = sprintf("UPDATE stock_quiz SET categorie_ID= 0 WHERE categorie_ID=%s",
                       GetSQLValueString($_POST['ID_categorie'], "int"));
  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result2 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));



  $deleteGoTo = "gestion_categorie.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>

