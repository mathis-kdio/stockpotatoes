<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>

<?php require_once('../Connections/conn_intranet.php'); ?>


<?php

mysql_select_db($database_conn_intranet, $conn_intranet);
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ";
$rsClasse = mysql_query($query_rsClasse, $conn_intranet) or die(mysql_error());
$row_rsClasse = mysql_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysql_num_rows($rsClasse);


mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsMatiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$RsMatiere = mysql_query($query_RsMatiere, $conn_intranet) or die(mysql_error());
$row_RsMatiere = mysql_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysql_num_rows($RsMatiere);



mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysql_query($query_RsNiveau, $conn_intranet) or die(mysql_error());
$row_RsNiveau = mysql_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysql_num_rows($RsNiveau);


$colname1_RsTheme = "0";
if (isset($_POST['ID_mat'])) {
  $colname1_RsTheme = (get_magic_quotes_gpc()) ? $_POST['ID_mat'] : addslashes($_POST['ID_mat']);
}
$colname2_RsTheme = "0";
if (isset($_POST['ID_niveau'])) {
  $colname2_RsTheme = (get_magic_quotes_gpc()) ? $_POST['ID_niveau'] : addslashes($_POST['ID_niveau']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_RsTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.mat_ID=%s AND stock_theme.niv_ID=%s", $colname1_RsTheme,$colname2_RsTheme);
$RsTheme = mysql_query($query_RsTheme, $conn_intranet) or die(mysql_error());
$row_RsTheme = mysql_fetch_assoc($RsTheme);
$totalRows_RsTheme = mysql_num_rows($RsTheme);



 ?>

<html>
<head>
<title>R&eacute;sultats d'un quiz pour une classe</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body>
<p align="right" class="title"> <font face="Arial, Helvetica, sans-serif">R&eacute;sultats 
  aux exercices Hotpotatoes pour un th&egrave;me </font></p>
<div id="Layer1" style="position:absolute; width:281px; height:115px; z-index:1; left: 497px; top: 74px;"> 
  <ul>
    <li><a href="../index.php" align="center">Accueil Stockpotatoes</a></li>
    <li><a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a></li>
    <li><a href="../administrateur/login_administrateur.php">Espace Administrateur</a></li>
    <li><a href="../upload/upload_menu.php" align="center">Envoyer un exercice sur 
      le serveur</a></li>
  </ul>
</div>
<table width="46%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="50%">&nbsp;</td>
    <td width="50%"><form style="margin:0px;display:inline;padding:0px" name="form2" method="post" action="liste_resultat_theme_classe.php">
        <div align="right"> 
          <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="17%"> <div align="left"> </div></td>
              <td width="60%"> <select name="classe" id="select10">
                  <option value="classe" <?php if  (isset($_POST['classe'])) { if (!(strcmp("classe", $_POST['classe']))) {echo "SELECTED";} }?>>Sélectionner 
                  votre classe</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";} }?>><?php echo $row_rsClasse['classe']?></option>
                  <?php
} while ($row_rsClasse = mysql_fetch_assoc($rsClasse));
  $rows = mysql_num_rows($rsClasse);
  if($rows > 0) {
      mysql_data_seek($rsClasse, 0);
	  $row_rsClasse = mysql_fetch_assoc($rsClasse);
  }
?>
                </select> </td>
              <td width="11%"> <div align="left"> </div></td>
              <td width="12%"> <div align="left"> 
                  <input type="submit" name="Submit2" value="Validez">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>

  <tr> 
    <td height="63"></td>
    <td><form name="form4" style="margin:0px;display:inline;padding:0px" method="post" action="liste_resultat_theme_classe.php">
        <div align="right"> 
          <table width="71%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="36%"><div align="left"> 
                  <select name="ID_mat" id="select11">
                    <option value="ID_mat" <?php if (isset($_POST['ID_mat'])) { if (!(strcmp("ID_mat", $_POST['ID_mat']))) {echo "SELECTED";} }?>>Sélectionnez 
                    la matière</option>
                    <?php
do {  
?>

<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($_POST['ID_mat'])) { if (!(strcmp($row_RsMatiere['ID_mat'], $_POST['ID_mat']))) {echo "SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
                    <?php
} while ($row_RsMatiere = mysql_fetch_assoc($RsMatiere));
  $rows = mysql_num_rows($RsMatiere);
  if($rows > 0) {
      mysql_data_seek($RsMatiere, 0);
	  $row_RsMatiere = mysql_fetch_assoc($RsMatiere);
  }
?>                  </select>
                </div></td>
              <td width="14%"><div align="left"> 
                  <select name="ID_niveau" id="select7">
                    <option value="ID_niveau" <?php if (isset($_POST['ID_niveau'])) { if (!(strcmp("ID_niveau", $_POST['ID_niveau']))) {echo "SELECTED";}}?>>Selectionnez 
                    le niveau</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($_POST['ID_niveau'])) {  if (!(strcmp($row_RsNiveau['ID_niveau'], $_POST['ID_niveau']))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
                    <?php
} while ($row_RsNiveau = mysql_fetch_assoc($RsNiveau));
  $rows = mysql_num_rows($RsNiveau);
  if($rows > 0) {
      mysql_data_seek($RsNiveau, 0);
	  $row_RsNiveau = mysql_fetch_assoc($RsNiveau);
  }
?>
                  </select>
                </div></td>
              <td width="50%"><div align="left"> 
                  <input name="classe" type="hidden" id="classe4" value="<?php echo $_POST['classe']?>">
                  <input type="submit" name="Submit3" value="Validez">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>


  <tr> 
    <td></td>
    <td><form name="form1" style="margin:0px;display:inline;padding:0px" method="post" action="liste_resultat_theme_classe.php">
        <div align="right"> 
          <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="17%"><div align="left"> 
                  <input name="ID_mat" type="hidden" id="ID_mat3" value="<?php echo $_POST['ID_mat']?>">
                  <input name="ID_niveau" type="hidden" id="ID_niveau3" value="<?php echo $_POST['ID_niveau']?>">
                  <input name="classe" type="hidden" id="classe5" value="<?php echo $_POST['classe']?>">
                </div></td>
              <td width="60%"> <div align="left"> 
                  


<select name="ID_theme" id="select8">
<option value="ID_theme" <?php if (isset($_POST['ID_theme'])) { if (!(strcmp("ID_theme", $_POST['ID_theme']))) {echo "SELECTED";} }?>>Sélectionnez votre thème</option>
<?php
do {  
?>
<option value="<?php echo $row_RsTheme['ID_theme']?>"<?php if (isset($_POST['ID_theme'])) { if (!(strcmp($row_RsTheme['ID_theme'], $_POST['ID_theme']))) {echo "SELECTED";}} ?>>
<?php echo $row_RsTheme['theme']?></option>
<?php
} while ($row_RsTheme = mysql_fetch_assoc($RsTheme));
  $rows = mysql_num_rows($RsTheme);
  if($rows > 0) {
      mysql_data_seek($Rsquiz, 0);
	  $row_RsTheme = mysql_fetch_assoc($RsTheme);
}
?>
 </select>
                </div></td>
              <td width="11%"><div align="left"></div></td>
              <td width="12%"> <div align="left"> 
                  <input type="submit" name="Submit" value="Valider">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>
</table>


<?php
// recuperation du nom du theme
$choix_th_Rs_theme_choisi = "0";
if (isset($_POST['ID_theme'])) {
  $choix_th_Rs_theme_choisi = (get_magic_quotes_gpc()) ? $_POST['ID_theme'] : addslashes($_POST['ID_theme']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Rs_theme_choisi = sprintf("SELECT stock_theme.theme, stock_theme.ID_theme FROM stock_theme WHERE stock_theme.ID_theme = %s", $choix_th_Rs_theme_choisi);
$Rs_theme_choisi = mysql_query($query_Rs_theme_choisi, $conn_intranet) or die(mysql_error());
$row_Rs_theme_choisi = mysql_fetch_assoc($Rs_theme_choisi);
$totalRows_Rs_theme_choisi = mysql_num_rows($Rs_theme_choisi);

?>


<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCC99">
  
  <tr valign="top"> 
    <td width="29%"><div align="center"><strong> 
        <font size="4"><?php echo $row_Rs_theme_choisi['theme']?></font></strong></div></td>
    
    <td width="20%"><div align="right"><strong> </strong><strong> </strong> <strong> 
        <input name="Submit5" type="submit" onClick="MM_callJS('javascript:window.print();')" value="Imprimer">
        </strong></div></td>
  </tr>
</table>




<?php 


//debut traitement pour ce theme
if (isset($_POST['ID_theme'])) {
		
		//liste activité
		$n_matiere = "0";
		if (isset($_POST['ID_mat'])) {
		  $n_matiere = (get_magic_quotes_gpc()) ? $_POST['ID_mat'] : addslashes($_POST['ID_mat']);
		}
		$n_classe = "0";
		if (isset($_POST['classe'])) {
		  $n_classe = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
		}
		$n_classe="'".$n_classe."'";
	
		mysql_select_db($database_conn_intranet, $conn_intranet);
		$query_RsActiviteClasse = sprintf("SELECT * FROM `stock_activite`, `stock_quiz`  WHERE stock_activite.nom_classe = %s AND stock_quiz.matiere_ID = %s AND stock_activite.quiz_ID = stock_quiz.ID_quiz ORDER BY stock_activite.eleve_ID,stock_activite.quiz_ID ", $n_classe, $n_matiere);
		//echo $query_RsActiviteClasse;
		$RsActiviteClasse = mysql_query($query_RsActiviteClasse, $conn_intranet) or die(mysql_error());
		
		$row_RsActiviteClasse = mysql_fetch_assoc($RsActiviteClasse);
		$totalRows_RsActiviteClasse = mysql_num_rows($RsActiviteClasse);



		$colname1_Rsquiz = "0";
		if (isset($_POST['ID_theme'])) {
		 $colname1_Rsquiz = (get_magic_quotes_gpc()) ? $_POST['ID_theme'] : addslashes($_POST['ID_theme']);
		}
		
		mysql_select_db($database_conn_intranet, $conn_intranet);
		$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.theme_ID=%s " , $colname1_Rsquiz);
		$Rsquiz = mysql_query($query_Rsquiz, $conn_intranet) or die(mysql_error());
		$row_Rsquiz = mysql_fetch_assoc($Rsquiz);
		$totalRows_Rsquiz = mysql_num_rows($Rsquiz);
		

							// remplissage tableau des quiz du theme
							$numquiz=array();
							$titrequiz=array();
							do { 
								
								$numquiz[]=$row_Rsquiz['ID_quiz'];
								$titrequiz[]=$row_Rsquiz['titre'];
								
							   } while ($row_Rsquiz = mysql_fetch_assoc($Rsquiz));
							
							

//Mise en tableau


$tab=array();
$somme_v=array();
$nb_notes_v=array();
$somme_h=array();
$nb_notes_h=array();

$cumul_moy_theme=0;

do { 
$tab[$row_RsActiviteClasse['eleve_ID']][$row_RsActiviteClasse['quiz_ID']]=$row_RsActiviteClasse['score'];
} while ($row_RsActiviteClasse = mysql_fetch_assoc($RsActiviteClasse));


//liste d'élève
$nom_classe = "1";
if (isset($_POST['classe'])) {
  $nom_classe = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysql_select_db($database_conn_intranet, $conn_intranet);
$query_Rs_Liste_eleve = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom FROM stock_eleve WHERE stock_eleve.classe='%s'", $nom_classe);
$Rs_Liste_eleve = mysql_query($query_Rs_Liste_eleve, $conn_intranet) or die(mysql_error());
$row_Rs_Liste_eleve = mysql_fetch_assoc($Rs_Liste_eleve);
$totalrows_Rs_Liste_eleve = mysql_num_rows($Rs_Liste_eleve);




//affichage final
?>
<p>&nbsp;</p>

<table border="1" cellspacing="0">
  <tr class="retrait20"> 
    <td class="retrait20" bgcolor="#CCCC99"> <div align="center"><strong>N&deg;</strong></div></td>
    <td class="retrait20" bgcolor="#CCCC99"> <div align="center"><strong>Nom</strong></div></td>
   
	<?php
	$i=0;
	do  {
	echo ' <td width="100"  bgcolor="#CCCC99"> <div align="center"><strong>'."   ".$titrequiz[$i].'<br>'.'</strong>'.'( N° '.$numquiz[$i].')'.'</div></td>';
	$i=$i+1;
	}
	while ($i < $totalRows_Rsquiz);
	?><td width="50"  bgcolor="#CCCC99"> <div align="right"><strong>Moy</strong></div></td>
  </tr>
	<?php

//initialisation tableau moyenne
			$i=0;
			$cumul_moy_theme=0;$nb_moy=0 ;
			do {
			$nb_notes_v[$i]=0; $somme_v[$i]=0;
			$nb_notes_h[$i]=0; $somme_h[$i]=0;
			$i=$i+1;}
			while ($i < $totalRows_Rsquiz); 


// debut traitement liste eleve
do {
$total=0; 
?>		
<tr> 
    <td class="retrait20"><div align="right"><?php echo $row_Rs_Liste_eleve['ID_eleve']; ?></div></td>
    <td class="retrait20"><?php echo $row_Rs_Liste_eleve['nom'].' '.$row_Rs_Liste_eleve['prenom']; ?></td>

			
			<?php
		
			$i=0;
			$somme_h[$row_Rs_Liste_eleve['ID_eleve']]=0;
			$nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']]=0;
			
			do  {  
			echo '<td class="retrait20"><div align="right">';

			if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]])) 
						{ 
						
					

                        echo $tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]]; 
						$somme_v[$i] = $somme_v[$i] + $tab[$row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]];
						$somme_h[$row_Rs_Liste_eleve['ID_eleve']] = $somme_h[$row_Rs_Liste_eleve['ID_eleve']] + $tab[         $row_Rs_Liste_eleve['ID_eleve']][$numquiz[$i]];
						$nb_notes_v[$i]=$nb_notes_v[$i]+1;
						$nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']]=$nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']]+1;
						
						} else { echo '&nbsp;'; };
			echo '</div></td>';
			$i=$i+1;

			}
			while ($i < $totalRows_Rsquiz);

