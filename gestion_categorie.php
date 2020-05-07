<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1); 
if (isset($_SESSION['Sess_nom'])) { 
	if ($_SESSION['Sess_nom']<>'Enseignant') { header("Location: login_enseignant.php");}
; } else { header("Location: ../index.php");}?>
<?php require_once('../Connections/conn_intranet.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsMax = "SELECT MAX(pos_categorie) AS resultat FROM stock_categorie ";
  $RsMax = mysqli_query($conn_intranet, $query_RsMax) or die(mysqli_error());
  $row_RsMax = mysqli_fetch_assoc($RsMax);
  $position=$row_RsMax['resultat']+1;

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO stock_categorie (ID_categorie, nom_categorie, mat_ID, niv_ID, pos_categorie) VALUES (%s, %s, %s, %s ,%s)",
                       GetSQLValueString($_POST['ID_categorie'], "int"),
                       GetSQLValueString($_POST['categorie'], "text"),
					             GetSQLValueString($_POST['mat_ID'], "int"),
                       GetSQLValueString($_POST['niv_ID'], "int"),
					             GetSQLValueString($position, "int")
					   );

  mysqli_select_db($conn_intranet, $database_conn_intranet);
  $Result1 = mysqli_query($conn_intranet, $insertSQL) or die(mysqli_error());
}

