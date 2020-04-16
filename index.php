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
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Identification de l'élève</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page principale de Stockpotatoes">
    <link href="style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <header>
      <div class="center">
        <img src="patate.gif" width="45" height="41"><img src="stockpotatoes.png" width="324" height="39"> 
      </div>
    </header>
    <section class="">
      <h3 class="border center">Stockpotatoes: Le distributeur de patates chaudes!</h3>
      <div class="border center shadow">  
        <ul class="">
          <li class="padding-bottom-1"><a href="login_eleve.php">Accès aux documents en mode identifié - Evaluation</a></li>
          <li class="padding-bottom-1"><a href="accueil_visiteur.php"> Accès aux documents en mode visiteur - Entrainement</a></li>
          <li class="padding-bottom-1"><a href="upload/login_upload.php">Envoyer un exercice ou un document sur le serveur</a></li>
          <li class="padding-bottom-1"><a href="administrateur/login_administrateur.php">Administrateur</a></li>
          <li class="padding-bottom-1"><a href="enseignant/login_enseignant.php">Enseignant</a></li>
        </ul>
      </div>
      <div class="text-center">
        <h4>Ver 3.0 ALPHA 3 - 14/04/2020</h4>
      </div>
    </section>
  </body>
</html>