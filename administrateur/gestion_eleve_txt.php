<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsEleve = "SELECT * FROM stock_eleve";
$RsEleve = mysqli_query($conn_intranet,$query_RsEleve) or die(mysqli_error());
$row_RsEleve = mysqli_fetch_assoc($RsEleve);
$totalRows_RsEleve = mysqli_num_rows($RsEleve);
?>
<html>
<head>
<title>Ins&eacute;rer des donn&eacute;es provenant d'un fichier texte dans la 
table &eacute;l&egrave;ve </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<a href="../index.php"><img src="../patate.gif" width="52" height="42" border="0"></a> 
<img src="../patate.jpg" width="324" height="39" align="top"> 
<p><strong>Ins&eacute;rer des donn&eacute;es provenant d'un fichier texte dans 
  la table &eacute;l&egrave;ve </strong></p>
<p align="right"><a href="../../mysql//" target="_blank"><strong>Acc&egrave;s 
  &agrave; la base de donn&eacute;es via PhpMyAdmin</strong></a></p>
<p align="right">(ce lien fonctionne pour une installation en local)</p>
<blockquote> 
  <blockquote> 
    <p>&nbsp;</p>
    <p>Cette op&eacute;ration g&eacute;n&eacute;ralement effectu&eacute;e en d&eacute;but 
      d'ann&eacute;e, n&eacute;cessite la pr&eacute;paration d'un fichier texte 
      ayant la structure suivante :</p>
  </blockquote>
</blockquote>
<table width="32%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCC99">
  <tr> 
    <td class="retrait20"> <p align="left"><strong><font size="3">Jospin</font><font size="3">;Lionel;Cp<br>
        Chirac;Jacques;Cm2</font></strong></p></td>
  </tr>
</table>
<blockquote> 
  <blockquote> 
    <p>Chaque champ est d&eacute;limit&eacute; par un pont virgule. Un autre s&eacute;parateur 
      est possible (tabulation)dans le cas ou vous utiliserez PhpMyadmin. Les 
      champs peuvent &ecirc;tre entour&eacute;s par des guillemets.</p>
    <ul>
      <li><strong>Champ 1</strong> : Nom</li>
      <li><strong>Champ 2</strong> : Pr&eacute;nom</li>
      <li><strong>Champ 3 </strong>: Classe</li>
    </ul>
    <p>Ne pas faire de retour &agrave; la ligne &agrave; la fin du dernier enregistrement 
      sinon il y aurait cr&eacute;ation d'un enregistrement suppl&eacute;mentaire 
      vide. </p>
    <p align="center"><img src="eleve_txt.gif" width="299" height="184"></p>
    <p align="center">&nbsp;</p>
    <table border="1" cellspacing="0" cellpadding="0">
      <tr bgcolor="#CCCC99" class="retrait20"> 
        <td class="retrait20"><strong>Le fichier &eacute;tant pr&eacute;par&eacute;, 
          r&eacute;aliser l'import avec PhpMyadmin</strong></td>
      </tr>
      <tr> 
        <td><p align="center">&nbsp;</p>
          <blockquote> 
            <p><a href="../../mysql//" target="_blank"><strong>Acc&egrave;s &agrave; 
              la base de donn&eacute;es via PhpMyAdmin</strong></a><a href="/../mysql//" align="center"></a> 
              - <strong>(<a href="aide_phpmyadmin.php">Aide pour cet acc&egrave;s 
              en cas de difficult&eacute;</a>)</strong></p>
            <p align="left">Cliquer &agrave; gauche sur la table &eacute;l&egrave;ve 
              puis au bas de la nouvelle page affich&eacute;e, cliquer sur :</p>
            <p align="left"><font color="#993333"><strong>&quot;Ins&eacute;rer 
              des donn&eacute;es provenant d'un fichier texte dans la table&quot;</strong></font></p>
            <p align="left"><strong><font color="#993333"><img src="../install/phpmyadmin1.gif" width="636" height="588"></font></strong></p>
            <p align="left"><strong>Compl&eacute;ter en s&eacute;lectionnant votre 
              fichier via <font color="#993333">Parcourir </font></strong></p>
            <p align="left">Dans le champ Nom des colonnes, pr&eacute;cisez l'expression 
              ci-dessous ( TRES IMPORTANT ) de fa&ccedil;on injecter correctement 
              vos informations dans les bonnes colonnes de la table.</p>
            <p align="center"><em><font color="#993333"><strong>nom,prenom,classe 
              </strong></font></em></p>
            <p align="center"><em><font color="#000000">(Attention, il s'agit 
              ici de virgules dans cette expression )</font></em></p>
            <p align="left"><strong>S&eacute;lectionner<font color="#993333"> 
              Data</font> et non Data Local. (Dans le cas de Free, choisir Data 
              Local) </strong>Tester les deux en cas de probl&egrave;me.</p>
            <p align="left"><strong> Enfin Ex&eacute;cuter</strong></p>
            <p align="left"><strong><img src="../install/phpmyadmin2.gif" width="519" height="524"></strong></p>
          </blockquote></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>Remarque : Le mot de passe par d&eacute;faut sera &quot;eleve&quot; (sans 
      accent) et pourra etre modifi&eacute; par l'&eacute;l&egrave;ve lors de 
      son premier acc&eacute;s au logiciel.</p>
    <p>Vous pouvez introduire dans votre fichier texte, le mot de passe. Le fichier 
      aurait alors cette structure :</p>
    <table width="32%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCC99">
      <tr> 
        <td class="retrait20"> <p align="left"><strong><font size="3">Jospin</font><font size="3">;Lionel;Cp;<font color="#993333">D8H6</font><br>
            Chirac;Jacques;Cm2;<font color="#993333">E95X</font></font></strong></p></td>
      </tr>
    </table>
    <p>Dans ce cas de figure, il vous faudra pr&eacute;ciser comme nom de colonne 
      :</p>
    <p align="center"><em><font color="#993333"><strong><font color="#000000">nom,prenom,classe</font>,pass</strong></font></em></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </blockquote>
</blockquote>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
<?php
mysqli_free_result($RsEleve);
?>

