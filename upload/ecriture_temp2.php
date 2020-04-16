<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>

<?php
require_once('../Connections/conn_editeur.inc.php'); 

if ( version_compare( phpversion(), '4.1.0' ) == -1 )
    // prior to 4.1.0, use HTTP_POST_VARS
    $postArray = &$_POST ;
else
    // 4.1.0 or later, use $_POST
    $postArray = &$_POST ;

$i=1;
foreach ( $postArray as $sForm => $value )
{
$tab[$i]=$value;
$i=$i+1;
}
$postedValue = htmlspecialchars( stripslashes( $tab[1] ) ) ; 
//$a = htmlentities($postedValue);
$postedValue = html_entity_decode($postedValue);
// On supprime pour les images la chaine précédant le nom de l'image
$chaine_supp=$chemin_images.'Image/';
$postedValue = str_replace($chaine_supp, "", $postedValue);

$postedValue = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head><body>'.$postedValue.'</body></html>';
$fp = fopen("../Exercices/temp.htm","w");
fputs($fp,$postedValue);
fclose($fp);

// Mise à jour du fichier html

$file = '../Exercices/temp.htm';
$newfile = '../Exercices/'.$_POST['nom_fichier'];
copy($file, $newfile);

//copie des images intégrées dans le fichier html
$files = array();
$chaine_image='../Exercices/UserFiles/Image';
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
	$fichier_source = $chaine_image.'/'.$v;
	$fichier_destination = '../Exercices/'.$_POST['repertoire'].$v;
	rename($fichier_source,$fichier_destination);
	}
}

if ($_SESSION['Sess_nom'] <> 'ENSEIGNANT') {header("Location: upload_menu.php");} 
else {
//echo 'ici '.$_POST['ID_quiz'];         
//header("Location: ../enseignant/misajour_online.php");
header("Location: ../enseignant/gestion_exos.php");

};


?>