<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>

<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysql_query($query_rsClasse, $conn_intranet) or die(mysql_error());
$row_rsClasse = mysql_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysql_num_rows($rsClasse);

$choix_RsListePass = "0";
if (isset($_POST['classe'])) {
  $choix_RsListePass = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsListePass = sprintf("SELECT ID_eleve, nom, prenom, pass FROM stock_eleve WHERE stock_eleve.classe='%s' ORDER BY nom ASC, prenom", $choix_RsListePass);
$RsListePass = mysql_query($query_RsListePass, $conn_intranet) or die(mysql_error());
$row_RsListePass = mysql_fetch_assoc($RsListePass);
$totalRows_RsListePass = mysql_num_rows($RsListePass);

?>
<html>
<head>
<title>Liste des mots de passe</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p> <img src="../patate.gif" width="62" height="41"> <img src="../patate.jpg" width="324" height="39" align="top"> 
</p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php">Espace Enseignant</a> - Liste des 
    mots de passe</strong></p>
<form name="form1" method="post" action="liste_pass.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr valign="top"> 
      <td> <select name="classe" size="1" id="classe">
          <option value="classe">Sélectionner une classe</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rsClasse['classe']?>"><?php echo $row_rsClasse['classe']?></option>
          <?php
} while ($row_rsClasse = mysql_fetch_assoc($rsClasse));
  $rows = mysql_num_rows($rsClasse);
  if($rows > 0) {
      mysql_data_seek($rsClasse, 0);
	  $row_rsClasse = mysql_fetch_assoc($rsClasse);
  }
?>
        </select> <input type="submit" name="Submit" value="S&eacute;lectionner"> 
      </td>
      <td>&nbsp;</td>
      <td> <script language="JavaScript">
<!-- Begin
if (window.print) {
document.write('<form><FONT FACE="Arial,Helvetica"><FONT SIZE=2><FONT COLOR="#000000">Cliquez pour imprimer cette page    '
+ '<input type=button name=print value="Imprimer" '
+ 'onClick="javascript:window.print()">     </form>');
}
// End -->
</script></td>
    </tr>
  </table>
</form>
<p> </p>
<?php if (isset($_POST['classe'])) { ?>
<table border="1">
  <tr bgcolor="#CCCC99"> 
    <td> <div align="center"><strong>N&deg;</strong></div></td>
    <td bgcolor="#CCCC99"> <div align="left" class="retrait20"><strong>Nom</strong></div></td>
    <td bgcolor="#CCCC99"> <div align="left" class="retrait20"><strong>Pr&eacute;nom</strong></div></td>
    <td> <div align="center"><strong>Mot de passe</strong></div></td>
  </tr>
  <?php do { ?>
  <tr> 
    <td class="retrait20"><?php echo $row_RsListePass['ID_eleve']; ?></td>
    <td class="retrait20"><?php echo $row_RsListePass['nom']; ?></td>
    <td class="retrait20"><?php echo $row_RsListePass['prenom']; ?></td>
    <td class="retrait20"><?php echo $row_RsListePass['pass']; ?></td>
  </tr>
  <?php } while ($row_RsListePass = mysql_fetch_assoc($RsListePass)); ?>
</table>
<?php } ?>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p align="right">&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($RsListePass);

mysql_free_result($rsClasse);
?>

