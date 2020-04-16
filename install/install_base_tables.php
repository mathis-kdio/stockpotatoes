<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../Connections/conn_intranet.php'); 
$query = "CREATE DATABASE ". $database_conn_intranet ."CHARACTER SET 'utf8'"; 

$result = mysqli_query($conn_intranet, $query);
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query = "
CREATE TABLE `stock_activite` (
  `ID_activite` smallint(5) unsigned NULL auto_increment,
  `eleve_ID` smallint(6) NOT NULL default '0',
  `identifiant` varchar(250) NOT NULL default '',
  `nom_classe` varchar(50) NOT NULL default '',
  `quiz_ID` smallint(5) unsigned NOT NULL default '0',
  `score` smallint(6) NOT NULL default '0',
  `debut` varchar(255) NOT NULL default '',
  `fin` varchar(255) NOT NULL default '',
  `fait` enum('N','O') NOT NULL default 'N',
  PRIMARY KEY  (`ID_activite`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";
$result = mysqli_query($conn_intranet, $query);
$query = "
CREATE TABLE `stock_categorie` (
  `ID_categorie` smallint(5) NOT NULL auto_increment,
  `nom_categorie` varchar(250) NOT NULL default '',
  `pos_categorie` smallint(5) NOT NULL default '1', 
  PRIMARY KEY  (`ID_categorie`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";
$result = mysqli_query($conn_intranet, $query);
$query = "
CREATE TABLE `stock_eleve` (
  `ID_eleve` smallint(5) unsigned NOT NULL auto_increment,
  `identifiant` varchar(250) NOT NULL default '',
  `nom` varchar(50) NOT NULL default '',
  `prenom` varchar(50) NOT NULL default '',
  `classe` varchar(50) NOT NULL default '',
  `pass` varchar(10) NOT NULL default 'eleve',
  `niveau` tinyint(5) NOT NULL,
  PRIMARY KEY  (`ID_eleve`),
  UNIQUE (`identifiant`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";
$result = mysqli_query($conn_intranet, $query);
$query = "
CREATE TABLE `stock_matiere` (
  `ID_mat` tinyint(4) NULL auto_increment,
  `nom_mat` varchar(50) NOT NULL default '',
  `theme` varchar(255) default NULL,
  PRIMARY KEY  (`ID_mat`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";
$result = mysqli_query($conn_intranet, $query);
$query = "
CREATE TABLE `stock_niveau` (
  `ID_niveau` tinyint(4) NULL auto_increment,
  `nom_niveau` varchar(255) NOT NULL default '',
  `pos_niv` smallint(5) unsigned NULL default '1', 

  PRIMARY KEY  (`ID_niveau`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";
$result = mysqli_query($conn_intranet, $query);
$query = "
CREATE TABLE `stock_quiz` (
  `ID_quiz` smallint(5) unsigned NULL auto_increment,
  `titre` varchar(255) NOT NULL default 'Sans titre',
  `fichier` varchar(255) NOT NULL default '',
  `matiere_ID` tinyint(4) NOT NULL default '0',
  `niveau_ID` tinyint(4) NOT NULL default '0',
  `theme_ID` smallint(6) default NULL,
  `categorie_ID` tinyint(4) NOT NULL default '0',
  `auteur` varchar(50) default NULL,
  `en_ligne` char(1) NOT NULL default 'N',
  `avec_score` char(1) NOT NULL default 'N',
  `evaluation_seul` char(1) NOT NULL default 'N',
  `type_doc` TINYINT ( 3 ) UNSIGNED DEFAULT '2' NOT NULL,
  `cat_doc` TINYINT ( 3 ) UNSIGNED DEFAULT '2' NOT NULL,
  `pos_doc` SMALLINT( 5 ) UNSIGNED DEFAULT '1' NOT NULL,

  PRIMARY KEY  (`ID_quiz`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";
$result = mysqli_query($conn_intranet, $query);
$query = "
CREATE TABLE `stock_theme` (
  `ID_theme` smallint(5) unsigned NULL auto_increment,
  `theme` varchar(255) NOT NULL default '',
  `mat_ID` tinyint(4) NOT NULL default '0',
  `niv_ID` tinyint(4) NOT NULL default '0',
  `pos_theme` smallint(5) UNSIGNED DEFAULT '1',
  `date_apparition` date NOT NULL,
  `date_disparition` date NOT NULL,
  
  PRIMARY KEY  (`ID_theme`)
) ENGINE=INNODB AUTO_INCREMENT=0;";
$result = mysqli_query($conn_intranet, $query);

?> 

<html>
<head>
<title>Installation des tables</title>
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
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="top"> 
    <td width="38%"><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td width="62%"> <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center"><span class="title"><font size="6" face="Arial, Helvetica, sans-serif">&lt; 
        Etape 4/5&gt;</font></span> </p>
      <p align="center">&nbsp;</p>      <div align="center"> 
        <div align="center">
          <ul>
            <li>
              <div align="left"><strong>La cr&eacute;ation de la base et des tables a &eacute;t&eacute; effectu&eacute;e</strong></div>
            </li>
          </ul>
          <div align="center">
            <div align="center">
              <ul>
                <li>
                  <div align="left"><strong align="left">Il vous faut maintenant param&eacute;trer l'&eacute;diteur Html en ligne (FCKeditor) </strong></div>
                </li>
                <li>
                  <div align="left"><strong align="left">Si des difficult&eacute;s survenaient &agrave; l'utilisation de cet &eacute;diteur, vous pourrez revenir sur ces param&egrave;tres dans l'espace Administrateur </strong></div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <p align="center">
          <input name="Submit" type="submit" onClick="MM_goToURL('parent','install_editeur.php');return document.MM_returnValue" value="Param&eacute;trage de l'&eacute;diteur Html en ligne">
        </p>
        <p>&nbsp;</p>
      </div>
      <p>&nbsp;</p></td>
  </tr>
</table>

</body>
</html>
