<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php


$pass_profs=$_POST['pass_profs'] ;
$pass_admin=$_POST['pass_admin'] ;
$pass_upload=$_POST['pass_upload'] ;

 

		$fp = @fopen("../Connections/gestion_pass.inc.php", "w")
			or die ("<b>Le fichier Connections/gestion_pass.inc.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
	
		$data = "<?PHP\n";
		$data.= " \$pass_profs = \"".$pass_profs."\";\n";
        $data.= " \$pass_admin = \"". $pass_admin."\";\n";
		$data.= " \$pass_upload = \"".$pass_upload."\";\n";
		$data.= "\n";
		$data.= "?>";
		$desc = @fwrite($fp, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp) or die ("<b>Erreur > Fermeture du fichier </b>");



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
      <p align="center">&nbsp;</p>
      <div align="center">
        <ul>
          <li><strong>Les mots de passe ont &eacute;t&eacute; actualis&eacute;s 
            avec succ&egrave;s.</strong></li>
        </ul>
      </div>
      <p align="center">&nbsp;</p>
      <p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
        Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
      <p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou 
        un document sur le serveur</a></p>
<p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
