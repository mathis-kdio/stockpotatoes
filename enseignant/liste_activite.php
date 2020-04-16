<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>

<?php require_once('../Connections/conn_intranet.php'); ?> 
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_RsActivite = 40;
$pageNum_RsActivite = 0;
if (isset($_GET['pageNum_RsActivite'])) {
  $pageNum_RsActivite = $_GET['pageNum_RsActivite'];
}
$startRow_RsActivite = $pageNum_RsActivite * $maxRows_RsActivite;
$maxRows_RsActivite = 40;;
$pageNum_RsActivite = 0;
if (isset($_GET['pageNum_RsActivite'])) {
  $pageNum_RsActivite = $_GET['pageNum_RsActivite'];
}
$startRow_RsActivite = $pageNum_RsActivite * $maxRows_RsActivite;

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsActivite = "SELECT * FROM stock_activite, stock_eleve, stock_quiz WHERE stock_activite.eleve_ID=stock_eleve.ID_eleve AND stock_activite.quiz_ID= stock_quiz.ID_quiz  ORDER BY ID_activite DESC";
$query_limit_RsActivite = sprintf("%s LIMIT %d, %d", $query_RsActivite, $startRow_RsActivite, $maxRows_RsActivite);
$RsActivite = mysqli_query($conn_intranet, $query_limit_RsActivite) or die(mysqli_error());
$row_RsActivite = mysqli_fetch_assoc($RsActivite);

if (isset($_GET['totalRows_RsActivite'])) {
  $totalRows_RsActivite = $_GET['totalRows_RsActivite'];
} else {
  $all_RsActivite = mysqli_query($conn_intranet, $query_RsActivite);
  $totalRows_RsActivite = mysqli_num_rows($all_RsActivite);
}
$totalPages_RsActivite = ceil($totalRows_RsActivite/$maxRows_RsActivite)-1;

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rs_matiere = "SELECT * FROM stock_matiere";
$Rs_matiere = mysqli_query($conn_intranet, $query_Rs_matiere) or die(mysqli_error());
$row_Rs_matiere = mysqli_fetch_assoc($Rs_matiere);
$totalRows_Rs_matiere = mysqli_num_rows($Rs_matiere);


do { 
   $libel_mat[$row_Rs_matiere['ID_mat']]=$row_Rs_matiere['nom_mat'];
   } while ($row_Rs_matiere = mysqli_fetch_assoc($Rs_matiere)); 

   
   mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rs_niveau = "SELECT * FROM stock_niveau";
$Rs_niveau = mysqli_query($conn_intranet, $query_Rs_niveau) or die(mysqli_error());
$row_Rs_niveau = mysqli_fetch_assoc($Rs_niveau);
$totalRows_Rs_niveau = mysqli_num_rows($Rs_niveau);


do { 
   $libel_niveau[$row_Rs_niveau['ID_niveau']]=$row_Rs_niveau['nom_niveau'];
   } while ($row_Rs_niveau = mysqli_fetch_assoc($Rs_niveau));
   
   
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rs_theme = "SELECT * FROM stock_theme";
$Rs_theme = mysqli_query($conn_intranet, $query_Rs_theme) or die(mysqli_error());
$row_Rs_theme = mysqli_fetch_assoc($Rs_theme);
$totalRows_Rs_theme = mysqli_num_rows($Rs_theme);

do { 
   $libel_theme[$row_Rs_theme['ID_theme']]=$row_Rs_theme['theme'];
   } while ($row_Rs_theme = mysqli_fetch_assoc($Rs_theme)); 

$queryString_RsActivite = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsActivite") == false && 
        stristr($param, "totalRows_RsActivite") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsActivite = "&" . implode("&", $newParams);
  }
}
$queryString_RsActivite = sprintf("&totalRows_RsActivite=%d%s", $totalRows_RsActivite, $queryString_RsActivite);
?>

