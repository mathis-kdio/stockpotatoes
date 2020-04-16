<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}
 require_once('../Connections/conn_intranet.php'); 
 
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO stock_eleve (ID_eleve, nom, prenom, classe, pass) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_eleve'], "int"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenom'], "text"),
                       GetSQLValueString($_POST['classe'], "text"),
                       GetSQLValueString($_POST['pass'], "text"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($insertSQL, $conn_intranet) or die(mysql_error());

  $insertGoTo = "gestion_eleve.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO stock_eleve (ID_eleve, nom, prenom, classe, pass) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_eleve'], "int"),
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenom'], "text"),
                       GetSQLValueString($_POST['classe'], "text"),
                       GetSQLValueString($_POST['pass'], "text"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($insertSQL, $conn_intranet) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form5")) {
  $updateSQL = sprintf("UPDATE stock_eleve SET nom=%s, prenom=%s, classe=%s, pass=%s WHERE ID_eleve=%s",
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['prenom'], "text"),
                       GetSQLValueString($_POST['classe'], "text"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['ID_eleve'], "int"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());

  $updateGoTo = "gestion_eleve.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['numsupeleve'])) && ($_GET['numsupeleve'] != "")) {
  $deleteSQL = sprintf("DELETE FROM stock_eleve WHERE ID_eleve=%s",
                       GetSQLValueString($_GET['numsupeleve'], "int"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($deleteSQL, $conn_intranet) or die(mysql_error());

  $deleteGoTo = "confirm_supp_eleve.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsEleve = "SELECT * FROM stock_eleve";
$RsEleve = mysql_query($query_RsEleve, $conn_intranet) or die(mysql_error());
$row_RsEleve = mysql_fetch_assoc($RsEleve);
$totalRows_RsEleve = mysql_num_rows($RsEleve);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysql_query($query_rsClasse, $conn_intranet) or die(mysql_error());
$row_rsClasse = mysql_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysql_num_rows($rsClasse);

$choixclasse_RsChoixClasse = "0";
if (isset($_POST['classe'])) {
  $choixclasse_RsChoixClasse = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixClasse = sprintf("SELECT * FROM stock_eleve WHERE stock_eleve.classe='%s'", $choixclasse_RsChoixClasse);
$RsChoixClasse = mysql_query($query_RsChoixClasse, $conn_intranet) or die(mysql_error());
$row_RsChoixClasse = mysql_fetch_assoc($RsChoixClasse);
$totalRows_RsChoixClasse = mysql_num_rows($RsChoixClasse);

$nomclasse_RsAjout = "0";
if (isset($_POST['classe'])) {
  $nomclasse_RsAjout = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsAjout = sprintf("SELECT * FROM stock_eleve WHERE stock_eleve.classe='%s'", $nomclasse_RsAjout);
$RsAjout = mysql_query($query_RsAjout, $conn_intranet) or die(mysql_error());
$row_RsAjout = mysql_fetch_assoc($RsAjout);
$totalRows_RsAjout = mysql_num_rows($RsAjout);

$nomclasse_Rschoixeleve = "0";
if (isset($_POST['classe'])) {
  $nomclasse_Rschoixeleve = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Rschoixeleve = sprintf("SELECT * FROM stock_eleve WHERE stock_eleve.classe='%s'", $nomclasse_Rschoixeleve);
$Rschoixeleve = mysql_query($query_Rschoixeleve, $conn_intranet) or die(mysql_error());
$row_Rschoixeleve = mysql_fetch_assoc($Rschoixeleve);
$totalRows_Rschoixeleve = mysql_num_rows($Rschoixeleve);

$numeleve_RsModifEleve = "0";
if (isset($_POST['numeleve'])) {
  $numeleve_RsModifEleve = (get_magic_quotes_gpc()) ? $_POST['numeleve'] : addslashes($_POST['numeleve']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsModifEleve = sprintf("SELECT * FROM stock_eleve WHERE stock_eleve.ID_eleve=%s", $numeleve_RsModifEleve);
$RsModifEleve = mysql_query($query_RsModifEleve, $conn_intranet) or die(mysql_error());
$row_RsModifEleve = mysql_fetch_assoc($RsModifEleve);
$totalRows_RsModifEleve = mysql_num_rows($RsModifEleve);
?>
<html>
<head>
<title>Gestion des &eacute;l&egrave;ves</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>
<body>
<p><a href="../index.php"><img src="../patate.gif" width="63" height="42" border="0"></a> 
  <img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_admin.php">Espace Administrateu</a>r</strong><strong> 
  - Gestion des &eacute;l&egrave;ves</strong></p>
<p>&nbsp;</p>
<table border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td width="50%" rowspan="5" valign="top"><p><strong>Liste des &eacute;l&egrave;ves</strong></p>
      <form name="form2" style="margin:0px" method="post" action="gestion_eleve.php">
        <select name="classe" id="select2">
          <?php
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
        </select>
        <input type="submit" name="Submit3" value="S&eacute;lectionner la classe">
      </form>
      <p>&nbsp;</p>
      <table border="1">
        <tr> 
          <td>ID_eleve</td>
          <td>nom</td>
          <td>prenom</td>
          <td>classe</td>
          <td>pass</td>
        </tr>
        <?php do { ?>
        <tr> 
          <td><?php echo $row_RsChoixClasse['ID_eleve']; ?></td>
          <td><?php echo $row_RsChoixClasse['nom']; ?></td>
          <td><?php echo $row_RsChoixClasse['prenom']; ?></td>
          <td><?php echo $row_RsChoixClasse['classe']; ?></td>
          <td><?php echo $row_RsChoixClasse['pass']; ?></td>
        </tr>
        <?php } while ($row_RsChoixClasse = mysql_fetch_assoc($RsChoixClasse)); ?>
    </table></td>
  </tr>
  <tr> 
    <td width="300" valign="top"> <p>&nbsp;</p>
      <p> 
        <input name="Submit5" type="submit" onClick="MM_goToURL('parent','gestion_eleve_txt.php');return document.MM_returnValue" value="Ins&eacute;rer des &eacute;l&egrave;ves depuis un fichier">
      </p>
      <p>&nbsp;</p>
      <p><strong>Ajout d'un &eacute;l&egrave;ve dans une classe existante</strong></p>
      <form method="post" name="form3" style="margin:0px" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline"> 
            <td nowrap align="right">Nom:</td>
            <td><input type="text" name="nom" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Prenom:</td>
            <td><input type="text" name="prenom" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Classe:</td>
            <td><select name="classe" id="classe">
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
              </select></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Mot de passe:</td>
            <td><input type="text" name="pass" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Ajouter cet &eacute;l&egrave;ve"></td>
          </tr>
        </table>
        <input type="hidden" name="ID_eleve" value="">
        <input type="hidden" name="MM_insert" value="form3">
    </form></td>
  </tr>
  <tr> 
    <td width="300" valign="top"> <p><strong>Ajout d'un &eacute;l&egrave;ve avec cr&eacute;ation 
        d'une nouvelle classe</strong></p>
      <form method="post" style="margin:0px" name="form1" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline"> 
            <td nowrap align="right">Nom:</td>
            <td><input type="text" name="nom" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Prenom:</td>
            <td><input type="text" name="prenom" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Classe:</td>
            <td><input type="text" name="classe" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Mot de passe::</td>
            <td><input type="text" name="pass" value="" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Ajouter cet &eacute;l&egrave;ve"></td>
          </tr>
        </table>
        <input type="hidden" name="ID_eleve" value="">
        <input type="hidden" name="MM_insert" value="form1">
    </form></td>
  </tr>
  <tr> 
    <td width="300" valign="top"> <p><strong>Suppression d'un &eacute;l&egrave;ve</strong></p>
      <form name="form2" style="margin:0px" method="post" action="gestion_eleve.php">
        <p> 
          <select name="classe" id="classe">
            <?php
do {  
?>
            <option value="<?php echo $row_rsClasse['classe']?>"<?php if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";} ?>><?php echo $row_rsClasse['classe']?></option>
            <?php
} while ($row_rsClasse = mysql_fetch_assoc($rsClasse));
  $rows = mysql_num_rows($rsClasse);
  if($rows > 0) {
      mysql_data_seek($rsClasse, 0);
	  $row_rsClasse = mysql_fetch_assoc($rsClasse);
  }
?>
          </select>
          <input type="submit" name="Submit4" value="S&eacute;lectionner la classe">
      </form>
      <?php if (isset($_POST['classe'])) { ?>
      <form name="form4" style="margin:0px" method="get" action="gestion_eleve.php">
        <select name="numsupeleve" id="select3">
          <?php
do {  
?>
          <option value="<?php echo $row_Rschoixeleve['ID_eleve']?>"<?php if (!(strcmp($row_Rschoixeleve['ID_eleve'], $_POST['numeleve']))) {echo "SELECTED";} ?>><?php echo $row_Rschoixeleve['nom']?></option>
          <?php
} while ($row_Rschoixeleve = mysql_fetch_assoc($Rschoixeleve));
  $rows = mysql_num_rows($Rschoixeleve);
  if($rows > 0) {
      mysql_data_seek($Rschoixeleve, 0);
	  $row_Rschoixeleve = mysql_fetch_assoc($Rschoixeleve);
  }
?>
        </select>
        <input type="submit" name="Submit22" value="Supprimer cet &eacute;l&egrave;ve">
        <input name="classe" type="hidden" id="select" value="<?php echo $_POST['classe']?>">
      </form>
    <?php } ?> </td>
  </tr>
  <tr> 
    <td width="300" valign="top"> <p><strong>Modification d'un nom ou classe d'un &eacute;l&egrave;ve</strong></p>
      <form name="form2" style="margin:0px" method="post" action="gestion_eleve.php">
        <select name="classe" id="classe">
          <?php
do {  
?>
          <option value="<?php echo $row_rsClasse['classe']?>"<?php if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";} ?>><?php echo $row_rsClasse['classe']?></option>
          <?php
} while ($row_rsClasse = mysql_fetch_assoc($rsClasse));
  $rows = mysql_num_rows($rsClasse);
  if($rows > 0) {
      mysql_data_seek($rsClasse, 0);
	  $row_rsClasse = mysql_fetch_assoc($rsClasse);
  }
?>
        </select>
        <input type="submit" name="Submit" value="S&eacute;lectionner la classe">
      </form>
      <?php if (isset($_POST['classe'])) {	?>
      <form name="form4" style="margin:0px" method="post" action="">
        <select name="numeleve" id="numeleve">
          <?php
do {  
?>
          <option value="<?php echo $row_Rschoixeleve['ID_eleve']?>"<?php if (!(strcmp($row_Rschoixeleve['ID_eleve'], $_POST['numeleve']))) {echo "SELECTED";} ?>><?php echo $row_Rschoixeleve['nom']?></option>
          <?php
} while ($row_Rschoixeleve = mysql_fetch_assoc($Rschoixeleve));
  $rows = mysql_num_rows($Rschoixeleve);
  if($rows > 0) {
      mysql_data_seek($Rschoixeleve, 0);
	  $row_Rschoixeleve = mysql_fetch_assoc($Rschoixeleve);
  }
?>
        </select>
        <input type="submit" name="Submit2" value="S&eacute;lectionner l'&eacute;l&egrave;ve">
        <input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
      </form>
      <?php if (isset($_POST['numeleve'])) { ?>
      <form style="margin:0px" method="post" name="form5" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline"> 
            <td nowrap align="right">Nom:</td>
            <td><input type="text" name="nom" value="<?php echo $row_RsModifEleve['nom']; ?>" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Prenom:</td>
            <td><input type="text" name="prenom" value="<?php echo $row_RsModifEleve['prenom']; ?>" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Classe:</td>
            <td><input type="text" name="classe" value="<?php echo $row_RsModifEleve['classe']; ?>" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Mot de passe::</td>
            <td><input type="text" name="pass" value="<?php echo $row_RsModifEleve['pass']; ?>" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Mettre à jour l'enregistrement"></td>
          </tr>
        </table>
        <input type="hidden" name="ID_eleve" value="<?php echo $row_RsModifEleve['ID_eleve']; ?>">
        <input type="hidden" name="MM_update" value="form5">
        <input type="hidden" name="ID_eleve" value="<?php echo $row_RsModifEleve['ID_eleve']; ?>">
      </form>
    <?php } } ?> </td>
  </tr>
  <tr> 
    <td width="300" valign="top">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
</body>
</html>
<?php
mysql_free_result($RsEleve);

mysql_free_result($rsClasse);

mysql_free_result($RsChoixClasse);

mysql_free_result($RsAjout);

mysql_free_result($Rschoixeleve);

mysql_free_result($RsModifEleve);
?>

