<?php
require_once('../Connections/conn_editeur.inc.php'); 
?>
<html>
<head>
<title>Paramètres de l'éditeur en ligne</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Style2 {color: #000000}
.Style4 {
	color: #0000FF;
	font-weight: bold;
}
.Style5 {
	font-size: xx-small;
	color: #990000;
}
-->
</style>
</head>
<body>
<p><img src="../patate.gif" width="54" height="46"> <img src="../patate.jpg" width="324" height="39" align="top"> 
</p>
<p><b>Param&eacute;trage de l'Editeur HTMLen ligne FCKeditor</b></p>
<form name="parametres" method="post" action="install_editeur2.php">
  <table border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#996666">
    <br>
    <tr bordercolor="#FFFFD0"> 
      <td colspan="2" align="center">          <div align="center"><span class="title"><font size="6" face="Arial, Helvetica, sans-serif">&lt; Etape </font></span><span style="background-color: #990000; color: #FFFF66;" #invalid_attr_id="30px"><font size="6" face="Arial, Helvetica, sans-serif">5/5 </font></span><span class="title"><font size="6" face="Arial, Helvetica, sans-serif">&gt;</font></span> <br>
    </div></td></tr>
    <tr bordercolor="#FFFFD0"> 
      <td width="50%"><p><b>Dossier racine </b><br>
          URL de votre serveur. <span class="Style4"><br>
          Laisser vide dans le cas d'un Intranet</span>.<br> 
          Dans les autres cas indiquer le chemin complet : http://nom_de_votre_serveur<br>
        Chez Free, ce sera par exemple <font color="#990000"><strong>http://votre_login.free.fr<br>
        </strong></font>Attention &agrave; ne pas mettre de barre oblique &agrave; la fin de votre adresse.<br>
      </p>        </td>
      <td width="50%" valign="top"><p>&nbsp;
        </p>
        <p>
          <input name="url_base" type="texte" id="url_base" value="<?php  echo $url_base ?>" size="80" maxlength="80">
        </p></td>
    </tr>
    <tr bordercolor="#FFFFD0"> 
      <td width="50%"><p><b>Nom du chemin des fichiers images <br>
          </b><span class="Style4">Cette valeur par d&eacute;faut convient normalement </span>(convient pour Free notamment) <br>
          <span class="Style2">Attention si vous avez renomm&eacute; stockpotatoes. Cela deviendra </span>/votre_dossier_stockpotatoes/Exercices/UserFiles/</p>
        <p> Attention aux barres obliques (d&eacute;but et fin). </p>
        <p>Respecter majuscules et minuscules<br>
        Si des probl&ecirc;mes subsistaient, v&eacute;rifier que vous poss&eacute;dez les droits en &eacute;criture sur ce dossier UserFiles et ses sous dossiers. </p>
        <p>V&eacute;rifiez que le dossier est bien &agrave; la racine de votre serveur </p>
        <p class="Style5">Exemple. L'adresse de mon site h&eacute;berg&eacute; sur le serveur acad&eacute;mique est <br>
          http://www.etab.ac-caen.fr/bsauveur. <br>
          Je dois donc mettre dans cette boite de formulaire<br>
          /bsauveur/stockpotatoes/Exercices/UserFiles/
        </p>
        <p> <br>        
        </p></td>
      <td width="50%" valign="top"><p>&nbsp;
        </p>
        <p>
          <input name="chemin_images" type="text" id="chemin_images" value="<?php  echo $chemin_images ?>" size="80" maxlength="80">
        </p></td>
    </tr>
    <tr bordercolor="#FFFFD0"> 
      <td width="50%" valign="top"><p><b>Chemin de l'&eacute;diteur <br>
          </b><span class="Style4">Cette valeur par d&eacute;faut convient normalement </span></p>
        <p><span class="Style2">Respecter majuscules et minuscules<br>
        </span><span class="Style2">Attention si vous avez renomm&eacute; stockpotatoes.<br>
  Attention aux barres obliques.  (d&eacute;but et fin) </span></p>
        <p><br>        
      </p></td>
      <td width="50%" valign="top"> <p>&nbsp;
        </p>
        <p>
          <input name="chemin_editeur" type="text" id="chemin_editeur" value="/stockpotatoes/upload/" size="80" maxlength="80" >
        </p></td>
    </tr>
    <tr bordercolor="#FFFFD0"> 
      <td colspan="2"><div align="center">
        <p>&nbsp;          </p>
        <p>
          <input type="submit" name="verif" value="Enregistrer ces param&egrave;tres  " >
        </p>
        <p>&nbsp;    </p>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
