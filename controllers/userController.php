<?php

class UserController extends Controller {

    use Tools;

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
                if(isset($id) && $id > 0){
                    $response = $user_model->getUserById($id);
                }
                else {
                    $response = $user_model->getUsers();
                }
                if($response){
                    $this->response_data = json_encode($response);
                }
                else{
                    $this->response_data =
                        json_encode(array('message'=>'Invalid `id` param / No Data!', 'success'=>false));
                }

            }catch (ErrorException $e){
                $this->serverError($e->getMessage());
            }
        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->header_with_code);
    }

    /**
     *This method is responsible for creating a user
     * call : test-api/index.php/user/create
     * params : {"user_name": "mike","user_email": "another_test@myapp.com",
    "password": "test_pass_23","mobile_number": "+44 78267262",
    "address": "address_test_lodz"}
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
                else{
                    $this->serverError('');
                }
            }catch (ErrorException $e){
                $this->serverError($e->getMessage());
            }

        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->header_with_code);
    }
    /**
     *This method is responsible for creating a user
     * call : test-api/index.php/user/update/1
     *  params : {"user_name": "mike","password": "test_pass_23",
    "mobile_number": "+44 78267262","address": "address_test_lodz"}
     */
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
                $this->serverError($e->getMessage());
            }

        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->header_with_code);
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
                $this->serverError($e->getMessage());
            }

        }
        else{
            $this->invalidMethodError();
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->header_with_code);
    }
}