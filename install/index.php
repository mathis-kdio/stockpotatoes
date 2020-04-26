<?php
$titre_page = "Etape 1 de l'installation de stockpotatoes ";
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
				<h1><?php echo $titre_page?></h1>
			</header>
			<article>
				<div class="container">
					
					<div class="row">
						<div class="col-lg-3">
							<img class="img-fluid rounded mx-auto d-block"  src="images/patate.png" alt="hotpotatoes" title="hotpotatoes" height="150" width="150" />
						</div>
						<div class="col-lg-9 align-middle">
							<p class="h3 bg-secondary text-center p-3" style="margin-top: 50px;">Etape 1/5</p>
						</div>
					</div>
					<div class="jumbotron m-3">
						<form action="install_etape3.php" method="post" name="parametres">
							<blockquote class="p-3">	
								
								<p class="h5 text-center">( La phase la plus d&eacute;licate pour les d&eacute;butants ! Courage ;)</p>
								<ul>
									<li><span>Vous avez d&eacute;compress&eacute; votre archive et copi&eacute; le dossier <strong>stockpotatoes</strong> sur le serveur. Pour &eacute;viter les difficult&eacute;s de param&eacute;trages ult&eacute;rieurs,<strong> il est en effet pref&eacute;rable de conserver ce nom de dossier stockpotatoes et de le copier &agrave; la racine de votre serveur.</strong> </span></li>
								</ul>
								<div class="text-left m-2">
									<img class="img-fluid rounded mx-auto d-block" src="images/arbo.gif" height="126" width="136"  />
									<p class="m-3">
										Vos exercices seront rang&eacute;s ult&eacute;rieurement et automatiquement dans un dossier <strong>Exercices</strong> selon le mod&egrave;le d'arborescence ci-dessus. Trois fichiers de param&egrave;trages seront enregistr&eacute;s dans le dossier <strong>Connections</strong>.
									</p>
								</div>
								<div class="text-left m-2">
									<p class="m-3">
										<ul>
											<li>👉 Vous devez donc poss&eacute;der par d&eacute;faut les droits en &eacute;criture sur ces deux dossiers.</li>
											<li>👉 Si vous avez fait une<strong> installation en local</strong>, vous devez poss&eacute;der par d&eacute;faut les droits en &eacute;criture n&eacute;cessaires. Vous pouvez donc<strong> passer &agrave; l'&eacute;tape 2.</strong></li>
											<li>👉 Si vous utilisez un <strong>h&eacute;bergeur type Free, serveur acad&eacute;mique, OVH, Amen ou autres,</strong> lisez attentivement le<strong> paragraphe ci-dessous.</strong></li>
										</ul>
									</p>
								</div>	
								<p class="text-center">
									<input name="Submit2" type="submit" onClick="MM_goToURL('parent','install_etape2.php');return document.MM_returnValue" value="Passer &agrave; l'&eacute;tape 2">
								</p>
							</blockquote>
							<blockquote>
								<div class="h3 alert alert-secondary text-center">DROITS EN ECRITURE</div>
								<div class="text-left">
									<p>Vous devez poss&eacute;der les droits en &eacute;criture sur les dossiers <strong>Exercices et Connections</strong>.</p>
									<p>Les deux fichiers ci-dessous seront cr&eacute;&eacute;s &agrave; l'installation (Etape 3) avec attribution des droits en &eacute;criture (chmod 777) par le script. (droits &agrave; v&eacute;rifier en cas de probl&egrave;mes).</p>
								</div>
								<ul>
									<li>👉 Le fichier <strong>Connections/gestion_pass.inc.php</strong> (mots de passe)</li>
									<li>👉 Le fichier <strong>Connections/conn_intranet.php</strong> (param&egrave;tres de connection)</li>
								</ul>
								<p class="h5 alert alert-info p-3 text-center">Pour cr&eacute;er les droits en &eacute;criture sur les dossiers <strong>Exercices et Connections</strong>, vous avez deux possibilit&eacute;s :</p>
								<div class="table-responsive text-left">
									<table class="table table-bordered">
										<tbody>
											<tr class="h5 bg-dark text-white text-center">
												<td class="align-middle">
													<p>Effectuer manuellement l'op&eacute;ration avec votre Outil FTP</p>
												</td>
												<td class="align-middle">
												<p>Effectuer l'op&eacute;ration avec un script Php</p>
												</td> 
											</tr>
											<tr class="bg-white text-dark">
												<td class="align-middle">
													<p>
														Par exemple, clic droit sur le dossier Exercices puis Propri&eacute;t&eacute;s<br />
														👉 Vous cochez tout de fa&ccedil;on &agrave; avoir tous les droits 👉 (chmod 777)
													</p>
												</td>
												<td>
													<p>Je vous propose de tenter de modifier les droits via un Chmod 777. Cette op&eacute;ration ne fonctionne pas avec tous les h&eacute;bergeurs.En cas de probl&egrave;me, (messages d'erreurs renvoy&eacute;s par le serveur), il vous faudra attribuer<strong> ces droits manuellement</strong>.</p>
													<p class="text-center">
														<input name="Submit22" type="submit" onClick="MM_goToURL('parent','install_chmod.php');return document.MM_returnValue" value="Tenter de modifier les droits en &eacute;criture avec un Chmod">
													</p>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
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