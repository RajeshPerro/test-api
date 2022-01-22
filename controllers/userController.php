<?php

class UserController extends Controller {

    private $response_data = '';
    private $error_message = '';
    private $error_header = '';
    private $request_method = '';

    public function __construct(){
        $this->request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    /**
     *This method is to get all users
     * call : test-api/index.php/user/get
     * OR : call : test-api/index.php/user/get/1
     * param id = 1
     */
    public function getAction(){

        if($this->request_method == 'GET'){
            $id = $this->getIdFromURI();
            try{
                $user_model = new UserModel();
                $response = $user_model->read($id);
                if($response){
                    $this->response_data = json_encode($response);
                }
                else{
                    $this->response_data =
                        json_encode(array('message'=>'Invalid `id` param', 'success'=>false));
                }

            }catch (ErrorException $e){
                $this->error_message = $e->getMessage().'Something went wrong!';
                $this->error_header = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }

    /**
     *This method is responsible for creating a user
     * call : test-api/index.php/user/create
     * params {"username": "Rajesh","user_email": "rajesh@myapp.com","user_status": "1"}
     */
    public function createAction(){

        if($this->request_method == 'POST' ) {
            try{
                $data = $this->parseRequestBody();
                $user_model = new UserModel();
                $response = $user_model->createUser($data);
                if($response){
                    $this->response_data =
                        json_encode(array('message'=>'User Created!', 'success'=>true));
                }
            }catch (ErrorException $e){
                $this->error_message = $e->getMessage().'Something went wrong!';
                $this->error_header = 'HTTP/1.1 500 Internal Server Error';
            }

        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }

    public function updateAction(){
        if($this->request_method == 'PUT' ) {
            $id = $this->getIdFromURI();
            try{
                $data = $this->parseRequestBody();
                $user_model = new UserModel();
                $response = $user_model->updateUser($id, $data);
                if($response){
                    $this->response_data =
                        json_encode(array('message'=>'User Updated!', 'success'=>true));
                }
                else{
                    $this->response_data =
                        json_encode(array('message'=>'Invalid `id` param', 'success'=>false));
                }
            }catch (ErrorException $e){
                $this->error_message = $e->getMessage().'Something went wrong!';
                $this->error_header = 'HTTP/1.1 500 Internal Server Error';
            }

        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }

    /**
     *This method is responsible for deleting a user
     * call : test-api/index.php/user/delete/1
     * params id = 1
     */
    public function deleteAction(){
        if($this->request_method == 'DELETE' ) {
            try{
                $id = $this->getIdFromURI();
                $user_model = new UserModel();
                $response = $user_model->deleteUser($id);
                if($response){
                    $this->response_data =
                        json_encode(array('message'=>'User Deleted!', 'success'=>true));
                }
                else{
                    $this->response_data =
                        json_encode(array('message'=>'Invalid `id` param', 'success'=>false));
                }
            }catch (ErrorException $e){
                $this->error_message = $e->getMessage().'Something went wrong!';
                $this->error_header = 'HTTP/1.1 500 Internal Server Error';
            }

        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }
}