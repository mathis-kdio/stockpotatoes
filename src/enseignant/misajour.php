<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form4")) {
if ($_POST['en_ligne']=='O'){$en_ligne='O';} else {$en_ligne='N';}
if ($_POST['avec_score']=='O'){$avec_score='O';} else {$avec_score='N';}
if ($_POST['evaluation_seul']=='O'){$evaluation_seul='O';} else {$evaluation_seul='N';}
if ($_POST['evaluation_seul']=='O'){$avec_score='O';}
  $updateSQL = sprintf("UPDATE stock_quiz SET titre=%s, theme_ID=%s ,auteur=%s, en_ligne=%s, avec_score=%s, evaluation_seul=%s  WHERE ID_quiz=%s",
                       GetSQLValueString($_POST['titre'], "text"),
					   GetSQLValueString($_POST['ID_theme'], "int"),
					   GetSQLValueString($_POST['auteur'], "text"),					   
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
                       GetSQLValueString($evaluation_seul, "text"),
                       GetSQLValueString($_POST['Id_quiz'], "int"));

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());

  $updateGoTo = 'gestion_exos.php?matiere_ID='.$_POST['matiere_ID'].'&niveau_ID='.$_POST['niveau_ID'].'&theme_ID='.$_POST['ID_theme'];
  
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RsChoixQuiz = "0";
if (isset($_POST['ID_quiz'])) {
  $colname_RsChoixQuiz = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixQuiz = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = %s", $colname_RsChoixQuiz);
$RsChoixQuiz = mysqli_query($conn_intranet, $query_RsChoixQuiz) or die(mysqli_error());
$row_RsChoixQuiz = mysqli_fetch_assoc($RsChoixQuiz);
$totalRows_RsChoixQuiz = mysqli_num_rows($RsChoixQuiz);

$choix_mat = "0";
if (isset($_GET['matiere_ID'])) {
  $choix_mat = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
$choix_niv = "0";
if (isset($_GET['niveau_ID'])) {
  $choix_niv = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.theme", $choix_mat,$choix_niv);
$RsTheme = mysqli_query($conn_intranet, $query_RsTheme) or die(mysqli_error());
$row_RsTheme = mysqli_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysqli_num_rows($RsTheme);

$choixmat_RsMatiere = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsMatiere = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $choixmat_RsMatiere);
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error());
$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysqli_num_rows($RsMatiere);

$choix_niv_RsNiveau = "0";
if (isset($_GET['niveau_ID'])) {
  $choix_niv_RsNiveau = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsNiveau = sprintf("SELECT * FROM stock_niveau WHERE stock_niveau.ID_niveau=%s", $choix_niv_RsNiveau);
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error());
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysqli_num_rows($RsNiveau);
?>
<html>
<head>
<title>Mise &agrave; jour d'une fiche exercice</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php">Espace 
  Enseignant</a></strong> - <strong>Mise &agrave; jour d'une fiche exercice</strong></p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="top"> 
    <td width="35%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="60%"> <form name="form4" method="POST" action="<?php echo $editFormAction; ?>">
        <table width="100%" border="1" cellspacing="10" cellpadding="0">
          <tr> 
            <td><div align="right"><strong>N&deg; Exercice</strong></div></td>
            <td class="retrait20"><?php echo $row_RsChoixQuiz['ID_quiz']; ?></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Titre</strong></div></td>
            <td class="retrait20"> <input name="titre" type="text" id="titre" value="<?php echo $row_RsChoixQuiz['titre']; ?>" size="50"> 
            </td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Th&egrave;me d'&eacute;tude</strong></div></td>
            <td class="retrait20"> 
				<select name="ID_theme" id="ID_theme"> 
				<option value="0" <?php if (!(strcmp($row_RsTheme['ID_theme'], $_POST['theme_ID']))) {echo "SELECTED";} ?>>Aucun thème (Divers)</option>
                <?php     
				do { ?>
                	<option value="<?php echo $row_RsTheme['ID_theme']?>"<?php if (!(strcmp($row_RsTheme['ID_theme'], $_POST['theme_ID']))) {echo "SELECTED";} ?>><?php echo $row_RsTheme['theme']?></option>
                	<?php
				} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme));
  $rows = mysqli_num_rows($RsTheme);
  if($rows > 0) {
      mysqli_data_seek($RsTheme, 0);
	  $row_RsTheme = mysqli_fetch_assoc($RsTheme);
  }
?>
              </select></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Nom du fichier</strong></div></td>
            <td class="retrait20"><?php echo $row_RsChoixQuiz['fichier']; ?></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mati&egrave;re</strong></div></td>
            <td class="retrait20"><?php echo $row_RsMatiere['nom_mat']; ?></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Niveau</strong></div></td>
            <td class="retrait20"> <?php echo $row_RsNiveau['nom_niveau']?></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Auteur</strong></div></td>
            <td class="retrait20"> <input name="auteur" type="text" id="auteur" value="<?php echo $row_RsChoixQuiz['auteur']; ?>"></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mode Entrainement</strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['en_ligne'],"O"))) {echo "checked";} ?> name="en_ligne" type="checkbox" id="en_ligne" value="O">
              Si coch&eacute;, l'exercice sera accessible sans identification 
              de l'&eacute;l&egrave;ve. Le score ne sera pas enregistr&eacute;</td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mode Evaluation </strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['avec_score'],"O"))) {echo "checked";} ?> name="avec_score" type="checkbox" id="avec_score" value="O">
              Si coch&eacute;, l'exercice sera accessible si l'&eacute;l&egrave;ve 
              s'identifie. Le score sera enregistr&eacute; (note sur 20)</td>
          </tr>
<tr> 
            <td><div align="right"><strong>Un seul essai</strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['evaluation_seul'],"O"))) {echo "checked";} ?> name="evaluation_seul" type="checkbox" id="evaluation_seul" value="O">
              Si coch&eacute;, l'&eacute;l&egrave;ve ne pourra faire qu'un seul 
              essai en mode &eacute;valuation. (Interro)</td>
          </tr>
        </table>
        <blockquote> 
          <p align="right"> 
            <input name="Id_quiz" type="hidden" id="Id_quiz" value="<?php echo $row_RsChoixQuiz['ID_quiz']; ?>">
            <input type="submit" name="Submit" value="Enregistrer les modifications">
          </p>
        </blockquote>
        <input type="hidden" name="MM_update" value="form4">
        <input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $row_RsChoixQuiz['matiere_ID']; ?>">
        <input name="niveau_ID" type="hidden" id="niveau_ID" value="<?php echo $row_RsChoixQuiz['niveau_ID']; ?>">
      </form></td>
  </tr>
</table>
<p align="center"><a href="gestion_exos.php">Retour Gestion des exercices</a></p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
</body>
</html>
<?php
mysqli_free_result($RsChoixQuiz);

mysqli_free_result($RsTheme);

mysqli_free_result($RsMatiere);

mysqli_free_result($RsNiveau);
?>

