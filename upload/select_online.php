<?php session_start();
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']=='Enseignant') { $_SESSION['Sess_nom']='Upload';}
	if ($_SESSION['Sess_nom']<>'Upload') { header("Location: login_upload.php");}
; } else { header("Location: ../index.php");}?>
<?php 

require_once('../Connections/conn_intranet.php'); 

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysql_query($query_rs_matiere, $conn_intranet) or die(mysql_error());
$row_rs_matiere = mysql_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysql_num_rows($rs_matiere);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysql_query($query_rs_niveau, $conn_intranet) or die(mysql_error());
$row_rs_niveau = mysql_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysql_num_rows($rs_niveau);

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsListequiz = "SELECT * FROM stock_quiz WHERE stock_quiz.en_ligne='O' ORDER BY stock_quiz.titre";
$rsListequiz = mysql_query($query_rsListequiz, $conn_intranet) or die(mysql_error());
$row_rsListequiz = mysql_fetch_assoc($rsListequiz);
$totalRows_rsListequiz = mysql_num_rows($rsListequiz);

$choixmat_rsListeSelectMatiereNiveau = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
$choixniv_rsListeSelectMatiereNiveau = "0";
if (isset($_GET['niveau_ID'])) {
  $choixniv_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
$choixtheme_rsListeSelectMatiereNiveau = "0";
if (isset($_GET['theme_ID'])) {
  $choixtheme_rsListeSelectMatiereNiveau = (get_magic_quotes_gpc()) ? $_GET['theme_ID'] : addslashes($_GET['theme_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s  AND stock_quiz.theme_ID=%s AND stock_quiz.en_ligne='O'  ORDER BY stock_quiz.titre", $choixmat_rsListeSelectMatiereNiveau,$choixniv_rsListeSelectMatiereNiveau,$choixtheme_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysql_query($query_rsListeSelectMatiereNiveau, $conn_intranet) or die(mysql_error());
$row_rsListeSelectMatiereNiveau = mysql_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysql_num_rows($rsListeSelectMatiereNiveau);

$colname_rsChoix = "1";
if (isset($_GET['matiere_ID'])) {
  $colname_rsChoix = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat =%s", $colname_rsChoix);
$rsChoix = mysql_query($query_rsChoix, $conn_intranet) or die(mysql_error());
$row_rsChoix = mysql_fetch_assoc($rsChoix);
$totalRows_rsChoix = mysql_num_rows($rsChoix);

$colname_rsChoix2 = "1";
if (isset($_GET['niveau_ID'])) {
  $colname_rsChoix2 = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_rsChoix2);
$rsChoix2 = mysql_query($query_rsChoix2, $conn_intranet) or die(mysql_error());
$row_rsChoix2 = mysql_fetch_assoc($rsChoix2);
$totalRows_rsChoix2 = mysql_num_rows($rsChoix2);

$choixniv_RsListeTheme = "0";
if (isset($_GET['niveau_ID'])) {
  $choixniv_RsListeTheme = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
$choixmat_RsListeTheme = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsListeTheme = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsListeTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.theme", $choixmat_RsListeTheme,$choixniv_RsListeTheme);
$RsListeTheme = mysql_query($query_RsListeTheme, $conn_intranet) or die(mysql_error());
$row_RsListeTheme = mysql_fetch_assoc($RsListeTheme);
$totalRows_RsListeTheme = mysql_num_rows($RsListeTheme);

$selectheme_RsChoixTheme = "0";
if (isset($_GET['theme_ID'])) {
  $selectheme_RsChoixTheme = (get_magic_quotes_gpc()) ? $_GET['theme_ID'] : addslashes($_GET['theme_ID']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsChoixTheme = sprintf("SELECT stock_theme.theme FROM stock_theme WHERE stock_theme.ID_theme=%s", $selectheme_RsChoixTheme);
$RsChoixTheme = mysql_query($query_RsChoixTheme, $conn_intranet) or die(mysql_error());
$row_RsChoixTheme = mysql_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysql_num_rows($RsChoixTheme);
?>

<html>
<head>
<title>S&eacute;lection d'un exercice &agrave; modifier en ligne</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<a href="../index.php"><img src="../patate.gif" width="58" height="42" border="0"></a> 
<img src="../patate.jpg" width="324" height="39"> 
<p><strong><a href="../index.php">Accueil Stockpotatoes</a> - </strong><strong><a href="upload_menu.php"> Envoi de documents</a></strong><strong> - S&eacute;lection d'un exercice &agrave; modifier en ligne </strong></p>
<hr>
<form name="form1" method="GET" action="select_online.php">
  <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_GET['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_GET['matiere_ID']))) {echo "SELECTED";} } 
 ?>><?php echo $row_rs_matiere['nom_mat']?></option>
            <?php
} while ($row_rs_matiere = mysql_fetch_assoc($rs_matiere));
  $rows = mysql_num_rows($rs_matiere);
  if($rows > 0) {
      mysql_data_seek($rs_matiere, 0);
	  $row_rs_matiere = mysql_fetch_assoc($rs_matiere);
  }
?>
          </select>
        </div></td>
      <td width="21%"><div align="center"> 
          <select name="niveau_ID" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_GET['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
            <?php
} while ($row_rs_niveau = mysql_fetch_assoc($rs_niveau));
  $rows = mysql_num_rows($rs_niveau);
  if($rows > 0) {
      mysql_data_seek($rs_niveau, 0);
	  $row_rs_niveau = mysql_fetch_assoc($rs_niveau);
  }
?>
          </select>
        </div></td>
      <td width="44%"> <input type="submit" name="Submit" value="Valider"></td>
      <td width="44%"><div align="center"><font size="6"><strong> 
          <?php 
	  if (isset($_GET['matiere_ID'])) { 
	  echo $row_rsChoix['nom_mat']; }
	  ?>
          </strong></font></div></td>
    </tr>
  </table>
</form>
<?php if (isset($_GET['matiere_ID'])) { ?>
<table width="100%" border="0" cellspacing="50" cellpadding="0">
  <tr valign="top"> 
    <td height="150"> 
      <table border="1">
        <tr> 
          <td bgcolor="#CCCC99"><div align="center"><strong>Th&egrave;me d'&eacute;tude</strong></div></td>
        </tr>
        <?php do { ?>
        <tr> 
          <td class="retrait20"><strong><a href="select_online.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=<?php echo $row_RsListeTheme['ID_theme']?>"><?php echo $row_RsListeTheme['theme']?></a></strong></td>
        </tr>
        <?php } while ($row_RsListeTheme = mysql_fetch_assoc($RsListeTheme)); ?>
        <tr> 
          <td class="retrait20"><strong><a href="select_online.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=0">Divers</a></strong></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
    <td> <table border="1" align="center" >
        <tr class="retrait20" > 
          <td colspan="11" bgcolor="#CCCC99"><div align="left" class="retrait20"> 
              <p><strong> <font size="4"> 
                <?php 			
			    if (isset($_GET['theme_ID'])) {
				echo $row_RsChoixTheme['theme']; }
				else {echo 'Divers';};
				?>
                </font></strong></p>
            </div></td>
        </tr>
        <tr class="retrait20"> 
          <td bgcolor="#CCCC99"> <div align="center"><strong>N&deg;</strong></div></td>
          <td bgcolor="#CCCC99">&nbsp;</td>
          <td width="235" bgcolor="#CCCC99"> <div align="center"><strong>Titre 
              de l'exercice</strong></div></td>
          <td width="223" bgcolor="#CCCC99"><div align="center"><strong>Fichier</strong></div></td>
          <td width="223" bgcolor="#CCCC99"><div align="center"><strong>Auteur</strong></div></td>
          
        </tr>
        <?php do { ?>
        <tr> 
          <td><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
          <td>		  
		  <form name="form2" style="margin:0px" method="post" action="modifier_online.php">
              <div align="center">
                <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
                <input name="matiere_ID" type="hidden" id="matiere_ID" value="<?php echo $row_rsChoix['ID_mat']; ?>">
                <input name="Submit3" type="submit" value="Editer">
              </div>
		  </form></td>
          <td class="retrait20"><a href="../choix_quiz.php?VAR_fichier=<?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?>&VAR_ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?>&VAR_nom_mat=<?php echo $row_rsChoix['nom_mat']; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></td>
          <td class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['fichier']; ?></td>
          <td class="retrait20">&nbsp;<?php echo $row_rsListeSelectMatiereNiveau['auteur']; ?></td>
          
        </tr>
        <?php } while ($row_rsListeSelectMatiereNiveau = mysql_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<br>
<br>
<br>
<?php   } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/login_enseignant.php">Espace 
  Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace 
  Administrateur</a></p>
<p align="center"><a href="upload_menu.php">Envoyer un exercice ou un document sur 
  le serveur</a></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_matiere);

mysql_free_result($rs_niveau);

mysql_free_result($rsListequiz);

mysql_free_result($rsListeSelectMatiereNiveau);

mysql_free_result($rsChoix);

mysql_free_result($rsChoix2);

mysql_free_result($RsListeTheme);

mysql_free_result($RsChoixTheme);
?>

  