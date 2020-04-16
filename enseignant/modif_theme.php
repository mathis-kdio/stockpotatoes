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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE stock_theme SET theme=%s WHERE ID_theme=%s",
                       GetSQLValueString($_POST['theme'], "text"),
                       GetSQLValueString($_POST['ID_theme'], "int"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());

  $updateGoTo = "gestion_theme.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$choixtheme_RsChoixTheme = "0";
if (isset($_POST['ID_theme'])) {
  $choixtheme_RsChoixTheme = (get_magic_quotes_gpc()) ? $_POST['ID_theme'] : addslashes($_POST['ID_theme']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.ID_theme=%s", $choixtheme_RsChoixTheme);
$RsChoixTheme = mysql_query($query_RsChoixTheme, $conn_intranet) or die(mysql_error());
$row_RsChoixTheme = mysql_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysql_num_rows($RsChoixTheme);
?>
<html>
<head>
<title>Modification d'un th&egrave;me</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
          <p><strong>Modification du libell&eacute; du th&egrave;me de l'&eacute;tude</strong></p>
        </blockquote>
        <table align="center">
          <tr valign="baseline"> 
            <td width="234"><input type="text" name="theme" value="<?php echo $row_RsChoixTheme['theme']; ?>" size="50"></td>
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
        <input type="hidden" name="ID_theme" value="<?php echo $row_RsChoixTheme['ID_theme']; ?>">
      </form>
      <p align="center"><a href="gestion_theme.php">Gestion des th&egrave;mes</a></p></td>
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
mysql_free_result($RsChoixTheme);
?>

