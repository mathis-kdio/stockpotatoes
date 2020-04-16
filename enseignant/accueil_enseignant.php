<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<html>
<head>
<title>Espace enseignant</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Style1 {
	color: #FFFF66;
	font-weight: bold;
}
.Style2 {color: #FFFF66}
-->
</style>
</head>
<body>


<table width="100%"  border="0">
  <tr>
    <td><a href="../index.php"><img src="../patate.gif" width="47" height="40" border="0"></a><img src="../patate.jpg" width="324" height="39" align="top"></td>
    <td valign="bottom"><strong><a href="../index.php">Accueil Stockpotatoes</a> - Espace Enseignant</strong></td>
    <td valign="bottom"><div align="right"><span class="subtitle"><strong><?php 
	if (isset($_SESSION['Sess_nom'])){
	
	echo $_SESSION['Sess_nom'];} else {$_SESSION['Sess_nom']='ENSEIGNANT';echo $_SESSION['Sess_nom'];} ?></strong></span></div></td>
  </tr>
</table>
<table border="0" align="center" cellpadding="1" cellspacing="5">
  <tr valign="bottom">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="50%" class="title"> <p class="retrait20"><strong> Gestion des exercices</strong></p></td>
    <td width="50%" class="title"> <p class="retrait20"><strong> Suivi des &eacute;l&egrave;ves</strong></p></td>
  </tr>
  <tr valign="bottom"> 
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="gestion_exos.php">Gestion 
    des exercices - Modification - Suppression</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_activite.php">Les 
    derni&egrave;res activit&eacute;s</a></strong></p></td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="gestion_theme.php">Gestion 
    des th&egrave;mes d'&eacute;tude dans une mati&egrave;re</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_resultat_quiz_classe.php">R&eacute;sultats 
    &agrave; un exercice dans une classe</a></strong></p></td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20">&nbsp;</td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"><a href="liste_resultat_theme_classe.php"><strong>R&eacute;sultats 
      des exercices li&eacute;s &agrave; un th&egrave;me pour une classe</strong></a></td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_quiz_recent.php">Liste 
    des derniers exercices publi&eacute;s</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_resultat_theme_pourcent_classe.php">R&eacute;sultats 
    en % par th&egrave;me pour une classe</a></strong></p></td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_quiz_publie.php">Liste 
    des exercices publi&eacute;s dans une mati&egrave;re</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="modif_score_blanc.php">Remise 
    &agrave; blanc des r&eacute;sultats pour un exercice dans une classe</a></strong></p></td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_quiz_non_publie.php">Liste 
    des exercices non publi&eacute;s dans une mati&egrave;re</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><a href="../Exercices/resultats.csv"><strong>Consulter 
        le dernier export Excel- Csv de r&eacute;sultats g&eacute;n&eacute;r&eacute;</strong> 
    </a></p></td>
  </tr>
  <tr valign="top"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_quiz_avec_score.php">Liste 
    des exercices en &eacute;valuation seule</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="liste_pass.php">Liste 
    des mots de passe d'une classe</a></strong></p></td>
  </tr>
  <tr> 
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr> 
    <td width="50%" class="title"> <p class="retrait20"><strong>Divers</strong></p></td>
    <td width="50%" class="title">&nbsp;</td>
  </tr>
  <tr valign="bottom" class="retrait20"> 
    <td width="50%" height="20" class="retrait20">&nbsp;</td>
    <td width="50%" height="20" class="retrait20">&nbsp;</td>
  </tr>
  <tr valign="bottom" class="retrait20"> 
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="../upload/upload_menu.php">Envoyer 
    un exercice ou un document sur le serveur</a></strong></p></td>
    <td width="50%" bgcolor="#cccc99" class="retrait20"> <p><strong><a href="../documentation.htm" target="_blank">Documentation 
    compl&egrave;te </a>- <a href="config.php">Aide pour les enseignants</a></strong></p></td>
  </tr>
  <tr valign="bottom" class="retrait20">
    <td bgcolor="#cccc99" class="retrait20"><strong><a href="../upload/modif_select.php">G&eacute;rer les fichiers joints &agrave; un exercice</a> (images ...)</strong></td>
    <td bgcolor="#cccc99" class="retrait20"><strong><a href="../administrateur/login_administrateur.php">Espace administration</a> - <a href="../index.php"> Accueil Stockpotatoes</a></strong></td>
  </tr>
  <tr valign="bottom" class="retrait20">
    <td bgcolor="#cccc99" class="retrait20"><a href="http://www.ac-orleans-tours.fr/ses/pedagogie/utilisation%20tice/exo_hotpot/sommaire.htm"><strong>Tutoriel Hotpotatoes 6 </strong></a></td>
    <td bgcolor="#cccc99" class="retrait20">&nbsp;</td>
  </tr>
  <tr valign="bottom" class="retrait20"> 
    <td colspan="2" bgcolor="#cccc99" class="retrait20"> <p>&nbsp;</p> <p><!-- Fil RSS Café Pédagogique -->
  <style>
.rss_box{
border: solid 2px #dcb478;
background-color:#ffffff;/*blanc*/
margin:0px;
width:100%;
}
.rss_title a {
background-color:#ffefce;/*marron*/
font-family:arial;
font-size:medium; 
font-style:oblique; 
font-weight:bolder; 
color:#000000;/* noir*/
width :100%;
text-align:justify;
tex-decoration:blink;
margin-left:0px;
padding:0px;
}
.rss_title {
background-color:#ffefce;/*marron*/
font-family:arial;
font-size:100%;
font-weight:bolder; 
color:#dc1803;/*rouge-orangé*/
text-align:left;
margin-left:0px;
width:100%;
text-decoration :none;
padding:5px;
}
.rss_item a:visited {
font-family:arial;
font-size:100%;
color:#000000;/* noir*/
background-color:transparent;
margin-top :0px;
margin-left :0px;
text-decoration :none;
text-align: justify; text-justify: distribute;
}
.rss_item a:hover {
font-family:arial;
font-size:100%;
color:#dc1803;/*rouge-orangé*/
background-color:transparent;
margin-top :0px;
margin-left :0px;
text-decoration :none;
text-align: justify; text-justify: distribute;
}
.rss_item a:active {
font-family:arial;
font-size:100%;
color:#884da7;/*violet*/
background-color:transparent;
margin-top :0px;
margin-left :0px;
text-decoration :none;
text-align: justify; text-justify: distribute;
}

.rss_items {
/* E - Une nouvelle */
font-size: 100%;
margin-left: 25px;
margin-right:10px;
margin-top :0px;
margin-bottom :25px;
text-decoration :none;
text-align: justify; text-justify: distribute;
}
</style>
  
<script language="JavaScript" src="http://www.cafepedagogique.net/feed2js/feed2jsStyle.php?src=http://www.cafepedagogique.net/rss/rss.xml" type="text/javascript"></script>
  
    <noscript>
<a href="http://www.cafepedagogique.net/feed2js/feed2jsStyle.php?src=http://www.cafepedagogique.net/rss/rss.xml">View RSS feed</a>
      </noscript>
      <!-- Fin du fil RSS -->      &nbsp;
      </p></td>
  </tr>
</table>

<p align="center">&nbsp;</p>
<p align="center"><a href="../index.php" align="center">Accueil Stockpotatoes</a> 
  - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a> 
  - <a href="../upload/upload.php" align="center">Envoyer un exercice sur le serveur</a></p>
<p>&nbsp; </p>

</body>
</html>
