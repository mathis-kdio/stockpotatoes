<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once('../Connections/conn_intranet.php');
$colname_rsActivite = "1";
if (isset($_SESSION['Sess_ID_eleve'])) {
	$colname_rsActivite = (get_magic_quotes_gpc()) ? $_SESSION['Sess_ID_eleve'] : addslashes($_SESSION['Sess_ID_eleve']);
}
$colname2_rsActivite = "1";
if (isset($_SESSION['Sess_ID_quiz'])) {
	$colname2_rsActivite = (get_magic_quotes_gpc()) ? $_SESSION['Sess_ID_quiz'] : addslashes($_SESSION['Sess_ID_quiz']);
}
if ($_POST["Start_Time"] == "") $debut = "inconnu";
	else $debut = $_POST["Start_Time"];
if ($_POST["End_Time"] == "") $fin = "inconnu";
	else $fin = $_POST["End_Time"];
if ($_POST["subject"] == "") $sujet = "inconnu";
	else $sujet = $_POST["subject"];	
if ($_POST["realname"] == "") $eleve = "inconnu";
	else $eleve = $_POST["realname"];
if ($_POST["Score"] == "") $score = "inconnu";
	else { 
			 $score = $_POST["Score"];
		 $note = $score/5;
		 }
if ($_POST["recipient"] == "") $recipient = "inconnu";
	else $recipient = $_POST["recipient"];
	
if ($_SESSION['Sess_nom']<>'VISITEUR') {
	
$quiz_ID=$_SESSION['Sess_ID_quiz'];	
$eleve_ID=$_SESSION['Sess_ID_eleve'];
$nom_classe=$_SESSION['Sess_classe'];
$identifiant=$_SESSION['Sess_identifiant'];

$fait='O';

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rsActivite = sprintf("SELECT * FROM stock_activite WHERE eleve_ID = '%s' AND quiz_ID='%s'", $colname_rsActivite,$colname2_rsActivite);
$rsActivite = mysqli_query($conn_intranet, $query_rsActivite) or die(mysqli_error($conn_intranet));
$row_rsActivite = mysqli_fetch_assoc($rsActivite);
$totalRows_rsActivite = mysqli_num_rows($rsActivite);

if ($totalRows_rsActivite<>'0') {
	if ($row_rsActivite['score'] < $note) {
		$sql = sprintf("UPDATE stock_activite SET score='%s', debut='%s', fin='%s' WHERE eleve_ID = '%s' AND quiz_ID='%s'", $note,$debut,$fin,$colname_rsActivite,$colname2_rsActivite);
		mysqli_query($conn_intranet, $sql) or die(mysqli_error($conn_intranet)); 
	}
}
else {
	$sql = sprintf("INSERT INTO stock_activite ( `ID_activite` , `eleve_ID` , `identifiant` , `nom_classe` , `quiz_ID` , `score` , `debut` , `fin` , `fait` ) VALUES('','%s','%s','%s','%s','%s','%s','%s','%s')",$eleve_ID,$identifiant,$nom_classe,$quiz_ID,$note,$debut,$fin,$fait);
	mysqli_query($conn_intranet, $sql) or die(mysqli_error($conn_intranet)); 
}

mysqli_close($conn_intranet);  
}

if ($_SESSION['Sess_nom']<>'VISITEUR') {
	echo '<script type="text/javascript" language="javascript">';
	echo ' opener.location.href ="../accueil_eleve.php?matiere_ID='.$_SESSION['matiere_ID'].'&niveau_ID='.$_SESSION['niveau_ID'].'&theme_ID='.$_SESSION['theme_ID'].'&categorie_ID='.$_SESSION['categorie_ID'].'"';
	echo '</script>';
}
else
{
	echo '<script type="text/javascript" language="javascript">';
	echo ' opener.location.href ="../accueil_visiteur.php?matiere_ID='.$_SESSION['matiere_ID'].'&niveau_ID='.$_SESSION['niveau_ID'].'&theme_ID='.$_SESSION['theme_ID'].'&categorie_ID='.$_SESSION['categorie_ID'].'"';
	echo '</script>';
}
?>

<HTML>
<link href="../style_jaune.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
window.onload=function(){
		window.setTimeout(function(){
				window.close()
		}, 10);
}
</script>
<title>Enregistrement des notes</title><body>
<?php
if ($_SESSION['Sess_nom']<>'VISITEUR')
{
if ((isset($_SESSION['Sess_prenom'])) && (isset($_SESSION['Sess_classe']))){
echo '<strong>'.$_SESSION['Sess_nom']." ".$_SESSION['Sess_prenom']." ".$_SESSION['Sess_classe'].'</strong><BR><BR> ';
echo "Note : ".$note." /20  ";
echo "<BR>Note enregistrée.";
}

}

else 
{
echo '<strong>'.$_SESSION['Sess_nom'].'</strong><BR><BR> ';
echo "Note : ".$note." /20  ";
}
?>
<hr>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
	<tr> 
		<td><input name="Submit" type="submit" onClick="ferme_popup()" value="Faire un autre exercice"></td>
	</tr>
	<tr> 
		<td><input name="Submit2" type="submit" onClick="deconnecter()" value="Se d&eacute;connecter"></td>
	</tr>
</table>

 
</body>
</html>
<?php
if ($_SESSION['Sess_nom']<>'VISITEUR') {
mysqli_free_result($rsActivite);
}
?>