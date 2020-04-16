<?php require_once('Connections/conn_intranet.php'); ?>
<?php 
session_start();
require_once('Connections/conn_intranet.php'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$_SESSION['Sess_nom'] = 'VISITEUR';
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);



mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau ORDER BY stock_niveau.ID_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsListequiz = "SELECT * FROM stock_quiz WHERE stock_quiz.en_ligne='O' ORDER BY stock_quiz.titre";
$rsListequiz = mysqli_query($conn_intranet, $query_rsListequiz) or die(mysqli_error());
$row_rsListequiz = mysqli_fetch_assoc($rsListequiz);
$totalRows_rsListequiz = mysqli_num_rows($rsListequiz);

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
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s  AND stock_quiz.theme_ID=%s AND stock_quiz.en_ligne='O' ORDER BY stock_quiz.titre", $choixmat_rsListeSelectMatiereNiveau,$choixniv_rsListeSelectMatiereNiveau,$choixtheme_rsListeSelectMatiereNiveau);
$rsListeSelectMatiereNiveau = mysqli_query($conn_intranet, $query_rsListeSelectMatiereNiveau) or die(mysqli_error());
$row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau);
$totalRows_rsListeSelectMatiereNiveau = mysqli_num_rows($rsListeSelectMatiereNiveau);


$colname_rsChoix = "1";
if (isset($_GET['matiere_ID'])) {
  $colname_rsChoix = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsChoix = sprintf("SELECT * FROM stock_matiere WHERE ID_mat =%s", $colname_rsChoix);
$rsChoix = mysqli_query($conn_intranet, $query_rsChoix) or die(mysqli_error());
$row_rsChoix = mysqli_fetch_assoc($rsChoix);
$totalRows_rsChoix = mysqli_num_rows($rsChoix);

$colname_rsChoix2 = "1";
if (isset($_GET['niveau_ID'])) {
  $colname_rsChoix2 = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsChoix2 = sprintf("SELECT * FROM stock_niveau WHERE ID_niveau = %s", $colname_rsChoix2);
$rsChoix2 = mysqli_query($conn_intranet, $query_rsChoix2) or die(mysqli_error());
$row_rsChoix2 = mysqli_fetch_assoc($rsChoix2);
$totalRows_rsChoix2 = mysqli_num_rows($rsChoix2);

$choixniv_RsListeTheme = "0";
if (isset($_GET['niveau_ID'])) {
  $choixniv_RsListeTheme = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
$choixmat_RsListeTheme = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsListeTheme = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsListeTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s ORDER BY stock_theme.pos_theme", $choixmat_RsListeTheme,$choixniv_RsListeTheme);
$RsListeTheme = mysqli_query($conn_intranet, $query_RsListeTheme) or die(mysqli_error());
$row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme);
$totalRows_RsListeTheme = mysqli_num_rows($RsListeTheme);

$selectheme_RsChoixTheme = "0";
if (isset($_GET['theme_ID'])) {
  $selectheme_RsChoixTheme = (get_magic_quotes_gpc()) ? $_GET['theme_ID'] : addslashes($_GET['theme_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixTheme = sprintf("SELECT stock_theme.theme FROM stock_theme WHERE stock_theme.ID_theme=%s", $selectheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error());
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysqli_num_rows($RsChoixTheme);
?>

<html>
<head>
<title>Espace El&egrave;ve - Choix de l'exercice</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="style_jaune.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><p><a href="index.php"><img src="patate.gif" width="47" height="38" border="0"></a> 
        <img src="patate.jpg" width="324" height="39" align="top"></p>
      <p><strong><a href="index.php"> Accueil Stockpotatoes</a> - Mode Entrainement 
        - Choix du document</strong></p></td>
    <td><p align="right" class="subtitle"><strong><?php echo $_SESSION['Sess_nom']?></strong></p>
      <p align="right"><strong>Mode Entrainement</strong></p></td>
  </tr>
</table>
<form name="form1" method="GET" action="accueil_visiteur.php">
  <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_GET['matiere_ID'])) {if (!(strcmp($row_rs_matiere['ID_mat'], $_GET['matiere_ID']))) {echo "SELECTED";} }?>><?php echo $row_rs_matiere['nom_mat']?></option>
            <?php
} while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere));
  $rows = mysqli_num_rows($rs_matiere);
  if($rows > 0) {
      mysqli_data_seek($rs_matiere, 0);
	  $row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
  }
