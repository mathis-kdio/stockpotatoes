<?php
require_once('../Connections/conn_intranet.php');
mysqli_select_db($conn_intranet, $database_conn_intranet);

$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error($conn_intranet));

$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error($conn_intranet));
?>

<form name="form1" method="GET">
	<div class="form-group row align-items-center justify-content-center">
		<label for="matiere_ID" class="col-auto col-form-label">Matière :</label>
		<div class="col-auto">
			<select name="matiere_ID" id="select2" class="custom-select" required>
				<?php
				if (mysqli_num_rows($rs_matiere) != 1) { ?>
					<option disabled selected value="">Veuillez choisir une matière</option>
					<?php 
				}
				while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere)) { ?>
					<option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($matiereId)) { if (!(strcmp($row_rs_matiere['ID_mat'], $matiereId))) {echo "SELECTED";} }?>><?php echo $row_rs_matiere['nom_mat']?></option>
					<?php
				}
				if (mysqli_num_rows($rs_matiere) > 0) {
					mysqli_data_seek($rs_matiere, 0);
					$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
				} ?>
			</select>
		</div>
		<label for="niveau_ID" class="col-auto col-form-label">Niveau :</label>
		<div class="col-auto">
			<select name="niveau_ID" id="select" class="custom-select" required>
				<option disabled selected value="">Veuillez choisir un niveau</option>
				<?php
				while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau)) { ?>
					<option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($niveauId)) { if (!(strcmp($row_rs_niveau['ID_niveau'], $niveauId))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
					<?php
				}
				if (mysqli_num_rows($rs_niveau) > 0) {
					mysqli_data_seek($rs_niveau, 0);
					$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
				} ?>
			</select>
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-primary">Sélectionner</button>
		</div>
	</div>
</form>