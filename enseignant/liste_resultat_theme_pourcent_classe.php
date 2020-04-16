<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
  if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>

<?php require_once('../Connections/conn_intranet.php'); ?>
<?php

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsClasse = "SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom, stock_eleve.classe, stock_eleve.niveau FROM stock_eleve GROUP BY classe ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));
$row_rsClasse = mysqli_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysqli_num_rows($rsClasse);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error());
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysqli_num_rows($RsNiveau);

$time = date('d-m-Y');
?>
<html>
<head>
<title>R&eacute;sultats d'un quiz pour une classe</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<p align="right" class="title"> <font face="Arial, Helvetica, sans-serif">R&eacute;sultats en % par th&egrave;me pour une classe</font></p>
<div align="right"> 
    <a href="../index.php" align="center"><strong>Accueil Stockpotatoes</strong></a> - 
    <a href="../enseignant/accueil_enseignant.php"><strong>Espace Enseignant</strong></a> - 
    <a href="../administrateur/login_administrateur.php"><strong>Espace Administrateur</strong></a> - 
    <a href="../upload/upload_menu.php" align="center"><strong>Envoyer un exercice sur le serveur</strong></a>
</div>
<table align="center">
<td width="50%">
  <form style="margin:0px;display:inline;padding:0px" name="form2" method="post" action="liste_resultat_theme_pourcent_classe.php">
    <div align="center"> 
      <table width="100%" border="0" cellspacing="10" cellpadding="0">
        <tr> 
          <td width="5%">
            <select name="classe" id="select10">
              <option value="classe" 
                <?php if (isset($_POST['classe'])) { if (!(strcmp("classe", $_POST['classe']))) {echo "SELECTED";}} ?>>Selectionnez votre classe
              </option>
              <?php
              do 
              { ?>
                <option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";} }?>><?php echo $row_rsClasse['classe']?></option>
              <?php 
              } while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
              $rows = mysqli_num_rows($rsClasse);
              if($rows > 0) 
              {
                mysqli_data_seek($rsClasse, 0);
                $row_rsClasse = mysqli_fetch_assoc($rsClasse);
              }?>
            </select>
          </td>
          <td width="5%">
            <div align="left"> 
              <select name="ID_niveau" id="select7">
                <option value="ID_niveau"
                  <?php if (isset($_POST['ID_niveau'])) { if (!(strcmp("ID_niveau", $_POST['ID_niveau']))) {echo "SELECTED";}}?>>Selectionnez le niveau
                </option>
                <?php
                do 
                {?>
                  <option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($_POST['ID_niveau'])) {  if (!(strcmp($row_RsNiveau['ID_niveau'], $_POST['ID_niveau']))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
                  <?php
                } while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
                $rows = mysqli_num_rows($RsNiveau);
                if($rows > 0) 
                {
                  mysqli_data_seek($RsNiveau, 0);
                  $row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
                }?>
              </select>
            </div>
          </td>
          <td width="12%">
            <div align="left"> 
              <input type="submit" name="Submit2" value="Validez">
            </div>
          </td>
        </tr>
      </table>
    </div>
  </form>
</td>
</table>


<?php
if (isset($_POST['classe'])) {
?>
<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCC99">
  <tr valign="top"> 
    <td width="29%">
      <div align="center">
        <strong> 
          <!--<font size="4"><?php //echo $row_Rs_theme_choisi['theme']?></font>-->
        </strong>
      </div>
    </td>        
    <td width="51%"> 
      <form style="margin:0px" name="form3" method="post" action="../Exercices/resultats_themes_100_<?php echo $_POST['classe']?>_<?php echo $time?>.csv">
        <div align="right"> 
          <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $_POST['ID_quiz']?>">
          <input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
          <input type="submit" name="Submit4" value="Exporter au format Calc">
        </div>
      </form>
    </td>
    <td width="20%">
    <div align="right">
      <strong><input name="Submit5" type="submit" onClick="MM_callJS('javascript:window.print();')" value="Imprimer"></strong>
    </div>
  </td>
  </tr>
</table>

<?php

$choixniveau = "0";
if (isset($_POST['ID_niveau']))
{
  $choixniveau = (get_magic_quotes_gpc()) ? $_POST['ID_niveau'] : addslashes($_POST['ID_niveau']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixTheme = sprintf("SELECT * FROM stock_theme WHERE stock_theme.niv_ID='%s' ORDER BY theme", $choixniveau);
$RsChoixTheme = mysqli_query($conn_intranet, $query_RsChoixTheme) or die(mysqli_error());
$row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme);
$totalRows_RsChoixTheme = mysqli_num_rows($RsChoixTheme);



$nom_classe = "1";
if (isset($_POST['classe'])) {
  $nom_classe = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rs_Liste_eleve = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom FROM stock_eleve WHERE stock_eleve.classe='%s' ORDER BY nom ", $nom_classe);
$Rs_Liste_eleve = mysqli_query($conn_intranet, $query_Rs_Liste_eleve) or die(mysqli_error());
$row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve);
$totalrows_Rs_Liste_eleve = mysqli_num_rows($Rs_Liste_eleve);

$themeid=array();
$theme=array();
do 
{
	$themeid[]=$row_RsChoixTheme['ID_theme'];
	$theme[]=$row_RsChoixTheme['theme'];
}while ($row_RsChoixTheme = mysqli_fetch_assoc($RsChoixTheme));


mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rsmoyenne = sprintf("SELECT COUNT(ID_activite) AS nombre20, ID_eleve, theme_ID FROM stock_activite INNER JOIN stock_eleve ON stock_activite.eleve_ID=stock_eleve.ID_eleve INNER JOIN stock_quiz ON stock_activite.quiz_ID=stock_quiz.ID_quiz INNER JOIN stock_theme ON stock_quiz.theme_ID=stock_theme.ID_theme WHERE score=20 GROUP BY ID_eleve, theme_ID");
$Rsmoyenne = mysqli_query($conn_intranet, $query_Rsmoyenne) or die(mysqli_error());
$row_Rsmoyenne = mysqli_fetch_assoc($Rsmoyenne);
$totalRows_Rsmoyenne = mysqli_num_rows($Rsmoyenne);


mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rsquiz = sprintf("SELECT COUNT(ID_quiz) AS nombrequiz, theme_ID FROM stock_quiz WHERE avec_score='O' GROUP BY theme_ID");
$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error());
$row_Rsquiz = mysqli_fetch_assoc($Rsquiz);
$totalRows_Rsquiz = mysqli_num_rows($Rsquiz);

$tab=array();
do { 
	$tab[$row_Rsmoyenne['ID_eleve']][$row_Rsmoyenne['theme_ID']]=$row_Rsmoyenne['nombre20'];

} while ($row_Rsmoyenne = mysqli_fetch_assoc($Rsmoyenne));
do{
	$totaltheme[$row_Rsquiz['theme_ID']]=$row_Rsquiz['nombrequiz'];
}while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz));

