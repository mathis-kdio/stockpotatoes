<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$serveur		= $_POST['serveur'] ;
$login			= $_POST['login'] ;
$password		= $_POST['password'] ;
$base			= $_POST['base'] ;


touch("../Connections/conn_intranet.php");
$fichier1='../Connections/conn_intranet.php';
chmod($fichier1,0777);
touch("../Connections/gestion_pass.inc.php");
$fichier2='../Connections/gestion_pass.inc.php';
chmod($fichier2,0777);

function EcrireFichier($serveur,$base,$login, $password ) {
	
		$fp = @fopen("../Connections/conn_intranet.php", "w")
			or die ("<b>Le fichier Connections/conn_intranet.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
		$data = "<?php\n";
		$data.= " \$hostname_conn_intranet = \"".$serveur."\";\n";
        $data.= " \$database_conn_intranet = \"". $base."\";\n";
		$data.= " \$username_conn_intranet = \"".$login."\";\n";
		$data.= " \$password_conn_intranet = \"".$password."\";\n";
		$data.= " \$conn_intranet = mysqli_connect(\$hostname_conn_intranet, \$username_conn_intranet, \$password_conn_intranet) or die(mysql_error());\n";
		$data.= " mysqli_set_charset(\$conn_intranet, 'utf8mb4');\n";	
		$data.= "\n";
		$data.= "?>";
		$desc = @fwrite($fp, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp) or die ("<b>Erreur > Fermeture du fichier </b>");

		$fp2 = @fopen("../Connections/gestion_pass.inc.php", "w")
			or die ("<b>Le fichier Connections/gestion_pass.inc.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
		$data = "<?php\n";
		$data.= " \$pass_profs = \"tuteur\";\n";
        $data.= " \$pass_admin = \"maitre\";\n";
		$data.= " \$pass_upload = \"hotpot\";\n";
		$data.= "\n";
		$data.= "?>";
	    $desc = @fwrite($fp2, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp2) or die ("<b>Erreur > Fermeture du fichier </b>");

}

EcrireFichier($serveur, $base, $login, $password)  ;

require_once('../Connections/conn_intranet.php');


?>



<html>
<head>
<title>Installation du Serveur > Etape 2</title>
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td><a href="../index.php"><img src="../patate.gif" width="253" height="227" border="0"></a></td>
    <td> <p align="center"><img src="../patate.jpg" width="324" height="39" align="top"></p>
      <p align="center">&nbsp;</p>
      <p align="center"><span class="title"><font size="6" face="Verdana, Arial, Helvetica, sans-serif">&lt; 
        Etape 3/5 &gt;</font></span></p>
      <p align="center">La connexion &agrave; la base de donn&eacute;e</p>
      <p align="center"> 
        <?php $base ?>
      </p>
      <p align="center">est maintenant r&eacute;alis&eacute;e avec vos param&egrave;tres.</p>
      <p align="center">&nbsp;</p>
      <p align="center"> 
        <input name="Submit" type="submit" onClick="MM_goToURL('parent','install_base_tables.php');return document.MM_returnValue" value="Cr&eacute;er la base de donn&eacute;es  et les tables">
      </p>
      <p align="center"> 
        <input name="Submit2" type="submit" onClick="MM_goToURL('parent','install_tables.php');return document.MM_returnValue" value="Ma base est d&eacute;j&agrave; existante - Cr&eacute;er uniquement les tables">
      </p>
      <blockquote> 
        <blockquote> 
          <blockquote> 
            <blockquote>
              <p align="left">Dans le cas d'un h&eacute;bergeur tel que Free, 
                votre (unique) base est d&eacute;j&agrave; existante et porte 
                le nom de votre login. Il vous suffit de cr&eacute;er uniquement 
                les tables.</p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote>
      <p align="center">&nbsp;</p>
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
