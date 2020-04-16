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
  mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsMax = "SELECT MAX(pos_theme) AS resultat FROM stock_theme ";
  $RsMax = mysql_query($query_RsMax, $conn_intranet) or die(mysql_error());
  $row_RsMax = mysql_fetch_assoc($RsMax);
  $position=$row_RsMax['resultat']+1;


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO stock_theme (ID_theme, theme, mat_ID, niv_ID, pos_theme) VALUES (%s, %s, %s, %s ,%s)",
                       GetSQLValueString($_POST['ID_theme'], "int"),
                       GetSQLValueString($_POST['theme'], "text"),
					   GetSQLValueString($_POST['mat_ID'], "int"),
                       GetSQLValueString($_POST['niv_ID'], "int"),
					   GetSQLValueString($position, "int")
					   );

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($insertSQL, $conn_intranet) or die(mysql_error());
}

$choixmat_RsTheme = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsTheme = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
$choixniv_RsTheme = "0";
if (isset($_GET['niveau_ID'])) {
  $choixniv_RsTheme = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.pos_theme", $choixmat_RsTheme,$choixniv_RsTheme);
$RsTheme = mysql_query($query_RsTheme, $conn_intranet) or die(mysql_error());
$row_RsTheme = mysql_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysql_num_rows($RsTheme);

$choixmat_RsChoixmatiere = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsChoixmatiere = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixmatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $choixmat_RsChoixmatiere);
$RsChoixmatiere = mysql_query($query_RsChoixmatiere, $conn_intranet) or die(mysql_error());
$row_RsChoixmatiere = mysql_fetch_assoc($RsChoixmatiere);
$totalRows_RsChoixmatiere = mysql_num_rows($RsChoixmatiere);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysql_query($query_rs_matiere, $conn_intranet) or die(mysql_error());
$row_rs_matiere = mysql_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysql_num_rows($rs_matiere);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysql_query($query_rs_niveau, $conn_intranet) or die(mysql_error());
$row_rs_niveau = mysql_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysql_num_rows($rs_niveau);
?>
 
<html>
<head>
<title>Gestion des th&egrave;mes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><img src="../patate.gif" width="60" height="42"> <img src="../patate.jpg" width="324" height="39" align="top"></p>
<p><strong> <a href="../index.php">Accueil stockpotatoes</a> - <a href="accueil_enseignant.php">Espace Enseignant</a> - Gestion des th&egrave;mes d'&eacute;tude dans une mati&egrave;re</strong></p>

<form name="form1" method="GET" action="gestion_theme.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_GET['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_GET['matiere_ID']))) {echo "SELECTED";} }  ?>><?php echo $row_rs_matiere['nom_mat']?></option>
            <?php
} while ($row_rs_matiere = mysql_fetch_assoc($rs_matiere));
  $rows = mysql_num_rows($rs_matiere);
  if($rows > 0) {
      mysql_data_seek($rs_matiere, 0);
	  $row_rs_matiere = mysql_fetch_assoc($rs_matiere);
  }
?>
          </select>
        </div></td>
      <td width="21%"><div align="center"> 
          <select name="niveau_ID" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_GET['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
            <?php
} while ($row_rs_niveau = mysql_fetch_assoc($rs_niveau));
  $rows = mysql_num_rows($rs_niveau);
  if($rows > 0) {
      mysql_data_seek($rs_niveau, 0);
	  $row_rs_niveau = mysql_fetch_assoc($rs_niveau);
  }
