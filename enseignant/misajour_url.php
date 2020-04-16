<?php session_start(); 
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

  $type_doc=1;
  $updateSQL = sprintf("UPDATE stock_quiz SET titre=%s, niveau_ID=%s, fichier=%s, theme_ID=%s ,auteur=%s, en_ligne=%s, avec_score=%s, evaluation_seul=%s, cat_doc=%s, type_doc=%s  WHERE ID_quiz=%s",
                       GetSQLValueString($_POST['titre'], "text"),
					   GetSQLValueString($_POST['select_niveau_ID'], "int"),
					   GetSQLValueString($_POST['fichier'], "text"),
					   GetSQLValueString($_POST['ID_theme'], "int"),
					   GetSQLValueString($_POST['auteur'], "text"),					   
                       GetSQLValueString($en_ligne, "text"),
                       GetSQLValueString($avec_score, "text"),
                       GetSQLValueString($evaluation_seul, "text"),
                       GetSQLValueString($_POST['cat_doc'], "int"),
					   GetSQLValueString($type_doc, "int"),
					   GetSQLValueString($_POST['Id_quiz'], "int")
					   );

  mysql_select_db($database_conn_intranet, $conn_intranet);
  $Result1 = mysql_query($updateSQL, $conn_intranet) or die(mysql_error());

  $updateGoTo = 'gestion_exos.php?matiere_ID='.$_POST['matiere_ID'].'&niveau_ID='.$_POST['niveau_ID'].'&theme_ID='.$_POST['ID_theme'];
  
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RsChoixQuiz = "0";
if (isset($_GET['ID_quiz'])) {
  $colname_RsChoixQuiz = (get_magic_quotes_gpc()) ? $_GET['ID_quiz'] : addslashes($_GET['ID_quiz']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixQuiz = sprintf("SELECT * FROM stock_quiz WHERE ID_quiz = %s", $colname_RsChoixQuiz);
$RsChoixQuiz = mysql_query($query_RsChoixQuiz, $conn_intranet) or die(mysql_error());
$row_RsChoixQuiz = mysql_fetch_assoc($RsChoixQuiz);
$totalRows_RsChoixQuiz = mysql_num_rows($RsChoixQuiz);

$choix_mat = "0";
if (isset($_GET['matiere_ID'])) {
  $choix_mat = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
$choix_niv = "0";
if (isset($_GET['niveau_ID'])) {
  $choix_niv = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.theme", $choix_mat,$choix_niv);
$RsTheme = mysql_query($query_RsTheme, $conn_intranet) or die(mysql_error());
$row_RsTheme = mysql_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysql_num_rows($RsTheme);

$choixmat_RsMatiere = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsMatiere = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsMatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $choixmat_RsMatiere);
$RsMatiere = mysql_query($query_RsMatiere, $conn_intranet) or die(mysql_error());
$row_RsMatiere = mysql_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysql_num_rows($RsMatiere);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_liste_niveau = "SELECT * FROM stock_niveau ORDER BY stock_niveau.ID_niveau";
$liste_niveau = mysql_query($query_liste_niveau, $conn_intranet) or die(mysql_error());
$row_liste_niveau = mysql_fetch_assoc($liste_niveau);
$totalRows_liste_niveau = mysql_num_rows($liste_niveau);






$choix_niv_RsNiveau = "0";
if (isset($_GET['niveau_ID'])) {
  $choix_niv_RsNiveau = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsNiveau = sprintf("SELECT * FROM stock_niveau WHERE stock_niveau.ID_niveau=%s", $choix_niv_RsNiveau);
$RsNiveau = mysql_query($query_RsNiveau, $conn_intranet) or die(mysql_error());
$row_RsNiveau = mysql_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysql_num_rows($RsNiveau);
?>
<html>
<head>
<title>Mise&agrave;jour d'une fiche lien hypertexte</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
<!--
function changer() {
var sel;
 var nom=new Array();
    var valeur=new Array();
    
    // On enlève le ?
    param = window.location.search.slice(1,window.location.search.length);

    // On s&pare le paramètres....
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
  Enseignant</a></strong> - <strong>Mise &agrave; jour d'une fiche lien hypertexte </strong></p>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr valign="top"> 
    <td width="35%"><img src="../patate.gif" width="171" height="150"></td>
    <td width="60%"> <form name="form4" method="POST" action="<?php echo $editFormAction; ?>">
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
} while ($row_liste_niveau = mysql_fetch_assoc($liste_niveau));
  $rows = mysql_num_rows($liste_niveau);
  if($rows > 0) {
      mysql_data_seek($liste_niveau, 0);
	  $row_liste_niveau = mysql_fetch_assoc($liste_niveau);
  }
?>
              </select>
            </strong></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Titre</strong></div></td>
            <td class="retrait20"> <input name="titre" type="text" id="titre" value="<?php echo $row_RsChoixQuiz['titre']; ?>" size="100"> 
            </td>
          </tr>
          <tr>
            <td><div align="right"><strong>Adresse URL du document </strong></div></td>
            <td class="retrait20"><input name="fichier" type="text" id="fichier" value="<?php echo $row_RsChoixQuiz['fichier']; ?>" size="100"> </td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Ce lien est relatif &agrave; l'&eacute;tude du th&egrave;me</strong></div></td>
            <td class="retrait20"> 
				<select name="ID_theme" id="ID_theme"> 
				<option value="0" <?php if (!(strcmp($row_RsTheme['ID_theme'], $_GET['theme_ID']))) {echo "SELECTED";} ?>>Aucun thème (Divers)</option>
                <?php     
				do { ?>
                	<option value="<?php echo $row_RsTheme['ID_theme']?>"<?php if (!(strcmp($row_RsTheme['ID_theme'], $_GET['theme_ID']))) {echo "SELECTED";} ?>><?php echo $row_RsTheme['theme']?></option>
                	<?php
				} while ($row_RsTheme = mysql_fetch_assoc($RsTheme));
  $rows = mysql_num_rows($RsTheme);
  if($rows > 0) {
      mysql_data_seek($RsTheme, 0);
	  $row_RsTheme = mysql_fetch_assoc($RsTheme);
  }
?>
              </select></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Ce lien est &agrave; classer dans</strong></div></td>
            <td class="retrait20"><table width="459">
              <tr>
                <td><label>
                  <input <?php if (!(strcmp($row_RsChoixQuiz['cat_doc'],"1"))) {echo "CHECKED";} ?> name="cat_doc" type="radio" value="1" checked>
      Cours</label></td>
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
            <td><div align="right"><strong>Auteur</strong></div></td>
            <td class="retrait20"> <input name="auteur" type="text" id="auteur" value="<?php echo $row_RsChoixQuiz['auteur']; ?>"></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mode Entrainement</strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['en_ligne'],"O"))) {echo "checked";} ?> name="en_ligne" type="checkbox" id="en_ligne" value="O">
              <font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>Ce lien peut &ecirc;tre vu sans que l'&eacute;l&egrave;ve soit identifi&eacute;. </em></font></em></font></em></font></td>
          </tr>
          <tr> 
            <td><div align="right"><strong>Mode Evaluation </strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['avec_score'],"O"))) {echo "checked";} ?> name="avec_score" type="checkbox" id="avec_score" value="O">
              <em><font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>Ce lien peut &ecirc;tre vu</em></font></em></font></em></font><font color="#990000"><em><font color="#990000"><em> par l'&eacute;l&egrave;ve en s'identifiant</em></font> . </em></font></em></td>
          </tr>
<tr> 
            <td><div align="right"><strong>Un seul essai</strong></div></td>
            <td> <input <?php if (!(strcmp($row_RsChoixQuiz['evaluation_seul'],"O"))) {echo "checked";} ?> name="evaluation_seul" type="checkbox" id="evaluation_seul" value="O">
              <em><font color="#990000"><em><em>En mode &eacute;valuation, <font color="#990000"><em><font color="#990000"><em><font color="#990000"><em>ce lien ne pourra &ecirc;tre vu</em></font></em></font></em></font> qu'une seule fois</em></em></font></em></td>
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
mysql_free_result($RsChoixQuiz);

mysql_free_result($RsTheme);

mysql_free_result($RsMatiere);

mysql_free_result($RsNiveau);
?>

