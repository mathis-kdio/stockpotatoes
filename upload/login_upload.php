<?php 
include("../Connections/gestion_pass.inc.php");
if (isset($_POST['pass_upload'])) 
{
	if (htmlspecialchars($_POST['pass_upload']) == $pass_upload)
	{
		session_start();
		$_SESSION['Sess_nom'] = 'Upload';
		if (isset($_POST['cible'])) 
		{
			header("Location: ".htmlspecialchars($_POST['cible']).".php");
		}
		else
		{
			header("Location: upload_menu.php");
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
			$cible = 'upload_menu';
		}
		header("Location: login_upload.php?cible=".$cible."&pass=bad");
	}
}

$titre_page = "Login Upload";
$meta_description = "Page de login pour accéder à la page upload";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="";
$css_deplus = "";

require('include/headerUpload.inc.php');
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<h1>Espace Upload</h1>
		</div>
		<div class="row">
			<div class="col-3">
				<img class="img-fluid rounded mx-auto d-block" src="../patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
			</div>
			<div class="col-9 align-middle">
				<p class="h3 bg-warning text-center p-3" style="margin-top: 50px;">Connection à l'espace Upload</p>
			</div>
		</div>
		<div class="row jumbotron">
			<div class="col">
				<?php 
				if (htmlspecialchars($_GET['pass']) == 'bad')
				{
					echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
				} ?>
				<form name="form1" method="post" action="login_upload.php">
					<div class="form-group form-row justify-content-center">
						<div class="col-4">
							<label for="pass_upload">Entrer votre mot de passe</label>
							<input type="password" class="form-control" name="pass_upload" id="pass_upload" placeholder="Mot de passe">
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
	</div>
</div>
<?php
require('include/footerUpload.inc.php');
?>
