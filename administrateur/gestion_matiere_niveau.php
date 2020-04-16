<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
function sans_accent($chaine) 
{ 
   $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
   return strtr(trim($chaine),$accent,$noaccent); 
} 

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


if ((isset($_GET['niveau_supp_ID'])) && ($_GET['niveau_supp_ID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM stock_niveau WHERE ID_niveau=%s",
                       GetSQLValueString($_GET['niveau_supp_ID'], "int"));

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error());

  $deleteGoTo = "confirm_supp_niv.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form10")) {
  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $query_RsMax = "SELECT MAX(pos_niv) AS resultat FROM stock_niveau ";
  $RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error());
  $row_RsMax = mysqli_fetch_assoc($RsMax);
  $position=$row_RsMax['resultat']+1;

  
  $insertSQL = sprintf("INSERT INTO stock_niveau (nom_niveau , pos_niv) VALUES (%s, %s)",
                       
                       GetSQLValueString($_POST['nom_niveau'], "text"),
					   GetSQLValueString($position, "int")

					   );

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error());

  $insertGoTo = "gestion_matiere_niveau.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form9")) {
  $insertSQL = sprintf("INSERT INTO stock_matiere (nom_mat) VALUES ( %s)",
                       
                       GetSQLValueString($_POST['nom_mat'], "text"));
$nom_matiere=sans_accent($_POST['nom_mat']);
$repertoire='../Exercices/'.$nom_matiere;

$old_umask = umask(0);
mkdir ($repertoire, 0777);
umask($old_umask);



  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error());

  $insertGoTo = "gestion_matiere_niveau.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form8")) {
  $updateSQL = sprintf("UPDATE stock_niveau SET nom_niveau=%s WHERE ID_niveau=%s",
                       GetSQLValueString($_POST['nom_niveau'], "text"),
                       GetSQLValueString($_POST['ID_niveau'], "int"));

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());

  $updateGoTo = "gestion_matiere_niveau.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form7")) {
  $updateSQL = sprintf("UPDATE stock_matiere SET nom_mat=%s WHERE ID_mat=%s",
                       GetSQLValueString($_POST['nom_mat'], "text"),
                       GetSQLValueString($_POST['ID_mat'], "int"));

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());

  $updateGoTo = "gestion_matiere_niveau.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMatiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error());
$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysqli_num_rows($RsMatiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsNiveau = "SELECT * FROM stock_niveau ORDER BY stock_niveau.pos_niv";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error());
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysqli_num_rows($RsNiveau);

