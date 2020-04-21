<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php 

require_once('../Connections/conn_intranet.php'); 

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
$query_rsListequiz = "SELECT * FROM stock_quiz WHERE stock_quiz.en_ligne='O' AND stock_quiz.avec_score='O' ORDER BY stock_quiz.titre";
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
$query_rsListeSelectMatiereNiveau = sprintf("SELECT * FROM stock_quiz, stock_categorie WHERE stock_quiz.matiere_ID=%s  AND stock_quiz.niveau_ID=%s  AND stock_quiz.theme_ID=%s AND stock_quiz.categorie_ID = stock_categorie.ID_categorie ORDER BY stock_quiz.pos_doc, stock_quiz.titre", $choixmat_rsListeSelectMatiereNiveau,$choixniv_rsListeSelectMatiereNiveau,$choixtheme_rsListeSelectMatiereNiveau);
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
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.ID_theme=%s", $selectheme_RsChoixTheme);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error());
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysqli_num_rows($RsChoixTheme);
 
$icone[1]='images/link.gif';
$icone[2]='images/patate.gif';
$icone[3]='images/b_edit.png';
$icone[4]='images/html.gif';
$icone[5]='images/word.gif';
$icone[6]='images/xls.gif';
$icone[7]='images/ppt.gif';
$icone[8]='images/pdf.gif';
$icone[9]='images/oopres.gif';
$icone[10]='images/oott.gif';
$icone[11]='images/ootab.gif';
$icone[12]='images/image.gif';
$icone[13]='images/swf.gif';
$icone[14]='images/avi.gif';
$icone[15]='images/avi.gif';
$icone[16]='images/autres.gif';
?>

<html>
	<head>
		<title>Espace Enseignant - Gestion des exercices</title>
		<link href="../style_jaune.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="theme-color" content="#3f51b5">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-red.min.css"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
		<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	</head>
	<body>
		<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
			<header class="mdl-layout__header">
  			</header>
  			<main class="mdl-layout__content">
    			<div class="page-content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td>
      <p align="center"><strong><a href="../index.php">Accueil Stockpotatoes</a> - <a href="accueil_enseignant.php">Espace enseignant</a> - Gestion des documents</strong></p>
      <p><strong><span class="subtitle"><?php echo $_SESSION['Sess_nom']?></span></strong></p>
	</td>
    <td><ul class="interligne Style2">
        <li><a href="../upload/upload_hotpot.php">Envoyer un exercice Hotpotatoes</a></li>
        <li><a href="../upload/modif_select.php">Ajouter des fichiers li&eacute;s &agrave; un exercice Hotpotatoes (images, sons...)</a></li>
        <li><a href="../upload/upload_divers.php">Envoyer un document autre ( Word, OpenOffice, Pdf ...)</a></li>
        <li><a href="../upload/redac_online.php">R&eacute;diger directement en ligne un document Web et le publier </a>(&eacute;diteur)</li>
        <li><a href="../upload/select_online.php">Ouvrir un document Web d&eacute;j&agrave; publi&eacute; et le modifier</a> (&eacute;diteur) </li>
        <li><a href="../upload/upload_url.php">Cr&eacute;er un lien hypertexte vers un document externe</a><strong><span style="font-weight: bold; color: #660000; font-style: oblique; font-family: Georgia, &quot;Times New Roman&quot;, Times, serif;" #invalid_attr_id="20px"></span></strong></li>
		</ul>      
	</td>
  </tr>
</table>
<form name="form1" method="GET" action="gestion_exos.php">
  <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <tr> 
      <td width="35%"><div align="right"> 
          <select name="matiere_ID" id="select2">
            <?php
