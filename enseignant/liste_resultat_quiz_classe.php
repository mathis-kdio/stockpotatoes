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
$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error());
$row_rsClasse = mysqli_fetch_assoc($rsClasse);
$totalRows_rsClasse = mysqli_num_rows($rsClasse);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMatiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$RsMatiere = mysqli_query($conn_intranet, $query_RsMatiere) or die(mysqli_error());
$row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
$totalRows_RsMatiere = mysqli_num_rows($RsMatiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error());
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
$totalRows_RsNiveau = mysqli_num_rows($RsNiveau);

$colname1_Rsquiz = "0";
if (isset($_POST['ID_mat'])) {
  $colname1_Rsquiz = (get_magic_quotes_gpc()) ? $_POST['ID_mat'] : addslashes($_POST['ID_mat']);
}
$colname2_Rsquiz = "0";
if (isset($_POST['ID_niveau'])) {
  $colname2_Rsquiz = (get_magic_quotes_gpc()) ? $_POST['ID_niveau'] : addslashes($_POST['ID_niveau']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rsquiz = sprintf("SELECT * FROM stock_quiz WHERE stock_quiz.matiere_ID=%s AND stock_quiz.niveau_ID=%s ORDER BY titre ASC", $colname1_Rsquiz,$colname2_Rsquiz);
$Rsquiz = mysqli_query($conn_intranet, $query_Rsquiz) or die(mysqli_error());
$row_Rsquiz = mysqli_fetch_assoc($Rsquiz);
$totalRows_Rsquiz = mysqli_num_rows($Rsquiz);

$varquiz_RsActiviteClasse = "0";
if (isset($_POST['ID_quiz'])) {
  $varquiz_RsActiviteClasse = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
$varchoixclasse_RsActiviteClasse = "0";
if (isset($_POST['classe'])) {
  $varchoixclasse_RsActiviteClasse = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsActiviteClasse = sprintf("SELECT * FROM stock_activite,stock_eleve WHERE stock_activite.quiz_ID='%s' AND stock_activite.nom_classe='%s' AND stock_activite.eleve_ID=stock_eleve.ID_eleve ORDER BY stock_eleve.nom, stock_eleve.prenom ", $varquiz_RsActiviteClasse,$varchoixclasse_RsActiviteClasse);
$RsActiviteClasse = mysqli_query($conn_intranet, $query_RsActiviteClasse) or die(mysqli_error());
$row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse);
$totalRows_RsActiviteClasse = mysqli_num_rows($RsActiviteClasse);
//echo $query_RsActiviteClasse;
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
<p align="right" class="title"> <font face="Arial, Helvetica, sans-serif">R&eacute;sultats d'un exercice Hotpotatoes </font></p>
<div align="right">
	<a href="../index.php" align="center"><strong>Accueil Stockpotatoes</strong></a> -
	<a href="../enseignant/accueil_enseignant.php"><strong>Espace Enseignant</strong></a> -
	<a href="../administrateur/login_administrateur.php"><strong>Espace Administrateur</strong></a> - 
	<a href="../upload/upload_menu.php" align="center"><strong>Envoyer un exercice sur le serveur</strong></a>
</div>
<table width="46%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="50%">&nbsp;</td>
    <td width="50%"><form style="margin:0px;display:inline;padding:0px" name="form2" method="post" action="liste_resultat_quiz_classe.php">
        <div align="right"> 
          <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="17%"> <div align="left"> </div></td>
              <td width="60%"> <select name="classe" id="select10">
                  <option value="classe" 
				  <?php if (isset($_POST['classe'])) { if (!(strcmp("classe", $_POST['classe']))) {echo "SELECTED";}} ?>>Sélectionner votre classe
				  </option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";} }?>><?php echo $row_rsClasse['classe']?></option>
                  <?php
} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
  $rows = mysqli_num_rows($rsClasse);
  if($rows > 0) {
      mysqli_data_seek($rsClasse, 0);
	  $row_rsClasse = mysqli_fetch_assoc($rsClasse);
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
      </form>
	  </td>
  </tr>
  <?php  if (isset($_POST['classe'])) {?>
  <tr> 
    <td height="63"></td>
    <td><form name="form4" style="margin:0px;display:inline;padding:0px" method="post" action="liste_resultat_quiz_classe.php">
        <div align="right"> 
          <table width="71%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="36%"><div align="left"> 
                  <select name="ID_mat" id="select11">
                    <option value="ID_mat"
						<?php if (isset($_POST['ID_mat'])) { if (!(strcmp("ID_mat", $_POST['ID_mat']))) {echo "SELECTED";} }?>>Sélectionnez la matière
					</option>
                    <?php
do {  
?>

<option value="<?php echo $row_RsMatiere['ID_mat']?>"<?php if (isset($_POST['ID_mat'])) { if (!(strcmp($row_RsMatiere['ID_mat'], $_POST['ID_mat']))) {echo "SELECTED";}} ?>><?php echo $row_RsMatiere['nom_mat']?></option>
                    <?php
} while ($row_RsMatiere = mysqli_fetch_assoc($RsMatiere));
  $rows = mysqli_num_rows($RsMatiere);
  if($rows > 0) {
      mysqli_data_seek($RsMatiere, 0);
	  $row_RsMatiere = mysqli_fetch_assoc($RsMatiere);
  }
?>
                </select>
                </div></td>
              <td width="14%"><div align="left"> 
                  <select name="ID_niveau" id="select7">
                    <option value="ID_niveau"
						<?php if (isset($_POST['ID_niveau'])) { if (!(strcmp("ID_niveau", $_POST['ID_niveau']))) {echo "SELECTED";}}?>>Selectionnez le niveau
					</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_RsNiveau['ID_niveau']?>"<?php if (isset($_POST['ID_niveau'])) {  if (!(strcmp($row_RsNiveau['ID_niveau'], $_POST['ID_niveau']))) {echo "SELECTED";}} ?>><?php echo $row_RsNiveau['nom_niveau']?></option>
                    <?php
} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
  $rows = mysqli_num_rows($RsNiveau);
  if($rows > 0) {
      mysqli_data_seek($RsNiveau, 0);
	  $row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
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
	<?php  if (isset($_POST['ID_mat'])) { ?>
  <tr> 
    <td></td>
    <td><form name="form1" style="margin:0px;display:inline;padding:0px" method="post" action="liste_resultat_quiz_classe.php">
        <div align="right"> 
          <table width="100%" border="0" cellspacing="10" cellpadding="0">
            <tr> 
              <td width="17%"><div align="left"> 
                  <input name="ID_mat" type="hidden" id="ID_mat3" value="<?php echo $_POST['ID_mat']?>">
                  <input name="ID_niveau" type="hidden" id="ID_niveau3" value="<?php echo $_POST['ID_niveau']?>">
                  <input name="classe" type="hidden" id="classe5" value="<?php echo $_POST['classe']?>">
                </div></td>
              <td width="60%"> <div align="left"> 
				<select name="ID_quiz" id="select8">
                    <option value="ID_quiz" <?php if (isset($_POST['ID_quiz'])) {  if (!(strcmp("ID_quiz", $_POST['ID_quiz']))) {echo "SELECTED";} }?>>Sélectionnez votre exercice</option>
                    <?php
do {  
?>
                    <option value="<?php echo $row_Rsquiz['ID_quiz']?>"<?php if (isset($_POST['ID_quiz'])) { if (!(strcmp($row_Rsquiz['ID_quiz'], $_POST['ID_quiz']))) {echo "SELECTED";}} ?>><?php echo $row_Rsquiz['titre']?></option>
                    <?php
} while ($row_Rsquiz = mysqli_fetch_assoc($Rsquiz));
  $rows = mysqli_num_rows($Rsquiz);
  if($rows > 0) {
      mysqli_data_seek($Rsquiz, 0);
	  $row_Rsquiz = mysqli_fetch_assoc($Rsquiz);
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
// recuperation du nom du quiz
$choix_th_Rs_quiz_choisi = "0";
if (isset($_POST['ID_quiz'])) {
  $choix_th_Rs_quiz_choisi = (get_magic_quotes_gpc()) ? $_POST['ID_quiz'] : addslashes($_POST['ID_quiz']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rs_quiz_choisi = sprintf("SELECT stock_quiz.titre, stock_quiz.ID_quiz FROM stock_quiz WHERE stock_quiz.ID_quiz = %s", $choix_th_Rs_quiz_choisi);
$Rs_quiz_choisi = mysqli_query($conn_intranet, $query_Rs_quiz_choisi) or die(mysqli_error());
$row_Rs_quiz_choisi = mysqli_fetch_assoc($Rs_quiz_choisi);
$totalRows_Rs_quiz_choisi = mysqli_num_rows($Rs_quiz_choisi);

?>

<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCC99">
  <tr valign="top"> 
    <td width="29%"><div align="center"><strong>
        <font size="4"><?php echo $row_Rs_quiz_choisi['titre']?></font></strong></div></td>

    <td width="51%"> <form style="margin:0px" name="form3" method="post" action="export_resultat.php">
        <div align="right"> 
          <input name="ID_quiz" type="hidden" id="ID_quiz" value="<?php echo $_POST['ID_quiz']?>">
          <input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
          <input type="submit" name="Submit4" value="Exporter au format Excel">
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
<p><strong></strong></p>
<table border="1" cellspacing="0">
  <tr class="retrait20"> 
    <td bgcolor="#CCCC99"> <div align="center"><strong>N&deg;</strong></div></td>
    <td bgcolor="#CCCC99"> <div align="center"><strong>Nom</strong></div></td>
    <td bgcolor="#CCCC99"> <div align="center"><strong>Note sur 20</strong></div></td>
    <td bgcolor="#CCCC99"> <div align="center"><strong>Date</strong></div></td>
  </tr>
<?php 
  //$fichier_log = 'resultats.csv';
  //$fp = fopen($fichier_log,"a");
  //$chaine=('Nom;Prenom;Note sur 20;Date'."\n");

//fputs($fp, $chaine);
  $somme=0;
  do { ?>
  <tr > 
    <td class="retrait20"><div align="right"><?php echo $row_RsActiviteClasse['eleve_ID']; ?></div></td>
    <td class="retrait20"><?php echo $row_RsActiviteClasse['nom']; ?> <?php echo $row_RsActiviteClasse['prenom']; ?></td>
    <td class="retrait20"><div align="right"><?php echo $row_RsActiviteClasse['score']; ?></div></td>
    <td class="retrait20"><?php echo $row_RsActiviteClasse['debut']; ?></td>
  </tr>
  <?php 

  $chaine_valeur = $row_RsActiviteClasse['nom'].';'.$row_RsActiviteClasse['prenom'].';'.$row_RsActiviteClasse['score'].';'.$row_RsActiviteClasse['debut']."\n"; 
  
  //fputs($fp, $chaine_valeur);
  $somme=$somme+$row_RsActiviteClasse['score'];
  } while ($row_RsActiviteClasse = mysqli_fetch_assoc($RsActiviteClasse)); 
  
 //fclose($fp);

  ?>
  <tr> 
    <td >&nbsp;</td>
    <td><div align="center"><strong>
      <?php if (isset($_POST['ID_quiz']))  { 

  if ($totalRows_RsActiviteClasse<>0) {
  echo $totalRows_RsActiviteClasse.' élèves';
?></strong></div>
    </td>
    <td class="retrait20"><div align="right"><strong>Moy <?php echo round(($somme/$totalRows_RsActiviteClasse),1); ?></strong></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong> 
  <?php  
 }
  else 
  {
echo ' <BR><BR><strong><center>Pas encore de résultats pour cet exercice dans cette classe </center></strong>';
}
  ?>
  </strong></p>


<?php 

} //fin du isset(id_quiz)
}  // de la matiere
} //de la classe?>


</body>
</html>
<?php
mysqli_free_result($rsClasse);

mysqli_free_result($RsMatiere);

mysqli_free_result($RsNiveau);

mysqli_free_result($Rsquiz);

mysqli_free_result($RsActiviteClasse);
?>

