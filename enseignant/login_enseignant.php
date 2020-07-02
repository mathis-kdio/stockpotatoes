<?php
include("../Connections/gestion_pass.inc.php");
if (isset($_POST['pass_enseignant'])) 
{
	if (htmlspecialchars($_POST['pass_enseignant']) == $pass_profs)
	{
		session_start();
		$_SESSION['Sess_nom'] = 'Enseignant';
		if (isset($_POST['cible'])) 
		{
			header("Location: ".htmlspecialchars($_POST['cible']).".php");
		}
		else
		{
			header("Location: accueil_enseignant.php");			
		}
	}
	else
	{
		if (isset($_POST['cible']))
		{
			$cible = htmlspecialchars($_POST['cible']);
		}
		else
		{
			$cible = 'accueil_enseignant';
		}
		header("Location: login_enseignant.php?cible=".$cible."&pass=bad");
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
	<div class="col">
		<?php 
		if (isset($_GET['pass']) && htmlspecialchars($_GET['pass']) == 'bad')
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
			<?php
			if (isset($_GET['cible']))
			{
				echo '<input type="hidden" name="cible" id="cible" value="'.htmlspecialchars($_GET['cible']).'">';
			} ?>
		</form>
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php');
?>