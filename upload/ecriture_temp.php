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

foreach ( $postArray as $sForm => $value )
{
$code = htmlspecialchars( stripslashes( $value ) ) ; 

// On supprime pour les images la chaine précédant le nom de l'image
$chaine_supp=$chemin_images.'Image/';
$new_code = str_replace($chaine_supp, "", $code);
$postedValue = html_entity_decode($new_code);
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
}
header("Location: upload_online.php");


?>