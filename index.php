<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/20/22
 * Time: 9:16 PM
 */
require __DIR__ . "/config/autoload.php";

$db = new DB();
$dbConnect = $db->dbConnect;

$query = $dbConnect->prepare("SELECT * FROM `users`");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
print_r(json_encode($result));

//let's split the URL and restrict the access
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$userEndPoints = isset($uri[3]) && $uri[3] == 'user';
$reserveEndPoints = isset($uri[3]) && $uri[3] == 'reserve';

if ((!$userEndPoints && !$reserveEndPoints) || (!isset($uri[4]) || $uri[4] == '')) {
    header("HTTP/1.1 404 Not Found");
    exit();
}