<?php

if (isset($_POST['url_base	'] )) { $url_base		= $_POST['url_base	'] ;} else {$url_base='';}
if (isset($_POST['chemin_images'])) {$chemin_images		= $_POST['chemin_images'] ;} else {$chemin_images='';}
if (isset($_POST['chemin_editeur'])) {$chemin_editeur	= $_POST['chemin_editeur'] ;} else {$chemin_editeur='';}


touch("../Connections/conn_editeur.inc.php");
$fichier1='../Connections/conn_editeur.inc.php';
chmod($fichier1,0777);


function EcrireFichier($url_base,$chemin_images,$chemin_editeur) {
	
		$fp = @fopen("../Connections/conn_editeur.inc.php", "w")
			or die ("<b>Le fichier Connections/conn_editeur.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
		$data = "<?PHP\n";
		$data.= " \$url_base = \"".$_POST['url_base']."\";\n";
                $data.= " \$chemin_images = \"". $_POST['chemin_images']."\";\n";
		$data.= " \$chemin_editeur	= \"".$_POST['chemin_editeur']."\";\n";
		$data.= "\n";
		$data.= "?>";
		$desc = @fwrite($fp, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp) or die ("<b>Erreur > Fermeture du fichier </b>");

		

}


EcrireFichier($url_base,$chemin_images,$chemin_editeur)  ;




?>



<html>
<head>
<title>Installation du Serveur > Etape 2</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td> <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center">.</p>
      <p align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif"> Param&egrave;trage de l'&eacute;diteur</font><br>
      </strong><strong>Vos param&egrave;tres ont &eacute;t&eacute; enregistr&eacute;s. </strong></p>
      <blockquote>
        <div align="center">
          <div align="center">
            .</div>
          <p align="center" class="title"><font face="Verdana, Arial, Helvetica, sans-serif">FIN DE L'INSTALLATION</font></p>
          <p align="left">Si vous avez d&eacute;j&agrave; install&eacute; Stockpotatoes et venez simplement de modifier le param&eacute;trage de l'&eacute;diteur, ignorez les &eacute;tapes ci-dessous. </p>
          <p align="left"><strong>Il vous reste &agrave; cr&eacute;er dans <a href="../administrateur/accueil_admin.php" target="_blank">l'espace administrateur :</a></strong></p>
        </div>
        <ul>
          <li>
            <div align="left"><strong><a href="../administrateur/gestion_matiere_niveau.php" target="_blank">les mati&egrave;res et les niveaux</a></strong></div>
          </li>
          <li>
            <div align="left"><strong><a href="../administrateur/gestion_eleve_txt.php" target="_blank">la liste des &eacute;l&egrave;ves</a></strong></div>
          </li>
        </ul>
        <p><strong>Puis enfin <a href="../presentation/config.htm" target="_blank">param&eacute;trer convenablement le logiciel Hotpotatoes</a> permettant de r&eacute;aliser les exercices.</strong></p>
        <p><strong>Chaque enseignant pourra alors<a href="../enseignant/gestion_theme.php" target="_blank"> cr&eacute;er ses th&egrave;mes d'&eacute;tude</a> au sein de sa mati&egrave;re et envoyer sur le serveur ses premiers exercices.</strong></p>
        <p align="center">.</p>
        <p align="center" class="subtitle">S&eacute;curit&eacute;</p>
        <p align="left">A la fin de l'installation, vous pouvez prot&eacute;ger - ou supprimer -<font size="2"> le dossier &quot;install&quot; afin d'&eacute;viter un acte malveillant</font> tel la r&eacute;installation du logiciel et par voie de cons&eacute;quence, le vidage de la base stockpotatoes.</p>
        <p>.</p>
        <p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../administrateur/accueil_admin.php">Espace administrateur</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a></p>
        <p>.</p>
      </blockquote>      <p align="center">.</p>
      <p>.</p>
      <p>.</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
