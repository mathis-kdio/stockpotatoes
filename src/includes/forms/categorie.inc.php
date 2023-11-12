<?php
require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

$listeCategorie = mysqli_prepare($conn_intranet, "SELECT ID_categorie, nom_categorie FROM stock_categorie WHERE mat_ID = ? AND niv_ID = ? ORDER BY pos_categorie") or exit(mysqli_error($conn_intranet));
mysqli_stmt_bind_param($listeCategorie, "ii", $matiereId, $niveauId);
mysqli_stmt_execute($listeCategorie);
mysqli_stmt_bind_result($listeCategorie, $row_rs_categorie['id'], $row_rs_categorie['categorie']);

?>

<form name="formCategorie" method="GET">
	<div class="form-group row align-items-center justify-content-center">
		<label for="categorie_ID" class="col-auto col-form-label">Catégorie :</label>
		<div class="col-auto">
			<select name="categorie_ID" id="selectCategorie" class="custom-select" required>
				<?php
				if (mysqli_stmt_num_rows($listeCategorie) != 1) { ?>
					<option disabled selected value="">Veuillez choisir une catégorie</option>
					<?php 
				}
				while (mysqli_stmt_fetch($listeCategorie)) { ?>
					<option value="<?php echo $row_rs_categorie['id']?>"<?php if (isset($categorieId)) { if (!(strcmp($row_rs_categorie['id'], $categorieId))) {echo "SELECTED";} }?>><?php echo $row_rs_categorie['categorie']?></option>
					<?php
				}?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
  <input type="hidden" name="matiere_ID" value="<?php echo $matiereId; ?>">
	<input type="hidden" name="niveau_ID" value="<?php echo $niveauId; ?>">
  <input type="hidden" name="theme_ID" value="<?php echo $themeId; ?>">
</form>

<?php
mysqli_stmt_close($listeCategorie);
?>