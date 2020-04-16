<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Administrateur') { header("Location: login_administrateur.php");}
; } else { header("Location: ../index.php");}?>
<?php

$serveur		= $_POST['serveur'] ;
$login			= $_POST['login'] ;
$password		= $_POST['password'] ;
$base			= $_POST['base'] ;



function EcrireFichier($serveur,$base,$login, $password ) {

		$fp = @fopen("../Connections/conn_intranet.php", "w")
			or die ("<b>Le fichier Connections/conn_intranet.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
	
		
		$data = "<?PHP\n";
		$data.= " \$hostname_conn_intranet = \"".$serveur."\";\n";
        $data.= " \$database_conn_intranet = \"". $base."\";\n";
		$data.= " \$username_conn_intranet = \"".$login."\";\n";
		$data.= " \$password_conn_intranet = \"".$password."\";\n";
		$data.= " \$conn_intranet = mysql_pconnect(\$hostname_conn_intranet, \$username_conn_intranet, \$password_conn_intranet) or die(mysql_error());\n";
		$data.= "\n";
		$data.= "?>";
		$desc = @fwrite($fp, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp) or die ("<b>Erreur > Fermeture du fichier </b>");


}


EcrireFichier($serveur, $base, $login, $password)  ;

require_once('../Connections/conn_intranet.php');


?>



<html>
<head>
<title>Installation du Serveur > Etape 2</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p>&nbsp; </p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td> <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p>&nbsp;</p>
      <p align="center">La connexion &agrave; la base de donn&eacute;e</p>
      <p align="center"> 
        <?php $base ?>
      </p>
      <p align="center">s'est correctement d&eacute;roul&eacute;e avec ces param&egrave;tres.</p>
      <p align="center"><a href="accueil_admin.php"><strong>Retour &agrave; l'Espace 
        Administrateur</strong></a></p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> -<a href="accueil_admin.php"> Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
