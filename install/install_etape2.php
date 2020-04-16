<html>
<head>
<title>Paramètres de connexion à la base de donnée</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><img src="../patate.gif" width="54" height="46"> <img src="../patate.jpg" width="324" height="39" align="top"> 
</p>
<p><b>Param&eacute;trages de la connexion &agrave; la base de donn&eacute;es</b> 
</p>
<form name="parametres" method="post" action="install_etape3.php">
  <table border="0" align="center" cellspacing="3" cellpadding="5">
    <br>
    <tr> 
      <td colspan="2" align="center"><div align="left"> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top"> 
              <td width="31%"><span class="title"><font size="6" face="Verdana, Arial, Helvetica, sans-serif">&lt; 
                Etape 2 &gt;</font></span> </td>
              <td width="69%"> <p>&nbsp;</p>
                </td>
            </tr>
          </table>
          <p>Nous avons attribu&eacute; des droits en &eacute;criture aux dossiers 
            Exercices et Connections. Nous allons maintenant param&eacute;trer 
            l'acc&egrave;s &agrave; la base de donn&eacute;es.</p>
          <hr>
          <p><br>
          </p>
        </div></td>
    </tr>
    <tr> 
      <td width="50%"><b>Serveur MySQL:</b><br>
        Adresse IP ou URL de votre serveur de bases de données MySQL. La valeur<font color="#0000FF"> 
        <strong>localhost</strong></font> conviendra dans le cas d'un Intranet<br>
        Chez Free, ce sera <font color="#990000"><strong>sql.free.fr. </strong><font color="#000000">Attention, 
        il convient &eacute;videmment d'avoir activ&eacute; sa base MySql chez 
        ce fournisseur. (<a href="http://subscribe.free.fr/acces/createbase.html">Activer 
        Free</a>) </font></font></td>
      <td width="50%"><input type="texte" name="serveur" size="25" maxlength="80" value="localhost"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Nom d'utilisateur MySQL :<br>
        </b>La valeur <strong><font color="#0000FF">root</font></strong> conviendra 
        dans le cas d'un Intranet.<br>
        Chez Free, ce sera <strong><font color="#990033">votre login Free </font></strong></td>
      <td width="50%"><input type="text" name="login" size="25" maxlength="80" value="root"></td>
    </tr>
    <tr> 
      <td width="50%"><b>Mot de passe MySQL :<br>
        </b><font color="#0000FF"><strong>Pas de mot de passe</strong></font> 
        par d&eacute;faut dans le cas d'un Intranet.<br>
        Chez Free, ce sera<strong><font color="#990000"> votre password Free..</font></strong></td>
      <td width="50%"> <input type="password" name="password" size="25" maxlength="80" ></td>
    </tr>
    <tr> 
      <td width="50%"><p><b>Nom de la base de données :<br>
          </b>Conservez la valeur <strong><font color="#0000FF">stockpotatoes</font></strong> 
          dans le cas d'un Intranet ou dans le cas ou vous ne disposez pas encore 
          d'une base<b>.<br>
          </b>Chez Free, ce sera &agrave; nouveau <strong><font color="#990000">votre 
          login Free</font></strong>. </p></td>
      <td width="50%"> <input name="base" type="text" id="base2" value="stockpotatoes" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td colspan="2"><br> <br></td>
    </tr>
    <tr> 
      <td colspan="2" align="center"><p> 
          <input type="submit" name="verif" value="Enregistrer ces param&egrave;tres et passer &agrave; l'&eacute;tape suivante" >
        </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td>
    </tr>
  </table>
</form>
</body>
</html>
