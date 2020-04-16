<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
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



if ((isset($_POST['ID_quiz'])) && ($_POST['ID_quiz'] != "")) {
$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz=%s",
                       GetSQLValueString($_POST['ID_quiz'], "int"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  
 if (isset($_POST['confirm'])) 
 {
 $Result1 = mysql_query($deleteSQL, $conn_intranet) or die(mysql_error());
 }


$choixquiz_RsQuiz = "0";
if (isset($_POST['ID_quiz'])) {
  $choixquiz_RsQuiz = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsQuiz = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.ID_quiz=%s", $choixquiz_RsQuiz);
$RsQuiz = mysql_query($query_RsQuiz, $conn_intranet) or die(mysql_error());
$row_RsQuiz = mysql_fetch_assoc($RsQuiz);
$totalRows_RsQuiz = mysql_num_rows($RsQuiz);

$repertoire='../Exercices/'.$_POST['nom_mat'].'/q'.$_POST['ID_quiz'];

if (isset($_POST['confirm'])) {
effacer($repertoire);

 $deleteGoTo = "supp_quiz_confirm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
  $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
  $deleteGoTo .= $_SERVER['QUERY_STRING'];
}
header(sprintf("Location: %s", $deleteGoTo));
  }
}
?>

<html>
<head>
<title>Suppression d'un exercice</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">

</head>
<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0" onMouseOver="MM_goToURL('parent','gestion_exos.php');return document.MM_returnValue">
  <tr valign="top"> 
    <td width="45%"> <div align="left"><img src="../patate.gif" width="253" height="227"></div></td>
    <td width="55%"> 
      <div align="center"><img src="../patate.jpg" width="324" height="39">
       
        <form name="form1" method="post" action="supp_quiz.php">
          <p><strong>Vous avez demand&eacute; la suppression de l'exercice</strong></p>
          <p><strong><font color="#CC0000" size="3"><?php echo $row_RsQuiz['titre']; ?></font></strong></p>
          <p><font size="3"><strong>en <?php echo $_POST['nom_mat']?></strong></font></p>
          <p> 
            <input name="confirm" type="submit" id="confirm" value="Confirmer la suppression">
            <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $_POST['ID_quiz']?>">
            <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $_POST['nom_mat']?>">
      
			<br>
          </p>
    
        </form>
        <p><strong><a href="gestion_exos.php">Abandonner et retourner &agrave; 
          la gestion des exercices</a></strong></p>
</div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
</body>
</html>

<?php mysql_free_result($RsQuiz); ?>