?>
          </select>
        </div></td>
      <td width="44%"> <input type="submit" name="Submit3" value="S&eacute;lectionner"></td>
      <td width="44%"><div align="center"><font size="6"><strong> 
          <?php 
	  if (isset($_GET['matiere_ID'])) { 
	  echo $row_RsChoixmatiere['nom_mat']; }
	  ?>
          </strong></font></div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<?php  if (isset($_GET['matiere_ID'])) {   



?>
<div align="center"> 
  <p><font size="6"></font></p>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top">
	<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
        <p align="center"><strong>Ins&eacute;rer un nouveau th&egrave;me d'&eacute;tude 
          pour cette mati&egrave;re</strong></p>
        <table align="center">
          <tr valign="baseline"> 
            <td><input type="text" name="theme" value="" size="48"></td>
          </tr>
          <tr valign="baseline"> 
            <td> <p align="center"><br>
                <input name="submit" type="submit" value="Enregistrer ce nouveau th&egrave;me d'&eacute;tude ">
              </p></td>
          </tr>
        </table>
        <p> 
          <input type="hidden" name="ID_theme" value="">
          <input type="hidden" name="mat_ID" value="<?php echo $_GET['matiere_ID'] ?>">
          <input type="hidden" name="niv_ID" value="<?php echo $_GET['niveau_ID'] ?>">
          <input type="hidden" name="MM_insert" value="form2">
          <input name="ID_mat2" type="hidden" id="ID_mat3" value="<?php echo $_POST['ID_mat'] ?>">
        </p>
        <p>&nbsp; </p>
    </form></td>
    <td width="8%" rowspan="2">&nbsp;</td>
    <td rowspan="2" valign="top"> <div align="center"> 
        <table border="1">
          <tr> 
            <td bgcolor="#CCCC99"> <div align="center"><strong>N&deg;</strong></div></td>
            <td bgcolor="#CCCC99">&nbsp;</td>
            <td bgcolor="#CCCC99">&nbsp;</td>
            <td bgcolor="#CCCC99"><div align="center"><strong>Th&egrave;me d'&eacute;tude</strong></div></td>
            <td bgcolor="#CCCC99">&nbsp;</td>
            <td bgcolor="#CCCC99"> <div align="center"></div></td>
          </tr>
          <?php 
			$x=0;
		 do {
		  $x=$x+1;
		  $tabpos1[$x]=$row_RsTheme['pos_theme'];$tabid1[$x]=$row_RsTheme['ID_theme'];
        	   } while ($row_RsTheme = mysql_fetch_assoc($RsTheme)); 
			   


		 
		 if ($totalRows_RsTheme !=0)
		
		  {
		  mysql_data_seek($RsTheme,0);		
	      $row_RsTheme = mysql_fetch_assoc($RsTheme);
		  $t1=$x; $x=0;

		  do { 
		  
		    $x=$x+1; 
		  ?>
          <tr valign="top" class="retrait20"> 
            <td class="retrait20"><?php echo $row_RsTheme['ID_theme']; ?></td>
<td bgcolor="#CCCC99" >
			  <?php if($x!=1) { ?>            
			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter_theme.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $_GET['niveau_ID']; ?>
			  <?php echo '"><input name="niveau_ID" type="hidden" id="niveau_ID" value="';?>
			  <?php echo $_GET['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_RsTheme['ID_theme'] ?>
			  
			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
			  <?php echo $tabid1[$x-1] ?>
			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
			  <?php echo $tabpos1[$x-1] ?>
			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce thème "></div>';?>
              <?php echo ' </form>';
			   
			     } else {echo '&nbsp;';};?>	
			
		    </td>
			  <td bgcolor="#CCCC99">
			  
			   
			   <?php if($x!=$t1) { ?>            
			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre_theme.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $_GET['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_RsTheme['ID_theme'] ?>
			  
			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
			  <?php echo $tabid1[$x+1] ?>
			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
			  <?php echo $tabpos1[$x+1] ?>
			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce thème "></div>';?>
              <?php echo ' </form>';
			   } else {echo '&nbsp;';};?>	
			  </td>
            <td class="retrait20"><?php echo $row_RsTheme['theme']; ?></td>
            <td> 
              <form name="form4" style="margin:0px" method="post" action="verif_supp_theme.php">
                <input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $row_RsTheme['ID_theme'] ?>">
                <input type="submit" name="Submit" value="Supprimer">
              </form></td>
            <td> 
              <form name="form3" style="margin:0px" method="post" action="modif_theme.php">
                <input name="ID_theme" type="hidden" id="ID_theme" value="<?php echo $row_RsTheme['ID_theme'] ?>">
                <input type="submit" name="Submit2" value="Modifier">
              </form></td>
          </tr>
          <?php 
		  } while ($row_RsTheme = mysql_fetch_assoc($RsTheme));
 		  } //du if totalrow different de zero 
		  ?>
       </table>
      </div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p align="right">&nbsp;</p>
<?php  }   ?>
</body>
</html>
<?php
mysql_free_result($RsTheme);

mysql_free_result($RsChoixmatiere);

mysql_free_result($rs_matiere);

mysql_free_result($rs_niveau);
?>