//affichage moyenne eleve

			
			?><td class="retrait20" width="50"  bgcolor="#CCCC99"> <div align="right"><strong><?php 
if ($nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']]<>0) 
			{
			$total=  ($somme_h[$row_Rs_Liste_eleve['ID_eleve']]/$nb_notes_h[$row_Rs_Liste_eleve['ID_eleve']]);
			echo number_format($total, 1, ',', '');

			$cumul_moy_theme = $total + $cumul_moy_theme;
			$nb_moy = $nb_moy + 1; 
			} else {echo '&nbsp;';}; 



			?></strong></div></td>

</tr>
<?php
   } while ($row_Rs_Liste_eleve = mysql_fetch_assoc($Rs_Liste_eleve));
			

// ligne des moyennes de bas de tableau
			
			$i=0; ?>
			<tr><td> - </td>
    <td class="retrait20"><strong>Moyenne</strong></td>
    <?php
			do  { ?>
			<td class="retrait20"><div align="right"><strong>
        <?php 

			if ($nb_notes_v[$i]<>0) { echo round(($somme_v[$i]/$nb_notes_v[$i]),1);} else {echo '&nbsp;';}; 

			?>
        </strong></div></td><?php
			echo '</div></td>';
			$i=$i+1;
			}
			while ($i < $totalRows_Rsquiz);
//moyenne générale

if ($nb_moy <>0 ) { ?>
<td class="retrait20" width="50"  bgcolor="#CCCC99"> <div align="right"><strong>
<?php
echo round(($cumul_moy_theme/$nb_moy),2);
echo '</td>'; 
};
?>
</tr>
</table>
<?php 

mysql_free_result($Rsquiz);
mysql_free_result($RsActiviteClasse);
mysql_free_result($Rs_Liste_eleve);
mysql_free_result($Rs_theme_choisi);
 }
// fin du isset($_POST['ID_theme']) ?> 

</body>
</html>
<?php
mysql_free_result($rsClasse);
mysql_free_result($RsTheme);
mysql_free_result($RsMatiere);
mysql_free_result($RsNiveau);

?>



