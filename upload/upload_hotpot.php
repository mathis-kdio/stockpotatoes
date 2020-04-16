<?php session_start();
if (isset($_SESSION['Sess_nom'])) {
	if ($_SESSION['Sess_nom']=='Enseignant') { $_SESSION['Sess_nom']='Upload';} 
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
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
	
	
$choixmat_RsTheme = "0";
if (isset($_POST['matiere_ID'])) {
  $choixmat_RsTheme = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
$choixniv_RsTheme = "0";
if (isset($_POST['niveau_ID'])) {
  $choixniv_RsTheme = (get_magic_quotes_gpc()) ? $_POST['niveau_ID'] : addslashes($_POST['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.theme", $choixmat_RsTheme,$choixniv_RsTheme);
$RsTheme = mysql_query($query_RsTheme, $conn_intranet) or die(mysql_error());
$row_RsTheme = mysql_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysql_num_rows($RsTheme);

$selection_RsChoixMatiere = "0";
if (isset($_POST['matiere_ID'])) {
  $selection_RsChoixMatiere = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $selection_RsChoixMatiere);
$RsChoixMatiere = mysql_query($query_RsChoixMatiere, $conn_intranet) or die(mysql_error());
$row_RsChoixMatiere = mysql_fetch_assoc($RsChoixMatiere);
$totalRows_RsChoixMatiere = mysql_num_rows($RsChoixMatiere);





if (!Empty($_POST['submit2'])) {
if ($_POST['titre']=='') {
 print '<strong><center><font size=5 color="#FF0000">Il faut donner un titre à votre document </font> </center></strong>';
    echo '<BR><hr>';
} else {

   // Ok pour enregistrer
   
//enregistrement dans la table
  if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  if ((isset($_POST['en_ligne'])) && ($_POST['en_ligne']=='O')){$en_ligne='O';} else {$en_ligne='N';}
  if ((isset($_POST['avec_score'])) && ($_POST['avec_score']=='O')){$avec_score='O';} else {$avec_score='N';}
  if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul']=='O')){$evaluation_seul='O';} else {$evaluation_seul='N';}
  if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul']=='O')){$avec_score='O';}
  
  $query_RsMax = "SELECT MAX(pos_doc) AS resultat FROM stock_quiz ";
  $RsMax = mysql_query($query_RsMax, $conn_intranet) or die(mysql_error());
  $row_RsMax = mysql_fetch_assoc($RsMax);
  $position=$row_RsMax['resultat']+1;
  
  $type_doc = 2;
  $insertSQL = sprintf("INSERT INTO stock_quiz (titre, fichier, matiere_ID, niveau_ID,theme_ID, auteur, en_ligne, avec_score, evaluation_seul, cat_doc, type_doc, pos_doc) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s)",
                       
                       GetSQLValueString($_POST['titre'], "text"),
                       GetSQLValueString($_FILES['fichier']['name'], "text"),
					   GetSQLValueString($_POST['matiere_ID'], "text"),
                       GetSQLValueString($_POST['niveau_ID'], "text"),
					   GetSQLValueString($_POST['theme_ID'], "int"),
                       GetSQLValueString($_POST['auteur'], "text"),
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
					   GetSQLValueString($evaluation_seul, "text"),
					   GetSQLValueString($_POST['cat_doc'], "int"),
					   GetSQLValueString($type_doc, "int"),
					   GetSQLValueString($position, "int"));

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($insertSQL, $conn_intranet) or die(mysql_error());
  mysql_free_result($RsMax);
}
//fin enregistrement ds la table

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsMaxId_quiz = "SELECT MAX( Id_quiz )  FROM stock_quiz";
$RsMaxId_quiz = mysql_query($query_RsMaxId_quiz, $conn_intranet) or die(mysql_error());
$row_RsMaxId_quiz = mysql_fetch_assoc($RsMaxId_quiz);
$totalRows_RsMaxId_quiz = mysql_num_rows($RsMaxId_quiz);

$total=$row_RsMaxId_quiz['MAX( Id_quiz )'];
mysql_free_result($RsMaxId_quiz);
$nom_matiere=sans_accent($row_RsChoixMatiere['nom_mat']);
$repertoire='../Exercices/'.$nom_matiere.'/q'.$total;

if (is_dir($repertoire)) {echo "<center> Le dossier ".$repertoire." existait déjà </center><BR> "; } else { mkdir($repertoire,0777);}
if ($_FILES['fichier']['tmp_name']<>'') {
    $dossier_destination = $repertoire; 
    $dossier_temporaire = $_FILES['fichier']['tmp_name'];
	$type_fichier = $_FILES['fichier']['type'];
	$nom_fichier = $_FILES['fichier']['name'];
	$erreur= $_FILES['fichier']['error'];
	if ($erreur == 2 ) {
		exit ("Le fichier dépasse la taille de 100 Mo.");
		$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz=%s",
                       GetSQLValueString($total, "int"));
		mysql_select_db($database_conn_cahier_de_texte, $conn_cahier_de_texte);
  		$Result1 = mysql_query($deleteSQL, $conn_cahier_de_texte) or die(mysql_error());
	}
	if ($erreur == 3 ) {
		exit ("Le fichier travail a été partiellement transféré. Envoyez-le à nouveau.");
		$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz=%s",
                       GetSQLValueString($total, "int"));
		mysql_select_db($database_conn_cahier_de_texte, $conn_cahier_de_texte);
  		$Result1 = mysql_query($deleteSQL, $conn_cahier_de_texte) or die(mysql_error());
	}
	if( !move_uploaded_file($dossier_temporaire, $dossier_destination.'/'.$nom_fichier) )
    {
        exit("Impossible de copier le fichier ");
		$deleteSQL = sprintf("DELETE FROM stock_quiz WHERE ID_quiz=%s",
                       GetSQLValueString($total, "int"));
		mysql_select_db($database_conn_cahier_de_texte, $conn_cahier_de_texte);
  		$Result1 = mysql_query($deleteSQL, $conn_cahier_de_texte) or die(mysql_error());

		
    }else {
	    print '<strong><center><font size=5 color="#FF0000">Le fichier '.$_FILES['fichier']['name']. ' a été envoyé sur le serveur </font> </center></strong><BR><center><font size=2 color="#FF0000">dans le dossier '.$dossier_destination .'</font></center><hr>';

	}


	//fin OK enregistrer
	}
}

}
?>
    
    


<html>
<head>
<title>Mettre un exercice Hotpotatoes en ligne </title>
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
<a href="../index.php"><img src="../patate.gif" width="48" height="44" border="0"></a> 
<img src="../patate.jpg" width="324" height="39" align="top"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="63%"><strong><a href="../index.php">Accueil Stockpotatoes</a> - Espace Upload 
      - Envoyer un exercice sur le serveur</strong></td>
    <td width="37%"><div align="right">
        <input name="Submit2" type="submit" onClick="MM_goToURL('parent','modif_select.php');return document.MM_returnValue" value="Ajouter des fichiers (images, son, vid&eacute;o li&eacute;s &agrave; un exercice) ">
    </div></td>
  </tr>
</table>


<form name="form1" method="post" action="upload_hotpot.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_POST['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_POST['matiere_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_matiere['nom_mat']?></option>
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
          <select name="niveau_ID" id="niveau_ID">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_POST['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_POST['niveau_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
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
      <td width="44%"> <input type="submit" name="Submit" value="S&eacute;lectionner"></td>
    </tr>
  </table>
</form>
<?php if (isset($_POST['matiere_ID'])) { ?>
<p align="center"> <strong><font size="6"><?php echo $row_RsChoixMatiere['nom_mat']; ?>

</font></strong> 
<form method="post" enctype="multipart/form-data" name="form1" id="formulaire" action="upload_hotpot.php">
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Ce fichier est relatif &agrave; l'&eacute;tude 
        du th&egrave;me </td>
      <td> <select name="theme_ID" id="select">
          <option value="value">Selectionnez un thème</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RsTheme['ID_theme']?>"><?php echo $row_RsTheme['theme']?></option>
          <?php
} while ($row_RsTheme = mysql_fetch_assoc($RsTheme));
  $rows = mysql_num_rows($RsTheme);
  if($rows > 0) {
      mysql_data_seek($RsTheme, 0);
	  $row_RsTheme = mysql_fetch_assoc($RsTheme);
  }
?>
        </select> 
      &nbsp;&nbsp;&nbsp;<a href="../enseignant/gestion_theme.php"> Ajouter un nouveau 
        th&egrave;me</a></td>
    </tr>
    
          <tr> 
    <tr valign="baseline"> 
      <td nowrap align="right">Titre de l'exercice<font color="#990000"> <strong>(Obligatoire)</strong></font>:</td>
      <td><input type="text" name="titre" value="" size="50"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Fichier:</td>
      <td> <input type="hidden" name="MM_insert" value="form1"> 
      <input type="hidden" name="MAX_FILE_SIZE" value="100000000"> <input type="file" size="50" name="fichier" class="Style2">

        <input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $_POST['matiere_ID'] ?>"> 
        <input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $_POST['niveau_ID'] ?>"> 
        <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $_POST['nom_mat'] ?>"> 
      </td>
    </tr>
	<tr>
            <td><div align="right">A classer dans</div></td>
            <td class="retrait20"><table width="459">
              <tr>
                <td><label>
                  <input name="cat_doc" type="radio" value="1">
      Cours</label></td>
	  <td><label>
                  <input name="cat_doc" type="radio" value="2" checked>
      Ex. Hotpotatoes</label></td>
                <td><label>
                  <input type="radio" name="cat_doc" value="3">
      Exercices</label></td>
                <td><label>
                  <input type="radio" name="cat_doc" value="4">
      Travail &agrave; faire</label></td>
                <td><label>
                  <input  type="radio" name="cat_doc" value="5">
      Annexes</label></td>
              </tr>
            </table></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Auteur:</td>
      <td><input type="text" name="auteur" value="" size="50"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Mode Entrainement:</td>
      <td><input name="en_ligne" type="checkbox" id="en_ligne" value="O" checked> 
        <font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>L'exercice 
        peut &ecirc;tre fait sans que l'&eacute;l&egrave;ve soit identifi&eacute;. 
        Le score n'est pas enregistr&eacute;</em></font></em></font></em></font><font color="#990000"><em> 
        </em></font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Mode Evaluation</td>
      <td><em> 
        <input name="avec_score" type="checkbox" id="avec_score" value="O" checked>
        <font color="#990000"> <em> <font color="#990000"><em>L'exercice peut 
        &ecirc;tre fait par l'&eacute;l&egrave;ve en s'identifiant</em></font> 
        . Le score est enregistr&eacute; (Note sur 20)</em></font></em></td>
    </tr>
    <tr valign="baseline"> 
	  <td nowrap align="right">Un seul essai</td>
      <td><em>
<input name="evaluation_seul" type="checkbox" id="evaluation_seul" value="O">
        <font color="#990000"> <em> <em>En mode &eacute;valuation, un seul essai 
        sera autoris&eacute; (Interro)</em></em></font></em></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td ><font color="#990000"> <em> <font color="#990000"> 
        <em> <em><font color="#990000">Les param&egrave;tres ci-dessus tels que 
        le choix du mode, pourront &ecirc;tre modifi&eacute;s par la suite <br>
        (voir Espace Enseignant - Gestion des exercices ).</font> </em><font color="#990000"><em> 
        </em></font></em></font></em></font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input name="submit2" type="submit" value="Envoyer sur le serveur"></td>
    </tr>
  </table>
  <div align="center"> </div>
</form>

<?php } ?>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil StockPotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a> 
  - <a href="upload_menu.php">Envoi de documents </a></p>
<p align="center"><a href="modif_select.php">Ajouter des fichiers (images, son, vid&eacute;o 
    li&eacute;s &agrave; un exercice)</a> </p>
</body>
</html>
<?php


mysql_free_result($rs_matiere);

mysql_free_result($rs_niveau);

mysql_free_result($RsTheme);

mysql_free_result($RsChoixMatiere);
?>