$colname_RsModifMatiere = "1";
if (isset($_GET['matiere_modif_ID'])) {
  $colname_RsModifMatiere = (get_magic_quotes_gpc()) ? $_GET['matiere_modif_ID'] : addslashes($_GET['matiere_modif_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsModifMatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = %s", $colname_RsModifMatiere);
$RsModifMatiere = mysqli_query($conn_intranet, $query_RsModifMatiere) or die(mysqli_error());
$row_RsModifMatiere = mysqli_fetch_assoc($RsModifMatiere);
$totalRows_RsModifMatiere = mysqli_num_rows($RsModifMatiere);

$colname_RsModifNiveau = "1";
if (isset($_GET['niveau_modif_ID'])) {
  $colname_RsModifNiveau = (get_magic_quotes_gpc()) ? $_GET['niveau_modif_ID'] : addslashes($_GET['niveau_modif_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsModifNiveau = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_RsModifNiveau);
$RsModifNiveau = mysqli_query($conn_intranet, $query_RsModifNiveau) or die(mysqli_error());
$row_RsModifNiveau = mysqli_fetch_assoc($RsModifNiveau);
$totalRows_RsModifNiveau = mysqli_num_rows($RsModifNiveau);
?>

<html>
<head>
<title>Gestion des mati&egrave;res et des niveaux</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p> <img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_admin.php">Espace Administrateu</a>r</strong><strong> - Gestion des 
  mati&egrave;res et des niveaux</strong></p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr> 
    <td width="50%"><strong>Gestion des mati&egrave;res</strong></td>
    <td width="50%"><strong>Gestion des niveaux</strong></td>
  </tr>
  <tr> 
    <td width="50%" height="51"> <form method="post" name="form9" action="<?php echo $editFormAction; ?>">
        <table cellspacing="10">
          <tr valign="baseline"> 
            <td nowrap align="right"> <input name="nom_mat" type="text" id="nom_mat" value="" size="32">
            </td>
            <td width="50%"><input name="submit" type="submit" value="Cr&eacute;er cette mati&egrave;re"></td>
          </tr>
        </table>
        <p class="retrait20">
          <input type="hidden" name="ID_mat" value="">
          <input type="hidden" name="MM_insert" value="form9">
        </p>
    </form></td>
    <td width="50%"> <form method="post" name="form10" action="<?php echo $editFormAction; ?>">
        <div align="left"></div>
        <table cellspacing="10">
          <tr align="left" valign="baseline"> 
            <td align="left" nowrap> <div align="left"> 
                <input name="nom_niveau" type="text" id="nom_niveau" value="" size="32">
                </div></td>
            <td width="50%"> <input name="submit2" type="submit" value="Cr&eacute;er ce niveau"></td>
          </tr>
        </table>
        <p class="retrait20">
          <input type="hidden" name="ID_niveau" value="">
          <input type="hidden" name="MM_insert" value="form10">
        </p>
    </form></td>
  </tr>
  <tr> 
    <td width="50%"> <form name="form4" method="POST" action="verif_supp_mat.php">
        <table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr> 
            <td> <select name="matiere_supp_ID" id="select2">
                <?php
do {  
?>
                <option value="<?php echo $row_RsMatiere['ID_mat']?>"><?php echo $row_RsMatiere['nom_mat']?></option>
                <?php
} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere));
  $rows = mysqli_num_rows($RsMatiere);
  if($rows > 0) {
      mysqli_data_seek($RsMatiere, 0);
	  $row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
  }
?>
              </select></td>
            <td width="50%"> <input type="submit" name="Submit" value="Supprimer cette mati&egrave;re"></td>
          </tr>
        </table>
    </form></td>
    <td width="50%"> <form name="form5" method="get" action="gestion_matiere_niveau.php">
        <table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr> 
            <td> <select name="niveau_supp_ID" id="niveau_supp_ID">
                <?php
do {  
?>
                <option value="<?php echo $row_RsNiveau['ID_niveau']?>"><?php echo $row_RsNiveau['nom_niveau']?></option>
                <?php
} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
  $rows = mysqli_num_rows($RsNiveau);
  if($rows > 0) {
      mysqli_data_seek($RsNiveau, 0);
	  $row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
  }
?>
              </select></td>
            <td width="50%"> <input type="submit" name="Submit2" value="Supprimer ce niveau">            </td>
          </tr>
        </table>
    </form></td>
  </tr>
  <tr> 
    <td width="50%" valign="top"> <form name="form3" method="get" action="gestion_matiere_niveau.php">
        <table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr> 
            <td> <select name="matiere_modif_ID" id="select">
                <?php
do {  
?>
                <option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($_GET['matiere_modif_ID'])) { if (!(strcmp($row_RsMatiere['ID_mat'], $_GET['matiere_modif_ID']))) {echo "SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
                <?php 
} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere));
  $rows = mysqli_num_rows($RsMatiere);
  if($rows > 0) {
      mysqli_data_seek($RsMatiere, 0);
	  $row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
  }
?>
              </select></td>
            <td width="50%"> <input type="submit" name="Submit3" value="Modifier cette mati&egrave;re"></td>
          </tr>
        </table>
      </form>
      <?php  if (isset($_GET['matiere_modif_ID'])) { ?>
      <form method="post" name="form7" action="<?php echo $editFormAction; ?>">
        <table align="left">
          <tr valign="baseline"> 
            <td nowrap align="right"><input type="text" name="nom_mat" value="<?php echo $row_RsModifMatiere['nom_mat']; ?>" size="25">
              :</td>
            <td><input name="submit3" type="submit" value="Modifier le nom de la mati&egrave;re"></td>
          </tr>
        </table>
        <p><br>
          <input type="hidden" name="ID_mat" value="<?php echo $row_RsModifMatiere['ID_mat']; ?>">
          <input type="hidden" name="MM_update" value="form7">
          <input type="hidden" name="ID_mat" value="<?php echo $row_RsModifMatiere['ID_mat']; ?>">
        </p>
      </form>
      <p align="center">&nbsp;</p>
      <p align="center"><font color="#CC0000"><strong><font size="2">Attention</font></strong></font></p>
      <p align="left"><font color="#CC0000" size="2">Pour cette op&eacute;ration, 
        il vous faudra &eacute;galement modifier manuellement le nom du dossier 
        mati&egrave;re correspondant pr&eacute;sent dans le dossier Exercices sur le serveur.</font></p>
    <?php } ?></td>
    <td width="50%" valign="top"> <form name="form6" method="get" action="gestion_matiere_niveau.php">
        <table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr> 
            <td> <select name="niveau_modif_ID" id="niveau_modif_ID">
                <?php
do { 
?>
                <option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($_GET['niveau_modif_ID'])) { if (!(strcmp($row_RsNiveau['ID_niveau'], $_GET['niveau_modif_ID']))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
                <?php 
} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
  $rows = mysqli_num_rows($RsNiveau);
  if($rows > 0) {
      mysqli_data_seek($RsNiveau, 0);
	  $row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
  }
?>
              </select></td>
            <td width="50%"> <input type="submit" name="Submit4" value="Modifier ce niveau"></td>
          </tr>
        </table>
      </form>
      <?php if (isset($_GET['niveau_modif_ID'])) { ?>
      <form method="post" name="form8" action="<?php echo $editFormAction; ?>">
        <table align="left">
          <tr valign="baseline"> 
            <td nowrap align="right"><input type="text" name="nom_niveau" value="<?php echo $row_RsModifNiveau['nom_niveau']; ?>" size="25">
              :</td>
            <td><input name="submit4" type="submit" value="Modifier le nom du niveau"></td>
          </tr>
        </table>
        <p><br>
          <input type="hidden" name="ID_niveau" value="<?php echo $row_RsModifNiveau['ID_niveau']; ?>">
          <input type="hidden" name="MM_update" value="form8">
          <input type="hidden" name="ID_niveau" value="<?php echo $row_RsModifNiveau['ID_niveau']; ?>">
        </p>
        <p>&nbsp; </p>
      </form>
      <p>&nbsp;</p>
    <?php } ?></td>
  </tr>
  <tr> 
    <td width="50%" valign="top"> <p><strong>Liste des mati&egrave;res</strong></p>
      <p><em>Les mati&egrave;res sont class&eacute;es par ordre alphab&eacute;tique . </em></p>
      <table border="1">
        <tr bgcolor="#CCCC99"> 
          <td> <div align="center"><strong>ID_mat</strong></div></td>
          <td> <div align="center"><strong>Mati&egrave;res</strong></div></td>
        </tr>
        <?php do { ?>
        <tr> 
          <td class="retrait20"><div align="right"><?php echo $row_RsMatiere['ID_mat']; ?></div></td>
          <td class="retrait20"><?php echo $row_RsMatiere['nom_mat']; ?></td>
        </tr>
        <?php } while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere)); ?>
    </table></td>
    <td width="50%" valign="top"> <p><strong>Liste des niveaux</strong></p>
      <p><em>Vous pouvez classer les niveaux (<img src="up.gif" width="15" height="10"><img src="down.gif" width="15" height="10"> ) </em></p>
      <table border="1">
        <tr bgcolor="#CCCC99"> 
          <td> <div align="center"><strong>ID_niveau</strong></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td> <div align="center"><strong>Niveaux</strong></div></td>
        </tr>
        <?php 
        
			$x=0;
		 do {
		  $x=$x+1;
		  $tabpos1[$x]=$row_RsNiveau['pos_niv'];$tabid1[$x]=$row_RsNiveau['ID_niveau'];
        	   } while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)); 
			   

		 if ($totalRows_RsNiveau !=0)
		
		  {
		  mysqli_data_seek($RsNiveau,0);		
	      $row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
		  $t1=$x; $x=0;

		  do { 
		  
		    $x=$x+1; 
		  ?>
        <tr> 
          <td><div align="right" class="retrait20"><?php echo $row_RsNiveau['ID_niveau']; ?></div></td>
          <td valign="top" bgcolor="#CCCC99" class="retrait20" >
            <?php if($x!=1) { ?>
            <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter_niveau.php';?> 
			<?php echo '"><div align="center"><input name="ID_niveau" type="hidden" id="ID_niveau" value="';?> 
			<?php echo $row_RsNiveau['ID_niveau'] ?> 
			<?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?> <?php echo $tabid1[$x-1] ?> 
			<?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?> <?php echo $tabpos1[$x-1] ?> 
			<?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="up.gif" alt="Remonter ce niveau "></div>';?> <?php echo ' </form>';
			   
			     } else {echo '&nbsp;';};?> </td>
          <td valign="top" bgcolor="#CCCC99" class="retrait20">
            <?php if($x!=$t1) { ?>
            <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre_niveau.php';?>
            <?php echo '"><div align="center"><input name="ID_niveau" type="hidden" id="ID_niveau" value="';?> 
			<?php echo $row_RsNiveau['ID_niveau'] ?> 
			<?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?> <?php echo $tabid1[$x+1] ?> 
			<?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?> <?php echo $tabpos1[$x+1] ?> 
			<?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="down.gif" alt="Descendre ce niveau "></div>';?> <?php echo ' </form>';
			   } else {echo '&nbsp;';};?> </td>
          <td class="retrait20"><?php echo $row_RsNiveau['nom_niveau']; ?></td>
        </tr>
        <?php } while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)); 
		}
		?>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($RsMatiere);

mysqli_free_result($RsNiveau);

mysqli_free_result($RsModifMatiere);

mysqli_free_result($RsModifNiveau);


?>

