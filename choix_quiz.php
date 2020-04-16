<?php 
session_start();
function sans_accent($chaine) 
{ 
   $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ"; 
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby"; 
   return strtr(trim($chaine),$accent,$noaccent); 
} 	
	

    $_SESSION['Sess_ID_quiz'] = $_GET['VAR_ID_quiz'];
	$fichier=$_GET['VAR_fichier'];
	$nom_mat=sans_accent($_GET['VAR_nom_mat']);

	$_SESSION['nom_mat'] = $nom_mat;
	
	if (isset($_GET['matiere_ID'])){$_SESSION['matiere_ID'] = $_GET['matiere_ID'];}
	if (isset($_GET['ID_niveau'])){$_SESSION['niveau_ID'] = $_GET['ID_niveau'];}
	if (isset($_GET['theme_ID'])){$_SESSION['theme_ID'] = $_GET['theme_ID'];}
	
	
	$lien="Exercices/".$nom_mat."/q".$_GET['VAR_ID_quiz']."/".$fichier;
	

	
	header("Location: $lien");
	
?>