<html>
<head>
<title>Liste des dern&egrave;res activit&eacute;s</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body> 
<p align="center"><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php"> Espace Enseignant</a> - Liste des derni&egrave;res activit&eacute;s enregistr&eacute;es</strong></p>
<p> 
<table border="0" width="50%" align="center">
  <tr> 
    <td width="23%" align="center"> <?php if ($pageNum_RsActivite > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, 0, $queryString_RsActivite); ?>"><img src="First.gif" border=0></a> 
      <?php } // Show if not first page ?> </td>
    <td width="31%" align="center"> <?php if ($pageNum_RsActivite > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, max(0, $pageNum_RsActivite - 1), $queryString_RsActivite); ?>"><img src="Previous.gif" border=0></a> 
      <?php } // Show if not first page ?> </td>
    <td width="23%" align="center"> <?php if ($pageNum_RsActivite < $totalPages_RsActivite) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, min($totalPages_RsActivite, $pageNum_RsActivite + 1), $queryString_RsActivite); ?>"><img src="Next.gif" border=0></a> 
      <?php } // Show if not last page ?> </td>
    <td width="23%" align="center"> <?php if ($pageNum_RsActivite < $totalPages_RsActivite) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, $totalPages_RsActivite, $queryString_RsActivite); ?>"><img src="Last.gif" border=0></a> 
      <?php } // Show if not last page ?> </td>
  </tr>
</table></p>
<table border="1" cellspacing="0" cellpadding="0">
  <tr bgcolor="#CCCC99"> 
    <td> <div align="center"><strong>N&deg; Eleve</strong></div></td>
    <td> <div align="center"><strong>El&egrave;ve</strong></div></td>
    <td> <div align="center"><strong>Classe</strong></div></td>
    <td> <div align="center"><strong>Mati&egrave;re</strong></div></td>
    <td> <div align="center"><strong>Niveau</strong></div></td>
    <td> <div align="center"><strong>Th&ecirc;me d'&eacute;tude</strong></div></td>
    <td> <div align="center"><strong>Titre</strong></div></td>
    <td> <div align="center"><strong>Note /20</strong></div></td>
    <td> <div align="center"><strong>Date d&eacute;but</strong></div></td>
  </tr>
  <?php do { ?>
  <tr> 
    <td class="retrait20"><div align="right"><?php echo $row_RsActivite['eleve_ID']; ?></div></td>
    <td class="retrait20"><?php echo $row_RsActivite['nom']; ?> <?php echo $row_RsActivite['prenom']; ?></td>
    <td class="retrait20"><?php echo $row_RsActivite['classe']; ?></td>
    <td class="retrait20"><?php echo $libel_mat[$row_RsActivite['matiere_ID']];?></td>
	<td class="retrait20"><?php echo $libel_niveau[$row_RsActivite['niveau_ID']];?></td>
    <td class="retrait20"><div align="left"><?php 
		if ($row_RsActivite['theme_ID'] <>0)
		{ echo $libel_theme[$row_RsActivite['theme_ID']];} else { echo '<div align="center">'.'Divers'.'<div>'; }; ?>	
		</div>
	</td>
    <td class="retrait20"><?php echo $row_RsActivite['titre']; ?></td>
    <td class="retrait20"> <div align="right"><?php echo $row_RsActivite['score']; ?></div></td>
    <td class="retrait20"><?php echo $row_RsActivite['debut']; ?></td>
  </tr>
  <?php } while ($row_RsActivite = mysqli_fetch_assoc($RsActivite)); ?>
</table>
<p> 
<table border="0" width="50%" align="center">
  <tr> 
    <td width="23%" align="center"> <?php if ($pageNum_RsActivite > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, 0, $queryString_RsActivite); ?>"><img src="First.gif" border=0></a> 
      <?php } // Show if not first page ?> </td>
    <td width="31%" align="center"> <?php if ($pageNum_RsActivite > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, max(0, $pageNum_RsActivite - 1), $queryString_RsActivite); ?>"><img src="Previous.gif" border=0></a> 
      <?php } // Show if not first page ?> </td>
    <td width="23%" align="center"> <?php if ($pageNum_RsActivite < $totalPages_RsActivite) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, min($totalPages_RsActivite, $pageNum_RsActivite + 1), $queryString_RsActivite); ?>"><img src="Next.gif" border=0></a> 
      <?php } // Show if not last page ?> </td>
    <td width="23%" align="center"> <?php if ($pageNum_RsActivite < $totalPages_RsActivite) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, $totalPages_RsActivite, $queryString_RsActivite); ?>"><img src="Last.gif" border=0></a> 
      <?php } // Show if not last page ?> </td>
  </tr>
</table></p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p align="right">&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($RsActivite);

mysqli_free_result($Rs_matiere);

mysqli_free_result($Rs_niveau);

mysqli_free_result($Rs_theme);
?>

