<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']=='Enseignant') { $_SESSION['Sess_nom']='Upload';}
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>
<?php 
require_once('../Connections/conn_editeur.inc.php'); 
/*
 * /*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 
 * 
 * Version:  2.0 RC3
 * Modified: 2005-02-27 19:35:29
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */
include("fckeditor.php") ;
?>
<html>
	<head>
		<title>Rédiger un document en ligne</title>
		<meta name="robots" content="noindex, nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="sample.css" rel="stylesheet" type="text/css">
		<link href="../style_jaune.css" rel="stylesheet" type="text/css">


	</head>
	<body>
	<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td width="440"><a href="../index.php"><img src="../patate.gif" width="47" height="40" border="0"></a><img src="../patate.jpg" width="324" height="39" align="top"></td>
    <td width="440"><strong><a href="../index.php">Accueil Stockpotatoes</a> - <a href="upload_menu.php">Envoi de documents</a><br>
      R&eacute;diger un document Web en ligne </strong></td>
  </tr>
</table>

<form action="ecriture_temp.php" method="post" >
<?php
//recup variable conn_editeur.inc.php
$oFCKeditor->BasePath = $chemin_editeur;
$oFCKeditor->sBasePath = $chemin_editeur;
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $chemin_editeur;
$oFCKeditor->Value		= '' ;
$oFCKeditor->Create() ;
?>
<div align="center">
<p> <input type="submit" value="Enregistrer votre document sur le serveur">
</p>
<p>&nbsp; </p>
</div>
</form>
</body>
</html>
