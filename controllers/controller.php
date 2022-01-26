<?php

class Controller {

    use Tools;

    protected $response_data = '';
    protected $status_header = '';
    protected $error_message = '';
    protected $error_header = '';
    protected $request_method = '';

    public function __call($name, $arguments){
        //if there is no method
        $this->sendResponse('','','Invalid method!','HTTP/1.1 405 Method Not Allowed');
    }

    /**
     * @param string $query
     */
    protected function getQueryStringParams(string $query){
        return parse_str($_SERVER['QUERY_STRING'],$query);
    }

    /**
     * This method is responsible to prepare any kind of response
      we have to send
     * @param mixed $data
     * @param array $$httpHeaders
     */
    protected function prepareResponse($data, $httpHeaders=array()){
        header_remove('Set-Cookie');

        if(is_array($httpHeaders) && count($httpHeaders)){
            foreach($httpHeaders as $httpHeader){
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }

    /**
     * This method is being use to send an error
     */
    protected function invalidMethodError(){
        $this->error_message = 'Method Not Supported!';
        $this->error_header = 'HTTP/1.1 422 Unprocessable Entity';
        $this->sendResponse('','',$this->error_message,$this->error_header);
    }

    /**
     * This method is being use to send an error
     */
    protected function invalidQueryError(){
        $this->error_message = 'Invalid id / params';
        $this->error_header = 'HTTP/1.1 406 Not Acceptable';
        $this->sendResponse('','',$this->error_message,$this->error_header);
    }

    /**
     * This method is being use to send any response we have for our caller
     * @param string $response_to_send
     * @param string $error_message
     * @param string $error_header
     */
    protected function sendResponse(string $response_to_send, string $status_header,
                                    string $error_message, string $error_header){
        if($error_message == ''){
            $this->prepareResponse($response_to_send,
                array('Content-Type: application/json', $status_header));
        }
        else{
            $this->prepareResponse(json_encode(array('error' => $error_message, 'success'=>false)),
                array('Content-Type: application/json', $error_header)
            );
        }
    }
}