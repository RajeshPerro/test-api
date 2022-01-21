<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/20/22
 * Time: 9:16 PM
 */
require __DIR__ . "/config/autoload.php";

//let's split the URL and restrict the access
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$userEndPoints = isset($uri[3]) && $uri[3] == 'user';
$reserveEndPoints = isset($uri[3]) && $uri[3] == 'reserve';

//for all invalid request
$response  = json_encode(array('error' => 'Nothing Found!', 'status'=>'404'));

if ((!$userEndPoints && !$reserveEndPoints) || (!isset($uri[4]) || $uri[4] == '')) {
    header('Content-Type: application/json');
    header("HTTP/1.1 404 Not Found");
    echo $response;
    exit();
}

//manage routing
if($userEndPoints){
    $objFeedController = new UserController();
    $method_to_call = $uri[4].'Action';
    $objFeedController->{$method_to_call}();
}
elseif($reserveEndPoints){
    header('Content-Type: application/json');
    header("HTTP/1.1 404 Not Found");
    echo $response;
    exit();
}
else{
header('Content-Type: application/json');
header("HTTP/1.1 404 Not Found");
echo $response;
exit();
}

?>