?>
          </select>
        </div></td>
      <td width="21%"><div align="center"> 
          <select name="niveau_ID" id="select">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_GET['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} }?>><?php echo $row_rs_niveau['nom_niveau']?></option>
            <?php
} while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau));
  $rows = mysqli_num_rows($rs_niveau);
  if($rows > 0) {
      mysqli_data_seek($rs_niveau, 0);
	  $row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
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
<table width="100%" border="0" cellspacing="20" cellpadding="0">
  <tr valign="top"> 
    <td height="150"> 
      <table width="100%"  border="0" cellspacing="20">
        <tr>
          <td><table border="0" cellspacing="0" class="bord_rouge">
            <tr>
              <td bgcolor="#CCCC99"><div align="center"><strong>Th&egrave;me d'&eacute;tude</strong></div></td>
            </tr>
            <?php do { ?>
            <tr>
              <td class="retrait20"><a href="accueil_visiteur.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=<?php echo $row_RsListeTheme['ID_theme']?>"><?php echo $row_RsListeTheme['theme']?></a></td>
            </tr>
            <?php } while ($row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme)); ?>
            <tr>
              <td class="retrait20"><a href="accueil_visiteur.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=0">Divers</a></td>
            </tr>
          </table></td>
        </tr>
      </table>
    <p>&nbsp;</p></td>
    <td> <table width="100%"  border="0" cellspacing="20">
      <tr>
        <td><p align="center" class="title"><strong>
          <?php 			
			    if (isset($_GET['theme_ID'])) {
				echo $row_RsChoixTheme['theme']; }
				else {echo 'Divers';};
				
$icone[1]='enseignant/images/link.gif';
$icone[2]='enseignant/images/patate.gif';
$icone[3]='enseignant/images/b_edit.png';
$icone[4]='enseignant/images/html.gif';
$icone[5]='enseignant/images/word.gif';
$icone[6]='enseignant/images/xls.gif';
$icone[7]='enseignant/images/ppt.gif';
$icone[8]='enseignant/images/pdf.gif';
$icone[9]='enseignant/images/oopres.gif';
$icone[10]='enseignant/images/oott.gif';
$icone[11]='enseignant/images/ootab.gif';
$icone[12]='enseignant/images/image.gif';
$icone[13]='enseignant/images/swf.gif';
$icone[14]='enseignant/images/avi.gif';
$icone[15]='enseignant/images/avi.gif';
$icone[16]='enseignant/images/autres.gif';
				?>
          <a href="#cours"></a></strong></p>
        <table width="100%" border="1" align="left" >
          <tr class="retrait20" >
            <td bgcolor="#CCCC99"><div align="left" class="retrait20">
                <p align="center">                      <a href="#cours">Cours</a> - <a href="#hotpotatoes">Ex. Hotpotatoes</a> - <a href="#exercices">Autres exercices</a> - <a href="#travail">Travail &agrave; faire</a> - <a href="#annexes">Documents annexes</a><strong><br>
                                    </strong></p>
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" align="left" >
          <tr class="retrait20" >
            <td bgcolor="#CCCC99"><div align="left" class="retrait20">
                <p align="left"> <strong>Le cours<a name="cours"></a></strong><strong><br>
                </strong></p>
            </div></td>
          </tr>
        </table>        <p>&nbsp;</p>
        <table width="100%" border="0" align="left" cellspacing="0" >
          <?php 
		
		do { 

		if ($row_rsListeSelectMatiereNiveau['cat_doc']==1) { 

		?>
          <tr>
            <td width="10%" class="bordbasvert"><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
            <td width="4%" class="bordbasvert"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">&nbsp;</td>
			<td width="50%" class="bordbasvert">
		      <div align="left">
		          <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			if (isset($_GET['theme_ID'])) {$theme=$_GET['theme_ID'];} else {$theme=0;}

			if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) ) {
			$lien='choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
			} 

			} ?>
			      <a href="<?php echo $lien ; ?>" target="_blank" class="retrait20"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></div></td>
            <td width="6%" class="bordbasvert">
              <div align="center">
                <?php if ($row_rsListeSelectMatiereNiveau['avec_score']=='O') {?>
                <a href="login_eleve.php"><strong><?php echo 'Eval.'; ?></strong></a>
                <?php ; } else {echo '-';}?>
            </div></td>
            <td width="20%" class="bordbasvert"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] <>'') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
          </tr>
          <?php 
		} // du if
		} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
		
		
		
