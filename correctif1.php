<?php 
require_once('Connections/conn_intranet.php'); 
mysql_select_db($database_conn_intranet, $conn_intranet);
$sql="ALTER TABLE `stock_activite` CHANGE `quiz_ID` `quiz_ID` SMALLINT( 5 ) UNSIGNED DEFAULT '0' NOT NULL  ";
$sql2="ALTER TABLE `stock_quiz` ADD `evaluation_seul` VARCHAR( 1 ) DEFAULT 'N' NOT NULL ;";
mysql_query($sql) or die('Erreur SQL !'.$sql.mysql_error()); 
mysql_query($sql2) or die('Erreur SQL !'.$sql.mysql_error()); 
mysql_close();  


?>
<html>
<head>
<title>Patch de modification de la table stock_activité</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center"> 
  <p align="center" class="title">Correctif 1 </p>
</div>
<ul>
  <li> 
    <div align="left"><font color="#990000" size="2"><strong>Changement du type 
      du champ nomm&eacute;</strong></font><font color="#CC0000" size="2"><strong> 
      <font color="#000099">quiz_ID</font> <font color="#990000">de la table</font> 
      <font color="#000099">stock_activite</font></strong></font></div>
    <p>Ce correctif r&eacute;soud le probl&egrave;me d'hyperactivit&eacute; de 
      certains &eacute;tablissement. Le nombre d''enregistrements d'activit&eacute;s 
      &eacute;tait limit&eacute; et n'&eacute;tait plus pris en compte au dela 
      d'un certain seuil. Il se produisait un report de la note sur le nom d'un 
      autre quiz.</p>
  </li>
  <li> 
    <div align="left"><strong><font color="#990000" size="2">Ajout d'un champ 
      nomm&eacute;</font><font color="#000099" size="2"> evaluation_seul <font color="#990000">dans 
      la table</font> stock_quiz</font></strong></div>
    <p>Le correctif pr&eacute;pare &eacute;galement le terrain pour une prochaine 
      am&eacute;lioration (Future version 2.5). Certains voudraient en effet que 
      certains exercices apparaissent exclusivement en mode &eacute;valuation 
      et non simultan&eacute;ment en &eacute;valuation et entrainement.</p>
  </li>
</ul>
<div align="center"> 
  <hr>
  <p><font color="#990000" size="5"><strong>La modification des tables vient d'&ecirc;tre 
    effectu&eacute;e. </strong></font></p>
  <p><font color="#990000" size="2">En cas de probl&egrave;mes, n'h&eacute;sitez 
    pas &agrave; me contacter. </font></p>
  <p><font color="#990000" size="2">Pierre Lemaitre</font></p>
  <p><font color="#990000" size="2"><a href="mailto:pierre.lemaitre@etab.ac-caen.fr">pierre.lemaitre@etab.ac-caen.fr</a></font></p>
  <p>&nbsp;</p>
</div>
</body>
</html>