?>
<div>
</div>
<table border="1" align="center">
    <caption>Classement de la classe <?php echo $_POST['classe']?> pour toutes les le&ccedil;ons</caption>
    <tr>
        <td bgcolor="#CCCC99">Nom - Pr&eacute;nom</td>
        <?php
        
        $i=0;
        do  {
          echo ' <td width="100"  bgcolor="#CCCC99"> <div align="center"><strong>'."   ".$theme[$i]."  ".'( N&deg '.$themeid[$i].')'.'<br>'.'</strong>'.'</div></td>';
          $i=$i+1;
          }
        while ($i < $totalRows_RsChoixTheme);
        ?>
    </tr>
	<?php
	do	
	{?>
		<tr>
 			<td bgcolor="#CCCC99 "><?php echo $row_Rs_Liste_eleve['nom'].' '.$row_Rs_Liste_eleve['prenom'];?></td>
			<?php
			$i=0; 
          do { 
            if (isset($tab[$row_Rs_Liste_eleve['ID_eleve']][$themeid[$i]])) 
              { 
                $total = ($tab[$row_Rs_Liste_eleve['ID_eleve']][$themeid[$i]] / $totaltheme[$themeid[$i]] *100); 
                $totalf = number_format($total);
                if (0 < $totalf && $totalf < 50) {
                  echo '<td bgcolor="#ff140c">'.$totalf;
                }
                if (50 <= $totalf &&  $totalf < 75) {
                  echo '<td bgcolor="#ffd133">'.$totalf;
                }
                if (75 <= $totalf &&  $totalf < 100) {
                  echo '<td bgcolor="#78a419">'.$totalf;
                }
                if ($totalf >= 100) {
                  echo '<td bgcolor="#317324">'.$totalf;
                }                 
              }
            else { echo '<td bgcolor="#ff140c">0'; };
            echo "</td>";
            $i=$i+1;
      } while ($i < $totalRows_RsChoixTheme);?>
		</tr>
		<?php
	} while ( $row_Rs_Liste_eleve = mysqli_fetch_assoc($Rs_Liste_eleve)); ?>
</table>

<?php
//test téléchargement
  $fichier_log = '../Exercices/resultats_themes_100_'.$_POST['classe'].'_'.$time.'.csv';
  chmod($fichier_log,0777);
  unlink($fichier_log);
  $fp = fopen($fichier_log,"a");

  	$nomprenom=('Nom;');
	fwrite($fp, $nomprenom);


