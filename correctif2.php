<?php 
require_once('Connections/conn_intranet.php'); ?>
<?php
mysql_select_db($database_conn_intranet, $conn_intranet);
$sql="ALTER TABLE `stock_quiz` ADD `type_doc` TINYINT ( 3 ) UNSIGNED DEFAULT '2' NOT NULL  ";
$sql2="ALTER TABLE `stock_quiz` ADD `cat_doc` TINYINT( 3 ) UNSIGNED DEFAULT '2' NOT NULL  ";
$sql3="ALTER TABLE `stock_quiz` ADD `pos_doc` SMALLINT( 5 ) UNSIGNED DEFAULT '1' NOT NULL  ";
mysql_query($sql) or die('Erreur SQL !'.$sql.mysql_error()); 
mysql_query($sql2) or die('Erreur SQL !'.$sql1.mysql_error());
mysql_query($sql3) or die('Erreur SQL !'.$sql2.mysql_error()); 

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Recordset1 = "SELECT * FROM stock_quiz ";
$Recordset1 = mysql_query($query_Recordset1, $conn_intranet) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$i=0;
 do {
 $i=$i+1; 
 $updateSQL="UPDATE stock_quiz SET pos_doc=".$i." WHERE stock_quiz.ID_quiz=".$row_Recordset1['ID_quiz'];
 $Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());	     
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 

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
  <p align="center" class="title">Correctif 2 </p>
</div>
<ul>
  <li><strong><font color="#990000" size="2">Ajout d'un champ nomm&eacute;</font><font color="#000099" size="2"> type_doc</font><font size="2"><span class="Style1"> dans la table stock_quiz </span></font></strong>
    <p>Dans la table, <strong>type-doc</strong> permet d'identifier la nature du document et peut prendre les valeurs 1 &agrave; ..... <br>
   Lien hypertexte = 1; Exercice Hotpotatoes = 2 ; Document r&eacute;alis&eacute; en ligne =  3 ; Page web =4 ;  Word = 5 etc ... </p>
  </li>
  <li> 
    <div align="left"><strong><font color="#990000" size="2">Ajout d'un champ nomm&eacute;</font><font color="#000099" size="2"> cat_doc</font><font size="2"><span class="Style1"> dans la table stock_quiz </span></font></strong></div>
    <p>Dans la table, <strong>cat-doc</strong> sert au classement et peut prendre les valeurs suivantes :<br>
Cours = 1; Exercices Hotpotatoes = 2 ; Autres exercices = 3 ; Travail &agrave; faire = 4 ; Annexes =5 </p>
  </li>
  <li>
    <div align="left"><strong><font color="#990000" size="2">Ajout d'un champ nomm&eacute;</font><font color="#000099" size="2"> pos_doc</font><font size="2"><span class="Style1"> dans la table stock_quiz </span></font></strong></div>
    <p>Dans la table, <strong>pos-doc</strong> peut prendre les valeurs  les valeurs 1 &agrave; ..... et sert &agrave; positionner le document dans la cat&eacute;gorie. </p>
  </li>
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
