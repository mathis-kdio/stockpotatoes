<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Administrateur')
	{ 
		header("Location: login_administrateur.php?cible=gestion_eleve");
	}
} 
else
{
	header("Location: login_administrateur.php?cible=gestion_eleve");
}
require_once('../Connections/conn_intranet.php'); 

if (isset($_POST['prenom'])) {
	$prenom = htmlspecialchars($_POST['prenom']);
}
if (isset($_POST['nom'])) {
	$nom = htmlspecialchars($_POST['nom']);
}
if (isset($_POST['classe'])) {
	$classe = htmlspecialchars($_POST['classe']);
}
if (isset($_POST['pass'])) {
	$pass = htmlspecialchars($_POST['pass']);
}
if (isset($_POST['niveau'])) {
	$niveau = htmlspecialchars($_POST['niveau']);
}
if (isset($_POST['ID_eleve'])) {
	$ID_eleve = htmlspecialchars($_POST['ID_eleve']);
}
if (isset($_POST['numeleve'])) {
	$numeleve = htmlspecialchars($_POST['numeleve']);
}
if (isset($_GET['numsupeleve'])) {
	$numsupeleve = htmlspecialchars($_GET['numsupeleve']);
}

mysqli_select_db($conn_intranet, $database_conn_intranet);

//GENERATION DE L'IDENTIFIANT QUI DOIT ETRE UNIQUE
if (isset($prenom) && isset($nom)) 
{
	$query_IdentifiantEleve = "SELECT * FROM stock_eleve ORDER BY identifiant";
	$IdentifiantEleve = mysqli_query($conn_intranet, $query_IdentifiantEleve) or die(mysqli_error($conn_intranet));
	$row_IdentifiantEleve = mysqli_fetch_assoc($IdentifiantEleve);
	$identifiant = strtolower($nom . $prenom );

	$idtmp = $identifiant;
	$i = 0;
	do
	{
		if ($row_IdentifiantEleve['identifiant'] == $idtmp) 
		{
			$idtmp = $identifiant;
			$i++;
			$idtmp = strtolower($idtmp . $i);
		}

	}while ($row_IdentifiantEleve = mysqli_fetch_assoc($IdentifiantEleve));
}

//AJOUT D'UN ÉLÈVE AVEC CRÉATION D'UNE NOUVELLE CLASSE
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
{
	$insertSQL = sprintf("INSERT INTO stock_eleve (ID_eleve, identifiant, nom, prenom, classe, pass, niveau) VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s')", $idtmp, $nom, $prenom, $classe, $pass, $niveau);

	$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));
}

//INSERER UN ELEVE DANS UNE CLASSE EXISTANTE
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3"))
{
	$insertSQL = sprintf("INSERT INTO stock_eleve (ID_eleve, identifiant, nom, prenom, classe, pass, niveau) VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s')", $idtmp, $nom, $prenom, $classe, $pass, $niveau);

	$Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error($conn_intranet));
}

//MODIFICATION D'UN NOM OU CLASSE D'UN ÉLÈVE
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form5"))
{
	$updateSQL = sprintf("UPDATE stock_eleve SET nom = '%s', prenom = '%s', classe = '%s', pass = '%s', niveau = '%s' WHERE ID_eleve = '%s'", $nom, $prenom, $classe, $pass, $niveau, $ID_eleve);

	$Result1 = mysqli_query($conn_intranet, $updateSQL) or die(mysqli_error($conn_intranet));
}

//SUPPRESSION D'ÉLÈVES
if ((isset($numsupeleve)) && ($numsupeleve != ""))
{
	$deleteSQL = sprintf("DELETE FROM stock_eleve WHERE ID_eleve = '%s'", $numsupeleve);

	$Result1 = mysqli_query($conn_intranet, $deleteSQL) or die(mysqli_error($conn_intranet));

	header("Location: confirm_supp_eleve.php");
}

$query_RsEleve = "SELECT * FROM stock_eleve";
$RsEleve = mysqli_query($conn_intranet, $query_RsEleve) or die(mysqli_error($conn_intranet));
$row_RsEleve = mysqli_fetch_assoc($RsEleve);

$query_rsClasse = "SELECT DISTINCT classe FROM stock_eleve ORDER BY classe DESC";
$rsClasse = mysqli_query($conn_intranet, $query_rsClasse) or die(mysqli_error($conn_intranet));
$row_rsClasse = mysqli_fetch_assoc($rsClasse);

$choixclasse_RsChoixClasse = "0";
if (isset($classe))
{
	$choixclasse_RsChoixClasse = $classe;
}
$query_RsChoixClasse = sprintf("SELECT * FROM stock_eleve WHERE classe = '%s' ORDER BY nom", $choixclasse_RsChoixClasse);
$RsChoixClasse = mysqli_query($conn_intranet, $query_RsChoixClasse) or die(mysqli_error($conn_intranet));
$row_RsChoixClasse = mysqli_fetch_assoc($RsChoixClasse);

