<?php


class ReservationDetailsController extends Controller
{
    use ReservationUtility;

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
                $trip_validation =
                    $this->validateTripId((int)$data['trip_id'], (int) $data['number_of_spots']);

                if(!$this->validateInputs($data)){
                    $this->error_message = 'Invalid inputs!';
                    $this->error_header = 'HTTP/1.1 400 Invalid';
                }
                else if(!$this->validateUserId((int)$data['user_id'])){
                    $this->error_message = 'Invalid User id!';
                    $this->error_header = 'HTTP/1.1 400 Invalid';
                }

                else if($trip_validation === 0){
                    $this->error_message = 'Invalid Trip id! ';
                    $this->error_header = 'HTTP/1.1 400 Invalid';
                }
                else if($trip_validation === -1){
                    $this->error_message = 'Sold out!';
                    $this->error_header = 'HTTP/1.1 200 OK';
                }
                else {

                    //$reserve_model = new ReservationDetailsModel();
                    //$response = $reserve_model->createReservation($data);
                    $response = 1;
                    if($response){
                        $this->response_data =
                            json_encode(array('message'=>'OK', 'success'=>true));
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
     current available 'total_spots' for a valid id.
     * @param int $id
     * @return int
     */
    private function validateTripId( int $id, int $require_spots):int{
        var_dump($id);
        $trip_model = new TripsModel();
        $response = $trip_model->getTripById($id);
        var_dump($response);
        if($response)
        {
            $available_spots = (int)$response['total_spot'];
            if($require_spots > $available_spots) return -1;
            else return $available_spots;
        }
        else return 0;
    }
}