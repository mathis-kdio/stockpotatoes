<?php 
require_once('Connections/conn_intranet.php'); ?>
<?php
mysql_select_db($database_conn_intranet, $conn_intranet);
$sql="ALTER TABLE `stock_theme` ADD `pos_theme` SMALLINT( 5 ) UNSIGNED DEFAULT '1' NULL  ";
mysql_query($sql) or die('Erreur SQL !'.$sql.mysql_error()); 


mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Recordset1 = "SELECT * FROM stock_theme ORDER BY `ID_theme` ";
$Recordset1 = mysql_query($query_Recordset1, $conn_intranet) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$i=0;
 do {
 $i=$i+1; 
 $updateSQL="UPDATE stock_theme SET pos_theme=".$i." WHERE stock_theme.ID_theme=".$row_Recordset1['ID_theme'];
 $Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());	     
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 


mysql_select_db($database_conn_intranet, $conn_intranet);
$sql2="ALTER TABLE `stock_niveau` ADD `pos_niv` SMALLINT( 5 ) UNSIGNED DEFAULT '1' NULL  ";
mysql_query($sql2) or die('Erreur SQL !'.$sql2.mysql_error()); 


mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Recordset2 = "SELECT * FROM stock_niveau ORDER BY `ID_niveau` ";
$Recordset2 = mysql_query($query_Recordset2, $conn_intranet) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$i=0;
 do {
 $i=$i+1; 
 $updateSQL2="UPDATE stock_niveau SET pos_niv=".$i." WHERE stock_niveau.ID_niveau=".$row_Recordset2['ID_niveau'];
 $Result1 = mysql_query($updateSQL2, $conn_intranet) or die(mysql_error());	     
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); 

mysql_close();  


?>
<html>
<head>
<title>Patch de modification de la table stock_quiz</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Style1 {color: #990000}
-->
</style>
</head>
<body>
<div align="center"> 
  <p align="center" class="title">Correctif 3 </p>
  <p>&nbsp;</p>
</div>
<ul><li>
    <div align="left"><strong><font color="#990000" size="2">Ajout d'un champ nomm&eacute;</font><font color="#000099" size="2"> pos_theme</font><font size="2"><span class="Style1"> dans la table stock_theme</span></font></strong></div>
    <p>Dans la table, <strong>pos-theme</strong> peut prendre les valeurs  les valeurs 1 &agrave; ..... et sert &agrave; classer les th&egrave;mes. </p>
</li>
  <li>
    <div align="left"><strong><font color="#990000" size="2">Ajout d'un champ nomm&eacute;</font><font color="#000099" size="2"> pos_niv</font><font size="2"><span class="Style1"> dans la table stock_niveau</span></font></strong></div>
    <p>Dans la table, <strong>pos-niv</strong> peut prendre les valeurs les valeurs 1 &agrave; ..... et sert &agrave; classer les niveaux. </p>
  </li>
  <li></li>
</ul>
<div align="center"> 
  <hr>
  <p><font color="#990000" size="5"><strong>La modification de la table vient d'&ecirc;tre 
    effectu&eacute;e. </strong></font></p>
  <p><font color="#990000" size="2">En cas de probl&egrave;mes, n'h&eacute;sitez 
    pas &agrave; me contacter. </font></p>
  <p><font color="#990000" size="2">Pierre Lemaitre</font></p>
  <p><font color="#990000" size="2"><a href="mailto:pierre.lemaitre@etab.ac-caen.fr">pierre.lemaitre@etab.ac-caen.fr</a></font></p>
  <p>&nbsp;</p>
</div>
</body>
</html>
