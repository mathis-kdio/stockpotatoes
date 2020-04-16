<?php session_start(); 
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

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsActivite = "SELECT * FROM stock_activite, stock_eleve, stock_quiz WHERE stock_activite.eleve_ID=stock_eleve.ID_eleve AND stock_activite.quiz_ID= stock_quiz.ID_quiz  ORDER BY ID_activite DESC";
$query_limit_RsActivite = sprintf("%s LIMIT %d, %d", $query_RsActivite, $startRow_RsActivite, $maxRows_RsActivite);
$RsActivite = mysql_query($query_limit_RsActivite, $conn_intranet) or die(mysql_error());
$row_RsActivite = mysql_fetch_assoc($RsActivite);

if (isset($_GET['totalRows_RsActivite'])) {
  $totalRows_RsActivite = $_GET['totalRows_RsActivite'];
} else {
  $all_RsActivite = mysql_query($query_RsActivite);
  $totalRows_RsActivite = mysql_num_rows($all_RsActivite);
}
$totalPages_RsActivite = ceil($totalRows_RsActivite/$maxRows_RsActivite)-1;

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Rs_matiere = "SELECT * FROM stock_matiere";
$Rs_matiere = mysql_query($query_Rs_matiere, $conn_intranet) or die(mysql_error());
$row_Rs_matiere = mysql_fetch_assoc($Rs_matiere);
$totalRows_Rs_matiere = mysql_num_rows($Rs_matiere);


do { 
   $libel_mat[$row_Rs_matiere['ID_mat']]=$row_Rs_matiere['nom_mat'];
   } while ($row_Rs_matiere = mysql_fetch_assoc($Rs_matiere)); 
   
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Rs_theme = "SELECT * FROM stock_theme";
$Rs_theme = mysql_query($query_Rs_theme, $conn_intranet) or die(mysql_error());
$row_Rs_theme = mysql_fetch_assoc($Rs_theme);
$totalRows_Rs_theme = mysql_num_rows($Rs_theme);

do { 
   $libel_theme[$row_Rs_theme['ID_theme']]=$row_Rs_theme['theme'];
   } while ($row_Rs_theme = mysql_fetch_assoc($Rs_theme)); 

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<a href="../index.php"><img src="../patate.gif" width="51" height="39" border="0"></a> 
<img src="../patate.jpg" width="324" height="39" align="top"> 
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php"> Espace Enseignant</a> - Liste des 
    derni&egrave;res activit&eacute;s enregistr&eacute;es</strong></p>
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
    <td> <div align="center"><strong> N&deg; Eleve</strong></div></td>
    <td> <div align="center"><strong>El&egrave;ve</strong></div></td>
    <td> <div align="center"><strong>Classe</strong></div></td>
    <td><div align="center"><strong>Mati&egrave;re</strong></div></td>
    <td> <div align="center"><strong> Th&ecirc;me d'&eacute;tude</strong></div></td>
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
    <td class="retrait20"><div align="left"><?php 

	 if ($row_RsActivite['theme_ID'] <>0)
	{ echo $libel_theme[$row_RsActivite['theme_ID']];} else { echo '<div align="center">'.'Divers'.'<div>'; }; ?>

	
	</div></td>
    <td class="retrait20"><?php echo $row_RsActivite['titre']; ?></td>
    <td class="retrait20"> <div align="right"><?php echo $row_RsActivite['score']; ?></div></td>
    <td class="retrait20"><?php echo $row_RsActivite['debut']; ?></td>
  </tr>
  <?php } while ($row_RsActivite = mysql_fetch_assoc($RsActivite)); ?>
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
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document 
  sur le serveur</a></p>
<p align="right">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($RsActivite);

mysql_free_result($Rs_matiere);

mysql_free_result($Rs_theme);
?>

