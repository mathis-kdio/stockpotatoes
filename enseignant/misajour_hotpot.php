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
  if ((isset($_POST['en_ligne'])) && ($_POST['en_ligne']=='O')){$en_ligne='O';} else {$en_ligne='N';}
  if ((isset($_POST['avec_score'])) && ($_POST['avec_score']=='O')){$avec_score='O';} else {$avec_score='N';}
  if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul']=='O')){$evaluation_seul='O';} else {$evaluation_seul='N';}
  if ((isset($_POST['evaluation_seul'])) && ($_POST['evaluation_seul']=='O')){$avec_score='O';}

  $type_doc = 2;
  $updateSQL = sprintf("UPDATE stock_quiz SET titre=%s, niveau_ID=%s, theme_ID=%s, categorie_ID=%s, auteur=%s, en_ligne=%s, avec_score=%s, evaluation_seul=%s , cat_doc=%s, type_doc=%s WHERE ID_quiz=%s",
                       GetSQLValueString($_POST['titre'], "text"),
					   GetSQLValueString($_POST['select_niveau_ID'], "int"),
					   GetSQLValueString($_POST['ID_theme'], "int"),
					   GetSQLValueString($_POST['ID_categorie'], "int"),
					   GetSQLValueString($_POST['auteur'], "text"),					   
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
                       GetSQLValueString($evaluation_seul, "text"),
                       GetSQLValueString($_POST['cat_doc'], "int"),
					   GetSQLValueString($type_doc, "int"),
					   GetSQLValueString($_POST['Id_quiz'], "int")
					   );
					 

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error());

  $updateGoTo = 'gestion_exos.php?matiere_ID='.$_POST['matiere_ID'].'&niveau_ID='.$_POST['niveau_ID'].'&theme_ID='.$_POST['ID_theme'];
  
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RsChoixQuiz = "0";
if (isset($_GET['ID_quiz'])) {
  $colname_RsChoixQuiz = (get_magic_quotes_gpc()) ? $_GET['ID_quiz'] : addslashes($_GET['ID_quiz']);
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

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsCategorie= sprintf("SELECT * FROM stock_categorie ORDER BY stock_categorie.ID_categorie");
$RsCategorie = mysqli_query($conn_intranet, $query_RsCategorie) or die(mysqli_error());
$row_RsCategorie = mysqli_fetch_assoc($RsCategorie);
$totalRows_RsCategorie = mysqli_num_rows($RsCategorie);

$choixmat_RsMatiere = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsMatiere = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $choixmat_RsMatiere);
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error());
$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysqli_num_rows($RsMatiere);


mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_liste_niveau = "SELECT * FROM stock_niveau ORDER BY stock_niveau.ID_niveau";
$liste_niveau = mysqli_query($conn_intranet, $query_liste_niveau) or die(mysqli_error());
$row_liste_niveau = mysqli_fetch_assoc($liste_niveau);
$totalRows_liste_niveau = mysqli_num_rows($liste_niveau);





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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
<!--
function changer() {
var sel;
 var nom=new Array();
    var valeur=new Array();
    
    // On enl�ve le ?
    param = window.location.search.slice(1,window.location.search.length);

    // On s&pare le param�tres....
    // first[0] est de la forme param=valeur

    first = param.split("&");

    for(i=0;i<first.length;i++){
        second = first[i].split("=");
        nom[i] = second[0];
        valeur[i] = second[1];
    }


sel=document.form4.select_niveau_ID.selectedIndex +1;

page='http://localhost/stockpotatoes/enseignant/misajour_divers.php?matiere_ID='+valeur[0]+'&niveau_ID='+sel+'&ID_quiz='+valeur[2]+'&theme_ID=' + valeur[3];

window.location = page;

}
//-->
</script>
</head>
<body>
<p><img src="../patate.jpg" width="324" height="39" align="top"> </p>
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="accueil_enseignant.php">Espace 
  Enseignant</a></strong> - <strong>Mise &agrave; jour d'une fiche exercice</strong></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td width="28%"><img src="../patate.gif" width="253" height="227"></td>
    <td width="72%"> <form name="form4" method="POST" action="<?php echo $editFormAction; ?>">
        <table width="100%" border="1" cellspacing="10" cellpadding="0">
          <tr>
            <td><div align="right">
                <p><strong>N&deg; <?php echo $row_RsChoixQuiz['ID_quiz']; ?></strong> </p>
            </div></td>
            <td class="retrait20"><strong><?php echo $row_RsMatiere['nom_mat']; ?> </strong></td>
          </tr>
          <tr>
            <td><div align="right"><strong> Niveau</strong></div></td>
            <td class="retrait20"><strong>
              <select name="select_niveau_ID" id="select" onChange="changer()">
                <?php
					do {  
					?>
					                <option value="<?php echo $row_liste_niveau['ID_niveau']?>"<?php if (!(strcmp($row_liste_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} ?>><?php echo $row_liste_niveau['nom_niveau']?></option>
					                <?php
					} while ($row_liste_niveau = mysqli_fetch_assoc($liste_niveau));
					  $rows = mysqli_num_rows($liste_niveau);
					  if($rows > 0) {
					      mysqli_data_seek($liste_niveau, 0);
						  $row_liste_niveau = mysqli_fetch_assoc($liste_niveau);
					  }
					?>
              </select>
            </strong></td>
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
					<option value="0" <?php if (!(strcmp($row_RsTheme['ID_theme'], $_GET['theme_ID']))) {echo "SELECTED";} ?>>Aucun th�me (Divers)</option>
	                <?php     
					do { ?>
	                	<option value="<?php echo $row_RsTheme['ID_theme']?>"<?php if (!(strcmp($row_RsTheme['ID_theme'], $_GET['theme_ID']))) {echo "SELECTED";} ?>><?php echo $row_RsTheme['theme']?></option>
	                	<?php
					} while ($row_RsTheme = mysqli_fetch_assoc($RsTheme));
					$rows = mysqli_num_rows($RsTheme);
					if($rows > 0)
					{
					    mysqli_data_seek($RsTheme, 0);
						$row_RsTheme = mysqli_fetch_assoc($RsTheme);
					}?>
              </select>
          	</td>
          </tr>
          <<tr> 
            <td><div align="right"><strong>Cat&eacute;gorie</strong></div></td>
            <td class="retrait20"> 
        		<select name="ID_categorie" id="ID_categorie"> 
                  	<?php 
					do { ?>
	                	<option value="<?php echo $row_RsCategorie['ID_categorie']?>"<?php if (!(strcmp($row_RsCategorie['ID_categorie'], $_POST['categorie_ID']))) {echo "SELECTED";} ?>><?php echo $row_RsCategorie['nom_categorie']?></option>	                	
	                	<?php
					} while ($row_RsCategorie = mysqli_fetch_assoc($RsCategorie));
			        $rows = mysqli_num_rows($RsCategorie);
			        if($rows > 0)
			        {
			            mysqli_data_seek($RsCategorie, 0);
			            $row_RsCategorie = mysqli_fetch_assoc($RsCategorie);
			        }?>
                </select>
            </td>
          </tr>
		  <tr>
            <td><div align="right"><strong>A classer dans</strong></div></td>
            <td class="retrait20"><table width="459">
              <tr>
                <td><label>
                  <input <?php if (!(strcmp($row_RsChoixQuiz['cat_doc'],"1"))) {echo "CHECKED";} ?> name="cat_doc" type="radio" value="1" checked>
      Cours</label></td>
	  <td><label>
                  <input <?php if (!(strcmp($row_RsChoixQuiz['cat_doc'],"2"))) {echo "CHECKED";} ?> type="radio" name="cat_doc" value="2">
      Ex. Hotpotatoes</label></td>
                <td><label>
                  <input <?php if (!(strcmp($row_RsChoixQuiz['cat_doc'],"3"))) {echo "CHECKED";} ?> type="radio" name="cat_doc" value="3">
      Autres Ex./TP</label></td>
                <td><label>
                  <input <?php if (!(strcmp($row_RsChoixQuiz['cat_doc'],"4"))) {echo "CHECKED";} ?> type="radio" name="cat_doc" value="4">
      Travail &agrave; faire</label></td>
                <td><label>
                  <input <?php if (!(strcmp($row_RsChoixQuiz['cat_doc'],"5"))) {echo "CHECKED";} ?> type="radio" name="cat_doc" value="5">
      Annexes</label></td>
              </tr>
            </table></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Nom du fichier</strong></div></td>
            <td class="retrait20"><?php echo $row_RsChoixQuiz['fichier']; ?></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Auteur</strong></div></td>
            <td class="retrait20"> <input name="auteur" type="text" id="auteur" value="<?php echo $row_RsChoixQuiz['auteur']; ?>"></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mode Entrainement</strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['en_ligne'],"O"))) {echo "checked";} ?> name="en_ligne" type="checkbox" id="en_ligne" value="O">
              Si coch&eacute;, l'exercice sera accessible sans identification 
              de l'&eacute;l&egrave;ve. 
              Score non enregistr&eacute;</td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mode Evaluation </strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['avec_score'],"O"))) {echo "checked";} ?> name="avec_score" type="checkbox" id="avec_score" value="O">
              Si coch&eacute;, l'exercice sera accessible si l'&eacute;l&egrave;ve 
              s'identifie.  
              Le score sera enregistr&eacute; (note sur 20)</td>
          </tr>
<tr> 
            <td><div align="right"><strong>Un seul essai</strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['evaluation_seul'],"O"))) {echo "checked";} ?> name="evaluation_seul" type="checkbox" id="evaluation_seul" value="O">
              Si coch&eacute;, l'&eacute;l&egrave;ve ne pourra faire qu'un seul 
              essai en mode &eacute;valuation. (Interro)</td>
          </tr>
        </table>
        <blockquote> 
          <p align="center"> 
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