?>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" align="left" >
          <tr class="retrait20" >
            <td bgcolor="#CCCC99"><div align="left" class="retrait20">
                <p align="left"> <strong>Exercices Hotpotatoes<a name="hotpotatoes"></a> </strong><strong><br>
                </strong></p>
            </div></td>
          </tr>
        </table>        <p>&nbsp;</p>
        <table width="100%" border="0" align="left" cellspacing="0" bordercolor="#990000" >
          <?php 
		
		if ($totalRows_rsListeSelectMatiereNiveau <> 0) { mysqli_data_seek($rsListeSelectMatiereNiveau,0);}
		do { 				
		if ($row_rsListeSelectMatiereNiveau['cat_doc']==2) 
		{ 
				
 ?>
          <tr>
            <td width="10%" class="bordbasvert"><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
            <td width="4%" class="bordbasvert"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">&nbsp;</td>

			<td width="50%" class="bordbasvert">              <div align="left">
                <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			if (isset($_GET['theme_ID'])) {$theme=$_GET['theme_ID'];} else {$theme=0;}

			if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) ) {
			$lien='choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
			} 

			} ?>
<a href="<?php echo $lien ; ?>" class="retrait20"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></div></td>
            <td width="6%" class="bordbasvert">
              <div align="center">
                <?php if ($row_rsListeSelectMatiereNiveau['avec_score']=='O') {?>
                <a href="login_eleve.php"><strong><?php echo 'Eval.'; ?></strong></a>
                <?php ; } else {echo '-';}?>
            </div></td>
            <td width="20%" class="bordbasvert"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] <>'') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
          </tr>
          <?php 
		}
		} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
        </table>
		</td>
      </tr>
      <tr>
        <td><table width="100%" border="1" align="left" >
          <tr class="retrait20" >
            <td bgcolor="#CCCC99"><div align="left" class="retrait20">
                <p align="left"> <strong>Autres exercices<a name="exercices"></a></strong><strong><br>
                </strong></p>
            </div></td>
          </tr>
        </table>        <p>&nbsp;</p>
        <table width="100%" border="0" align="left" cellspacing="0">
          <?php 
		if ($totalRows_rsListeSelectMatiereNiveau <> 0) { mysqli_data_seek($rsListeSelectMatiereNiveau,0);}
		do { 
				if ($row_rsListeSelectMatiereNiveau['cat_doc']==3) { 
		?>
          <tr>
            <td width="10%" class="bordbasvert"><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
            <td width="4%" class="bordbasvert"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">&nbsp;</td>

			<td width="50%" class="bordbasvert">
              <div align="left">
                <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			if (isset($_GET['theme_ID'])) {$theme=$_GET['theme_ID'];} else {$theme=0;}

			if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) ) {
			$lien='choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
			} 

			} ?>
