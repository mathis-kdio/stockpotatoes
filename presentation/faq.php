<html>
<head>
<title>FAQ</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p>&nbsp; </p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="50%"><img src="patate.gif" width="253" height="227"></td>
    <td width="50%"><div align="center"> 
        <p><img src="patate.jpg" width="324" height="39" align="top"></p>
        <p class="subtitle">Questions fr&eacute;quentes</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><a href="index.htm">Retour au sommaire</a></p>
      </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p class="title"><font face="Verdana, Arial, Helvetica, sans-serif">Les mots de 
  passe par d&eacute;faut</font></p>
<blockquote> 
  <ul>
    <li>Mot de passe Enseignant <strong> : tuteur</strong></li>
    <li>Mot de passe Administrateur <strong>: maitre</strong></li>
    <li>Mot de passe pour envoyer ses exercices : <strong>hotpot</strong></li>
    <li>Mot de passe par d&eacute;faut pour les &eacute;l&egrave;ves : <strong>eleve</strong> 
      (sans accents) (mais<strong> bs</strong> dans le cas de la d&eacute;mo en 
      ligne)</li>
  </ul>
  <blockquote> 
    <p>Sur la page d'accueil de l'&eacute;l&egrave;ve, vous trouverez un lien 
      <strong>Modifier mon mot de passe</strong> permettant &agrave; chaque &eacute;l&egrave;ve 
      de modifier son mot de passe. Vous trouverez dans l'Espace Enseignant, un 
      lien vous permettant de lister tous les mots de passe d'une classe.</p>
  </blockquote>
  <p><strong> </strong></p>
  <p>&nbsp;</p>
</blockquote>
<p class="title"><font face="Verdana, Arial, Helvetica, sans-serif">Je souhaiterais 
  remplacer les mati&egrave;res par des Capacit&eacute;s </font></p>
<blockquote>
  <p>Il vous suffit simplement de les cr&eacute;er en lieu et place des mati&egrave;res. 
    Personellement, je conserverais les mati&egrave;res mais je saisirais les 
    capacit&eacute;s en lieu et place des niveaux.</p>
  <p>Pour information, la cr&eacute;ation d'une mati&egrave;re entraine la cr&eacute;ation 
    d'un r&eacute;pertoire sur le disque dans lequel seront rang&eacute;s les 
    exercices. Les niveaux sont un simple filtre sur une mati&egrave;re.</p>
  </blockquote>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="title"><font face="Verdana, Arial, Helvetica, sans-serif">Comment faire 
  pour abandonner un exercice en cours</font></p>
<blockquote> 
  <p>Si l'&eacute;l&egrave;ve va jusqu'au bout apres avoir repondu correctement 
    &agrave; ses questions, une fenetre s'ouvre avcec son score et deux boutons 
    <strong>Autre Qcm</strong> ou<br>
    <strong>Se deconnecter</strong>. Si l'&eacute;l&egrave;ve d&eacute;sire abandonner 
    en cours de route, il faut utiliser la touche pr&eacute;cedent puis Actualiser. 
    Peu &eacute;l&eacute;gant mais difficile de faire autrement, ceci &eacute;tant 
    li&eacute; au d&eacute;veloppement PHP</p>
  <p>Cependant la solution la plus esth&eacute;tique est la suivante mais n&eacute;cessite 
    de changer un param&egrave;tre de votre Hotpotatoes :</p>
  <p>Dans <font color="#990000">Hotpotatoes <strong>Option</strong></font> - <strong><font color="#990000">Configurer 
    le r&eacute;sultat</font></strong><font color="#990000"><font color="#333333"> 
    (version 5 )ou</font><strong> Configurer l'aspect de la page Web</strong></font>(version 
    6) puis onglet<font color="#990000"> <strong>Boutons</strong></font></p>
  <p>Cocher le Bouton Index et mettre par exemple &quot;Abandon - Autre exercice&quot; 
    et mettre dans le champ URL correspondant</p>
  <p><br>
    <strong><font color="#000000" size="5">../../../accueil_eleve.php</font></strong></p>
  <p><img src="config_bouton.gif" width="607" height="463"><br>
  </p>
  <p>Un exemple est pr&eacute;sent sur le site Demo en ligne &gt; prendre - <strong>Histoire 
    - Coll&egrave;ge - L'union europ&eacute;enne</strong><br>
  </p>
  <p>&nbsp; </p>
</blockquote>
<p class="title"><font face="Verdana, Arial, Helvetica, sans-serif">Les questions 
  de l'exercice ne s'affichent pas - Seules les consignes s'affichent.</font></p>
<blockquote> 
  <p><font face="Verdana, Arial, Helvetica, sans-serif">Vous avez probablement 
    repris un ancien exercice dans la derni&egrave;re version Hotpotatoes 6. Un 
    ancien qcm fait avec la version 5 <strong> ET POSSEDANT un texte d'accompagnement</strong> 
    (consigne), pose probl&egrave;me.</font></p>
  <p><font face="Verdana, Arial, Helvetica, sans-serif">Vous devez reprendre ces 
    vieux Qcm existant, avec votre Hotpotatoes version 5</font></p>
  <p><font face="Verdana, Arial, Helvetica, sans-serif">NB : Dans le cas de la 
    cr&eacute;ation d'un nouvel exercice, vous pouvez prendre la version 5 ou 
    la 6. Attention cependant, un navigateur trop ancien peut poser probl&egrave;me 
    &agrave; l'affichage d'un exercice construit avec les subtilit&eacute;s du 
    langage HTML de la version 6 de Hotpotatoes.<br>
    NB : Vous pouvez faire cohabiter les 2 versions sur son ordinateur.</font></p>
  <p>&nbsp;</p>
</blockquote>
<p class="title"><font face="Verdana, Arial, Helvetica, sans-serif">A quoi sert 
  l'invite javascript au lancement de l'exercice hotpotatoes ou l'&eacute;l&egrave;ve 
  doit taper son nom</font></p>
<blockquote>
  <p><font face="Verdana, Arial, Helvetica, sans-serif">A rien ! De toute f&agrave;&ccedil;on 
    il a d&eacute;j&agrave; identifi&eacute; en d&eacute;but de session. Il peut 
    taper ici n'importe quoi, (mais il doit obligatoirement taper quelque chose) 
    puis cliquer sur OK. Etrange me direz vous ? Cette fen&ecirc;tre est propre 
    au fonctionnement de Hotpotatoes. J'aurais pu l'&eacute;liminer, mais cela 
    aurait n&eacute;cessit&eacute; trop de comp&eacute;tences informatiques pour 
    les enseignants d&eacute;butants. Alors, laissons cette petite fen&ecirc;tre.</font></p>
</blockquote>
<p>&nbsp;</p>
<p align="center"></p>
<p align="center"><a href="index.htm">Retour au sommaire</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
