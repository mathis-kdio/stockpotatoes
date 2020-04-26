<?php
$serveur		= $_POST['serveur'] ;
$login			= $_POST['login'] ;
$password		= $_POST['password'] ;
$base			= $_POST['base'] ;
$port			= $_POST['port'] ;

$titre_page = "Etape 3 de l'installation de stockpotatoes";
$meta_description = "Paramètres de connexion à la base de donnée";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="fonctions.js";
$css_deplus = "";

require('include/fonctions.inc.php');

$info_de_suivi="";

$filename1 = "../Connections/conn_intranet.php";
if (touch($filename1)) {
	$info_de_suivi=  "1. Création du fichier de connexion réussie. <br> \n";
	$fichier1='../Connections/conn_intranet.php';
	//chmod($fichier1,0777);
	chmod_R( $fichier1, 0777, 0777);
} else {
    $info_de_suivi= "Impossible de créer le fichier " . $filename1 ."<br> \n";
}

$filename2 = "../Connections/gestion_pass.inc.php";
if (touch($filename2)) {
	$info_de_suivi.= "2. Création du fichier de gestion des mots de passe réussie. <br>\n";
	$fichier2='../Connections/gestion_pass.inc.php';
	//chmod($fichier1,0777);
	chmod_R( $fichier2, 0777, 0777);
} else {
  $info_de_suivi.= "Impossible de créer le fichier " . $filename2 ." <br>\n";
}


function EcrireFichier($serveur, $login, $password, $base , $port="3306" ) {
	
		$fp = @fopen("../Connections/conn_intranet.php", "w")
			or die ("<b>Le fichier Connections/conn_intranet.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
		$data = "<?PHP\n";
		$data.= " \$hostname_conn_intranet = \"".$serveur."\";\n";
		$data.= " \$username_conn_intranet = \"".$login."\";\n";
		$data.= " \$password_conn_intranet = \"".$password."\";\n";
		$data.= " \$database_conn_intranet = \"". $base."\";\n";
		$data.= " \$port_database_conn_intranet = \"". $port."\";\n";
		$data.= " \$conn_intranet = mysqli_connect(\"p:\".\$hostname_conn_intranet, \$username_conn_intranet, \$password_conn_intranet, \$database_conn_intranet, \$port_database_conn_intranet );\n";
		$data.= " if (!\$conn_intranet) { die('Erreur de connexion (' . mysqli_connect_errno() . ') '. mysqli_connect_error());} \n";
		$data.= " \$info_de_suivi2= '3. Succès de la connexion à ' . mysqli_get_host_info(\$conn_intranet); \n";
		$data.= " mysqli_set_charset(\$conn_intranet, 'utf8mb4');\n";
		$data.= "\n";
		$data.= "?>";
		$desc = @fwrite($fp, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp) or die ("<b>Erreur > Fermeture du fichier </b>");

		$fp2 = @fopen("../Connections/gestion_pass.inc.php", "w")
			or die ("<b>Le fichier Connections/gestion_pass.inc.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
		$data = "<?PHP\n";
		$data.= " \$pass_profs = \"tuteur\";\n";
        $data.= " \$pass_admin = \"maitre\";\n";
		$data.= " \$pass_upload = \"hotpot\";\n";
		$data.= "\n";
		$data.= "?>";
	    $desc = @fwrite($fp2, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp2) or die ("<b>Erreur > Fermeture du fichier </b>");

}
EcrireFichier($serveur, $login, $password , $base ,$port="3306");


require_once('../Connections/conn_intranet.php');
require('include/header.inc.php');
?>
<div class="row">
	<div class="col-lg-12">
		<section>
			<header>
				<h1><?php echo $titre_page ?></h1>
			</header>
			<article>
				<div class="container">
					<div class="row">
						<div class="col-lg-3">
							<img class="img-fluid rounded mx-auto d-block"  src="images/patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
						</div>
						<div class="col-lg-9 align-middle">
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;">Etape 3/5</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<blockquote class="p-3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<p class ="alert alert-info"><?php echo $info_de_suivi ?></p>
										<p class ="alert alert-info"><?php echo $info_de_suivi2 ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<p class="text-center">La connexion &agrave; la base de donn&eacute;e</p>
										<p class="text-center"><span class="btn btn-success"><b><?php echo $base ?></b></span></p>
										<p class="text-center">est maintenant r&eacute;alis&eacute;e avec vos param&egrave;tres.</p>
										<p class ="alert alert-info m-3">Il est temps maintenant d'installer les tables...</p>
										<p align="center"> 
											<input name="Submit2" type="submit" onClick="MM_goToURL('parent','install_tables.php');return document.MM_returnValue" value="Ma base est d&eacute;j&agrave; existante - Cr&eacute;er uniquement les tables">
										</p>
									</td>
								</tr>
							</table>
						</blockquote>
					</div><!--/.jumbotron -->
				</div><!--/.container -->
			</article>
		</section>
	</div><!-- fin class=col-lg-12 -->
</div><!-- fin class row -->
<?php
require('include/footer.inc.php');
?>
