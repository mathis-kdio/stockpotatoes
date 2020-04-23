<?php session_start(); 
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom']<>'Enseignant')
	{
		header("Location: login_enseignant.php");
	}
}
else
{
	header("Location: ../index.php");
}

$titre_page = "Espace enseignant";
$meta_description = "Page d'accueil pour les enseignants";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="";
$css_deplus = "";

require('includes/headerEnseignant.inc.php');
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Enseignant</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Accueil de l'espace Enseignant</p>
			</div>
		</div>
		<div class="container jumbotron">
			<div class="row mb-5">
				<div class="col-6">
					<h3 class="bg-warning shadow text-center pb-2 mb-4">Listes des exercices</h3>
					<div class="list-group">
						<a href="liste_quiz_recent.php" class="list-group-item list-group-item-action list-group-item-primary">Liste des derniers exercices publiés</a>
						<a href="liste_quiz_publie.php" class="list-group-item list-group-item-action list-group-item-primary">Liste des exercices publiés dans une matière</a>
						<a href="liste_quiz_non_publie.php" class="list-group-item list-group-item-action list-group-item-primary">Liste des exercices non publiés dans une matière</a>
						<a href="liste_quiz_avec_score.php" class="list-group-item list-group-item-action list-group-item-primary">Liste des exercices en évaluation seule</a>
					</div>
				</div>
				<div class="col-6">
					<h3 class="bg-warning shadow text-center pb-2 mb-4">Listes des résultats</h3>
					<div class="list-group">
						<a href="liste_activite.php" class="list-group-item list-group-item-action list-group-item-primary">Les dernières activités</a>
						<a href="liste_resultat_quiz_classe.php" class="list-group-item list-group-item-action list-group-item-primary">Résultats à un exercice dans une classe</a>
						<a href="liste_resultat_theme_classe.php" class="list-group-item list-group-item-action list-group-item-primary">Résultats des exercices liés à un thème pour une classe</a>
						<a href="liste_resultat_theme_pourcent_classe.php" class="list-group-item list-group-item-action list-group-item-primary">Résultats en % par thème pour une classe</a>
						<a href="../Exercices/resultats.csv" class="list-group-item list-group-item-action list-group-item-primary">Consulter le dernier export Excel- Csv de résultats généré</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<h3 class="bg-warning shadow text-center pb-2 mb-4">Gestion</h3>
					<div class="list-group">
						<a href="gestion_exos.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des exercices - Modification - Suppression</a>
						<a href="gestion_theme.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des thèmes d'étude dans une matière</a>
						<a href="gestion_categorie.php" class="list-group-item list-group-item-action list-group-item-primary">Gestion des categories d'étude dans une matière</a>
						<a href="modif_score_blanc.php" class="list-group-item list-group-item-action list-group-item-primary">Remise à blanc des résultats pour un exercice dans une classe</a>
						<a href="liste_pass.php" class="list-group-item list-group-item-action list-group-item-primary">Liste des mots de passe d'une classe</a>
					</div>
				</div>
				<div class="col-6">
					<h3 class="bg-warning shadow text-center pb-2 mb-4">Documentations</h3>
					<div class="list-group">
						<a href="../documentation.htm" target="_blank" class="list-group-item list-group-item-action list-group-item-primary">Documentation complète</a>
						<a href="config.php" class="list-group-item list-group-item-action list-group-item-primary">Aide pour les enseignants</a>
						<a href="http://www.ac-orleans-tours.fr/ses/pedagogie/utilisation%20tice/exo_hotpot/sommaire.htm" class="list-group-item list-group-item-action list-group-item-primary">Tutoriel Hotpotatoes 6</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php');
?>
