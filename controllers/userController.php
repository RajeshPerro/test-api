<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/21/22
 * Time: 1:36 PM
 */

class UserController extends Controller {

    public function getAction(){
        $request_method = $_SERVER["REQUEST_METHOD"];
         $response_data = '';
         $error_message = '';
        $error_header = '';

        if(strtoupper($request_method) == 'GET'){
            try{
                $user_model = new UserModel();
                $response_data = json_encode($user_model->read());

            }catch (ErrorException $e){
                $error_message = $e->getMessage().'Something went wrong!';
                $error_header = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else{
            $error_message = 'Method Not Supported!';
            $error_header = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if($error_message == ''){
            $this->response($response_data,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        }
        else{
            $this->response(json_encode(array('error' => $error_message)),
                array('Content-Type: application/json', $error_header)
            );
        }
    }
}