<a href="<?php echo $lien ; ?>" target="_blank" class="retrait20"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></div></td>
            <td width="6%" class="bordbasvert">
              <div align="center">
                <?php if ($row_rsListeSelectMatiereNiveau['avec_score']=='O') {?>
                <a href="login_eleve.php"><strong><?php echo 'Eval.'; ?></strong></a>
                <?php ; } else {echo '-';}?>
            </div></td>
            <td width="20%" class="bordbasvert"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] <>'') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
          </tr>
          <?php 
		}
		} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" align="left" >
          <tr class="retrait20" >
            <td bgcolor="#CCCC99"><div align="left" class="retrait20">
                <p align="left"> <strong>Travail &agrave; faire<a name="travail"></a></strong><strong><br>
                </strong></p>
            </div></td>
          </tr>
        </table>        <p>&nbsp;</p>
        <table width="100%" border="0" align="left" cellspacing="0" >
          <?php 
		if ($totalRows_rsListeSelectMatiereNiveau <> 0) { mysqli_data_seek($rsListeSelectMatiereNiveau,0);}
		do { 
				if ($row_rsListeSelectMatiereNiveau['cat_doc']==4) { 
		?>
          <tr>
            <td width="10%" class="bordbasvert"><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
            <td width="4%" class="bordbasvert"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">&nbsp;</td>

			<td width="50%" class="bordbasvert">
              <div align="left">
                <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			if (isset($_GET['theme_ID'])) {$theme=$_GET['theme_ID'];} else {$theme=0;}

			if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) ) {
			$lien='choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
			} 
			} ?>
<a href="<?php echo $lien ; ?>" target="_blank" class="retrait20"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></div></td>
            <td width="0%" class="bordbasvert">
              <div align="center">
                <?php if ($row_rsListeSelectMatiereNiveau['avec_score']=='O') {?>
                <a href="login_eleve.php"><strong><?php echo 'Eval.'; ?></strong></a>
                <?php ; } else {echo '-';}?>
            </div></td>
            <td width="20%" class="bordbasvert"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] <>'') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
          </tr>
          <?php 
		}
		} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" align="left" >
          <tr class="retrait20" >
            <td bgcolor="#CCCC99"><div align="left" class="retrait20">
                <p align="left"> <strong>Documents annexes <a name="annexes"></a></strong><strong><br>
                </strong></p>
            </div></td>
          </tr>
        </table>        <p>&nbsp;</p>
        <table width="100%" border="0" align="left" cellspacing="0" >
          <?php 
		if ($totalRows_rsListeSelectMatiereNiveau <> 0) { mysqli_data_seek($rsListeSelectMatiereNiveau,0);}
		do { 
				if ($row_rsListeSelectMatiereNiveau['cat_doc']==5) { 
		?>
          <tr>
            <td width="10%" class="bordbasvert"><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
            <td width="4%" class="bordbasvert"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19">&nbsp;</td>

			<td width="50%" class="bordbasvert">
              <div align="left">
                <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			if (isset($_GET['theme_ID'])) {$theme=$_GET['theme_ID'];} else {$theme=0;}

			if ((isset($_GET['matiere_ID'])) && (isset($_GET['niveau_ID'])) ) {
			$lien='choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'].'&matiere_ID='.$_GET['matiere_ID'].'&niveau_ID='.$_GET['niveau_ID'].'&theme_ID='.$theme; 
			} 
			} ?>
<a href="<?php echo $lien ; ?>" target="_blank" class="retrait20"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a></div></td>
            <td width="0%" class="bordbasvert">
              <div align="center">
                <?php if ($row_rsListeSelectMatiereNiveau['avec_score']=='O') {?>
                <a href="login_eleve.php"><strong><?php echo 'Eval.'; ?></strong></a>
                <?php ; } else {echo '-';}?>
            </div></td>
            <td width="20%" class="bordbasvert"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] <>'') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
          </tr>
          <?php 
		}
		} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
        </table></td>
      </tr>
    </table>     </td>
  </tr>
</table>
<p>&nbsp;</p>
<?php   } ?>

</body>
</html>
<?php
mysqli_free_result($rs_matiere);

mysqli_free_result($rs_niveau);

mysqli_free_result($rsListequiz);

mysqli_free_result($rsListeSelectMatiereNiveau);

mysqli_free_result($rsChoix);

mysqli_free_result($rsChoix2);

mysqli_free_result($RsListeTheme);

mysqli_free_result($RsChoixTheme);
?>

  