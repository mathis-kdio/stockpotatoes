<?php
include("../Connections/gestion_pass.inc.php");
if (isset($_POST['pass_enseignant'])) 
{
	if (htmlspecialchars($_POST['pass_enseignant']) == $pass_profs)
	{
		session_start();
		$_SESSION['Sess_nom'] = 'Enseignant';
		header("Location: accueil_enseignant.php");
	}
	else
	{
		$bad_password = 1;
	}
}

$titre_page = "Login Enseignant";
$meta_description = "Page de login pour les enseignants";
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
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Connection à l'espace Enseignant</p>
			</div>
		</div>
		<div class="row jumbotron">
			<div class="col">
				<?php 
				if ($bad_password == 1)
				{
					echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
				} ?>
				<form name="form1" method="post" action="login_enseignant.php">
					<div class="form-group form-row justify-content-center">
						<div class="col-4">
							<label for="pass_enseignant">Entrer votre mot de passe</label>
							<input type="password" class="form-control" name="pass_enseignant" id="pass_enseignant" placeholder="Mot de passe">
						</div>
					</div>
					<div class="form-group form-row justify-content-center">
						<div class="col-4">
							<button type="submit" name="Submit" class="btn btn-primary">Valider</button>
						</div>
					</div>
				</form>
			</div>			
		</div>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php');
?>