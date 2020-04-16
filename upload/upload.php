<?php require_once('../Connections/conn_intranet.php'); ?>
<?php

function sans_accent($chaine) 
{ 
   $accent  ="��������������������������������������������������������������"; 
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

$editFormAction = $HTTP_SERVER_VARS['PHP_SELF'];
if (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
  $editFormAction .= "?" . $HTTP_SERVER_VARS['QUERY_STRING'];
}

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMaxId_quiz = "SELECT MAX( Id_quiz )  FROM stock_quiz";
$RsMaxId_quiz = mysqli_query($conn_intranet, $query_RsMaxId_quiz) or die(mysqli_error());
$row_RsMaxId_quiz = mysqli_fetch_assoc($RsMaxId_quiz);
$totalRows_RsMaxId_quiz = mysqli_num_rows($RsMaxId_quiz);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);
	
	
$choixmat_RsTheme = "0";
if (isset($HTTP_POST_VARS['matiere_ID'])) {
  $choixmat_RsTheme = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['matiere_ID'] : addslashes($HTTP_POST_VARS['matiere_ID']);
}
$choixniv_RsTheme = "0";
if (isset($HTTP_POST_VARS['niveau_ID'])) {
  $choixniv_RsTheme = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['niveau_ID'] : addslashes($HTTP_POST_VARS['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.theme", $choixmat_RsTheme,$choixniv_RsTheme);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error());
$row_RsTheme = mysqli_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysqli_num_rows($RsTheme);

$selection_RsChoixMatiere = "0";
if (isset($HTTP_POST_VARS['matiere_ID'])) {
  $selection_RsChoixMatiere = (get_magic_quotes_gpc()) ? $HTTP_POST_VARS['matiere_ID'] : addslashes($HTTP_POST_VARS['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $selection_RsChoixMatiere);
$RsChoixMatiere = mysqli_query($conn_intranet, $query_RsChoixMatiere) or die(mysqli_error());
$row_RsChoixMatiere = mysqli_fetch_assoc($RsChoixMatiere);
$totalRows_RsChoixMatiere = mysqli_num_rows($RsChoixMatiere);



function pArray($array) {
	print '<pre style="background:#CCCC99">';
	print_r($array);
	print '</pre>';
}

// Chargement de la classe
require_once('upload.class.php');

// Instanciation d'un nouvel objet "upload"
$Upload = new Upload();

/**
 * Gestion lors de la soumission du formulaire
 **/

if (!Empty($_POST['submit2'])) {
if ($HTTP_POST_VARS['titre']=='') {
 print '<strong><center><font size=5 color="#FF0000">Il faut donner un titre � votre document </font> </center></strong>';
    echo '<BR><hr>';
} else {

    // Si vous voulez renommer le fichier...
    //$Upload-> Filename     = 'fichier';
    
    // Si vous voulez ajouter un pr�fixe au nom du fichier...
    //$Upload-> Prefixe = 'pre_';
    
    // Si vous voulez ajouter un suffixe au nom du fichier...
    //$Upload-> Suffice = '_suf';
    
    // Pour changer le mode d'�criture (entre 0 et 3)
    //$Upload-> WriteMode    = 0;
    
    // Pour filtrer les fichiers par extension
    //$Upload-> Extension = '.htm;.html';
    
    // Pour filtrer les fichiers par ent�te
    //$Upload-> MimeType  = 'image/gif;image/pjpeg;image/bmp;image/x-png'; 
    
    // Pour tester la largeur / hauteur d'une image
    //$Upload-> ImgMaxHeight = 200;
    //$Upload-> ImgMaxWidth  = 200;
    //$Upload-> ImgMinHeight = 100;
    //$Upload-> ImgMinWidth  = 100;
    
    // Pour v�rifier la page appelante
    //$Upload-> CheckReferer = 'http://mondomaine/mon_chemin/mon_fichier.php';
    
    // Pour g�n�rer une erreur si les champs sont obligatoires
    //$Upload-> Required     = false;
    
    // Pour interdire automatiquement tous les fichiers consid�r�s comme "dangereux"
    //$Upload-> SecurityMax  = true;
    
    // D�finition du r�pertoire de destination
	
$total=$row_RsMaxId_quiz['MAX( Id_quiz )']+1;
$nom_matiere=sans_accent($row_RsChoixMatiere['nom_mat']);
$repertoire='../Exercices/'.$nom_matiere.'/q'.$total;
$old_umask = umask(0);
if (is_dir($repertoire)) {echo "<center> Le dossier ".$repertoire." existait d�j� </center><BR> "; } else { mkdir($repertoire,0777);}
umask($old_umask);

$Upload-> DirUpload    = $repertoire;


    // On lance la proc�dure d'upload
$Upload-> Execute();



    // Gestion erreur / succ�s
    if ($UploadError) {
        print 'Il y a eu une erreur :'; 
        pArray($Upload-> GetError());
    } else {
	$aFichier1 = $Upload-> GetSummary(1);
	$chemin=$repertoire.'/'.$aFichier1['nom'];
	chmod($chemin,0777);
    print '<strong><center><font size=5 color="#FF0000">Le fichier '.$aFichier1['nom']. ' a �t� envoy� sur le serveur </font> </center></strong>';
    echo '<BR><hr>';
	//pArray($Upload-> GetSummary());
	
        

		
  if ((isset($HTTP_POST_VARS["MM_insert"])) && ($HTTP_POST_VARS["MM_insert"] == "form1")) {
  if ($HTTP_POST_VARS['en_ligne']=='O'){$en_ligne='O';} else {$en_ligne='N';}
  if ($HTTP_POST_VARS['avec_score']=='O'){$avec_score='O';} else {$avec_score='N';}
  if ($HTTP_POST_VARS['evaluation_seul']=='O'){$evaluation_seul='O';} else {$evaluation_seul='N';}
  if ($HTTP_POST_VARS['evaluation_seul']=='O'){$avec_score='O';}

  $insertSQL = sprintf("INSERT INTO stock_quiz (ID_quiz, titre, fichier, matiere_ID, niveau_ID,theme_ID, auteur, en_ligne, avec_score, evaluation_seul) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s, %s)",
                       GetSQLValueString($total, "int"),
                       GetSQLValueString($HTTP_POST_VARS['titre'], "text"),
                       GetSQLValueString($aFichier1['nom'], "text"),
                 	   GetSQLValueString($HTTP_POST_VARS['matiere_ID'], "text"),
                       GetSQLValueString($HTTP_POST_VARS['niveau_ID'], "text"),
					   GetSQLValueString($HTTP_POST_VARS['theme_ID'], "int"),
                       GetSQLValueString($HTTP_POST_VARS['auteur'], "text"),
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
					   GetSQLValueString($evaluation_seul, "text"));

             mysqli_select_db($conn_intranet, $database_conn_intranet);
             $Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error());
}
		
		
		
		
    }
	}
}

/**
 * Cr�ation du formulaire
 **/

// Pour limiter la taille d'un fichier (exprim�e en ko)
$Upload-> MaxFilesize  = '1024';

// Pour ajouter des attributs aux champs de type file
$Upload-> FieldOptions = 'style="border-color:black;border-width:1px;"';

// Pour indiquer le nombre de champs d�sir�
$Upload-> Fields       = 2;

// Initialisation du formulaire
$Upload-> InitForm();
?>
    


<html>
<head>
<title>Mettre un exercice en ligne &gt; Fiche</title>
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
    <td><strong><a href="../index.php">Accueil Stockpotatoes</a> - Espace Upload 
      - Envoyer un exercice sur le serveur</strong></td>
    <td><div align="right">
        <input name="Submit2" type="submit" onClick="MM_goToURL('parent','modif_select.php');return document.MM_returnValue" value="Ajouter des fichiers (images, son, vid&eacute;o li&eacute;s &agrave; un exercice) ">
      </div></td>
  </tr>
</table>
<hr>

<p align="center"><font color="#990000">S&eacute;lectionner la mati&egrave;re 
  et le niveau pour lesquels vous d&eacute;sirez envoyer un exercice.</font></p>
<form name="form1" method="post" action="upload.php">
  <table width="100%" border="0" cellspacing="10" cellpadding="0">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (!(strcmp($row_rs_matiere['ID_mat'], $HTTP_POST_VARS['matiere_ID']))) {echo "SELECTED";} ?>><?php echo $row_rs_matiere['nom_mat']?></option>
            <?php
} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere));
  $rows = mysqli_num_rows($rs_matiere);
  if($rows > 0) {
      mysqli_data_seek($rs_matiere, 0);
	  $row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
  }
?>
          </select>
        </div></td>
      <td width="21%"><div align="center"> 
          <select name="niveau_ID" id="niveau_ID">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (!(strcmp($row_rs_niveau['ID_niveau'], $HTTP_POST_VARS['niveau_ID']))) {echo "SELECTED";} ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
            <?php
} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau));
  $rows = mysqli_num_rows($rs_niveau);
  if($rows > 0) {
      mysqli_data_seek($rs_niveau, 0);
	  $row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
  }
