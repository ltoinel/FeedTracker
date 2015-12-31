<?php

/**
 * Tracker à inclure sous forme d'image dans votre template de flux RSS.
 * <img src="tracker.php?content_id=id_du_contenu" alt="tracker" />
 *
 * @author     Ludovic Toinel
 * @copyright  2015 Geeek.org
 * @license    http://www.gnu.org/licenses/gpl-3.0.fr.html
 * @link       https://www.geeek.org/php-calculer-lecteurs-rss-013.html
 */

require_once("conf.php");

// Extraction du referer si il existe
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

// On vérifie que l'identifiant du contenu en cours de lecture est bien passé en paramètre
if (!isset($_GET['content_id'])){
        die("Missing content id");
} else {
        $content_id = $_GET['content_id'];
}

// On vérifie l'id du lecteur stocké dans un cookie
if (!isset($_COOKIE["reader_id"])){
        $reader_id = uniqid('rid_');
        setcookie("reader_id", $reader_id, time()+60*60*24*365);
} else {
        $reader_id = $_COOKIE["reader_id"];
}

// On se connecte à la base de données
$bdd = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_pass, array(
    PDO::ATTR_PERSISTENT => true
));

// On insère une entrée indiquant qui a lu quel contenu à quelle heure
$req = $bdd->prepare('INSERT INTO stats(reader_id,content_id,ip,referer) VALUES(:reader_id, :content_id, :ip, :referer)');
$req->execute(array(
        'reader_id' => $reader_id,
        'content_id' => $content_id,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'referer' => $referer
        ));

// On redirige le navigateur avec une image transparente ou un logo
header("HTTP/1.1 301 Moved Permanently");
header('location: '.$image_url);
header("Connection: close");
