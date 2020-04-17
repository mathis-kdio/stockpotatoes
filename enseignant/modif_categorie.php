<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE stock_categorie SET nom_categorie=%s WHERE ID_categorie=%s",
                       GetSQLValueString($_POST['categorie'], "text"),
                       GetSQLValueString($_POST['ID_categorie'], "int"));

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());

  $updateGoTo = "gestion_categorie.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$choixcategorie_RsChoixcategorie = "0";
if (isset($_POST['ID_categorie'])) {
  $choixcategorie_RsChoixcategorie = (get_magic_quotes_gpc()) ? $_POST['ID_categorie'] : addslashes($_POST['ID_categorie']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixcategorie = sprintf("SELECT * FROM stock_categorie WHERE stock_categorie.ID_categorie=%s", $choixcategorie_RsChoixcategorie);
$RsChoixcategorie = mysqli_query($conn_intranet, $query_RsChoixcategorie) or die(mysqli_error());
$row_RsChoixcategorie = mysqli_fetch_assoc($RsChoixcategorie);
$totalRows_RsChoixcategorie = mysqli_num_rows($RsChoixcategorie);
?>
<html>
<head>
<title>Modification d'une catégorie</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td><img src="../patate.gif" width="253" height="227"></td>
    <td> <p><img src="../patate.jpg" width="324" height="39" align="top"> </p>
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
        <p>&nbsp;</p>
        <blockquote> 
          <p><strong>Modification du libell&eacute; de la catégorie de l'&eacute;tude</strong></p>
        </blockquote>
        <table align="center">
          <tr valign="baseline"> 
            <td width="234"><input type="text" name="categorie" value="<?php echo $row_RsChoixcategorie['nom_categorie']; ?>" size="50"></td>
          </tr>
          <tr valign="baseline"> 
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline"> 
            <td><div align="center"> 
                <input type="submit" value="Mettre à jour l'enregistrement">
              </div></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1">
        <input type="hidden" name="ID_categorie" value="<?php echo $row_RsChoixcategorie['ID_categorie']; ?>">
      </form>
      <p align="center"><a href="gestion_categorie.php">Gestion des catégories</a></p></td>
  </tr>
</table>
<p>&nbsp; </p>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($RsChoixcategorie);
?>

