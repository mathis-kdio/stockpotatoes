l<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
$varquiz_RsActiviteClasse = "0";
if (isset($_POST['ID_quiz'])) {
  $varquiz_RsActiviteClasse = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
$varchoixclasse_RsActiviteClasse = "0";
if (isset($_POST['classe'])) {
  $varchoixclasse_RsActiviteClasse = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsActiviteClasse = sprintf("SELECT * FROM stock_activite, stock_eleve WHERE stock_activite.quiz_ID=%s AND stock_activite.nom_classe='%s'  AND stock_activite.eleve_ID=stock_eleve.ID_eleve ORDER BY stock_eleve.nom, stock_eleve.prenom ", $varquiz_RsActiviteClasse,$varchoixclasse_RsActiviteClasse);
$RsActiviteClasse = mysqli_query($conn_intranet, $query_RsActiviteClasse) or die(mysqli_error($conn_intranet));
$row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse);
$totalRows_RsActiviteClasse = mysqli_num_rows($RsActiviteClasse);



 if (isset($_POST['ID_quiz'])) { 


  $fichier_log = '../Exercices/resultats.csv';
  chmod($fichier_log,0777);
  unlink($fichier_log);
  $fp = fopen($fichier_log,"a");
  $chaine=('Nom;Prenom;Note sur 20;Date'."\n");

fputs($fp, $chaine);
  do { 
  $chaine_valeur = $row_RsActiviteClasse['nom'].';'.$row_RsActiviteClasse['prenom'].';'.$row_RsActiviteClasse['score'].';'.$row_RsActiviteClasse['debut']."\n"; 
  
  fputs($fp, $chaine_valeur);
  } while ($row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse)); 
  
 fclose($fp);
?>
<html>
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
  
<title>Exportation des r&eacute;sultats</title><body>
<p>&nbsp;</p>
<p align="center"><strong><img src="../patate.jpg" width="324" height="39"></strong></p>
<p align="center">&nbsp;</p>
<p align="center"><strong>Un fichier d'extension &quot;CSV&quot; compatiple Excel 
  et Open Office a &eacute;t&eacute; g&eacute;n&eacute;r&eacute;.</strong></p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center"><a href="../Exercices/resultats.csv"><strong>Voir ou télécharger le fichier résultats.csv</strong></a></p>
<p align="center">&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p align="right">&nbsp;</p>
<?php }
mysqli_free_result($RsActiviteClasse);
?>
</body>
</html>  