<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php 
require_once('../Connections/conn_intranet.php'); 


$maxRows_rsListeSelectMatiereNiveau = 10;
$pageNum_rsListeSelectMatiereNiveau = 0;
if (isset($_GET['pageNum_rsListeSelectMatiereNiveau'])) {
  $pageNum_rsListeSelectMatiereNiveau = $_GET['pageNum_rsListeSelectMatiereNiveau'];
}
$startRow_rsListeSelectMatiereNiveau = $pageNum_rsListeSelectMatiereNiveau * $maxRows_rsListeSelectMatiereNiveau;

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsListeSelectMatiereNiveau = "SELECT * FROM stock_quiz,stock_matiere,stock_niveau WHERE stock_quiz.matiere_ID=stock_matiere.ID_mat  AND stock_quiz.niveau_ID=stock_niveau.ID_niveau ORDER BY stock_quiz.ID_quiz  DESC";
$query_limit_rsListeSelectMatiereNiveau = sprintf("%s LIMIT %d, %d", $query_rsListeSelectMatiereNiveau, $startRow_rsListeSelectMatiereNiveau, $maxRows_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_limit_rsListeSelectMatiereNiveau) or die(mysqli_error());
$row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau);

if (isset($_GET['totalRows_rsListeSelectMatiereNiveau'])) {
  $totalRows_rsListeSelectMatiereNiveau = $_GET['totalRows_rsListeSelectMatiereNiveau'];
} else {
  $all_rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau);
  $totalRows_rsListeSelectMatiereNiveau = mysqli_num_rows($all_rsListeSelectMatiereNiveau);
}
$totalPages_rsListeSelectMatiereNiveau = ceil($totalRows_rsListeSelectMatiereNiveau/$maxRows_rsListeSelectMatiereNiveau)-1;


function sans_accent($chaine) 
{ 
   $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
   return strtr(trim($chaine),$accent,$noaccent); 
} 
?>
<html>
<head>
<title>Exercices r&eacute;cemment publi&eacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">

</head>

<body>
<p><a href="../index.php"><img src="../patate.gif" width="51" height="42" border="0"></a> 
  <img src="../patate.jpg" width="324" height="39" align="top"></p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php">Espace Enseignant</a> - Exercices 
    r&eacute;cemment publi&eacute;s en ligne</strong></p>
<table border="1">
  <tr bgcolor="#CCCC99"> 
    <td> <div align="center"><strong>N&deg; Ex.</strong></div></td>
    <td> <div align="center"><strong>Titre de l'exercice</strong></div></td>
    <td> <div align="center"><strong>Fichier</strong></div></td>
    <td> <div align="center"><strong>Mati&egrave;re</strong></div></td>
    <td> <div align="center"><strong>Niveau</strong></div></td>
    <td> <div align="center"><strong>Auteur</strong></div></td>
    <td> <div align="center"><strong>En entra&icirc;nement</strong></div></td>
    <td> <div align="center"><strong>En &eacute;valuation</strong></div></td>
  </tr>
  <?php do 
  { 
  $matiere=sans_accent($row_rsListeSelectMatiereNiveau['nom_mat']);
  ?>
  <tr class="retrait20"> 
    <td><div align="right"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
    <td class="retrait20"><a href="<?php echo '../Exercices/'.$matiere.'/q'.$row_rsListeSelectMatiereNiveau['ID_quiz']; ?>/<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></td>
    <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?></td>
    <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['nom_mat']; ?></td>
    <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['nom_niveau']; ?></td>
    <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?></td>
    <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></div></td>
    <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
  </tr>
  <?php } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
</html>
<?php
mysqli_free_result($rsListeSelectMatiereNiveau);
?>

</body>



