<?php
$titre_page = "Installation du Serveur Etape 2";
$meta_description = "Paramétrage de l'éditeur";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="../fonctions.js";
$css_deplus = "";
require('include/fonctions.inc.php');
require('include/header.inc.php');

if (isset($_POST['url_base	'] )) { $url_base = $_POST['url_base'] ;} else {$url_base='';}
if (isset($_POST['chemin_images'])) {$chemin_images	= $_POST['chemin_images'] ;} else {$chemin_images='';}
if (isset($_POST['chemin_editeur'])) {$chemin_editeur = $_POST['chemin_editeur'] ;} else {$chemin_editeur='';}


touch("../Connections/conn_editeur.inc.php");
$fichier1='../Connections/conn_editeur.inc.php';
chmod($fichier1,0777);

function EcrireFichier($url_base,$chemin_images,$chemin_editeur) {
	
		$fp = @fopen("../Connections/conn_editeur.inc.php", "w")
			or die ("<b>Le fichier Connections/conn_editeur.php n'a pas pu être ouvert. Vérifiez que vous possédez les droits en écriture sur ce fichier. </b>");
		$data = "<?PHP\n";
		$data.= " \$url_base = \"".$_POST['url_base']."\";\n";
                $data.= " \$chemin_images = \"". $_POST['chemin_images']."\";\n";
		$data.= " \$chemin_editeur	= \"".$_POST['chemin_editeur']."\";\n";
		$data.= "\n";
		$data.= "?>";
		$desc = @fwrite($fp, $data) or die ("<b>Erreur > Ecriture du fichier de configuration ! </b>");
		@fclose($fp) or die ("<b>Erreur > Fermeture du fichier </b>");
}

EcrireFichier($url_base,$chemin_images,$chemin_editeur)  ;

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
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;"><?php echo $meta_description ?></p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<blockquote>
							<table class="table table-striped table-bordered">
							  <tr> 
								<td>
								  <p align="center"><strong>Vos param&egrave;tres ont &eacute;t&eacute; enregistr&eacute;s. </strong></p>
								  <blockquote>
									<div class="m-3 text-center">
									  <p class="h3 alert alert-success">✔️ FIN DE L'INSTALLATION</p>
									  <p>Si vous avez d&eacute;j&agrave; install&eacute; Stockpotatoes et venez simplement de modifier le param&eacute;trage de l'&eacute;diteur, ignorez les &eacute;tapes ci-dessous. </p>
									  <p><strong>Il vous reste &agrave; cr&eacute;er dans <a class="shadow btn btn-secondary" href="../administrateur/accueil_admin.php" target="_blank">🧑‍💻 l'espace administrateur :</a></strong></p>
									</div>
									<ul class="m-3">
									  <li>
										<div class="m-3"><strong><a class="shadow btn btn-secondary" href="../administrateur/gestion_matiere_niveau.php" target="_blank">📚 les mati&egrave;res et les niveaux</a></strong></div>
									  </li>
									  <li>
										<div class="m-3"><strong><a class="shadow btn btn-secondary" href="../administrateur/gestion_eleve_txt.php" target="_blank">🧑‍🤝‍🧑 la liste des &eacute;l&egrave;ves</a></strong></div>
									  </li>
									</ul>
									<p><strong>Puis enfin <a href="../presentation/config.php" target="_blank">param&eacute;trer convenablement le logiciel Hotpotatoes</a> permettant de r&eacute;aliser les exercices.</strong></p>
									<p><strong>Chaque enseignant pourra alors<a href="../enseignant/gestion_theme.php" target="_blank"> cr&eacute;er ses th&egrave;mes d'&eacute;tude</a> au sein de sa mati&egrave;re et envoyer sur le serveur ses premiers exercices.</strong></p>
									<p class="h4 text-center m-3">S&eacute;curit&eacute;</p>
									<p class="h5 text-center m-3">A la fin de l'installation, vous pouvez prot&eacute;ger - ou supprimer -<span class="badge badge-secondary"> le dossier &quot;install&quot; </span> afin d'&eacute;viter un acte malveillant tel la r&eacute;installation du logiciel et par voie de cons&eacute;quence, le vidage de la base stockpotatoes.</p>
									<p class=" h5 text-center m-3"><a class="shadow btn btn-success" href="../index.php">☝️ Accueil Stockpotatoes</a> - <a class="shadow btn btn-info" href="../administrateur/accueil_admin.php">🧑‍💻 Espace administrateur</a> - <a class="shadow btn btn-warning" href="../enseignant/accueil_enseignant.php">👩‍🧑‍🏫 Espace Enseignant</a></p>
								  </blockquote>
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
