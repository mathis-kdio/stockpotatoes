<?php require_once('Connections/conn_intranet.php'); ?>
<?php
$colpass_rsLogin = "1";
$valider="";


$collog_rsLogin = "1";
if (isset($_POST['log'])) {
  $collog_rsLogin = (get_magic_quotes_gpc()) ? $_POST['log'] : addslashes($_POST['log']);
}
$colpass_rsLogin = "1";
if (isset($_POST['pass'])) {
  $colpass_rsLogin = (get_magic_quotes_gpc()) ? $_POST['pass'] : addslashes($_POST['pass']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsLogin = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom, stock_eleve.classe, stock_eleve.pass FROM stock_eleve WHERE stock_eleve.ID_eleve='%s' AND stock_eleve.pass='%s'", $collog_rsLogin,$colpass_rsLogin);
$rsLogin = mysql_query($query_rsLogin, $conn_intranet) or die(mysql_error());
$row_rsLogin = mysql_fetch_assoc($rsLogin);
$totalRows_rsLogin = mysql_num_rows($rsLogin);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysql_query($query_rsClasse, $conn_intranet) or die(mysql_error());
$row_rsClasse = mysql_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysql_num_rows($rsClasse);

$choix_classe_rsLogin2 = "1";
if (isset($_POST['classe'])) {
  $choix_classe_rsLogin2 = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsLogin2 = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom FROM stock_eleve WHERE stock_eleve.classe='%s'", $choix_classe_rsLogin2);
$rsLogin2 = mysql_query($query_rsLogin2, $conn_intranet) or die(mysql_error());
$row_rsLogin2 = mysql_fetch_assoc($rsLogin2);
$totalRows_rsLogin2 = mysql_num_rows($rsLogin2);


if ((isset($_POST['valider'])) && ($_POST['valider']=="ok"))
{
if ($totalRows_rsLogin=='1')
	{
	session_start();
	$_SESSION['Sess_ID_eleve'] = $row_rsLogin['ID_eleve'];
    $_SESSION['Sess_nom'] = $row_rsLogin['nom'];
	$_SESSION['Sess_prenom'] = $row_rsLogin['prenom'];
	$_SESSION['Sess_classe'] = $row_rsLogin['classe'];
	
    header("Location: accueil_eleve.php");
	}
}
else
		
		{
		$erreurlog=1;
		}
?>


<html>
<head>
<title>Identification de l'&eacute;l&egrave;ve</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><img src="patate.gif" width="45" height="41"> <img src="patate.jpg" width="324" height="39" align="top"> 
</p>
<p><strong><a href="index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="login_eleve.php">Espace El&egrave;ve</a> - Mode Evaluation - Identification 
    de l'&eacute;l&egrave;ve</strong></p>
<p>&nbsp;</p>
<form name="form2" method="post" action="login_eleve.php">
  <div align="center"> 
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
      <tr> 
        <td width="400"> <div align="right">S&eacute;lectionnez votre classe</div></td>
        <td> <select name="classe" id="classe">
            <option value="classe" <?php if (isset($_POST['classe'])) {
			if (!(strcmp("classe", $_POST['classe']))) {echo "SELECTED";} }?>>Sélectionner 
            votre classe</option>
            <?php $classe=0;
do {  
?>
            <option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";}} ?>><?php echo $row_rsClasse['classe']?></option>
            <?php
} while ($row_rsClasse = mysql_fetch_assoc($rsClasse));
  $rows = mysql_num_rows($rsClasse);
  if($rows > 0) {
      mysql_data_seek($rsClasse, 0);
	  $row_rsClasse = mysql_fetch_assoc($rsClasse);
  }
?>
          </select> <input type="submit" name="Submit2" value="Validez"> </td>
      </tr>
    </table>
  </div>
</form>
<?php if (isset($_POST['classe'])) { ?>
<form name="form1" method="post" action="login_eleve.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="400"> <div align="right">S&eacute;lectionnez votre nom </div></td>
      <td> <select name="log" id="log">
          <?php
do {  
?>
          <option value="<?php echo $row_rsLogin2['ID_eleve']?>"><?php echo $row_rsLogin2['nom']." ".$row_rsLogin2['prenom']?></option>
          <?php
} while ($row_rsLogin2 = mysql_fetch_assoc($rsLogin2));
  $rows = mysql_num_rows($rsLogin2);
  if($rows > 0) {
      mysql_data_seek($rsLogin2, 0);
	  $row_rsLogin2 = mysql_fetch_assoc($rsLogin2);
  }
?>
        </select> </td>
    </tr>
    <tr> 
      <td width="400"> <div align="right">Tapez votre mot de passe</div></td>
      <td><input name="pass" type="password" id="pass"> <input type="submit" name="Submit" value="Validez"></td>
    </tr>
  </table>
  <input name="valider" type="hidden" id="valider" value="ok">
  <input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
</form>
<SCRIPT>document.form1.pass.focus();</SCRIPT>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($rsLogin);
mysql_free_result($rsClasse);
mysql_free_result($rsLogin2);
?>

