<?php

trait Tools {

    public $uri = null;

    /**
     * This method is responsible to parse the URL and give us back an Array
     */
    public function parseURI(){
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uri = explode( '/', $this->uri );
        return  $this->uri;
    }

    /**
     * This method will give us the ID from the URL
     * eg. localhost/test-api/index.php/trip/get/2 : it will give us the '2'
     * in case of invalid data we will get 0
     * @return int
     */
    public function getIdFromURI():int{
        $id = 0;
        $url = $this->parseURI();
        if(isset($url[5]) && (int)$url[5] > 0){
            $id = (int)$url[5];
        }
        return (int)$id;
    }

    /**
     * This method is responsible to parse the request body which
     * we get with POST / PUT request as JSON and then we get back PHP array
     */
    public function parseRequestBody(){
        $request_body = file_get_contents('php://input');
        return json_decode($request_body,true);
    }

    /**
     * Any kind of server / database error we will show by using this method
     * @param string $message
     */
    public function serverError(string $message){
        header('500 Internal Server Error.');
        $error = json_encode(array('error' => 'Something went wrong! '.$message, 'success'=>false));
        echo $error;
        die;
    }
}