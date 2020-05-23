<?php
require_once('Connections/conn_intranet.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$collog_rsLogin = "1";
if (isset($_POST['log'])) 
{
  $collog_rsLogin = htmlspecialchars($_POST['log']);
}
$colpass_rsLogin = "1";
if (isset($_POST['pass']))
{
  $colpass_rsLogin = htmlspecialchars($_POST['pass']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rsLogin = sprintf("SELECT * FROM stock_eleve WHERE ID_eleve = '%s' AND pass = '%s'", $collog_rsLogin, $colpass_rsLogin);
$rsLogin = mysqli_query($conn_intranet, $query_rsLogin) or die(mysqli_error());
$row_rsLogin = mysqli_fetch_assoc($rsLogin);
$totalRows_rsLogin = mysqli_num_rows($rsLogin);

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error());
$row_rsClasse = mysqli_fetch_assoc($rsClasse);

$choix_classe_rsLogin2 = "1";
if (isset($_POST['classe'])) 
{
  $choix_classe_rsLogin2 = htmlspecialchars($_POST['classe']);
}

$query_rsLogin2 = sprintf("SELECT ID_eleve, nom, prenom FROM stock_eleve WHERE classe = '%s' ORDER BY nom", $choix_classe_rsLogin2);
$rsLogin2 = mysqli_query($conn_intranet, $query_rsLogin2) or die(mysqli_error());
$row_rsLogin2 = mysqli_fetch_assoc($rsLogin2);

$bad_password = 0;
if ((isset($_POST['valider'])) && ($_POST['valider'] == "ok"))
{
	if ($totalRows_rsLogin == '1')
	{
		session_start();
		$_SESSION['Sess_ID_eleve'] = $row_rsLogin['ID_eleve'];
		$_SESSION['Sess_identifiant'] = $row_rsLogin['identifiant'];
		$_SESSION['Sess_nom'] = $row_rsLogin['nom'];
		$_SESSION['Sess_prenom'] = $row_rsLogin['prenom'];
		$_SESSION['Sess_classe'] = $row_rsLogin['classe'];
		$_SESSION['Sess_niveau'] = $row_rsLogin['niveau'];	
		header('Location: accueil_eleve.php?matiere_ID=1&niveau_ID='.$_SESSION['Sess_niveau'].'&Submit=Valider');
	}
	else
	{
		$bad_password = 1;
	}
}
else
{
	$erreurlog = 1;
}

$titre_page = "Identification de l'élève";
$meta_description = "Page login élève pour être évalué";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$css_deplus = "";
require('includes/header.inc.php');

?>
<div class="row mt-3">
	<div class="col bg-warning text-center shadow">
		<h3 class="">Espace Elève - Mode Evaluation - Identification de l'élève</h3>
	</div>
</div>
<div class="row pt-2 pb-2 mt-3 shadow bg-warning justify-content-center"> 
	<form name="form2" method="post" action="login_eleve.php">
		<div class="form-group">
			<label for="classe">Sélectionnez votre classe</label>
			<select class="form-control" name="classe" id="classe">
				<?php 
				do {  
				?>
					<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";}} ?>>
						<?php echo $row_rsClasse['classe']?>
					</option>
					<?php
				} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)); ?>
			</select>
		</div>
		<div class="form-group">
			<button type="submit" name="Submit2" class="btn btn-primary">Valider</button>
	  	</div>
	</form>
</div>
<br/><br/>
<?php if (isset($_POST['classe'])) 
{ ?>
	<div class="row mt-3 shadow bg-warning justify-content-center">
		<form name="form1" method="post" action="login_eleve.php">
			<div class="form-group">
			    <label for="log">Sélectionnez votre nom</label>
			    <select class="form-control" name="log" id="log">
					<?php
					do { ?>
						<option value="<?php echo $row_rsLogin2['ID_eleve']?>">
							<?php echo $row_rsLogin2['nom']." ".$row_rsLogin2['prenom']?>
						</option>
						<?php
					} while ($row_rsLogin2 = mysqli_fetch_assoc($rsLogin2)); ?>
			    </select> 
			</div>
			<?php 
			if ($bad_password == 1)
			{
			  	echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
			} ?>
			<div class="form-group">
    			<label for="pass">Tapez votre mot de passe</label>
    			<input type="password" class="form-control" name="pass" id="pass" placeholder="Mot de passe">
  			</div>
  			<div class="form-group">
				<button type="submit" name="Submit" class="btn btn-primary">Valider</button>
				<input name="valider" type="hidden" id="valider" value="ok">
				<input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
			</div>
		</form>
	</div>
<?php }

require('includes/footer.inc.php');
?>