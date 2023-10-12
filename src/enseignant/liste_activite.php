<?php
session_start();
if (isset($_SESSION['Sess_nom']))
{
	if ($_SESSION['Sess_nom'] <> 'Enseignant')
	{
		header("Location: login_enseignant.php?cible=liste_activite");
	}
}
else
{
	header("Location: login_enseignant.php?cible=liste_activite");
}

require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

$currentPage = $_SERVER["PHP_SELF"];
$maxRows_RsActivite = 40;
$pageNum_RsActivite = 0;
if (isset($_GET['pageNum_RsActivite']))
{
	$pageNum_RsActivite = htmlspecialchars($_GET['pageNum_RsActivite']);
}

$startRow_RsActivite = $pageNum_RsActivite * $maxRows_RsActivite;
$maxRows_RsActivite = 40;
$pageNum_RsActivite = 0;
if (isset($_GET['pageNum_RsActivite']))
{
	$pageNum_RsActivite = htmlspecialchars($_GET['pageNum_RsActivite']);
}
$startRow_RsActivite = $pageNum_RsActivite * $maxRows_RsActivite;

$query_RsActivite = "SELECT * FROM stock_activite, stock_eleve, stock_quiz WHERE stock_activite.eleve_ID=stock_eleve.ID_eleve AND stock_activite.quiz_ID= stock_quiz.ID_quiz  ORDER BY ID_activite DESC";
$query_limit_RsActivite = sprintf("%s LIMIT %d, %d", $query_RsActivite, $startRow_RsActivite, $maxRows_RsActivite);
$RsActivite = mysqli_query($conn_intranet, $query_limit_RsActivite) or die(mysqli_error($conn_intranet));

if (isset($_GET['totalRows_RsActivite']))
{
	$totalRows_RsActivite = htmlspecialchars($_GET['totalRows_RsActivite']);
}
else
{
	$all_RsActivite = mysqli_query($conn_intranet, $query_RsActivite);
	$totalRows_RsActivite = mysqli_num_rows($all_RsActivite);
}
$totalPages_RsActivite = ceil($totalRows_RsActivite / $maxRows_RsActivite) - 1;

$query_Rs_matiere = "SELECT * FROM stock_matiere";
$Rs_matiere = mysqli_query($conn_intranet, $query_Rs_matiere) or die(mysqli_error($conn_intranet));

while ($row_Rs_matiere = mysqli_fetch_assoc($Rs_matiere))
{ 
	$libel_mat[$row_Rs_matiere['ID_mat']] = $row_Rs_matiere['nom_mat'];
}

$query_Rs_niveau = "SELECT * FROM stock_niveau";
$Rs_niveau = mysqli_query($conn_intranet, $query_Rs_niveau) or die(mysqli_error($conn_intranet));

while ($row_Rs_niveau = mysqli_fetch_assoc($Rs_niveau))
{ 
	$libel_niveau[$row_Rs_niveau['ID_niveau']] = $row_Rs_niveau['nom_niveau'];
}

$query_Rs_theme = "SELECT * FROM stock_theme";
$Rs_theme = mysqli_query($conn_intranet, $query_Rs_theme) or die(mysqli_error($conn_intranet));
$row_Rs_theme = mysqli_fetch_assoc($Rs_theme);

while ($row_Rs_theme = mysqli_fetch_assoc($Rs_theme))
{ 
	$libel_theme[$row_Rs_theme['ID_theme']] = $row_Rs_theme['theme'];
}

$queryString_RsActivite = "";
if (!empty($_SERVER['QUERY_STRING']))
{
	$params = explode("&", $_SERVER['QUERY_STRING']);
	$newParams = array();
	foreach ($params as $param)
	{
		if (stristr($param, "pageNum_RsActivite") == false && stristr($param, "totalRows_RsActivite") == false)
		{
			array_push($newParams, $param);
		}
	}
	if (count($newParams) != 0)
	{
		$queryString_RsActivite = "&" . implode("&", $newParams);
	}
}
$queryString_RsActivite = sprintf("&totalRows_RsActivite=%d%s", $totalRows_RsActivite, $queryString_RsActivite);

$titre_page = "Résultats des dernères activités réalisées";
$meta_description = "Page des résultats des dernères activités réalisées";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus = "";
$css_deplus = "";
require('includes/headerEnseignant.inc.php');
?>

