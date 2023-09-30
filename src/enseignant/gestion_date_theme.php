<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
  if ($_SESSION['Sess_nom']<>'Enseignant') { 
    header("Location: login_enseignant.php");
  }
} 
else { 
  header("Location: ../index.php");
}

require_once('../Connections/conn_intranet.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formapparition"))
{
  $testdateupdate = $_POST['formapparition'];
  $testthemeupdate =  $_POST['ID_theme2'];
  $updateSQL = sprintf("UPDATE stock_theme SET date_apparition = '%s' WHERE ID_theme ='%s' ", htmlspecialchars($testdateupdate), $testthemeupdate);
  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result2 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));
}


if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "formdisparition"))
{
  $testdateupdate2 = $_POST['formdisparition'];
  $testthemeupdate2 =  $_POST['ID_theme3'];
  $updateSQL2 = sprintf("UPDATE stock_theme SET date_disparition = '%s' WHERE ID_theme ='%s' ", htmlspecialchars($testdateupdate2), $testthemeupdate2);
  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result3 = mysqli_query($conn_intranet, $updateSQL2) or die(mysqli_error($conn_intranet));
}

header('Location: gestion_theme.php?matiere_ID='.$_POST['ID_mat'].'&niveau_ID='.$_POST['ID_niv']);
?>