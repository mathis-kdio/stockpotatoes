<?php
include("../Connections/gestion_pass.inc.php");
if (isset($_POST['pass_administrateur'])) 
{
	if (htmlspecialchars($_POST['pass_administrateur']) == $pass_admin)
	{
		session_start();
		$_SESSION['Sess_nom'] = 'Administrateur';
		header("Location: accueil_admin.php");
	}
	else
	{
		$bad_password = 1;
	}
}

$titre_page = "Login Administrateur";
$meta_description = "Page de login pour les administrateurs";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Administrateur</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Connection à l'espace Administrateur</p>
			</div>
		</div>
		<div class="row jumbotron">
			<div class="col">
				<?php 
				if ($bad_password == 1)
				{
					echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
				} ?>
				<form name="form1" method="post" action="login_administrateur.php">
					<div class="form-group form-row justify-content-center">
						<div class="col-4">
							<label for="pass_administrateur">Entrer votre mot de passe</label>
							<input type="password" class="form-control" name="pass_administrateur" id="pass_administrateur" placeholder="Mot de passe">
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
require('include/footerAdministrateur.inc.php');
?>