<div class="row align-items-center justify-content-center">
	<div class="col-auto">
		<?php if ($pageNum_RsActivite > 0)
		{ // Show if not first page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, 0, $queryString_RsActivite); ?>"><img src="First.gif" border=0></a> 
			<?php 
		} // Show if not first page ?>
	</div>
	<div class="col-auto">
		<?php
		if ($pageNum_RsActivite > 0)
		{ // Show if not first page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, max(0, $pageNum_RsActivite - 1), $queryString_RsActivite); ?>"><img src="Previous.gif" border=0></a> 
			<?php
		} // Show if not first page ?>
	</div>
	<div class="col-auto">
		<?php
		if ($pageNum_RsActivite < $totalPages_RsActivite)
		{ // Show if not last page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, min($totalPages_RsActivite, $pageNum_RsActivite + 1), $queryString_RsActivite); ?>"><img src="Next.gif" border=0></a> 
			<?php
		} // Show if not last page ?>
	</div>
	<div class="col-auto">
		<?php
		if ($pageNum_RsActivite < $totalPages_RsActivite)
		{ // Show if not last page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, $totalPages_RsActivite, $queryString_RsActivite); ?>"><img src="Last.gif" border=0></a> 
			<?php
		} // Show if not last page ?>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-sm">
		<thead>
			<tr> 
				<th scope="col">N° Eleve</th>
				<th scope="col">Elève</th>
				<th scope="col">Classe</th>
				<th scope="col">Matière</th>
				<th scope="col">Niveau</th>
				<th scope="col">Thème d'étude</th>
				<th scope="col">Titre</th>
				<th scope="col">Note /20</th>
				<th scope="col">Date début</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row_RsActivite = mysqli_fetch_assoc($RsActivite))
			{ ?>
				<tr>
					<td><?php echo $row_RsActivite['eleve_ID']; ?></td>
					<td><?php echo $row_RsActivite['nom']; ?> <?php echo $row_RsActivite['prenom']; ?></td>
					<td><?php echo $row_RsActivite['classe']; ?></td>
					<td><?php echo $libel_mat[$row_RsActivite['matiere_ID']];?></td>
					<td><?php echo $libel_niveau[$row_RsActivite['niveau_ID']];?></td>
					<td>
						<?php 
						if (isset($libel_theme[$row_RsActivite['theme_ID']]) && $row_RsActivite['theme_ID'] != 0)
						{
							echo $libel_theme[$row_RsActivite['theme_ID']];
						}
						else
						{
							echo 'Divers'; 
						}?>	
					</td>
					<td><?php echo $row_RsActivite['titre']; ?></td>
					<td><?php echo $row_RsActivite['score']; ?></td>
					<td><?php echo $row_RsActivite['debut']; ?></td>
				</tr>
				<?php 
			} ?>
		</tbody>
	</table>
</div>
<div class="row align-items-center justify-content-center">
	<div class="col-auto">
		<?php if ($pageNum_RsActivite > 0)
		{ // Show if not first page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, 0, $queryString_RsActivite); ?>"><img src="First.gif" border=0></a> 
			<?php
		} // Show if not first page ?>
	</div>
	<div class="col-auto">
		<?php
		if ($pageNum_RsActivite > 0)
		{ // Show if not first page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, max(0, $pageNum_RsActivite - 1), $queryString_RsActivite); ?>"><img src="Previous.gif" border=0></a> 
			<?php
		} // Show if not first page ?>
	</div>
	<div class="col-auto">
		<?php
		if ($pageNum_RsActivite < $totalPages_RsActivite)
		{ // Show if not last page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, min($totalPages_RsActivite, $pageNum_RsActivite + 1), $queryString_RsActivite); ?>"><img src="Next.gif" border=0></a> 
			<?php
		} // Show if not last page ?>
	</div>
	<div class="col-auto">
		<?php
		if ($pageNum_RsActivite < $totalPages_RsActivite)
		{ // Show if not last page ?>
			<a href="<?php printf("%s?pageNum_RsActivite=%d%s", $currentPage, $totalPages_RsActivite, $queryString_RsActivite); ?>"><img src="Last.gif" border=0></a> 
			<?php
		} // Show if not last page ?> 
	</div>
</div>
<?php
require('includes/footerEnseignant.inc.php');


mysqli_free_result($RsActivite);
mysqli_free_result($Rs_matiere);
mysqli_free_result($Rs_niveau);
mysqli_free_result($Rs_theme); ?>