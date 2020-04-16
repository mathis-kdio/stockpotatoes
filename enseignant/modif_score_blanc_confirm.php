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

if ( 
(isset($_POST['ID_quiz'])) AND (isset($_POST['classe']))
) 

{
$deleteSQL = sprintf("DELETE FROM stock_activite WHERE stock_activite.nom_classe = %s  AND stock_activite.quiz_ID=%s",
                       GetSQLValueString($_POST['classe'], "text"),
					   GetSQLValueString($_POST['ID_quiz'], "int"));

mysqli_select_db($conn_intranet, $database_conn_intranet);

$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error());
}

?>
<HTML>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">

<title>Remise &agrave; blanc des notes &gt; Confirmation</title></head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="../patate.gif" width="253" height="227"></td>
    <td><div align="center"> 
        <p><img src="../patate.jpg" width="324" height="39" align="top"> </p>
        <p>&nbsp;</p>
      </div>
      <div align="center"><strong><?php echo 'Classe : '.$_POST['classe'];
echo '<BR>N° Exercice : '.$_POST['ID_quiz']; ?> </strong> 
        <p><strong>Suppression effectu&eacute;e</strong></p>
        <p>&nbsp;</p>
      </div>
      <p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
        Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
        Administrateur</a></p>
      <p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou 
        un document sur le serveur</a></p></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
</body>

</HTML>
