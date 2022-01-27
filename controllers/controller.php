<?php

class Controller {

    use Tools;

    protected $response_data = '';
    protected $error_message = '';
    protected $header_with_code = '';
    protected $request_method = '';

    public function __call($name, $arguments){
        //if there is no method
        $this->sendResponse('','Invalid method!','HTTP/1.1 405 Method Not Allowed');
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
        $this->header_with_code = 'HTTP/1.1 422 Unprocessable Entity';
        $this->sendResponse('',$this->error_message,$this->header_with_code);
    }

    /**
     * This method is being use to send an error
     */
    protected function invalidQueryError(){
        $this->error_message = 'Invalid id / params';
        $this->header_with_code = 'HTTP/1.1 406 Not Acceptable';
        $this->sendResponse('',$this->error_message,$this->header_with_code);
    }

    /**
     * This method is being use to send any response we have for our caller
     * @param string $response_to_send
     * @param string $error_message
     * @param string $header_with_code
     */
    protected function sendResponse(string $response_to_send,
                                    string $error_message, string $header_with_code){
        if($error_message == ''){
            if($header_with_code != ''){
                $this->prepareResponse($response_to_send,
                    array('Content-Type: application/json', $header_with_code));
            }else{
                $this->prepareResponse($response_to_send,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            }

        }
        else{
            $this->prepareResponse(json_encode(array('error' => $error_message, 'success'=>false)),
                array('Content-Type: application/json', $header_with_code)
            );
        }
    }
}