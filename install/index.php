<html>
<head>
<title>Installation &gt; Etape 1</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<p><img src="../patate.gif" width="54" height="46"> <img src="../patate.jpg" width="324" height="39" align="top"> 
</p>
<hr>
<form name="parametres" method="post" action="install_etape3.php">
  <p align="center">&nbsp;</p>
  <p align="left"><span class="title"><font size="6" face="Arial, Helvetica, sans-serif">&lt; 
    Etape 1/5 &gt;</font></span></p>
  <p align="center"><font size="2" face="Arial, Helvetica, sans-serif"><em>( La 
    phase la plus d&eacute;licate pour les d&eacute;butants ! Courage ;)</em></font></p>
  <blockquote> 
    <ul>
      <li><font face="Arial, Helvetica, sans-serif" align="left">Vous avez d&eacute;compress&eacute; 
        votre archive et copi&eacute; le dossier <strong>stockpotatoes</strong> 
        sur le serveur. Pour &eacute;viter les difficult&eacute;s de param&eacute;trages ult&eacute;rieurs,<strong> il est en effet pref&eacute;rable de conserver ce nom de dossier stockpotatoes et de le copier &agrave; la racine de votre serveur.</strong> </font></li>
    </ul>
    <blockquote> 
      <blockquote> 
        <div align="left"> 
          <table width="63%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="49%"><p>Vos exercices seront rang&eacute;s ult&eacute;rieurement 
                  et automatiquement dans un dossier <strong>Exercices</strong> 
                  selon le mod&egrave;le d'arborescence ci-contre. Trois fichiers 
                  de param&egrave;trages seront enregistr&eacute;s dans le dossier 
                  <strong>Connections</strong> </p></td>
              <td width="9%">&nbsp;</td>
              <td width="42%"><img src="arbo.gif" width="136" height="126"></td>
            </tr>
          </table>
        </div>
        <div align="center"></div>
      </blockquote>
      <div align="center"></div>
    </blockquote>
    <ul>
      <li>Vous devez donc <font face="Arial, Helvetica, sans-serif" align="center"> 
        poss&eacute;der par d&eacute;faut les droits en &eacute;criture</font> 
        sur ces deux dossiers.</li>
      <li><font face="Arial, Helvetica, sans-serif" align="center">Si vous avez 
        fait une<strong> installation en local</strong>, vous devez poss&eacute;der 
        par d&eacute;faut les droits en &eacute;criture n&eacute;cessaires. </font><font face="Arial, Helvetica, sans-serif">Vous 
        pouvez donc<strong> passer &agrave; l'&eacute;tape 2.</strong><br>
        </font></li>
      <li><font face="Arial, Helvetica, sans-serif">Si vous utilisez un <strong>h&eacute;bergeur 
        type Free, serveur acad&eacute;mique, OVH, Amen ou autres,</strong> lisez 
        attentivement le<strong> paragraphe ci-dessous.</strong></font></li>
    </ul>
    <p align="center">&nbsp;</p>
  </blockquote>
  <p align="center"><font face="Arial, Helvetica, sans-serif"> 
    <input name="Submit2" type="submit" onClick="MM_goToURL('parent','install_etape2.php');return document.MM_returnValue" value="Passer &agrave; l'&eacute;tape 2">
    </font></p>
  <p align="center">&nbsp;</p>
  <blockquote> 
    <div align="center" class="title"><font face="Arial, Helvetica, sans-serif">DROITS 
      EN ECRITURE</font></div>
    <blockquote> 
      <div align="left"> 
        <p><strong>Vous devez poss&eacute;der les droits en &eacute;criture sur 
          les dossier<strong>s Exercices et Connections</strong></strong> .</p>
        <p>Les deux fichiers ci-dessous seront cr&eacute;&eacute;s &agrave; l'installation 
          (Etape 3) avec attribution des droits en &eacute;criture (chmod 777) 
          par le script. (droits &agrave; v&eacute;rifier en cas de probl&egrave;mes).</p>
      </div>
      <ul>
        <li> 
          <div align="left">Le fichier <strong>Connections/gestion_pass.inc.php</strong> 
            (mots de passe) </div>
        </li>
        <li> 
          <div align="left">Le fichier <strong>Connections/ conn_intranet.php</strong> 
            (param&egrave;tres de connection)</div>
        </li>
      </ul>
      <p>Pour cr&eacute;er <strong> les droits en &eacute;criture sur les dossier<strong>s 
        Exercices et Connections</strong></strong>, vous avez deux possibilit&eacute;s 
        : </p>
      <table border="1" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td> <blockquote> 
              <p>&nbsp;</p>
              <p><strong>Effectuer manuellement l'op&eacute;ration avec votre 
                Outil FTP</strong></p>
              <p>Par exemple, clic droit sur le dossier Exercices puis Propri&eacute;t&eacute;s 
                &gt; Vous cochez tout de fa&ccedil;on &agrave; avoir tous les 
                droits ( chmod 777)</p>
            </blockquote></td>
          <td> <blockquote> 
              <blockquote> 
                <p>&nbsp;</p>
                <p><strong>Effectuer l'op&eacute;ration avec un script Php</strong></p>
                <div align="left">Je vous propose de tenter de modifier les droits 
                  via un Chmod 777. Cette op&eacute;ration ne fonctionne pas avec 
                  tous les h&eacute;bergeurs.En cas de probl&egrave;me, (messages 
                  d'erreurs renvoy&eacute;s par le serveur), il vous faudra attribuer<strong> 
                  ces droits manuellement</strong>.</div>
                <div align="left"></div>
              </blockquote>
            </blockquote>
            <p align="center"> 
              <input name="Submit22" type="submit" onClick="MM_goToURL('parent','install_chmod.php');return document.MM_returnValue" value="Tenter de modifier les droits en &eacute;criture avec un Chmod">
            </p>
            <p align="center">&nbsp; </p></td>
        </tr>
      </table>
      <p>&nbsp; </p>
    </blockquote>
    <p align="center" class="title"><font face="Arial, Helvetica, sans-serif"> 
      SI VOTRE HEBERGEUR EST FREE</font></p>
    <blockquote> 
      <div align="left">Vous devrez imp&eacute;rativement cr&eacute;er un dossier 
        vide nomm&eacute; <strong>sessions (en minuscules) &agrave; la racine 
        de votre site Free </strong>(et non pas dans votre dossier stockpotatoes).</div>
      <p><strong>Un probl&egrave;me subsiste pour l'h&eacute;bergeur Free</strong> 
        avec la suppression du dernier exercice upload&eacute;. Il y a bien suppression 
        de l'exo mais pas du dossier... et donc g&eacute;n&eacute;ration de bug 
        en s&eacute;rie... Free a en effet d&eacute;sactiv&eacute; la commande 
        php &quot;rmdir&quot; permettant de supprimer un r&eacute;pertoire !!!        </p>
      <p>Cela n'emp&ecirc;che cependant pas le fonctionnement de Stockpotatoes ! </p>
    </blockquote>
  </blockquote>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
