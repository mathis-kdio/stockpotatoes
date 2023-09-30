<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']=='Enseignant') { $_SESSION['Sess_nom']='Upload';}
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Document sans titre</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<?php require_once('../Connections/conn_intranet.php'); 
require_once('../Connections/conn_editeur.inc.php'); 

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
$RsChoixQuiz = mysqli_query($conn_intranet, $query_RsChoixQuiz) or die(mysqli_error($conn_intranet));
$row_RsChoixQuiz = mysqli_fetch_assoc($RsChoixQuiz);
$totalRows_RsChoixQuiz = mysqli_num_rows($RsChoixQuiz);

$colname_RsChoixMatiere = "1";
if (isset($_POST['matiere_ID'])) {
  $colname_RsChoixMatiere = (get_magic_quotes_gpc()) ? $_POST['matiere_ID'] : addslashes($_POST['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixMatiere = sprintf("SELECT * FROM stock_matiere WHERE ID_mat = %s", $colname_RsChoixMatiere);
$RsChoixMatiere = mysqli_query($conn_intranet, $query_RsChoixMatiere) or die(mysqli_error($conn_intranet));
$row_RsChoixMatiere = mysqli_fetch_assoc($RsChoixMatiere);
$totalRows_RsChoixMatiere = mysqli_num_rows($RsChoixMatiere);



$nom_matiere=sans_accent($row_RsChoixMatiere['nom_mat']);
$rep= $nom_matiere.'/q'.$_POST['ID_quiz'].'/';

/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */
$contenu='';
$fp = fopen("../Exercices/".$rep.$row_RsChoixQuiz['fichier'],"r");

while(!feof($fp))
{
$contenu .= fgets($fp, 10000);

}

fclose($fp);



//On remet dans les lignes cidessous le chemin relatif du dossier
// temporaire devant chaque fichier image
// sauf pour les smiley et les images ayant un chemin externe (par http)
$chaine_temp='src="'.$chemin_editeur.'editor/images/smiley/msn/"';
// on remplace toutes le chemin des smiley par t_e_m_p
$contenu = str_replace($chaine_temp,'t_e_m_p', $contenu);
// on remplace tous les src http par h_t_t_p (pour preserver les liens externes)
$contenu = str_replace('src="http://','h_t_t_p', $contenu);

$chaine_supp=$chemin_images.'Image/';
//on remet le chemin du dossier images temporaires devant le nom de chaque fichier image
$contenu = str_replace('src="','src="'.$chaine_supp, $contenu);
// on remet dans l'état initial le chemin des smyley et les liens externes
$contenu = str_replace('t_e_m_p',$chaine_temp, $contenu);
$contenu = str_replace('h_t_t_p','src="http://', $contenu);
//copie des images idans le dossier temporaire

$files = array();
$chaine_image='../Exercices/'.$rep;
$handle = opendir($chaine_image);
while($file = readdir($handle)) {
	if($file != "." && $file != "..") {
		$files[] = $file;
	}
}

// Fermeture du répertoire courant
closedir($handle);

// Tri du tableau
sort($files);

foreach($files as $v) {
	if (preg_match("/.jpg$|.jpeg$|.gif$|.png$/i", $v)) {

	$fichier_source = $chaine_image.$v;
	$fichier_destination = '../Exercices/UserFiles/Image/'.$v;
	copy($fichier_source,$fichier_destination);
	}
}
include("fckeditor.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Modifier un document rédigé en ligne</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="robots" content="noindex, nofollow">
		<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
	<body>
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td width="440"><a href="../index.php"><img src="../patate.gif" width="47" height="40" border="0"></a><img src="../patate.jpg" width="324" height="39" align="top"></td>
    <td width="440"><strong><a href="../index.php">Accueil Stockpotatoes</a> - <a href="upload_menu.php">Envoi de documents</a><br>
      Modifier un document Web en ligne </strong></td>
  </tr>
</table>
<br>
    <div align="center" class="title">
<table width="100%"  border="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td width="50%"><div align="center" class="title"><?php echo $row_RsChoixMatiere['nom_mat'] ?>    </div></td>
    <td width="50%"><div align="center" class="title"><?php echo $row_RsChoixQuiz['titre'] ?></div></td>

  </tr>
</table>

    </div>
<form action="ecriture_temp2.php" method="post" >
<?php
//recup variable conn_editeur.inc.php
$oFCKeditor->BasePath = $chemin_editeur;
$oFCKeditor->sBasePath = $chemin_editeur;
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $chemin_editeur;
$oFCKeditor->Value		= $contenu ;
$oFCKeditor->Create() ;
?>
<div align="center"><p>
<input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_RsChoixQuiz['ID_quiz']  ?>">        
<input name="nom_fichier" type="hidden" id="nom_fichier" value="<?php echo $rep.$row_RsChoixQuiz['fichier']  ?>">        
<input name="repertoire" type="hidden" id="repertoire" value="<?php echo $rep ?>">        
<input type="submit" value="Enregistrer vos modifications">
 </p><p>&nbsp;  </p>
  </div>
</form>
	</body>
</html>
<?php
mysqli_free_result($RsChoixMatiere);
mysqli_free_result($RsChoixQuiz);
?>