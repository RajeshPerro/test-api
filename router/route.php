<?php
/*
 * Our route works as follow :
 * http:://HOST/test-api/index.php/{model_name}/{action_name}
 * model_name (without the word Model)}
 * {action_name} (from Controller)
 * */

//let's split the URL and restrict the access
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$userEndPoints = isset($uri[3]) && $uri[3] == 'user';
$tripEndPoints = isset($uri[3]) && $uri[3] == 'trips';
$reserveEndPoints = isset($uri[3]) && $uri[3] == 'reserve';

//for all invalid request set the response
$response  = json_encode(array('error' => 'Nothing Found!', 'status'=>'404'));

if ((!$userEndPoints && !$reserveEndPoints && !$tripEndPoints)
    || (!isset($uri[4]) || $uri[4] == '')) {
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
elseif($tripEndPoints){
    $objFeedController = new TripsController();
    $method_to_call = $uri[4].'Action';
    $objFeedController->{$method_to_call}();
}
elseif($reserveEndPoints){
    $objFeedController = new ReservationDetailsController();
    $method_to_call = $uri[4].'Action';
    $objFeedController->{$method_to_call}();
}
else{
    header('Content-Type: application/json');
    header("HTTP/1.1 404 Not Found");
    echo $response;
    exit();
}

?>