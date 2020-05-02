<?php
session_start();
//session_destroy();
unset($_SESSION['Sess_nom']);
unset($_SESSION['Sess_prenom']);
unset($_SESSION['Sess_classe']);
unset($_SESSION['Sess_ID_eleve']);
unset($_SESSION['Sess_ID_quiz']);
unset($_SESSION['matiere_ID']);
unset($_SESSION['niveau_ID']);
unset($_SESSION['theme_ID']);
unset($_SESSION['nom_mat']);

$titre_page = "Accueil Stockpotatoes";
$meta_description = "Page principale de Stockpotatoes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$css_deplus = "";
require('includes/header.inc.php');
?>
<div class="row mt-3">
  <div class="col bg-warning text-center shadow">
    <h3>Stockpotatoes: Le distributeur de patates chaudes!</h3>
  </div>
</div>
<div class="row mt-3 mb-3 justify-content-center">
  <div class="col-8 pt-2 pb-2 bg-warning shadow">
    <ul class="">
      <li class=""><a href="login_eleve.php">Accès aux documents en mode identifié - Evaluation</a></li>
      <li class=""><a href="accueil_visiteur.php"> Accès aux documents en mode visiteur - Entrainement</a></li>
      <li class=""><a href="upload/login_upload.php">Envoyer un exercice ou un document sur le serveur</a></li>
      <li class=""><a href="administrateur/login_administrateur.php">Administrateur</a></li>
      <li class=""><a href="enseignant/login_enseignant.php">Enseignant</a></li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="col bg-warning text-center shadow">
    <?php 
    include("includes/version.php"); ?>
    <h4>Version : <?php echo $versioninstallee;?></h4>
  </div>  
</div>
</section>
<?php
require('includes/footer.inc.php');
?>