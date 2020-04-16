<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
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



$colname_RsChoixNiveau = "0";
if (isset($_POST['ID_niveau'])) {
  $colname_RsChoixNiveau = (get_magic_quotes_gpc()) ? $_POST['ID_niveau'] : addslashes($_POST['ID_niveau']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixNiveau = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_RsChoixNiveau);
$RsChoixNiveau = mysql_query($query_RsChoixNiveau, $conn_intranet) or die(mysql_error());
$row_RsChoixNiveau = mysql_fetch_assoc($RsChoixNiveau);

$temp=$row_RsChoixNiveau['pos_niv'];
$updateSQL = sprintf("UPDATE stock_niveau SET pos_niv=%s  WHERE ID_niveau=%s",
                       GetSQLValueString($_POST['pos_precedent'], "int"),
					   GetSQLValueString($_POST['ID_niveau'], "int"));





mysql_select_db($database_conn_intranet, $conn_intranet);

$Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());



$colname_RsChoixNiveau2 = "0";
if (isset($_POST['ID_precedent'])) {
  $colname_RsChoixNiveau2 = (get_magic_quotes_gpc()) ? $_POST['ID_precedent'] : addslashes($_POST['ID_precedent']);
}  
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixNiveau2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_RsChoixNiveau2);
$RsChoixNiveau2 = mysql_query($query_RsChoixNiveau2, $conn_intranet) or die(mysql_error());
$row_RsChoixNiveau2 = mysql_fetch_assoc($RsChoixNiveau2);

$updateSQL2 = sprintf("UPDATE stock_niveau SET pos_niv=%s  WHERE ID_niveau=%s",
                       GetSQLValueString($temp, "int"),
					   GetSQLValueString($_POST['ID_precedent'], "int"));



mysql_select_db($database_conn_intranet, $conn_intranet);
$Result2 = mysql_query($updateSQL2, $conn_intranet) or die(mysql_error());
  
  

  $updateGoTo = 'gestion_matiere_niveau.php';
  
  header(sprintf("Location: %s", $updateGoTo));


mysql_free_result($RsChoixNiveau);
mysql_free_result($RsChoixNiveau2);



?>