$choixniveaucalc = "0";
if (isset($_POST['ID_niveau']))
{
  $choixniveaucalc = (get_magic_quotes_gpc()) ? $_POST['ID_niveau'] : addslashes($_POST['ID_niveau']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixThemecalc = sprintf("SELECT * FROM stock_theme WHERE stock_theme.niv_ID='%s' ORDER BY theme", $choixniveaucalc);
$RsChoixThemecalc = mysqli_query($conn_intranet, $query_RsChoixThemecalc) or die(mysqli_error());
$row_RsChoixThemecalc = mysqli_fetch_assoc($RsChoixThemecalc);
$totalRows_RsChoixThemecalc = mysqli_num_rows($RsChoixThemecalc);



$nom_classecalc = "1";
if (isset($_POST['classe'])) {
  $nom_classecalc = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rs_Liste_elevecalc = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom FROM stock_eleve WHERE stock_eleve.classe='%s' ORDER BY nom ", $nom_classecalc);
$Rs_Liste_elevecalc = mysqli_query($conn_intranet, $query_Rs_Liste_elevecalc) or die(mysqli_error());
$row_Rs_Liste_elevecalc = mysqli_fetch_assoc($Rs_Liste_elevecalc);
$totalrows_Rs_Liste_elevecalc = mysqli_num_rows($Rs_Liste_elevecalc);

$themeidcalc=array();
$themecalc=array();
do 
{
	$themeidcalc[]=$row_RsChoixThemecalc['ID_theme'];
	$themecalc[]=$row_RsChoixThemecalc['theme'];
}while ($row_RsChoixThemecalc = mysqli_fetch_assoc($RsChoixThemecalc));


mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rsmoyennecalc = sprintf("SELECT COUNT(ID_activite) AS nombre20, ID_eleve, theme_ID FROM stock_activite INNER JOIN stock_eleve ON stock_activite.eleve_ID=stock_eleve.ID_eleve INNER JOIN stock_quiz ON stock_activite.quiz_ID=stock_quiz.ID_quiz INNER JOIN stock_theme ON stock_quiz.theme_ID=stock_theme.ID_theme WHERE score=20 GROUP BY ID_eleve, theme_ID");
$Rsmoyennecalc = mysqli_query($conn_intranet, $query_Rsmoyennecalc) or die(mysqli_error());
$row_Rsmoyennecalc = mysqli_fetch_assoc($Rsmoyennecalc);
$totalRows_Rsmoyennecalc = mysqli_num_rows($Rsmoyennecalc);


mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rsquizcalc = sprintf("SELECT COUNT(ID_quiz) AS nombrequiz, theme_ID FROM stock_quiz WHERE avec_score='O' GROUP BY theme_ID");
$Rsquizcalc = mysqli_query($conn_intranet, $query_Rsquizcalc) or die(mysqli_error());
$row_Rsquizcalc = mysqli_fetch_assoc($Rsquizcalc);
$totalRows_Rsquizcalc = mysqli_num_rows($Rsquizcalc);

$tabcalc=array();
do { 
	$tabcalc[$row_Rsmoyennecalc['ID_eleve']][$row_Rsmoyennecalc['theme_ID']]=$row_Rsmoyennecalc['nombre20'];
} while ($row_Rsmoyennecalc = mysqli_fetch_assoc($Rsmoyennecalc));

do {
	$totalthemecalc[$row_Rsquizcalc['theme_ID']]=$row_Rsquizcalc['nombrequiz'];
} while ($row_Rsquizcalc = mysqli_fetch_assoc($Rsquizcalc));

$sautdeligne = ("\n");
		$i=0;
        do  {
          $listethemes = $themecalc[$i]."  ".'(N'.$themeidcalc[$i].');';
          fwrite($fp, $listethemes);
          $i=$i+1;
          }
        while ($i < $totalRows_RsChoixThemecalc);
        fwrite($fp, $sautdeligne);
		do	{
 		$listeeleves = $row_Rs_Liste_elevecalc['nom'].' '.$row_Rs_Liste_elevecalc['prenom'].';';
 		fwrite($fp, $listeeleves);
			$i=0;

      		do {

      			if (isset($tabcalc[$row_Rs_Liste_elevecalc['ID_eleve']][$themeidcalc[$i]])) 
            	{ 
            		$totalcalc = ($tabcalc[$row_Rs_Liste_elevecalc['ID_eleve']][$themeidcalc[$i]] / $totalthemecalc[$themeidcalc[$i]] *100); 
           			fwrite($fp, number_format($totalcalc));
           		}
      			else fwrite($fp, '0');
      			fwrite($fp, ';');
      			$i=$i+1;
			} while ($i < $totalRows_RsChoixThemecalc);
 		fwrite($fp, $sautdeligne);
	} while ($row_Rs_Liste_elevecalc = mysqli_fetch_assoc($Rs_Liste_elevecalc));

fclose($fp);
//mysqli_free_result($Rsquiz);
//mysqli_free_result($RsActiviteClasse);
//mysqli_free_result($Rs_Liste_eleve);
//mysqli_free_result($Rs_theme_choisi);
};
// fin du isset($_POST['ID_theme']) 
?> 

</body>
</html>
<?php
mysqli_free_result($rsClasse);
mysqli_free_result($RsNiveau);
?>
