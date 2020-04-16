<?php session_start();
 require_once('Connections/conn_intranet.php'); 

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

if ($_POST['pass1']==$_POST['pass'])
{
  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2"))
  {
    $updateSQL = sprintf("UPDATE stock_eleve SET pass=%s WHERE ID_eleve=%s",
                         GetSQLValueString($_POST['pass'], "text"),
                         GetSQLValueString($_SESSION['Sess_ID_eleve'], "int"));

    mysqli_select_db($conn_intranet, $database_conn_intranet);
   $Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());

    $updateGoTo = "accueil_eleve.php";
    if (isset($_SERVER['QUERY_STRING'])) 
    {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
  header(sprintf("Location: %s", $updateGoTo));
  }
}
else
{
echo '<B> Erreur - Vous devez confirmer en retapant EXACTEMENT à l\'identique votre nouveau mot de passe. </B>';
}
?>

<html>
<head>
<title>Espace El&egrave;ve - Modification de mon mot de passe</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr> 
    <td width="58%">
      <p><strong><a href="accueil_eleve.php">Espace Elève</a> - Changement de mot de passe</strong> </p>
      <p>&nbsp; </p></td>
    <td width="42%"><p align="right" class="subtitle"><strong><?php echo $_SESSION['Sess_nom'].'   '.$_SESSION['Sess_prenom'].'   '.$_SESSION['Sess_classe']?></strong></p>
      <p align="right">&nbsp;</p></td>
  </tr>
</table>
<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
  <p align="center">&nbsp;</p>
  <table align="center">
    <tr valign="baseline"> 
      <td><div align="center">Entrer votre nouveau mot de passe</div></td>
    </tr>
    <tr valign="baseline"> 
      <td><div align="center"> 
          <input name="pass1" type="password" id="pass12" size="8">
        </div></td>
    </tr>
    <tr valign="baseline"> 
      <td><div align="center">Confirmer en retapant ce mot de passe</div></td>
    </tr>
    <tr valign="baseline"> 
      <td><p align="center"> 
          <input type="password" name="pass" size="8">
          <br>
        </p></td>
    </tr>
    <tr valign="baseline"> 
      <td valign="middle"> <div align="center"> 
          <p> <br>
            <input name="submit" type="submit" value="Enregistrer mon nouveau mot de passe">
          </p>
          <p>&nbsp; </p>
        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2">
</form>
<p>&nbsp; </p>
</body>
</html>
