<?php
// UTILISATION : echo breadcrumbs();

function breadcrumbs($separator = ' / ', $home = 'Accueil') {

$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
$base_url = substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['HTTP_HOST'] . '/';
$breadcrumbs = array("<a href=\"$base_url\">$home</a>");
$tmp = array_keys($path);
$last = end($tmp);
unset($tmp);

foreach ($path as $x => $crumb) {
$title = ucfirst(str_replace(array('index', '.php', '_'), array('', '', ' '), $crumb));
if ($x == 1){
$breadcrumbs[]  = "<a href=\"$base_url$crumb\">$title</a>";
}elseif ($x > 1 && $x < $last){
$tmp = "<a href=\"$base_url";
for($i = 1; $i <= $x; $i++){
$tmp .= $path[$i] . '/';
}
$tmp .= "\">$title</a>";
$breadcrumbs[] = $tmp;
unset($tmp);
}else{
$breadcrumbs[] = "$title";
}
} 

return  rawurldecode(implode($separator, $breadcrumbs));

} 
 

// exemple chmod_R( 'mydir', 0666, 0777);
function chmod_R($path, $filemode, $dirmode) {
    if (is_dir($path) ) {
        if (!chmod($path, $dirmode)) {
            $dirmode_str=decoct($dirmode);
            print "Failed applying filemode '$dirmode_str' on directory '$path'\n";
            print "  `-> the directory '$path' will be skipped from recursive chmod\n";
            return;
        }
        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if($file != '.' && $file != '..') {  // skip self and parent pointing directories
                $fullpath = $path.'/'.$file;
                chmod_R($fullpath, $filemode,$dirmode);
            }
        }
        closedir($dh);
    } else {
        if (is_link($path)) {
            print "link '$path' is skipped\n";
            return;
        }
        if (!chmod($path, $filemode)) {
            $filemode_str=decoct($filemode);
            print "Failed applying filemode '$filemode_str' on file '$path'\n";
            return;
        }
    }
}


//connexion
function connexion(){
	// vérifier l'existence de la base avant la connexion

$link = mysqli_connect($serveur, $login, $password, $base, $port);
$info ="";
if (!$link) {
    $info= "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
    $info.= "<br>Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
    $info.= "<br>Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$query = "CREATE DATABASE IF NOT EXISTS ". $database_conn_intranet ." CHARACTER SET utf8mb4 "; 

if (mysqli_query($link, $query)) {
    $info.= "<br>Base de données créée correctement\n" . PHP_EOL;

} else {
    $info.= '<br>Erreur lors de la création de la base de données : ' . mysqli_connect_error() . PHP_EOL . "\n";
}
// fin de la vérification l'existence de la base avant la connexion
}

function creer_base($servername, $username, $password, $base, &$retour){
	        
	try{
		$dbco = new PDO("mysql:host=$servername", $username, $password);
		$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "CREATE DATABASE IF NOT EXISTS ". $base ." CHARACTER SET utf8mb4 ";
		$dbco->exec($sql);
		
		$retour= 'Base de données créée correctement !';

	}
	
	catch(PDOException $e){
		$retour= "Erreur : " . $e->getMessage();

	}
	
	return $retour;	
			
}
?>

