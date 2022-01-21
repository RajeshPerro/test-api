<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/21/22
 * Time: 1:21 PM
 */

class Controller {


    public function __call($name, $arguments){
        //if there is no method
        $this->response(json_encode(array('error' => 'Invalid method!')),
            array('Content-Type: application/json', 'HTTP/1.1 405 Method Not Allowed')
        );
    }

    protected function parseURI():array{
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return explode('/',$uri);
    }

    /**
     * @param string $query
     */
    protected function getQueryStringParams(string $query){
        return parse_str($_SERVER['QUERY_STRING'],$query);
    }

    protected function response($data, $httpHeaders=array()){
        header_remove('Set-Cookie');

        if(is_array($httpHeaders) && count($httpHeaders)){
            foreach($httpHeaders as $httpHeader){
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}