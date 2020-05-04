<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../Connections/conn_intranet.php'); 
mysqli_select_db($conn_intranet, $database_conn_intranet) or die(mysqli_error($conn_intranet));
$query = "
CREATE TABLE IF NOT EXISTS `stock_activite` (
  `ID_activite` smallint(5) unsigned NOT NULL auto_increment,
  `eleve_ID` smallint(6) NOT NULL default '0',
  `identifiant` varchar(250) NOT NULL default '',
  `nom_classe` varchar(50) NOT NULL default '',
  `quiz_ID` smallint(5) unsigned NOT NULL default '0',
  `score` smallint(6) NOT NULL default '0',
  `debut` varchar(255) NOT NULL default '',
  `fin` varchar(255) NOT NULL default '',
  `fait` enum('N','O') NOT NULL default 'N',
  PRIMARY KEY  (`ID_activite`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$query = "
CREATE TABLE IF NOT EXISTS `stock_categorie` (
  `ID_categorie` smallint(5) NOT NULL auto_increment,
  `nom_categorie` varchar(250) NOT NULL default '',
  `mat_ID` tinyint(4) NOT NULL default '0',
  `niv_ID` tinyint(4) NOT NULL default '0',
  `theme_ID` tinyint(4) NOT NULL default '0',
  `pos_categorie` smallint(5) NOT NULL default '1', 
  PRIMARY KEY  (`ID_categorie`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$query = "
CREATE TABLE IF NOT EXISTS `stock_eleve` (
  `ID_eleve` smallint(5) unsigned NOT NULL auto_increment,
  `identifiant` varchar(250) NOT NULL default '',
  `nom` varchar(50) NOT NULL default '',
  `prenom` varchar(50) NOT NULL default '',
  `classe` varchar(50) NOT NULL default '',
  `pass` varchar(10) NOT NULL default 'eleve',
  `niveau` tinyint(5) NOT NULL,
  PRIMARY KEY  (`ID_eleve`),
  UNIQUE (`identifiant`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$query = "
CREATE TABLE IF NOT EXISTS `stock_matiere` (
  `ID_mat` tinyint(4) NOT NULL auto_increment,
  `nom_mat` varchar(50) NOT NULL default '',
  `theme` varchar(255) default NULL,
  PRIMARY KEY  (`ID_mat`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$query = "
CREATE TABLE IF NOT EXISTS `stock_niveau` (
  `ID_niveau` tinyint(4) NOT NULL auto_increment,
  `nom_niveau` varchar(255) NOT NULL default '',
  `pos_niv` smallint(5) unsigned NOT NULL default '1', 

  PRIMARY KEY  (`ID_niveau`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$query = "
CREATE TABLE IF NOT EXISTS `stock_quiz` (
  `ID_quiz` smallint(5) unsigned NOT NULL auto_increment,
  `titre` varchar(255) NOT NULL default 'Sans titre',
  `fichier` varchar(255) NOT NULL default '',
  `matiere_ID` tinyint(4) NOT NULL default '0',
  `niveau_ID` tinyint(4) NOT NULL default '0',
  `theme_ID` smallint(6) default NULL,
  `categorie_ID` tinyint(4) NOT NULL default '0',
  `auteur` varchar(50) default NULL,
  `en_ligne` char(1) NOT NULL default 'N',
  `avec_score` char(1) NOT NULL default 'N',
  `evaluation_seul` char(1) NOT NULL default 'N',
  `type_doc` TINYINT ( 3 ) UNSIGNED DEFAULT '2' NOT NULL,
  `cat_doc` TINYINT ( 3 ) UNSIGNED DEFAULT '2' NOT NULL,
  `pos_doc` SMALLINT( 5 ) UNSIGNED DEFAULT '1' NOT NULL,

  PRIMARY KEY  (`ID_quiz`)
) ENGINE=INNODB AUTO_INCREMENT=0 ;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$query = "
CREATE TABLE IF NOT EXISTS `stock_theme` (
  `ID_theme` smallint(5) unsigned NOT NULL auto_increment,
  `theme` varchar(255) NOT NULL default '',
  `mat_ID` tinyint(4) NOT NULL default '0',
  `niv_ID` tinyint(4) NOT NULL default '0',
  `pos_theme` smallint(5) UNSIGNED DEFAULT '1',
  `date_apparition` date NOT NULL,
  `date_disparition` date NOT NULL,

  PRIMARY KEY  (`ID_theme`)
) ENGINE=INNODB AUTO_INCREMENT=0;";

$result = mysqli_query($conn_intranet, $query) or die(mysqli_error($conn_intranet));

$titre_page = "Installation des tables";

$meta_description = "Le distributeur de patates chaudes";
$meta_keywords = "outils, ressources, exercices en ligne, hotpotatoes";
$js_deplus="fonctions.js";
$css_deplus = "";

require('include/fonctions.inc.php');
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
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;">Etape 4/5</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<blockquote class="p-3">				
							<div class="h5 text-center">La cr&eacute;ation des tables a &eacute;t&eacute; effectu&eacute;e dans votre base de donn&eacute;es.</div>
							<div class="h5 text-center">Il vous faut maintenant paramétrer l'&eacute;diteur Html en ligne (FCKeditor).</div>
							<div class="h5 text-center">Si des difficult&eacute;s survenaient &agrave; l'utilisation de cet &eacute;diteur, vous pourrez revenir sur ces param&egrave;tres dans l'espace Administrateur </div>
							<p class="text-center m-3">
								<input name="Submit" type="submit" onClick="MM_goToURL('parent','install_editeur.php');return document.MM_returnValue" value="Param&eacute;trage de l'&eacute;diteur Html en ligne">
							</p>
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
