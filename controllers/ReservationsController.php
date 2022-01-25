<?php


class ReservationDetailsController extends Controller
{
    use ReservationUtility;

    private $error_number;
    private $not_available_number;

    /*
     * based on the validation we send relevant error message
     * DO NOT MODIFY THESE arrays, Unless you have valid business reasons
    */
    private $ERROR_MESSAGES = array("","Invalid inputs!","Invalid User id!","Invalid Trip id!","Invalid request!");
    private $NOT_AVAILABLE_MESSAGE = array("","Sold out!","Not enough spots");

    public function __construct(){
        $this->request_method = strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    /**
     *This method is responsible for creating a user
     * call : test-api/index.php/reserve/create
     * params : {"user_id": 1,"trip_id": 1,
    "number_of_spots": 3}
     */
    public function createAction(){

        if($this->request_method == 'POST' ) {
            try{
                $data = $this->parseRequestBody();
                $input_validation = $this->validateInputs($data);
                //any type of garbage inputs
                if(!$input_validation){
                    $this->error_number = 1;
                }
                else{
                    //get the Trip & Spot validation result from helper method
                    $validation_result =
                        $this->validateTripAndSpot((int)$data['trip_id'],
                            (int) $data['number_of_spots']);
                    //if the userId doesn't exist
                    if(!$this->validateUserId((int)$data['user_id'])){
                        $this->error_number = 2;
                    }
                    //if the tripId doesn't exist
                    else if($validation_result === 0){
                        $this->error_number = 3;
                    }
                    //if all are sold out in a specific trip
                    else if($validation_result === -1){
                        $this->not_available_number = 1;
                    }
                    //if user request more tickets than the availability
                    else if($validation_result === -2){
                        $this->not_available_number = 2;
                    }
                    else {
                        //if everything is ok, we proceed with reservation
                        $data['total_spot'] = $validation_result;
                        $reserve_model = new ReservationDetailsModel();
                        $response = $reserve_model->createReservation($data);
                        if($response){
                            $this->response_data =
                                json_encode(array('message'=>'OK', 'success'=>true));
                        }
                        else{
                            $this->error_message = 'Something went wrong!';
                            $this->error_header = 'HTTP/1.1 500 Internal Server Error';
                        }
                    }
                }

            }catch (ErrorException $e){
                $this->error_message = $e->getMessage().'Something went wrong!';
                $this->error_header = 'HTTP/1.1 500 Internal Server Error';
            }

        }
        else{
            $this->invalidMethodError();
        }
        //check the final error code and set proper message
        if($this->error_number){
            $this->error_message = $this->ERROR_MESSAGES[$this->error_number];
            $this->error_header = 'HTTP/1.1 400 Invalid';
        }
        if($this->not_available_number){
            $this->error_message = $this->NOT_AVAILABLE_MESSAGE[$this->not_available_number];
            $this->error_header = 'HTTP/1.1 200 OK';
        }

        $this->sendResponse($this->response_data, $this->error_message,$this->error_header);
    }

    /**
     *This method is responsible for cancelling a reservation
     * call : test-api/index.php/reserve/cancel/{id}
     * params optional: {"number_of_spots": 2,"cancel_reason": "Cancel the tickets"}
     */
    public function cancelAction(){
        if($this->request_method == 'PUT' ) {
            $id = $this->getIdFromURI();
            try{
                $params = $this->parseRequestBody();
                $cancel_reason = isset($params['cancel_reason'])?$params['cancel_reason']:'';

                if(!$this->validateCancelRequest($params)){
                    //this means number_of_spot set but invalid data
                    $this->error_message = $this->ERROR_MESSAGES[1];
                    $this->error_header = 'HTTP/1.1 400 Invalid';
                }
                elseif(!$this->validateDateOfCancel($id)){
                    $this->error_message = $this->ERROR_MESSAGES[4];
                    $this->error_header = 'HTTP/1.1 400 Invalid';
                }
                else{
                    /*
                     * 1. number_of_spot is set with a valid data
                     * 2. number of spot not set at all (so cancel all)
                    */
                    $data['number_of_spots'] =
                        isset($params['number_of_spots'])?(int)$params['number_of_spots']:0;
                    $data['cancel_reason'] = $cancel_reason;

                    $reserve_model = new ReservationDetailsModel();
                    $response = $reserve_model->updateReservation($id, $data);

                    if($response){
                        $this->response_data =
                            json_encode(array('message'=>"$response spots are cancelled!", 'success'=>true));
                    }
                    else{
                        $this->response_data =
                            json_encode(array('message'=>'Invalid `id`/ param', 'success'=>false));
                    }
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
     * This method is to check if we get valid userId with input / not.
     * @param int $id
     * @return bool
     */

    private function validateUserId(int $id):bool{
        $user_model = new UserModel();
        return $user_model->getUserById($id) ? true : false;
    }

    /**
     * This method will validate a valid tripId, also it will return
     * current available 'total_spots' for a valid id.
     * @param int $id
     * @param int $require_spots
     * @return int
     */
    private function validateTripAndSpot( int $id, int $require_spots) : int {
        $trip_model = new TripsModel();
        $response = $trip_model->getTripById($id);
        if($response)
        {
            $available_spots = (int)$response['total_spot'];

            if($available_spots === 0)
                return -1;
            else if($available_spots < $require_spots)
                return -2;
            else
              return $available_spots;
        }
        else return 0;
    }
}