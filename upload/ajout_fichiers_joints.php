<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

 session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>

<?php require_once('../Connections/conn_intranet.php'); 


function sans_accent($chaine) 
{ 
   $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
   return strtr(trim($chaine),$accent,$noaccent); 
} 

$colname_RsChoixQuiz = "1";
if (isset($_POST['ID_quiz'])) {
  $colname_RsChoixQuiz = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixQuiz = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = %s", $colname_RsChoixQuiz);
//$query_limit_RsChoixQuiz = sprintf("%s LIMIT %d, %d", $query_RsChoixQuiz, $startRow_RsChoixQuiz, $maxRows_RsChoixQuiz);
//$RsChoixQuiz = mysqli_query($conn_intranet, $query_limit_RsChoixQuiz) or die(mysqli_error());
$RsChoixQuiz = mysqli_query($conn_intranet, $query_RsChoixQuiz) or die(mysqli_error());

$row_RsChoixQuiz = mysqli_fetch_assoc($RsChoixQuiz);



$colname_RsChoixMatiere = "1";
if (isset($_POST['matiere_ID'])) {
  $colname_RsChoixMatiere = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = %s", $colname_RsChoixMatiere);
$RsChoixMatiere = mysqli_query($conn_intranet, $query_RsChoixMatiere) or die(mysqli_error());
$row_RsChoixMatiere = mysqli_fetch_assoc($RsChoixMatiere);
$totalRows_RsChoixMatiere = mysqli_num_rows($RsChoixMatiere);

$choixquiz_RsChoixQuiz = "0";
if (isset($_POST['ID_quiz'])) {
  $choixquiz_RsChoixQuiz = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixQuiz = sprintf("SELECT stock_quiz.ID_quiz, stock_quiz.titre, stock_quiz.fichier, stock_quiz.matiere_ID, stock_quiz.niveau_ID, stock_quiz.auteur FROM stock_quiz WHERE stock_quiz.ID_quiz=%s", $choixquiz_RsChoixQuiz);
$RsChoixQuiz = mysqli_query($conn_intranet, $query_RsChoixQuiz) or die(mysqli_error());
$row_RsChoixQuiz = mysqli_fetch_assoc($RsChoixQuiz);
$totalRows_RsChoixQuiz = mysqli_num_rows($RsChoixQuiz);

$nom_matiere=sans_accent($row_RsChoixMatiere['nom_mat']);
$rep= $nom_matiere.'/q'.$_POST['ID_quiz'].'/';

?>
<?php


// Chargement de la classe
require_once('upload.class.php');

// Instanciation d'un nouvel objet "upload"
$Upload = new Upload();

/**
 * Gestion lors de la soumission du formulaire
 **/

if (!Empty($_POST['submit'])) {
    // Si vous voulez renommer le fichier...
    //$Upload-> Filename     = 'fichier';
    
    // Si vous voulez ajouter un préfixe au nom du fichier...
    //$Upload-> Prefixe = 'pre_';
    
    // Si vous voulez ajouter un suffixe au nom du fichier...
    //$Upload-> Suffice = '_suf';
    
    // Pour changer le mode d'écriture (entre 0 et 3)
    //$Upload-> WriteMode    = 0;
    
    // Pour filtrer les fichiers par extension
    //$Upload-> Extension = '.gif;.jpg;.jpeg;.bmp;.png';
    
    // Pour filtrer les fichiers par entête
    //$Upload-> MimeType  = 'image/gif;image/pjpeg;image/bmp;image/x-png'; 
    
    // Pour tester la largeur / hauteur d'une image
    //$Upload-> ImgMaxHeight = 200;
    //$Upload-> ImgMaxWidth  = 200;
    //$Upload-> ImgMinHeight = 100;
    //$Upload-> ImgMinWidth  = 100;
    
    // Pour vérifier la page appelante
    //$Upload-> CheckReferer = 'http://mondomaine/mon_chemin/mon_fichier.php';
    
    // Pour générer une erreur si les champs sont obligatoires
    //$Upload-> Required     = false;
    
    // Pour interdire automatiquement tous les fichiers considérés comme "dangereux"
    //$Upload-> SecurityMax  = true;
    
    // Définition du répertoire de destination
	$rep_complet='../Exercices/'.$_POST['rep'];
    $Upload-> DirUpload    = $rep_complet;

    // On lance la procédure d'upload
    $Upload-> Execute();
    
   // Gestion erreur / succès
   // if ($UploadError) {
   //  print 'Il y a eu une erreur :'; 
   // } else {
   //    print '<strong>Envoi des fichiers effectué avec succès </strong>';
   //        }
		
 
}

/**
 * Création du formulaire
 **/

// Pour limiter la taille d'un fichier (exprimée en ko) - 1024 soit 1 Mo par defaut
//$Upload-> MaxFilesize  = '1024';

// Pour ajouter des attributs aux champs de type file
$Upload-> FieldOptions = 'style="border-color:black;border-width:1px;"';

// Pour indiquer le nombre de champs désiré
$Upload-> Fields       = 6;

// Initialisation du formulaire
$Upload-> InitForm();
?>
<html>
<head>
<title>Envoi de fichiers joints &agrave; un exercice ( image, son, vid&eacute;o... 
)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>

<p> <a href="../index.php"><img src="../patate.gif" width="57" height="44" border="0"></a><img src="../patate.jpg" width="324" height="39" align="top"></p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="upload_menu.php"> Espace Upload</a> - Envoi de fichiers joints &agrave; 
  un exercice ( image, son, vid&eacute;o... )</strong></p>
<?php if (isset($_POST['ID_quiz'])) {?>
<div align="right"></div>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top" bgcolor="#CCCC99"> 
    <td> <blockquote> 
        <p><strong>Fichier s&eacute;lectionn&eacute;</strong></p>
      </blockquote>
      <table border="1" align="center" cellpadding="0" cellspacing="0">
        <tr valign="top"> 
          <td> <blockquote> 
              <div align="left">N&deg;</div>
            </blockquote></td>
          <td><blockquote> 
              <p><strong><?php echo $row_RsChoixQuiz['ID_quiz']; ?></strong></p>
            </blockquote></td>
        </tr>
        <tr valign="top"> 
          <td> <blockquote> 
              <div align="left">Titre</div>
            </blockquote></td>
          <td><blockquote> 
              <p><strong><?php echo $row_RsChoixQuiz['titre']; ?></strong></p>
            </blockquote></td>
        </tr>
        <tr valign="top"> 
          <td> <blockquote> 
              <div align="left">Fichier</div>
            </blockquote></td>
          <td><blockquote> 
              <p><strong><?php echo $row_RsChoixQuiz['fichier']; ?></strong></p>
            </blockquote></td>
        </tr>
        <tr valign="top"> 
          <td> <blockquote> 
              <div align="left">Auteur</div>
            </blockquote></td>
          <td><blockquote> 
              <p><strong><?php echo $row_RsChoixQuiz['auteur']; ?></strong></p>
            </blockquote></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
    <td> <blockquote> 
        <p><strong>Fichiers joints</strong></p>
      </blockquote>
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
        <tr> 
          <?php
		  $nom_matiere=sans_accent($row_RsChoixMatiere['nom_mat']);
$repertoire_list= '../Exercices/'.$nom_matiere.'/q'.$_POST['ID_quiz'].'/';

$dir = opendir($repertoire_list); 

?>
          <?php 
while ($f = readdir($dir)) {
   if(is_file($repertoire_list.$f)) {?>
   <?php 
   $chemin=$repertoire_list.$f;
   //chmod($chemin,0777);
   ?>
          <td><?php echo $f;?></td>
          <td><?php echo filesize($repertoire_list.$f)." octets";?></td>
        </tr>
        <?php
     }
}  closedir($dir); 
?>
      </table></td>
    <td> <blockquote> 
        <p><strong>Nouveaux fichiers joints &agrave; envoyer</strong></p>
      </blockquote>
      <form method="post" enctype="multipart/form-data" name="formulaire" id="formulaire" action="ajout_fichiers_joints.php">
        <table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr> 
            <td> <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $_POST['ID_quiz']?>"> 
              <input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $_POST['matiere_ID']?>"> 
              <input name="rep" type="hidden" id="rep" value="<?php echo $rep?>"> 
            </td>
            <td> 
              <?php
// Affichage du champ MAX_FILE_SIZE
print $Upload-> Field[0];

// Affichage du premier champ de type FILE
print $Upload-> Field[1] . '<br>';

// Affichage du second champ de type FILE
print $Upload-> Field[2].'<br>';

// Affichage du second champ de type FILE
print $Upload-> Field[3].'<br>';

// Affichage du second champ de type FILE
print $Upload-> Field[4].'<br>';

// Affichage du second champ de type FILE
print $Upload-> Field[5].'<br>';

// Affichage du second champ de type FILE
print $Upload-> Field[6].'<br>';


?>
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <div align="left"> 
                <input type="submit" value="Envoyer" name="submit">
              </div></td>
          </tr>
        </table>
      </form>
      <?php } ?>
    </td>
  </tr>
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p align="center">Les fichiers sont enregistr&eacute;s sur le serveur dans le 
  dossier : <strong> <?php echo $rep ?> </strong></p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="upload_menu.php">Envoyer un autre exercice ou document </a></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($RsChoixQuiz);

mysqli_free_result($RsChoixMatiere);
?>