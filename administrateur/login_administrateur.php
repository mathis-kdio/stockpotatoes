<?php
include("../Connections/gestion_pass.inc.php");
if (isset($_POST['pass_administrateur'])) 
{
	if (htmlspecialchars($_POST['pass_administrateur']) == $pass_admin)
	{
		session_start();
		$_SESSION['Sess_nom'] = 'Administrateur';
		if (isset($_POST['cible'])) 
		{
			header("Location: ".htmlspecialchars($_POST['cible']).".php");
		}
		else
		{
			header("Location: accueil_admin.php");
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
			$cible = 'accueil_admin';
		}
		header("Location: login_administrateur.php?cible=".$cible."&pass=bad");
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
	<div class="col">
		<?php 
		if (isset($_GET['pass']) && htmlspecialchars($_GET['pass']) == 'bad')
		{
			echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
		} ?>
		<form name="form1" method="post" action="login_administrateur.php">
			<div class="form-group form-row justify-content-center">
				<div class="col-4">
					<label for="pass_administrateur">Entrer votre mot de passe</label>
					<input type="password" class="form-control" name="pass_administrateur" id="pass_administrateur" placeholder="Mot de passe" required>
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
require('include/footerAdministrateur.inc.php');
?>