<?php require_once('Connections/conn_intranet.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$colpass_rsLogin = "1";
$valider="";

$collog_rsLogin = "1";
if (isset($_POST['log'])) 
{
  $collog_rsLogin = (get_magic_quotes_gpc()) ? $_POST['log'] : addslashes($_POST['log']);
}
$colpass_rsLogin = "1";
if (isset($_POST['pass']))
{
  $colpass_rsLogin = (get_magic_quotes_gpc()) ? $_POST['pass'] : addslashes($_POST['pass']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rsLogin = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom, stock_eleve.classe, stock_eleve.pass FROM stock_eleve WHERE stock_eleve.ID_eleve='%s' AND stock_eleve.pass='%s'", $collog_rsLogin, $colpass_rsLogin);
$rsLogin = mysqli_query($conn_intranet, $query_rsLogin) or die(mysqli_error());
$row_rsLogin = mysqli_fetch_assoc($rsLogin);
$totalRows_rsLogin = mysqli_num_rows($rsLogin);

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve  ";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error());
$row_rsClasse = mysqli_fetch_assoc($rsClasse);

$choix_classe_rsLogin2 = "1";
if (isset($_POST['classe'])) 
{
  $choix_classe_rsLogin2 = (get_magic_quotes_gpc()) ? $_POST['classe'] : addslashes($_POST['classe']);
}

$query_rsLogin2 = sprintf("SELECT stock_eleve.ID_eleve, stock_eleve.nom, stock_eleve.prenom FROM stock_eleve WHERE stock_eleve.classe='%s'", $choix_classe_rsLogin2);
$rsLogin2 = mysqli_query($conn_intranet, $query_rsLogin2) or die(mysqli_error());
$row_rsLogin2 = mysqli_fetch_assoc($rsLogin2);

$bad_password = 0;
if ((isset($_POST['valider'])) && ($_POST['valider']=="ok"))
{
	if ($totalRows_rsLogin=='1')
	{
		session_start();
		$_SESSION['Sess_ID_eleve'] = $row_rsLogin['ID_eleve'];
		$_SESSION['Sess_identifiant'] = $row_rsLogin['identifiant'];
		$_SESSION['Sess_nom'] = $row_rsLogin['nom'];
		$_SESSION['Sess_prenom'] = $row_rsLogin['prenom'];
		$_SESSION['Sess_classe'] = $row_rsLogin['classe'];
		$_SESSION['Sess_niveau'] = $row_rsLogin['niveau'];	
		header('Location: accueil_eleve.php?matiere_ID=3&ID_niveau='.$_SESSION['Sess_niveau'].'&Submit=Valider');
	}
	else
	{
		$bad_password = 1;
	}
}
else
{
	$erreurlog=1;
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Identification de l'élève</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Page login élève pour être évalué">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<header>
			<div class="center">
				<img src="patate.gif" width="45" height="41"><img src="stockpotatoes.png" width="324" height="39"> 
			</div>
		</header>
		<section class="">
			<h3 class="border center shadow">Espace Elève - Mode Evaluation - Identification de l'élève</h3>
			<div class="border shadow"> 
				<form name="form2" method="post" action="login_eleve.php">
					<h4 class="text-center">Sélectionnez votre classe</h4>
					<div class="center">
						<select name="classe" id="classe" class="text-center">
						  <option value="classe" <?php if (isset($_POST['classe'])) {
							if (!(strcmp("classe", $_POST['classe']))) {echo "SELECTED";} }?>>Sélectionner votre classe
							</option>
							<?php 
						  	$classe=0;
							do {  
							?>
								<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($_POST['classe'])) { if (!(strcmp($row_rsClasse['classe'], $_POST['classe']))) {echo "SELECTED";}} ?>>
									<?php echo $row_rsClasse['classe']?>
								</option>
								<?php
							} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
							$rows = mysqli_num_rows($rsClasse);
							if($rows > 0)
							{
							 	mysqli_data_seek($rsClasse, 0);
								$row_rsClasse = mysqli_fetch_assoc($rsClasse);
							}?>
						</select>
					</div>
					<div class="center">
					  <input type="submit" name="Submit2" value="Validez">
				  </div>
				</form>
			</div>
			<br/><br/>
			<?php if (isset($_POST['classe'])) 
			{ ?>
				<div class="border shadow">
					<form name="form1" method="post" action="login_eleve.php">
					  	<h4 class="text-center">Sélectionnez votre nom</h4>
					  	<div class="center">
						    <select name="log" id="log" class="text-center">
								<?php
								do { ?>
									<option value="<?php echo $row_rsLogin2['ID_eleve']?>">
										<?php echo $row_rsLogin2['nom']." ".$row_rsLogin2['prenom']?>
									</option>
									<?php
								} while ($row_rsLogin2 = mysqli_fetch_assoc($rsLogin2));
								$rows = mysqli_num_rows($rsLogin2);
								if($rows > 0)
								{
									mysqli_data_seek($rsLogin2, 0);
									$row_rsLogin2 = mysqli_fetch_assoc($rsLogin2);
								}?>
						    </select> 
						</div>
					    <h4 class="text-center">Tapez votre mot de passe</h4>
					    <?php 
					    if ($bad_password == 1)
					    {
					    	echo '<h4 class="text-center" style="color:red">MOT DE PASSE INCORRECT</h4>';
					    } ?>
					    <div class="center">
							<input name="pass" type="password" id="pass"><br><br><br/><br/>
						</div>
						<div class="center">
						    <input type="submit" name="Submit" value="Validez">
						  	<input name="valider" type="hidden" id="valider" value="ok">
						  	<input name="classe" type="hidden" id="classe" value="<?php echo $_POST['classe']?>">
					  	</div>
					</form>
				</div>
			<?php } ?>
			<br/><br/>
			<div class="border shadow">
				<h3 class="text-center">TUTO pour se connecter et conseils pour utiliser le site:</h3>
				<p></p>
			</div>
		</section>
		<footer>
			
		</footer>
	</body>
</html>