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



$colname_RsChoixQuiz = "0";
if (isset($_POST['ID_quiz'])) {
  $colname_RsChoixQuiz = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixQuiz = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = %s", $colname_RsChoixQuiz);
$RsChoixQuiz = mysql_query($query_RsChoixQuiz, $conn_intranet) or die(mysql_error());
$row_RsChoixQuiz = mysql_fetch_assoc($RsChoixQuiz);

$temp=$row_RsChoixQuiz['pos_doc'];
$updateSQL = sprintf("UPDATE stock_quiz SET pos_doc=%s  WHERE ID_quiz=%s",
                       GetSQLValueString($_POST['pos_suivant'], "int"),
					   GetSQLValueString($_POST['ID_quiz'], "int"));

mysql_select_db($database_conn_intranet, $conn_intranet);

$Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());



$colname_RsChoixQuiz2 = "0";
if (isset($_POST['ID_suivant'])) {
  $colname_RsChoixQuiz2 = (get_magic_quotes_gpc()) ? $_POST['ID_suivant'] : addslashes($_POST['ID_suivant']);
}  
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixQuiz2 = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = %s", $colname_RsChoixQuiz2);
$RsChoixQuiz2 = mysql_query($query_RsChoixQuiz2, $conn_intranet) or die(mysql_error());
$row_RsChoixQuiz2 = mysql_fetch_assoc($RsChoixQuiz2);

$updateSQL2 = sprintf("UPDATE stock_quiz SET pos_doc=%s  WHERE ID_quiz=%s",
                       GetSQLValueString($temp, "int"),
					   GetSQLValueString($_POST['ID_suivant'], "int"));

mysql_select_db($database_conn_intranet, $conn_intranet);
$Result2 = mysql_query($updateSQL2, $conn_intranet) or die(mysql_error());
  
  

  $updateGoTo = 'gestion_exos.php?matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$_POST['ID_theme'];
  
  header(sprintf("Location: %s", $updateGoTo));


mysql_free_result($RsChoixQuiz);
mysql_free_result($RsChoixQuiz2);



?>
