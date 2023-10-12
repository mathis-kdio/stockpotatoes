<?php session_start();
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




$varmat_RsMatSupp = "0";
if (isset($_POST['matiere_supp_ID'])) {
  $varmat_RsMatSupp = (get_magic_quotes_gpc()) ? $_POST['matiere_supp_ID'] : addslashes($_POST['matiere_supp_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMatSupp = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $varmat_RsMatSupp);
$RsMatSupp = mysqli_query($conn_intranet, $query_RsMatSupp) or die(mysqli_error($conn_intranet));
$row_RsMatSupp = mysqli_fetch_assoc($RsMatSupp);
$totalRows_RsMatSupp = mysqli_num_rows($RsMatSupp);

  if (isset($_POST['Suppression'])) {

function effacer($fichier) {
  if (file_exists($fichier)) {
    chmod($fichier,0777);
    if (is_dir($fichier)) {
      $id_dossier = opendir($fichier); 
      while($element = readdir($id_dossier)) {
        if ($element != "." && $element != "..")
        unlink($fichier."/".$element);
      }
      closedir($id_dossier);
      rmdir($fichier);
    }
    else delete($fichier);
  }
}
$deleteSQL = sprintf("DELETE FROM stock_matiere WHERE ID_mat=%s",
                       GetSQLValueString($_POST['matiere_supp_ID'], "int"));
$nom_matiere=sans_accent($row_RsMatSupp['nom_mat']);
$repertoire='../Exercices/'.$nom_matiere;

effacer($repertoire);

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

  $deleteGoTo = "confirm_supp_mat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysqli_free_result($RsMatSupp);

?>
<Html>
<link href="../style_jaune.css" rel="stylesheet" type="text/css">

<title>Suppression d'une mati&egrave;re &gt; V&eacute;rification</title><body>
<p><font size="3"><img src="../patate.jpg" width="324" height="39"></font></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center"><font color="#993333" size="3"><strong>Attention, </strong>vous 
  avez demand&eacute; la suppression de la mati&egrave;re<strong> <font color="#000000"><?php echo $row_RsMatSupp['nom_mat']; ?></font></strong></font></p>
<p align="center"><font size="3">Ce dossier <strong><?php echo $row_RsMatSupp['nom_mat']; ?> </strong>contient peut-&ecirc;tre des<font color="#993333"><strong> 
  exercices qui seront &eacute;galement supprim&eacute;s.</strong></font></font></p>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr> 
    <td><form name="form2" method="post" action="gestion_matiere_niveau.php">
        <div align="center"> 
          <input type="submit" name="Submit2" value="Abandonner">
        </div>
      </form></td>
    <td><form name="form1" method="post" action="verif_supp_mat.php">
        <div align="center">
          <input name="matiere_supp_ID" type="hidden" id="matiere_supp_ID" value="<?php echo $_POST['matiere_supp_ID']?>">
          <input type="submit" name="Suppression" value="Je confirme la suppression">
        </div>
      </form></td>
  </tr>
</table>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p>&nbsp; </p>
</body>
</html>