$nomclasse_RsAjout = "0";
if (isset($classe))
{
	$nomclasse_RsAjout = $classe;
}
$query_RsAjout = sprintf("SELECT * FROM stock_eleve WHERE classe = '%s'", $nomclasse_RsAjout);
$RsAjout = mysqli_query($conn_intranet, $query_RsAjout) or die(mysqli_error($conn_intranet));
$row_RsAjout = mysqli_fetch_assoc($RsAjout);

$nomclasse_Rschoixeleve = "0";
if (isset($classe))
{
	$nomclasse_Rschoixeleve = $classe;
}
$query_Rschoixeleve = sprintf("SELECT * FROM stock_eleve WHERE classe = '%s'", $nomclasse_Rschoixeleve);
$Rschoixeleve = mysqli_query($conn_intranet, $query_Rschoixeleve) or die(mysqli_error($conn_intranet));
$row_Rschoixeleve = mysqli_fetch_assoc($Rschoixeleve);

$numeleve_RsModifEleve = "0";
if (isset($numeleve))
{
	$numeleve_RsModifEleve = $numeleve;
}
$query_RsModifEleve = sprintf("SELECT * FROM stock_eleve WHERE ID_eleve = '%s'", $numeleve_RsModifEleve);
$RsModifEleve = mysqli_query($conn_intranet, $query_RsModifEleve) or die(mysqli_error($conn_intranet));
$row_RsModifEleve = mysqli_fetch_assoc($RsModifEleve);

$query_RsNiveau = "SELECT * FROM stock_niveau";
$RsNiveau = mysqli_query($conn_intranet, $query_RsNiveau) or die(mysqli_error($conn_intranet));
$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);


$titre_page = "Gestion des élèves";
$meta_description = "Page de gestion des élèves";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="";
$css_deplus = "";

require('include/headerAdministrateur.inc.php');

