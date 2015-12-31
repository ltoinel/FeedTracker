<?php

/**
 * Service REST retournant le nombre de lecteurs
 *
 * @author     Ludovic Toinel
 * @copyright  2015 Geeek.org
 * @license    http://www.gnu.org/licenses/gpl-3.0.fr.html
 * @link       https://www.geeek.org/php-calculer-lecteurs-rss-013.html
 */
 
require_once("conf.php");

// Connexion à la base de données.
$bdd = new PDO('mysql:host='+$db_host+';dbname='+$db_name, $db_user, $db_pass, array(
    PDO::ATTR_PERSISTENT => true
));

// Comptage du nombre de lecteurs.
$req = $bdd->prepare('SELECT count(distinct(reader_id)) as readerCount,count(distinct(ip)) as ipCount  FROM `stats` where read_time > (NOW() - INTERVAL 30 DAY)');
$req->execute();
$rows = $req->fetchAll(PDO::FETCH_ASSOC);

// Retour de résultat sous forme de flux JSON
header('Content-Type: application/json');
echo json_encode ($rows[0]);
