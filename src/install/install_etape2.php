<?php
$titre_page = "Etape 2 de l'installation de stockpotatoes";
$meta_description = "Définition des paramètres de connexion à la base de donnée";
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
							<p class="h3 bg-info text-center p-3" style="margin-top: 50px;">Etape 2/5</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<form name="parametres" method="post" action="install_base.php">
							<blockquote class="p-3">
								<table border="0" align="center" cellspacing="3" cellpadding="5">
									<tr> 
									  <td colspan="2" align="center">
											<p class="h5">
												Nous avons attribu&eacute; des droits en &eacute;criture aux dossiers <b>Exercices</b> et <b>Connections</b>. <br />
												Nous allons maintenant param&eacute;trer l'acc&egrave;s &agrave; la base de donn&eacute;es.
											</p>
											<p class="h5 bg-dark text-white text-center p-2"><?php echo $meta_description ?></p>											
									  </td>
									</tr>
									<tr> 
										<td width="50%"><b>Serveur MySQL:</b><br />
											Adresse IP ou URL de votre serveur de bases de données MySQL. La valeur <font color="#0000FF"><strong>localhost</strong></font> conviendra dans le cas d'un Intranet<br />
										</td>
										<td width="50%"><input type="texte" id="serveur" name="serveur" size="25" maxlength="80" value="localhost"></td>
									</tr>
									<tr> 
										<td width="50%"><b>Nom d'utilisateur MySQL :</b><br />
										La valeur <strong><font color="#0000FF">root</font></strong> conviendra dans le cas d'un Intranet.<br />
										Chez votre hébergeur, ce sera <strong><font color="#990033">votre login</font></strong></td>
										<td width="50%"><input type="text" id="username" name="login" size="25" maxlength="80" value="root"></td>
									</tr>
									<tr> 
										<td width="50%"><b>Mot de passe MySQL :</b><br />
											<font color="#0000FF"><strong>Pas de mot de passe</strong></font> par d&eacute;faut dans le cas d'un Intranet.<br />
											Chez votre hébergeur, ce sera <strong><font color="#990000">votre password</font></strong>
										</td>
										<td width="50%"><input type="password" id="password" name="password" size="25" maxlength="80" ></td>
									</tr>
									<tr> 
										<td width="50%"><b>Nom de la base de données :</b><br />
											Conservez la valeur <strong><font color="#0000FF">stockpotatoes</font></strong> dans le cas d'un Intranet ou dans le cas où vous ne disposez pas encore d'une base.<br />
											Chez votre hébergeur, ce sera &agrave; nouveau <strong><font color="#990000">votre login</font></strong>.
										</td>
										<td width="50%"><input name="base" type="text" id="base2" value="stockpotatoes" size="25" maxlength="80"></td>
									</tr>
									<tr> 
										<td width="50%"><p><b>Nom du port de la base de données :<br></b> Avec Maria db 10, la valeur est <strong><font color="#0000FF">3307</font></strong></p></td>
										<td width="50%"> <input name="port" type="text" id="port1" value="3307" size="8" maxlength="80"></td>
									</tr>
									<tr> 
										<td colspan="2" align="center">
											<p class="text-center"> 
												<button type="submit" name="verif" class="btn btn-primary">Enregistrer ces paramètres et passer à l'étape suivante</button>
											</p>
										</td>
									</tr>
								</table>
							</blockquote>	
						</form>
					</div><!--/.jumbotron -->
				</div><!--/.container -->
			</article>
		</section>
	</div><!-- fin class=col-lg-12 -->
</div><!-- fin class row -->
<?php
require('include/footer.inc.php');
?>        