<?php


class TripsController extends Controller
{
    use Tools;

    public function __construct(){
        $this->request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    /**
     *This method is responsible for creating a user
     * call : test-api/index.php/trips/create
     * params: {"name":"Trip To WAW","start_from":"Warsaw","end_to":"Lodz",
    "total_spot": 40,"trip_date":"2022-02-12 10:00:00"}
     */
    public function createAction(){

        if($this->request_method == 'POST' ) {
            try{
                $data = $this->parseRequestBody();
                $trip_model = new TripsModel();
                $response = $trip_model->createTrip($data);
                if($response){
                    $this->response_data =
                        json_encode(array('message'=>'Trip Created!', 'success'=>true));
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

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }

    /**
     *This method is to get all users
     * call : test-api/index.php/trips/get
     * OR : call : test-api/index.php/trips/get/1
     * param id = 1
     */
    public function getAction(){

        if($this->request_method == 'GET'){
            $id = $this->getIdFromURI();
            try{
                $trip_model = new TripsModel();
                if(isset($id) && $id > 0){
                    $response = $trip_model->getTripById($id);
                }
                else {
                    $response = $trip_model->getTrips();
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

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }

    /**
     *This method is responsible for creating a user
     * call : test-api/index.php/trips/update/1
     *  params : {"name":"Trip To WAW","start_from":"Warsaw","end_to":"Lodz",
    "total_spot": 40,"trip_date":"2022-02-12 10:00:00"}
     */
    public function updateAction(){
        if($this->request_method == 'PUT' ) {
            $id = $this->getIdFromURI();
            try{
                $data = $this->parseRequestBody();
                $trip_model = new TripsModel();
                $response = $trip_model->updateTrip($id, $data);
                if($response){
                    $this->response_data =
                        json_encode(array('message'=>'Trip Updated!', 'success'=>true));
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

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }
}