?>
          </select>
        </div></td>
      <td width="44%"> <input type="submit" name="Submit" value="S&eacute;lectionner"></td>
    </tr>
  </table>
</form>
<?php if (isset($HTTP_POST_VARS['matiere_ID'])) { ?>
<p align="center"> <strong><font size="6"><?php echo $row_RsChoixMatiere['nom_mat']; ?></font></strong> 
<form method="post" enctype="multipart/form-data" name="form1" id="formulaire" action="upload.php">
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Ce fichier est relatif &agrave; l'&eacute;tude 
        du th&egrave;me </td>
      <td> <select name="theme_ID" id="select">
          <option value="value">Selectionnez un th�me</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RsTheme['ID_theme']?>"><?php echo $row_RsTheme['theme']?></option>
          <?php
} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme));
  $rows = mysqli_num_rows($RsTheme);
  if($rows > 0) {
      mysqli_data_seek($RsTheme, 0);
	  $row_RsTheme = mysqli_fetch_assoc($RsTheme);
  }
?>
        </select> 
      &nbsp;&nbsp;&nbsp;<a href="../enseignant/gestion_theme.php"> Ajouter un nouveau 
        th&egrave;me</a></td>
    </tr>
    <tr valign="baseline"> 
      <td width="212" align="right" nowrap>&nbsp;</td>
      <td width="350">&nbsp;</td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Titre de l'exercice<font color="#990000"> <strong>(Obligatoire)</strong></font>:</td>
      <td><input type="text" name="titre" value="" size="50"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Fichier:</td>
      <td> <input type="hidden" name="MM_insert" value="form1"> 
        <?php
  // Affichage du premier champ de type FILE
print $Upload-> Field[1] . '<br>';
?>
        <input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $HTTP_POST_VARS['matiere_ID'] ?>"> 
        <input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $HTTP_POST_VARS['niveau_ID'] ?>"> 
        <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $HTTP_POST_VARS['nom_mat'] ?>"> 
      </td>
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
  - <a href="modif_select.php">Ajouter des fichiers (images, son, vid&eacute;o 
  li&eacute;s &agrave; un exercice)</a> </p>
</body>
</html>
<?php
mysqli_free_result($RsMaxId_quiz);

mysqli_free_result($rs_matiere);

mysqli_free_result($rs_niveau);

mysqli_free_result($RsTheme);

mysqli_free_result($RsChoixMatiere);
?>

