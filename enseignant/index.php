<?php session_start(); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant')
		header("Location: login_enseignant.php");
	else
		header("Location: accueil_enseignant.php");
; } else { header("Location: ../index.php");}?>
