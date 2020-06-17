<?php 
session_start();

if (!isset($_SESSION['Sess_nom']))
{
	header('Location:login_eleve.php');
}
else
{
	function sans_accent($chaine) 
	{
		$accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ";
		$noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby";
		return strtr(trim($chaine), $accent, $noaccent); 
	}

	$_SESSION['Sess_ID_quiz'] = htmlspecialchars($_GET['VAR_ID_quiz']);
	$fichier = htmlspecialchars($_GET['VAR_fichier']);
	$nom_mat = sans_accent(htmlspecialchars($_GET['VAR_nom_mat']));

	$_SESSION['nom_mat'] = $nom_mat;

	if (isset($_GET['matiere_ID']))
	{
		$_SESSION['matiere_ID'] = htmlspecialchars($_GET['matiere_ID']);
	}

	if (isset($_GET['niveau_ID']))
	{
		$_SESSION['niveau_ID'] = htmlspecialchars($_GET['niveau_ID']);
	}

	if (isset($_GET['theme_ID']))
	{
		$_SESSION['theme_ID'] = htmlspecialchars($_GET['theme_ID']);
	}

	if (isset($_GET['categorie_ID']))
	{
		$_SESSION['categorie_ID'] = htmlspecialchars($_GET['categorie_ID']);
	}

	$lien = "Exercices/".$nom_mat."/q".htmlspecialchars($_GET['VAR_ID_quiz'])."/".$fichier;

	header("Location: $lien");
}
?>