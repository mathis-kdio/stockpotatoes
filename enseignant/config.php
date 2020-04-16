<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?><html>
<head>
<title>Configuration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="../patate.gif" width="253" height="227"></td>
    <td><div align="center"> 
        <p><img src="../patate.jpg" width="324" height="39" align="top"> </p>
        <p>&nbsp;</p>
      </div>
      <ul>
        <li> 
          <div align="left"><a href="#passe">Quels sont les diff&eacute;rents 
            mots de passe ?</a></div>
        </li>
        <li> 
          <div align="left"><a href="#config1">Comment configurer Hotpotatoes 
            pour vos prochains exercices ?</a></div>
        </li>
        <li> 
          <div align="left"><a href="#config2">Comment modifier des exercices 
            r&eacute;alis&eacute;s par le pass&eacute; ?</a></div>
        </li>
        <li> 
          <div align="left"><a href="#envoi1">Comment envoyer un fichier exercice 
            sur le serveur ?</a></div>
        </li>
        <li> 
          <div align="left"><a href="#envoi2">Comment envoyer les images int&eacute;gr&eacute;es 
            dans un exercice ?</a></div>
        </li>
      </ul></td>
  </tr>
</table>
<p>&nbsp;</p>
<p class="title">Quels sont les diff&eacute;rents mots de passe ?<a name="passe"></a></p>
<ul>
  <li>Mot de passe Enseignant <strong> : tuteur</strong></li>
  <li>Mot de passe pour envoyer ses exercices : <strong>hotpot</strong></li>
  <li>Mot de passe par d&eacute;faut pour les &eacute;l&egrave;ves : <strong>eleve</strong> 
    (sans accents)</li>
</ul>
<blockquote> 
  <p>Sur la page d'accueil de l'&eacute;l&egrave;ve, vous trouverez un lien <strong>Modifier 
    mon mot de passe</strong> permettant &agrave; chaque &eacute;l&egrave;ve de 
    modifier son mot de passe. Vous trouverez dans l'Espace Enseignant, un lien 
    vous permettant de lister tous les mots de passe d'une classe.</p>
</blockquote>
<p>&nbsp; </p>
<p class="title"> Comment configurer Hotpotatoes pour vos prochains exercices 
  ?<a name="config1"></a> </p>
<blockquote> 
  <p>&nbsp;</p>
  <p>Dans chaque module de hotpotatoes, cliquer sur <strong>Option</strong>, puis 
    <strong>Configurer l'interface</strong></p>
  <p>Cliquer sur l'onglet bouton (&eacute;cran ci-dessous) et d&eacute;cochez 
    les &eacute;ventuels boutons de navigation</p>
  <p><img src="config1.gif" width="628" height="550"> </p>
  <p>&nbsp;</p>
  <p>Cliquer ensuite sur l'onglet <strong>Courriel</strong> (Hotpotatoes Version 
    6)<strong> </strong>ou<strong> CGI</strong> (Hotpotatoes Version 6) - Ecran 
    ci-dessous</p>
  <p>Cocher Envoyer les r&eacute;sultats puis dans le premier champ Adresse du 
    Script, taper :</p>
  <table width="16%" border="1" align="left" cellpadding="0" cellspacing="0">
    <tr> 
      <td bgcolor="#CCCC99"><div align="left"><font size="5">../../traitement.php</font></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>Respecter rigoureusement la syntaxe (minuscules, points, sans espaces)</p>
  <p align="center">&nbsp;</p>
  <p><img src="config2.gif" width="628" height="550"> </p>
  <p>&nbsp;</p>
  <p>Cliquer enfin sur <strong>Enregistrer</strong> puis <strong>OK</strong></p>
  <p>Rappel : cette op&eacute;ration est &agrave; faire une seule fois pour chaque 
    module de votre Hotpotatoes sur lequel vous composez vos exercices.</p>
  <p>&nbsp;</p>
  <p>&nbsp; </p>
  <p class="title"> Comment modifier des exercices r&eacute;alis&eacute;s par 
    le pass&eacute; ?<a name="config2"></a></p>
  <p>&nbsp;</p>
  <p>Il vous faut reprendre les fichiers sources (extension jbc par exemple) dans 
    Hotpotatoes, modifier les &eacute;crans ci-dessus et recr&eacute;er la page 
    Web. Fastidieux, me direz vous ? Un joli copier coller de l'expression &quot;<font size="2">../../traitement.php&quot; 
    et le tour est jou&eacute; ;). N'est ce pas l'occasion de v&eacute;rifier 
    certaines questions ? Enfin vous b&eacute;n&eacute;ficierez des am&eacute;liorations 
    de la version 6. </font></p>
  <p>&nbsp; </p>
  <p class="title"> Comment envoyer un fichier exercice sur le serveur ?<a name="envoi1"></a></p>
  <p>Mes exercices sont maintenant au format page Web. Depuis la page d'accueil 
    de Stockpotatoes, je clique sur<strong> Mettre un exercice en ligne. </strong>Je 
    tape le mot de passe<strong> hotpot </strong>puis effectue les consignes demand&eacute;es 
    sur la page.Je pense &agrave; cocher <strong>Publier en ligne</strong> (pour 
    un usage imm&eacute;diat) et<strong> Enregistrement du score</strong> si je 
    d&eacute;sire une note de l'&eacute;l&egrave;ve.</p>
  <p>&nbsp;</p>
  <p>&nbsp; </p>
  <p class="title"> Comment envoyer les images int&eacute;gr&eacute;es dans un 
    exercice ?<a name="envoi2"></a></p>
  <p>Vous avez d&eacute;j&agrave; envoy&eacute; la page Web ( fichier d'extension 
    htm ou html ). Pour envoyer les fichiers joints (images, vid&eacute;os, sons, 
    vous trouverez un lien en haut et &agrave; droite de la page <strong> Mettre 
    un exercice en ligne</strong> intitul&eacute; <a href="../upload/upload.php"><strong>Ajouter 
    des fichiers (images, son, vid&eacute;o li&eacute;s &agrave; un exercice)</strong></a> 
    . Suivez les consignes.</p>
</blockquote>
</body>
</html>
