<?php

trait Tools {

    public $uri = null;

    public function parseURI(){
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uri = explode( '/', $this->uri );
        return  $this->uri;
    }

    /**
     * @return int
     */
    public function getIdFromURI():int{
        $id = 0;
        $url = $this->parseURI();
        if(isset($url[5]) && (int)$url[5] > 0){
            $id = (int)$url[5];
        }
        return $id;
    }

    public function parseRequestBody(){
        $request_body = file_get_contents('php://input');
        return json_decode($request_body,true);
    }

    public function serverError(string $message){
        header('500 Internal Server Error.');
        $error = json_encode(array('error' => 'Something went wrong! '.$message, 'success'=>false));
        echo $error;
        die;
    }
}