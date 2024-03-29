<?php session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom']<>'Administrateur')
	{
		header("Location: login_administrateur.php");
	}
}
else
{ 
	header("Location: login_administrateur.php");
}

$titre_page = "Espace Administrateur";
$meta_description = "Page d'accueil pour les administrateurs";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>

<div class="row mb-5">
	<div class="col-6">
		<h3 class="bg-info shadow text-center pb-2 mb-4">Gestion</h3>
		<div class="list-group">
			<a href="gestion_matiere_niveau.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des matières et niveaux</a>
			<a href="gestion_eleve.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des élèves</a>
			<a href="install_param3.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des mots de passe de Stockpotatoes</a>
			<a href="gestion_activite.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des activités</a>
			<a href="gestion_stockpotatoes.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion de Stockpotatoes (thème, nom du site, ...)</a>
			<a href="gestion_espace_eleve.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion de l'espace élève (Demande mdp, barre de navigation, ...)</a>
		</div>
	</div>
	<div class="col-6">
		<h3 class="bg-info shadow text-center pb-2 mb-4">Paramétrage</h3>
		<div class="list-group">
			<a href="../enseignant/config.php" class="list-group-item list-group-item-action list-group-item-primary">Paramétrage du Hotpotatoes des enseignants</a>
			<a href="install_param.php" class="list-group-item list-group-item-action list-group-item-primary">Paramétrage de la connexion à la base de données</a>
			<a href="../install/install_editeur.php" class="list-group-item list-group-item-action list-group-item-primary">Paramétrage de l'éditeur en ligne</a>
			<a href="sauvegarde.php" class="list-group-item list-group-item-action list-group-item-primary">Sauvegarde de Stockpotatoes</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<h3 class="bg-info shadow text-center pb-2 mb-4">Documentations</h3>
		<div class="list-group">
			<a href="../documentation.htm" target="_blank" class="list-group-item list-group-item-action list-group-item-primary">Documentation complète</a>
			<a href="aide_editeur.php" class="list-group-item list-group-item-action list-group-item-primary">Aide sur le fonctionnement de l'éditeur</a>
			<a href="http://www.ac-orleans-tours.fr/ses/pedagogie/utilisation%20tice/exo_hotpot/sommaire.htm" class="list-group-item list-group-item-action list-group-item-primary">Tutoriel Hotpotatoes 6</a>
			<a href="aide_phpmyadmin.php" class="list-group-item list-group-item-action list-group-item-primary">Aide accès en intranet à la base via PhpMyAdmin</a>
		</div>
	</div>
</div>

<?php
require('include/footerAdministrateur.inc.php');
?>