$choixmat_Rscategorie = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_Rscategorie = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
$choixniv_Rscategorie = "0";
if (isset($_GET['niveau_ID'])) {
  $choixniv_Rscategorie = (get_magic_quotes_gpc()) ? $_GET['niveau_ID'] : addslashes($_GET['niveau_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_Rscategorie = sprintf("SELECT * FROM stock_categorie WHERE stock_categorie.mat_ID=%s AND stock_categorie.niv_ID=%s ORDER BY stock_categorie.pos_categorie", $choixmat_Rscategorie,$choixniv_Rscategorie);
$Rscategorie = mysqli_query($conn_intranet, $query_Rscategorie) or die(mysqli_error());
$row_Rscategorie = mysqli_fetch_assoc($Rscategorie);
$totalRows_Rscategorie = mysqli_num_rows($Rscategorie);

$choixmat_RsChoixmatiere = "0";
if (isset($_GET['matiere_ID'])) {
  $choixmat_RsChoixmatiere = (get_magic_quotes_gpc()) ? $_GET['matiere_ID'] : addslashes($_GET['matiere_ID']);
}
mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_RsChoixmatiere = sprintf("SELECT * FROM stock_matiere WHERE stock_matiere.ID_mat=%s", $choixmat_RsChoixmatiere);
$RsChoixmatiere = mysqli_query($conn_intranet, $query_RsChoixmatiere) or die(mysqli_error());
$row_RsChoixmatiere = mysqli_fetch_assoc($RsChoixmatiere);
$totalRows_RsChoixmatiere = mysqli_num_rows($RsChoixmatiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_matiere = "SELECT * FROM stock_matiere ORDER BY stock_matiere.nom_mat";
$rs_matiere = mysqli_query($conn_intranet, $query_rs_matiere) or die(mysqli_error());
$row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
$totalRows_rs_matiere = mysqli_num_rows($rs_matiere);

mysqli_select_db($conn_intranet, $database_conn_intranet);
$query_rs_niveau = "SELECT * FROM stock_niveau";
$rs_niveau = mysqli_query($conn_intranet, $query_rs_niveau) or die(mysqli_error());
$row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
$totalRows_rs_niveau = mysqli_num_rows($rs_niveau);

?>
<html>
  <head>
    <title>Gestion des catégorie</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../style_jaune.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <p align="center"><strong><a href="../index.php">Accueil stockpotatoes</a> - <a href="accueil_enseignant.php">Espace Enseignant</a> - Gestion des catégorie d'&eacute;tude dans une mati&egrave;re</strong></p>

  <form name="form1" method="GET" action="gestion_categorie.php">
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
      <tr> 
        <td width="35%"><div align="right"> 
            <select name="matiere_ID" id="select2">
              <?php
              do {  
              ?>
                <option value="<?php echo $row_rs_matiere['ID_mat']?>"<?php if (isset($_GET['matiere_ID'])) { if (!(strcmp($row_rs_matiere['ID_mat'], $_GET['matiere_ID']))) {echo "SELECTED";} }  ?>><?php echo $row_rs_matiere['nom_mat']?></option>
                <?php
              } while ($row_rs_matiere = mysqli_fetch_assoc($rs_matiere));
              $rows = mysqli_num_rows($rs_matiere);
              if($rows > 0) {
                mysqli_data_seek($rs_matiere, 0);
            	  $row_rs_matiere = mysqli_fetch_assoc($rs_matiere);
              }
            ?>
            </select>
          </div></td>
        <td width="21%"><div align="center"> 
            <select name="niveau_ID" id="select">
              <?php
              do {  
              ?>
                <option value="<?php echo $row_rs_niveau['ID_niveau']?>"<?php if (isset($_GET['niveau_ID'])) { if (!(strcmp($row_rs_niveau['ID_niveau'], $_GET['niveau_ID']))) {echo "SELECTED";} } ?>><?php echo $row_rs_niveau['nom_niveau']?></option>
                          <?php
              } while ($row_rs_niveau = mysqli_fetch_assoc($rs_niveau));
              $rows = mysqli_num_rows($rs_niveau);
              if($rows > 0)
              {
                mysqli_data_seek($rs_niveau, 0);
            	  $row_rs_niveau = mysqli_fetch_assoc($rs_niveau);
              } ?>
            </select>
          </div></td>
        <td width="44%"> <input type="submit" name="Submit3" value="S&eacute;lectionner"></td>
        <td width="44%"><div align="center"><font size="6"><strong> 
        <?php 
    	  if (isset($_GET['matiere_ID'])) { 
    	  echo $row_RsChoixmatiere['nom_mat']; }
    	  ?>
        </strong></font></div></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
  <?php  if (isset($_GET['matiere_ID'])) {   



  ?>
  <div align="center"> 
    <p><font size="6"></font></p>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td valign="top">
  	<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
          <p align="center"><strong>Ins&eacute;rer une nouvelle catégorie d'&eacute;tude 
            pour cette mati&egrave;re</strong></p>
          <table align="center">
            <tr valign="baseline"> 
              <td><input type="text" name="categorie" value="" size="48"></td>
            </tr>
            <tr valign="baseline"> 
              <td> <p align="center"><br>
                  <input name="submit" type="submit" value="Enregistrer cette nouvelle catégorie d'&eacute;tude ">
                </p></td>
            </tr>
          </table>
          <p> 
            <input type="hidden" name="ID_categorie" value="">
            <input type="hidden" name="mat_ID" value="<?php echo $_GET['matiere_ID'] ?>">
            <input type="hidden" name="niv_ID" value="<?php echo $_GET['niveau_ID'] ?>">
            <input type="hidden" name="MM_insert" value="form2">
            <input type="hidden" name="ID_mat2" id="ID_mat3" value="<?php echo $_POST['ID_mat'] ?>">
          </p>
          <p>&nbsp; </p>
      </form></td>
      <td width="8%" rowspan="2">&nbsp;</td>
      <td rowspan="2" valign="top"> <div align="center"> 
          <table border="1">
            <tr> 
              <td bgcolor="#CCCC99"> <div align="center"><strong>N&deg;</strong></div></td>
              <td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99"><div align="center"><strong>Catégorie d'&eacute;tude</strong></div></td>
              <td bgcolor="#CCCC99">&nbsp;</td>
              <td bgcolor="#CCCC99">&nbsp;</td>
            </tr>
            <?php 
  			$x=0;
  		 do {
  		  $x=$x+1;
  		  $tabpos1[$x]=$row_Rscategorie['pos_categorie'];$tabid1[$x]=$row_Rscategorie['ID_categorie'];
          	   } while ($row_Rscategorie = mysqli_fetch_assoc($Rscategorie)); 
  			   
  		 if ($totalRows_Rscategorie !=0)
  		
  		  {
  		  mysqli_data_seek($Rscategorie,0);		
  	      $row_Rscategorie = mysqli_fetch_assoc($Rscategorie);
  		  $t1=$x; $x=0;

  		  do { 
  		  
  		    $x=$x+1; 
  		  ?>
            <tr valign="top" class="retrait20"> 
              <td class="retrait20"><?php echo $row_Rscategorie['ID_categorie']; ?></td>
          <td bgcolor="#CCCC99" >
  			  <?php if($x!=1) { ?>            
  			  <?php echo '<form style="margin:0px" name="Remonter" method="post" action="remonter_categorie.php?matiere_ID=';?>
  			  <?php echo $_GET['matiere_ID']?>
  			  <?php echo '&niveau_ID=';?>
  			  <?php echo $_GET['niveau_ID']; ?>
  			  <?php echo '"><input name="niveau_ID" type="hidden" id="niveau_ID" value="';?>
  			  <?php echo $_GET['niveau_ID']; ?>
  			  <?php echo '"><div align="center"><input name="ID_categorie" type="hidden" id="ID_categorie" value="';?>
  			  <?php echo $row_Rscategorie['ID_categorie'] ?>
  			  
  			  <?php echo '"><input name="ID_precedent" type="hidden" id="ID_precedent" value="';?>
  			  <?php echo $tabid1[$x-1] ?>
  			  <?php echo '"><input name="pos_precedent" type="hidden" id="pos_precedent" value="';?>
  			  <?php echo $tabpos1[$x-1] ?>
  			  <?php echo '"><input name="Remonter" type="hidden" value="Remonter"><input type="image" src="images/up.gif" alt="Remonter ce thème "></div>';?>
                <?php echo ' </form>';
  			   
  			     } else {echo '&nbsp;';};?>	
  			
  		    </td>
  			  <td bgcolor="#CCCC99">
  			  
  			   
  			   <?php if($x!=$t1) { ?>            
  			  <?php echo '<form style="margin:0px" name="Descendre" method="post" action="descendre_categorie.php?matiere_ID=';?>
  			  <?php echo $_GET['matiere_ID']?>
  			  <?php echo '&niveau_ID=';?>
  			  <?php echo $_GET['niveau_ID']; ?>
  			  <?php echo '"><div align="center"><input name="ID_categorie" type="hidden" id="ID_categorie" value="';?>
  			  <?php echo $row_Rscategorie['ID_categorie'] ?>
  			  
  			  <?php echo '"><input name="ID_suivant" type="hidden" id="ID_suivant" value="';?>
  			  <?php echo $tabid1[$x+1] ?>
  			  <?php echo '"><input name="pos_suivant" type="hidden" id="pos_suivant" value="';?>
  			  <?php echo $tabpos1[$x+1] ?>
  			  <?php echo '"><input name="Descendre" type="hidden" value="Descendre"><input type="image" src="images/down.gif" alt="Descendre ce thème "></div>';?>
                <?php echo ' </form>';
  			   } else {echo '&nbsp;';};?>	
  			  </td>
              <td class="retrait20"><?php echo $row_Rscategorie['nom_categorie']; ?></td>
              <td> 
                <form name="form4" style="margin:0px" method="post" action="verif_supp_categorie.php">
                  <input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_Rscategorie['ID_categorie'] ?>">
                  <input type="submit" name="Submit" value="Supprimer">
                </form>
              </td>
              <td> 
                <form name="form3" style="margin:0px" method="post" action="modif_categorie.php">
                  <input name="ID_categorie" type="hidden" id="ID_categorie" value="<?php echo $row_Rscategorie['ID_categorie'] ?>">
                  <input type="submit" name="Submit2" value="Modifier">
                </form>
              </td>
            </tr>
            <?php 
  		  } while ($row_Rscategorie = mysqli_fetch_assoc($Rscategorie));
      } //du if totalrow different de zero 
        ?>
         </table>
        </div></td>
    </tr><tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
  <p align="center"><a href="../index.php">Accueil Stockpotatoes</a> - <a href="../enseignant/accueil_enseignant.php">Espace Enseignant</a> - <a href="../administrateur/login_administrateur.php">Espace Administrateur</a></p>
  <p align="center"><a href="../upload/upload_menu.php">Envoyer un exercice ou un document sur le serveur</a></p>
  <p align="right">&nbsp;</p>
  <?php  }   ?>
  </body>
</html>
<?php
mysqli_free_result($Rscategorie);

mysqli_free_result($RsChoixmatiere);

mysqli_free_result($rs_matiere);

mysqli_free_result($rs_niveau);
?>