do {  
?>
            <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_GET['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_GET['matiere_ID']))) {echo "SELECTED";} }  ?>><?php echo $row_rs_matiere['nom_mat']?></option>
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
            <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_GET['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
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
      <td width="44%"><div align="center"><font size="6"><strong><?php echo $row_rsChoix['nom_mat']; ?></strong></font></div></td>
    </tr>
  </table>
</form>
<?php if (isset($_GET['matiere_ID'])) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top"> 
    <td> <table width="100%"  border="0" cellspacing="10">
        <tr>
          <td><table border="0" cellspacing="0" class="bord_rouge">
            <tr>
              <td bgcolor="#CCCC99"><div align="center"><strong>Th&egrave;me d'&eacute;tude</strong></div></td>
            </tr>
            <?php do { ?>
            <tr>
              <td><ul class="interligne Style2"><li><a href="gestion_exos.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=<?php echo $row_RsListeTheme['ID_theme']?>"><?php echo $row_RsListeTheme['theme']?></a></li></td>
            </tr>
            <?php } while ($row_RsListeTheme = mysqli_fetch_assoc($RsListeTheme)); ?>
            <tr>
              <td><ul class="interligne Style2"><li><a href="gestion_exos.php?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $_GET['niveau_ID']?>&theme_ID=0">Divers</a></li></td>
            </tr>
          </table></td>
        </tr>
      </table>      <p>&nbsp;</p></td>
    <td> 
      <table width="100%"  border="0" cellspacing="10">
        <tr>
          <td><p align="center" class="title"><strong><font size="4">
              <?php 			
			    if (isset($_GET['theme_ID'])) {
				echo $row_RsChoixTheme['theme']; }
				else {echo 'Divers';};
				?>
</font></strong></p>
            <table width="100%" border="0" align="left" >
              <tr class="retrait20" >
                <td><div align="left">
                    <p align="center"><a href="#cours">Cours</a> - <a href="#hotpotatoes">Ex. Hotpotatoes</a> - <a href="#exercices">Autres exercices</a> - <a href="#travail">Travail &agrave; faire</a> - <a href="#annexes">Documents annexes</a></p>
                    </div></td>
              </tr>
          </table>            <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td> <!-- LE COURS -->
		   <table width="100%" border="O" align="left" cellspacing="0">
            <tr class="retrait20">
              <td colspan="12" bgcolor="#CCCC99"><div align="left" class="retrait20">
                  <p><strong>Le cours<a name="cours"></a></strong><strong> <font size="4"> </font></strong></p>
              </div></td>
            </tr>
			<?php
	    if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
 
			$x=0;
		   do {
		   if ($row_rsListeSelectMatiereNiveau['cat_doc']==1) 
		   {
		   $x=$x+1;
		   $tabpos1[$x]=$row_rsListeSelectMatiereNiveau['pos_doc'];$tabid1[$x]=$row_rsListeSelectMatiereNiveau['ID_quiz'];
		    }
		   } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 

		   $t1=$x;
		   if ($x!=0) {echo '
            <tr class="retrait20" class="Style1">
              <td bgcolor="#CCCC99">
                <div align="center">N&deg;</div></td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99"><div align="center">Titre</div></td>
              <td bgcolor="#CCCC99"><div align="center">Catégorie</div></td>
              <td bgcolor="#CCCC99"><div align="center">Fichier</div></td>
              <td bgcolor="#CCCC99"><div align="center">Auteur</div></td>
              <td bgcolor="#CCCC99"><div align="center">Entr.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Eval.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Interro</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
            </tr>
            ';}
		   
		   if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
           $x=0;
			
            do { 
			
			if ($row_rsListeSelectMatiereNiveau['cat_doc']==1) {
			$x=$x+1; 
			?>
            <tr valign="middle">
              <td><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
			  <td bgcolor="#CCCC99" >
			  <?php if($x!=1) { ?>            
			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
			  <?php echo $tabid1[$x-1] ?>
			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
			  <?php echo $tabpos1[$x-1] ?>
			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
              <?php echo ' </form>';
			   } 
			   else {echo '&nbsp;';};
			   ?>
			  </td>
			  <td bgcolor="#CCCC99">
			  
			   
			   <?php if($x!=$t1) { ?>            
			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
			  <?php echo $tabid1[$x+1] ?>
			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
			  <?php echo $tabpos1[$x+1] ?>
			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
              <?php echo ' </form>';
			   } else {echo '&nbsp;';};?>	
			  </td>
			  <td>
			    <div align="center"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19"></div></td>
                          
			  <td class="retrait20">                <div align="left" >
                    <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			$lien='../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
			} ?>
			
                    <a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
					</div></td>
        <td class="retrait20">
          <?php if ($row_rsListeSelectMatiereNiveau['nom_categorie'] !='') {echo $row_rsListeSelectMatiereNiveau['nom_categorie'];}else {echo '-';} ?>
        </td>
			  <td class="retrait20"> <?php if($row_rsListeSelectMatiereNiveau['type_doc'] !=1) {echo $row_rsListeSelectMatiereNiveau['fichier'];} else {echo 'Lien hypertexte';}?></td>
              <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] !='') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?></div></td>
              <td>
                <form name="formsup1" style="margin:0px" method="post" action="supp_quiz.php">
                  <div align="center">
                    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
                    <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
                    <input name="boutonsup1" type="hidden" value="Supprimer">
					<input type="image" src="images/delete.gif" alt="Supprimer un document">
                  </div>
                </form></td>
              <td>
			  
			  <?php
			  			 
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==1) {$redirection='misajour_url.php';}
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==2) {$redirection='misajour_hotpot.php';}
			  if($row_rsListeSelectMatiereNiveau['type_doc']==3){$redirection='misajour_online.php';};
			  if($row_rsListeSelectMatiereNiveau['type_doc']>3){$redirection='misajour_divers.php';};
			  

			  ?>
                <form style="margin:0px" name="formmod1" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
                  <div align="center">
                    <input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">                    
                    <input name="boutonmod1" type="hidden" value="Modifier">
					           <input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
                  </div>
                </form>
			  
			  
			  
			  </td>
            </tr>
            <?php 
			} // du if
			} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
          </table>
	    </td>
        </tr>
				<tr><td>
				
		<!-- HOTPOTATOES -->
		
		<table width="100%" border="O" align="left" cellspacing="0">
      <tr class="retrait20">
        <td colspan="12" bgcolor="#CCCC99">
          <div align="left" class="retrait20">
            <p><strong>Hotpotatoes<a name="hotpotatoes"></a></strong><strong> <font size="4"> </font></strong></p>
          </div>
        </td>
      </tr>
			<?php 
        if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
     		$x=0;
		    do {
    		  if ($row_rsListeSelectMatiereNiveau['cat_doc']==2) 
    		  {
    		    $x=$x+1;
    		    $tabpos2[$x]=$row_rsListeSelectMatiereNiveau['pos_doc'];$tabid2[$x]=$row_rsListeSelectMatiereNiveau['ID_quiz'];
    		  };		
  		  } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
		    $t2=$x; 
		    if ($x!=0) 
        {
          echo '
            <tr class="retrait20" class="Style1">
              <td bgcolor="#CCCC99">
                <div align="center">N&deg;</div></td>
      				<td bgcolor="#CCCC99">&nbsp;</td>
      				<td bgcolor="#CCCC99">&nbsp;</td>
      				<td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99"><div align="center">Titre</div></td>
              <td bgcolor="#CCCC99"><div align="center">Categorie</div></td>
              <td bgcolor="#CCCC99"><div align="center">Fichier</div></td>
              <td bgcolor="#CCCC99"><div align="center">Auteur</div></td>
              <td bgcolor="#CCCC99"><div align="center">Entr.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Eval.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Interro</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
            </tr>
            ';
        }
		    if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
           $x=0;
			
            do { 
			
        if ($row_rsListeSelectMatiereNiveau['cat_doc']==2)
        {
          $x=$x+1; ?>
          <tr valign="middle">
              <td><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
  			  <td bgcolor="#CCCC99" >
  			  <?php if($x!=1) { ?>            
  			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
  			  <?php echo $_GET['matiere_ID']?>
  			  <?php echo '&niveau_ID=';?>
  			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
  			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
  			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
  			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
  			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
  			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
  			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
  			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
  			  <?php echo $tabid2[$x-1] ?>
  			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
  			  <?php echo $tabpos2[$x-1] ?>
  			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
          <?php echo ' </form>';
        } 
			   else {echo '&nbsp;';};
			   ?>
			  </td>
			  <td bgcolor="#CCCC99">
			  
			   
			   <?php if ($x!=$t2){ 
			         
			   ?>            
			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
			  <?php echo $tabid2[$x+1] ?>
			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
			  <?php echo $tabpos2[$x+1] ?>
			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
              <?php echo ' </form>';
			   } else {echo '&nbsp;';};?>	
			  </td>
			  <td>
			    <div align="center"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19"></div></td>
                          
			  <td class="retrait20">
          <div align="left" >
            <?php 
      			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
      			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
      			else {
      			$lien='../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
      			} ?>
            <a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
					</div>
        </td>
        <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['nom_categorie'] !='') {echo $row_rsListeSelectMatiereNiveau['nom_categorie'];}else {echo '-';} ?></td>		  
			  <td class="retrait20"> <?php if($row_rsListeSelectMatiereNiveau['type_doc'] !=1) {echo $row_rsListeSelectMatiereNiveau['fichier'];} else {echo 'Lien hypertexte';}?></td>
              <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] !='') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?></div></td>
              <td>
                <form name="formsup2" style="margin:0px" method="post" action="supp_quiz.php">
                  <div align="center">
                    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
                    <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
                    <input name="boutonsup2" type="hidden" value="Supprimer">
					<input type="image" src="images/delete.gif" alt="Supprimer un document">
                  </div>
                </form></td>
              <td>
			  
			  <?php
			  			 
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==1) {$redirection='misajour_url.php';}
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==2) {$redirection='misajour_hotpot.php';}
			  if($row_rsListeSelectMatiereNiveau['type_doc']==3){$redirection='misajour_online.php';};
			  if($row_rsListeSelectMatiereNiveau['type_doc']>3){$redirection='misajour_divers.php';};
			  ?>
                <form style="margin:0px" name="formmod2" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
                 
                  <div align="center">
                    <input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
                    <input name="boutonmod2" type="hidden" value="Modifier">
                    <input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
                  </div>
                </form>
			        </td>
            </tr>
          <?php 
          } // du if
        } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
      </table>
		</td></tr>
				<tr><td>
		<!-- Autres exercices 3 -->
		<table width="100%" border="O" align="left" cellspacing="0">
            <tr class="retrait20">
              <td colspan="12" bgcolor="#CCCC99"><div align="left" class="retrait20">
                  <p><strong>Autres exercices - TP<a name="exercices"></a></strong><strong> <font size="4"> </font></strong></p>
              </div></td>
            </tr>
			<?php 
   if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}

			$x=0;
		   do {
		   if ($row_rsListeSelectMatiereNiveau['cat_doc']==3) 
		   {
		   $x=$x+1;
		   $tabpos3[$x]=$row_rsListeSelectMatiereNiveau['pos_doc'];$tabid3[$x]=$row_rsListeSelectMatiereNiveau['ID_quiz'];
		    }
		   } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
		   $t3=$x;
		   if ($x!=0) {echo '
            <tr class="retrait20" class="Style1">
              <td bgcolor="#CCCC99">
                <div align="center">N&deg;</div></td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99"><div align="center">Titre</div></td>
              <td bgcolor="#CCCC99"><div align="center">Categorie</div></td>
              <td bgcolor="#CCCC99"><div align="center">Fichier</div></td>
              <td bgcolor="#CCCC99"><div align="center">Auteur</div></td>
              <td bgcolor="#CCCC99"><div align="center">Entr.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Eval.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Interro</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
            </tr>
            ';}
		   
		   if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
           $x=0;
			
            do { 
			
			if ($row_rsListeSelectMatiereNiveau['cat_doc']==3) {
			$x=$x+1; 
			?>
            <tr valign="middle">
              <td><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
			  <td bgcolor="#CCCC99" >
			  <?php if($x!=1) { ?>            
			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
			  <?php echo $tabid3[$x-1] ?>
			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
			  <?php echo $tabpos3[$x-1] ?>
			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
              <?php echo ' </form>';
			   } 
			   else {echo '&nbsp;';};
			   ?>
			  </td>
			  <td bgcolor="#CCCC99">
			  
			   
			   <?php if($x!=$t3) { ?>            
			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
			  <?php echo $tabid3[$x+1] ?>
			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
			  <?php echo $tabpos3[$x+1] ?>
			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
              <?php echo ' </form>';
			   } else {echo '&nbsp;';};?>	
			  </td>
			  <td>
			    <div align="center"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19"></div></td>
                          
			  <td class="retrait20">                <div align="left" >
                    <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			$lien='../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
			} ?>
			
                    <a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
					</div></td>
          
        <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['nom_categorie'] !='') {echo $row_rsListeSelectMatiereNiveau['nom_categorie'];}else {echo '-';} ?></td>			  
			  <td class="retrait20"> <?php if($row_rsListeSelectMatiereNiveau['type_doc'] !=1) {echo $row_rsListeSelectMatiereNiveau['fichier'];} else {echo 'Lien hypertexte';}?></td>
              <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] !='') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?></div></td>
              <td>
                <form name="formsup3" style="margin:0px" method="post" action="supp_quiz.php">
                  <div align="center">
                    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
                    <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
                    <input name="boutonsup3" type="hidden" value="Supprimer">
					<input type="image" src="images/delete.gif" alt="Supprimer un document">
                  </div>
                </form></td>
              <td>
			  
			  <?php
			  			 
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==1) {$redirection='misajour_url.php';}
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==2) {$redirection='misajour_hotpot.php';}
			  if($row_rsListeSelectMatiereNiveau['type_doc']==3){$redirection='misajour_online.php';};
			  if($row_rsListeSelectMatiereNiveau['type_doc']>3){$redirection='misajour_divers.php';};
			  

			  ?>
                <form style="margin:0px" name="formmod3" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
                  <div align="center">
                    <input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
                    <input name="boutonmod3" type="hidden" value="Modifier">
					<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
                  </div>
                </form>
			  
			  
			  
			  </td>
            </tr>
            <?php 
			} // du if
			} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
          </table>
		</td></tr>
				<tr><td>
		<!-- Travail à faire 4 -->
		<table width="100%" border="O" align="left" cellspacing="0">
            <tr class="retrait20">
              <td colspan="12" bgcolor="#CCCC99"><div align="left" class="retrait20">
                  <p><strong>Travail à faire <a name="travail"></a></strong><strong> <font size="4"> </font></strong></p>
              </div></td>
            </tr>
			<?php 
	    if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}

			$x=0;
		   do {
		   if ($row_rsListeSelectMatiereNiveau['cat_doc']==4) 
		   {
		   $x=$x+1;
		   $tabpos4[$x]=$row_rsListeSelectMatiereNiveau['pos_doc'];$tabid4[$x]=$row_rsListeSelectMatiereNiveau['ID_quiz'];
		    }
		   } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
		   $t4=$x;
		   if ($x!=0) {echo '
            <tr class="retrait20" class="Style1">
              <td bgcolor="#CCCC99">
                <div align="center">N&deg;</div></td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99"><div align="center">Titre</div></td>
              <td bgcolor="#CCCC99"><div align="center">Categorie</div></td>
              <td bgcolor="#CCCC99"><div align="center">Fichier</div></td>
              <td bgcolor="#CCCC99"><div align="center">Auteur</div></td>
              <td bgcolor="#CCCC99"><div align="center">Entr.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Eval.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Interro</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
            </tr>
            ';}
		   
		   if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
           $x=0;
			
            do { 
			
			if ($row_rsListeSelectMatiereNiveau['cat_doc']==4) {
			$x=$x+1; 
			?>
            <tr valign="middle">
              <td><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
			  <td bgcolor="#CCCC99" >
			  <?php if($x!=1) { ?>            
			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
			  <?php echo $tabid4[$x-1] ?>
			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
			  <?php echo $tabpos4[$x-1] ?>
			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
              <?php echo ' </form>';
			   } 
			   else {echo '&nbsp;';};
			   ?>
			  </td>
			  <td bgcolor="#CCCC99">
			  
			   
			   <?php if($x!=$t4) { ?>            
			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
			  <?php echo $tabid4[$x+1] ?>
			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
			  <?php echo $tabpos4[$x+1] ?>
			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
              <?php echo ' </form>';
			   } else {echo '&nbsp;';};?>	
			  </td>
			  <td>
			    <div align="center"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19"></div></td>
                          
			  <td class="retrait20">                <div align="left" >
                    <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			$lien='../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
			} ?>
			
                    <a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
					</div></td>
          
        <td class="retrait20">
          <?php if ($row_rsListeSelectMatiereNiveau['nom_categorie'] !='') {echo $row_rsListeSelectMatiereNiveau['nom_categorie'];}else {echo '-';} ?>
        </td>
			  <td class="retrait20"> <?php if($row_rsListeSelectMatiereNiveau['type_doc'] !=1) {echo $row_rsListeSelectMatiereNiveau['fichier'];} else {echo 'Lien hypertexte';}?></td>
              <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] !='') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?></div></td>
              <td>
                <form name="formsup4" style="margin:0px" method="post" action="supp_quiz.php">
                  <div align="center">
                    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
                    <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
                    <input name="boutonsup4" type="hidden" value="Supprimer">
					<input type="image" src="images/delete.gif" alt="Supprimer un document">
                  </div>
                </form></td>
              <td>
			  
			  <?php
			  			 
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==1) {$redirection='misajour_url.php';}
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==2) {$redirection='misajour_hotpot.php';}
			  if($row_rsListeSelectMatiereNiveau['type_doc']==3){$redirection='misajour_online.php';};
			  if($row_rsListeSelectMatiereNiveau['type_doc']>3){$redirection='misajour_divers.php';};
			  

			  ?>
                <form style="margin:0px" name="formmod4" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
                  <div align="center">
                    <input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
                    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
					<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
                  </div>
                </form>
			  
			  
			  
			  </td>
            </tr>
            <?php 
			} // du if
			} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); ?>
          </table>
		</td></tr>
		
		<tr><td>
		<!-- Documents annexes 5 -->
		<table width="100%" border="O" align="left" cellspacing="0">
            <tr class="retrait20">
              <td colspan="12" bgcolor="#CCCC99"><div align="left" class="retrait20">
                  <p><strong>Documents annexes<a name="annexes"></a></strong><strong> <font size="4"> </font></strong></p>
              </div></td>
            </tr>
			<?php 
	    if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}

			$x=0;
		   do {
		   if ($row_rsListeSelectMatiereNiveau['cat_doc']==5) 
		   {
		   $x=$x+1;
		   $tabpos5[$x]=$row_rsListeSelectMatiereNiveau['pos_doc'];$tabid5[$x]=$row_rsListeSelectMatiereNiveau['ID_quiz'];
		    }
		   } while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
		   $t5=$x;
		   if ($x!=0) {echo '
            <tr class="retrait20" class="Style1">
              <td bgcolor="#CCCC99">
                <div align="center">N&deg;</div></td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
				<td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99"><div align="center">Titre</div></td>
              <td bgcolor="#CCCC99"><div align="center">Categorie</div></td>
              <td bgcolor="#CCCC99"><div align="center">Fichier</div></td>
              <td bgcolor="#CCCC99"><div align="center">Auteur</div></td>
              <td bgcolor="#CCCC99"><div align="center">Entr.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Eval.</div></td>
              <td bgcolor="#CCCC99"><div align="center">Interro</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
              <td bgcolor="#CCCC99"><div align="center">&nbsp;</div></td>
            </tr>
            ';}
		   
		   if ($totalRows_rsListeSelectMatiereNiveau != 0) {	mysqli_data_seek($rsListeSelectMatiereNiveau,0);		}
           $x=0;
			
            do { 
			
			if ($row_rsListeSelectMatiereNiveau['cat_doc']==5) {
			$x=$x+1; 
			?>
            <tr valign="middle">
              <td><div align="right" class="retrait20"><?php echo $row_rsListeSelectMatiereNiveau['ID_quiz']; ?></div></td>
			  <td bgcolor="#CCCC99" >
			  <?php if($x!=1) { ?>            
			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
			  <?php echo $tabid5[$x-1] ?>
			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
			  <?php echo $tabpos5[$x-1] ?>
			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce document "></div>';?>
              <?php echo ' </form>';
			   } 
			   else {echo '&nbsp;';};
			   ?>
			  </td>
			  <td bgcolor="#CCCC99">
			  
			   
			   <?php if($x!=$t5) { ?>            
			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre.php?matiere_ID=';?>
			  <?php echo $_GET['matiere_ID']?>
			  <?php echo '&niveau_ID=';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>
			  <?php echo '"><div align="center"><input name="ID_quiz" type="hidden" id="ID_quiz" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>
			  <?php echo '"><input name="ID_theme" type="hidden" id="ID_theme" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>
			  <?php echo '"><input name="cat_doc" type="hidden" id="cat_doc" value="';?>
			  <?php echo $row_rsListeSelectMatiereNiveau['cat_doc']; ?>
			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
			  <?php echo $tabid5[$x+1] ?>
			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
			  <?php echo $tabpos5[$x+1] ?>
			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce document "></div>';?>
              <?php echo ' </form>';
			   } else {echo '&nbsp;';};?>	
			  </td>
			  <td>
			    <div align="center"><img src="<?php echo $icone[$row_rsListeSelectMatiereNiveau['type_doc']] ; ?>" width="19" height="19"></div></td>
                          
			  <td class="retrait20">                <div align="left" >
                    <?php 
			if($row_rsListeSelectMatiereNiveau['type_doc'] ==1) 
			{$lien=$row_rsListeSelectMatiereNiveau['fichier'];} 
			else {
			$lien='../choix_quiz.php?VAR_fichier='.$row_rsListeSelectMatiereNiveau['fichier'].'&VAR_ID_quiz='.$row_rsListeSelectMatiereNiveau['ID_quiz'].'&VAR_nom_mat='.$row_rsChoix['nom_mat'];
			} ?>
			
                    <a href="<?php echo $lien ; ?>" target="_blank"><strong><?php echo $row_rsListeSelectMatiereNiveau['titre']; ?></strong></a>
					</div></td>
        <td class="retrait20">
          <?php if ($row_rsListeSelectMatiereNiveau['nom_categorie'] !='') {echo $row_rsListeSelectMatiereNiveau['nom_categorie'];}else {echo '-';} ?>
        </td>
			  <td class="retrait20"> <?php if($row_rsListeSelectMatiereNiveau['type_doc'] !=1) {echo $row_rsListeSelectMatiereNiveau['fichier'];} else {echo 'Lien hypertexte';}?></td>
              <td class="retrait20"><?php if ($row_rsListeSelectMatiereNiveau['auteur'] !='') {echo $row_rsListeSelectMatiereNiveau['auteur'];}else {echo '-';} ?></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['en_ligne']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['avec_score']; ?></div></td>
              <td><div align="center"><?php echo $row_rsListeSelectMatiereNiveau['evaluation_seul']; ?></div></td>
              <td>
                <form name="formsup5" style="margin:0px" method="post" action="supp_quiz.php">
                  <div align="center">
                    <input name="categorie_ID" type="hidden" value="<?php echo $row_rsListeSelectMatiereNiveau['categorie_ID'] ?>">
                    <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>">
                    <input name="nom_mat" type="hidden" id="nom_mat" value="<?php echo $row_rsChoix['nom_mat']; ?>">
                    <input name="boutonsup5" type="hidden" value="Supprimer">
					<input type="image" src="images/delete.gif" alt="Supprimer un document">
                  </div>
                </form></td>
              <td>
			  
			  <?php
			  			 
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==1) {$redirection='misajour_url.php';}
			  if ($row_rsListeSelectMatiereNiveau['type_doc']==2) {$redirection='misajour_hotpot.php';}
			  if($row_rsListeSelectMatiereNiveau['type_doc']==3){$redirection='misajour_online.php';};
			  if($row_rsListeSelectMatiereNiveau['type_doc']>3){$redirection='misajour_divers.php';};
			  

			  ?>
                <form style="margin:0px" name="formmod5" method="post" action="<?php echo $redirection ?>?matiere_ID=<?php echo $_GET['matiere_ID']?>&niveau_ID=<?php echo $row_rsListeSelectMatiereNiveau['niveau_ID']; ?>&ID_quiz=<?php echo $row_rsListeSelectMatiereNiveau['ID_quiz'] ?>&theme_ID=<?php echo $row_rsListeSelectMatiereNiveau['theme_ID']; ?>">
                  <div align="center">
                    <input name="boutonmod5" type="hidden" value="Modifier">
					<input type="image" src="images/edit.gif" alt="Modifier - Déplacer un document "> 
                  </div>
                </form>
			  
			  
			  
			  </td>
            </tr>
            <?php 
			} // du if
			} while ($row_rsListeSelectMatiereNiveau = mysqli_fetch_assoc($rsListeSelectMatiereNiveau)); 
			?>
          </table>
		</td></tr>
        
    </table>      <p>&nbsp;</p></td>
  
</table>

<?php   } ?>
<p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
<p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
<p align="right">&nbsp;</p>
<p>&nbsp;</p>
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

  