?>
<div class="row">
	<div class="col-7">
		<h4>Liste des élèves</h4>
		<form name="form2" style="margin:0px" method="post" action="gestion_eleve.php">
			<div class="form-group">
				<label for="select2">Sélectionnez une classe</label>
				<select name="classe" id="select2" class="custom-select">
					<?php
					do 
					{ ?>
						<option value="<?php echo $row_rsClasse['classe']?>"<?php if (isset($classe)) { if (!(strcmp($row_rsClasse['classe'], $classe))) {echo "SELECTED";}} ?>><?php echo $row_rsClasse['classe']?></option>
						<?php
					} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
					$rows = mysqli_num_rows($rsClasse);
					if($rows > 0)
					{
						mysqli_data_seek($rsClasse, 0);
						$row_rsClasse = mysqli_fetch_assoc($rsClasse);
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<button type="submit" name="Submit3" class="btn btn-primary">Sélectionner la classe</button>
			</div>
		</form>
		<div class="row">
			<div class="col table-responsive">
				<table class="table table-bordered table-striped table-sm">
					<thead>
						<tr> 
							<th scope="col">ID</th>
							<th scope="col">Identifiant</th>
							<th scope="col">Nom</th>
							<th scope="col">Prenom</th>
							<th scope="col">Classe</th>
							<th scope="col">Pass</th>
							<th scope="col">Niv</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						do
						{ ?>
							<tr> 
								<th scope="row"><?php echo $row_RsChoixClasse['ID_eleve']; ?></th>
								<td><?php echo $row_RsChoixClasse['identifiant']; ?></td>
								<td><?php echo $row_RsChoixClasse['nom']; ?></td>
								<td><?php echo $row_RsChoixClasse['prenom']; ?></td>
								<td><?php echo $row_RsChoixClasse['classe']; ?></td>
								<td><?php echo $row_RsChoixClasse['pass']; ?></td>
								<td><?php echo $row_RsChoixClasse['niveau']; ?></td>
							</tr>
							<?php 
						} while ($row_RsChoixClasse = mysqli_fetch_assoc($RsChoixClasse)); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-5"> 
		<div class="row">
			<div class="col">
				<h4>Insérer des élèves depuis un fichier</h4>
				<button name="Submit5" type="submit" class="btn btn-primary"  onClick="window.location = 'gestion_eleve_txt.php'">
					C'est par ici !
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h4>Ajout d'un élève dans une classe existante</h4>
				<form method="post" name="form3" action="gestion_eleve.php">
					<div class="form-group">
						<label for="nom">Nom :</label>
							<input type="text" class="form-control" name="nom" id="nom">
					</div>
					<div class="form-group">
						<label for="prenom">Prénom :</label>
							<input type="text" class="form-control" name="prenom" id="prenom">
					</div>
					<div class="form-group">
						<label for="classe">Classe :</label>
						<select name="classe" id="classe" class="custom-select">
							<?php
							do 
							{ ?>
								<option value="<?php echo $row_rsClasse['classe']?>"><?php echo $row_rsClasse['classe']?></option>
								<?php
							} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
							$rows = mysqli_num_rows($rsClasse);
							if($rows > 0)
							{
								mysqli_data_seek($rsClasse, 0);
								$row_rsClasse = mysqli_fetch_assoc($rsClasse);
							} ?>
						</select>
					</div>
					<div class="form-group">
						<label for="pass">Mot de passe :</label>
							<input type="text" class="form-control" name="pass" id="pass">
					</div>
					<div class="form-group">
						<label for="niveau">Niveau :</label>
						<select name="niveau" id="niveau" class="custom-select">
							<?php
							do 
							{ ?>
								<option value="<?php echo $row_RsNiveau['ID_niveau']?>"><?php echo $row_RsNiveau['nom_niveau']?></option>
								<?php
							} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
							$rows = mysqli_num_rows($RsNiveau);
							if($rows > 0)
							{
								mysqli_data_seek($RsNiveau, 0);
								$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
							} ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Ajouter cet(te) élève(e)</button>
					</div>
					<input type="hidden" name="ID_eleve" value="">
					<input type="hidden" name="MM_insert" value="form3">
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h4>Ajout d'un élève avec création d'une nouvelle classe</h4>
				<form method="post" name="form1" action="gestion_eleve.php">
					<div class="form-group">
						<label for="nom">Nom :</label>
							<input type="text" class="form-control" name="nom" id="nom">
					</div>
					<div class="form-group">
						<label for="prenom">Prénom :</label>
							<input type="text" class="form-control" name="prenom" id="prenom">
					</div>
					<div class="form-group">
						<label for="classe">Classe :</label>
						<input type="text" class="form-control" name="classe" id="classe">
					</div>
					<div class="form-group">
						<label for="pass">Mot de passe :</label>
							<input type="text" class="form-control" name="pass" id="pass">
					</div>
					<div class="form-group">
						<label for="niveau">Niveau :</label>
						<select name="niveau" id="niveau" class="custom-select">
							<?php
							do 
							{ ?>
								<option value="<?php echo $row_RsNiveau['ID_niveau']?>"><?php echo $row_RsNiveau['nom_niveau']?></option>
								<?php
							} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau));
							$rows = mysqli_num_rows($RsNiveau);
							if($rows > 0)
							{
								mysqli_data_seek($RsNiveau, 0);
								$row_RsNiveau = mysqli_fetch_assoc($RsNiveau);
							} ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Ajouter cet(te) élève(e)</button>
					</div>
					<input type="hidden" name="ID_eleve" value="">
					<input type="hidden" name="MM_insert" value="form1">
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h4>Suppression d'un élève</h4>
				<form name="form2" method="post" action="gestion_eleve.php">
					<div class="form-group">
						<label for="classe">Classe :</label>
						<select name="classe" id="classe" class="custom-select">
							<?php
							do 
							{ ?>
								<option value="<?php echo $row_rsClasse['classe']?>"<?php if(isset($classe)) { if (!(strcmp($row_rsClasse['classe'], $classe))) {echo "SELECTED";} }?>>
									<?php echo $row_rsClasse['classe']?>
								</option>
								<?php
							} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse));
							$rows = mysqli_num_rows($rsClasse);
							if($rows > 0)
							{
								mysqli_data_seek($rsClasse, 0);
								$row_rsClasse = mysqli_fetch_assoc($rsClasse);
							} ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" name="Submit4" class="btn btn-primary">Sélectionner la classe</button>
					</div>
				</form>
			</div>
		</div>
		<?php if (isset($classe))
		{ ?>
			<div class="row">
				<div class="col-10 offset-2">
					<form name="form4" method="get" action="gestion_eleve.php">
						<div class="form-group">
							<label for="select3">Elève :</label>
							<select name="numsupeleve" id="select3" class="custom-select">
								<?php
								do {  
								?>
									<option value="<?php echo $row_Rschoixeleve['ID_eleve']?>"<?php if(isset($numeleve)) { if (!(strcmp($row_Rschoixeleve['ID_eleve'], $numeleve))) {echo "SELECTED";} }?>><?php echo $row_Rschoixeleve['ID_eleve'].' '.$row_Rschoixeleve['nom'].' '.$row_Rschoixeleve['prenom']?></option>
									<?php
								} while ($row_Rschoixeleve = mysqli_fetch_assoc($Rschoixeleve));
								$rows = mysqli_num_rows($Rschoixeleve);
								if($rows > 0)
								{
									mysqli_data_seek($Rschoixeleve, 0);
									$row_Rschoixeleve = mysqli_fetch_assoc($Rschoixeleve);
								} ?>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" name="Submit22" class="btn btn-primary">Supprimer cet élève</button>
						</div>
						<input name="classe" type="hidden" id="select" value="<?php echo $classe?>">
					</form>
				</div>
			</div>
			<?php 
		}?>
		<div class="row">
			<div class="col">
				<h4>Modification d'un nom ou classe d'un élève</h4>
				<form name="form2"method="post" action="gestion_eleve.php">
					<div class="form-group">
						<label for="classe">Classe :</label>
						<select name="classe" id="classe" class="custom-select">
							<?php
							do
							{ ?>
								<option value="<?php echo $row_rsClasse['classe']?>"<?php if(isset($classe)) { if (!(strcmp($row_rsClasse['classe'], $classe))) {echo "SELECTED";} }?>>
									<?php echo $row_rsClasse['classe']?>
								</option>
								<?php
							} while ($row_rsClasse = mysqli_fetch_assoc($rsClasse)); ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" name="Submit" class="btn btn-primary">Sélectionner la classe</button>
					</div>
				</form>
			</div>
		</div>
		<?php if (isset($classe))
		{ ?>
			<div class="row">
				<div class="col-10 offset-2">
					<form name="form4" method="post" action="">
						<div class="form-group">
							<label for="numeleve">Elève :</label>
							<select name="numeleve" id="numeleve" class="custom-select">
								<?php
								do {  
								?>
									<option value="<?php echo $row_Rschoixeleve['ID_eleve']?>"<?php if(isset($numeleve)) { if (!(strcmp($row_Rschoixeleve['ID_eleve'], $numeleve)) ) {echo "SELECTED";} }?>>
										<?php echo $row_Rschoixeleve['ID_eleve'].' '.$row_Rschoixeleve['nom'].' '.$row_Rschoixeleve['prenom']?>
									</option>
									<?php
								} while ($row_Rschoixeleve = mysqli_fetch_assoc($Rschoixeleve)); ?>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" name="Submit2" class="btn btn-primary">Sélectionner l'élève</button>
						</div>
						<input name="classe" type="hidden" id="classe" value="<?php echo $classe?>">
					</form>
				</div>
			</div>
			<?php if (isset($numeleve))
			{ ?>
				<div class="row">
					<div class="col-8 offset-4">
						<form method="post" name="form5" action="gestion_eleve.php">
							<div class="form-group">
								<label for="nom">Nom :</label>
									<input type="text" class="form-control" name="nom" id="nom" value="<?php echo $row_RsModifEleve['nom']; ?>">
							</div>
							<div class="form-group">
								<label for="prenom">Prénom :</label>
									<input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo $row_RsModifEleve['prenom']; ?>">
							</div>
							<div class="form-group">
								<label for="classe">Classe :</label>
								<input type="text" class="form-control" name="classe" id="classe" value="<?php echo $row_RsModifEleve['classe']; ?>">
							</div>
							<div class="form-group">
								<label for="pass">Mot de passe :</label>
									<input type="text" class="form-control" name="pass" id="pass" value="<?php echo $row_RsModifEleve['pass']; ?>">
							</div>
							<div class="form-group">
								<label for="niveau">Niveau :</label>
								<select name="niveau" id="niveau" class="custom-select">
									<?php
									do 
									{ ?>
										<option value="<?php echo $row_RsNiveau['ID_niveau']?>" <?php if (!(strcmp($row_RsNiveau['ID_niveau'], $row_RsModifEleve['niveau'])) ) {echo "SELECTED";}?> ><?php echo $row_RsNiveau['nom_niveau']?></option>
										<?php
									} while ($row_RsNiveau = mysqli_fetch_assoc($RsNiveau)); ?>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Mettre à jour l'enregistrement</button>
							</div>
							<input type="hidden" name="ID_eleve" value="<?php echo $row_RsModifEleve['ID_eleve']; ?>">
							<input type="hidden" name="MM_update" value="form5">
							<input type="hidden" name="ID_eleve" value="<?php echo $row_RsModifEleve['ID_eleve']; ?>">
						</form>
					</div>
				</div>
				<?php 
			}
		} ?>
		</td>
	</div>
</div>
<?php
require('include/footerAdministrateur.inc.php');

mysqli_free_result($RsEleve);
mysqli_free_result($rsClasse);
mysqli_free_result($RsChoixClasse);
mysqli_free_result($RsAjout);
mysqli_free_result($Rschoixeleve);
mysqli_free_result($RsModifEleve);
?>