<?php

trait ReservationUtility {


    /**
     * This method validate if we get all required params and also
       they are set with proper values
     * @param array $data
     * @return bool
     */
    protected function validateInputs(Array $data):bool{
        if(!isset($data['user_id']) || !isset($data['trip_id'])
            || !isset($data['number_of_spots'])){
            return false;
        }
        else if((int)$data['user_id'] <= 0 || (int)$data['trip_id'] <= 0
            || (int) $data['number_of_spots'] <= 0){
            return false;
        }
        return true;
    }

    /**
     * This method is to check if we get valid userId with input / not.
     * @param int $id
     * @return bool
     */

    protected function validateUserId(int $id):bool{
        $user_model = new UserModel();
        return $user_model->getUserById($id) ? true : false;
    }

    /**
     * This method will validate a valid tripId, also it will return
      current available 'total_spots' for a valid id.
     * @param int $id
     * @param int $require_spots
     * @return int
     */
    private function validateTripAndSpot( int $id, int $require_spots) : int {
        $trip_model = new TripsModel();
        $response = $trip_model->getTripById($id);
        if($response)
        {
            if(!$this->validateDateOfReservation($response['trip_date'])) return 0;

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

    /**
     * This method validate if we get number_of_spots param and its a 0 or
       an invalid input
     * @param array|null $data
     * @return bool
     */
    protected function validateCancelRequest(Array $data = null):bool{

        if(isset($data['number_of_spots']) && (int)$data['number_of_spots'] <= 0)
            return false;
        return true;
    }

    /**
     * This method will validate if we get a request
      where user trying to cancel a reservation which has been used or
      lets imagine, the trip was yesterday but user is trying to cancel it today
      here, we cover till the trip time, we can adjust it with business requirements
     * @param int $reservation_id
     * @return bool
     */
    protected function validateDateOfCancel(int $reservation_id){
        $reserve_model = new ReservationDetailsModel();
        $data = $reserve_model->getDates($reservation_id);

        $trip_date = new DateTime($data[0]['trip_date']);
        $date_now = new DateTime();

        //imagine someone wants to cancel a reservation which has been done already!
        if($date_now >= $trip_date ) return false;

        return true;
    }

    /**
     * This method will validate if we get a request
    where user trying to book a reservation which is already started or ended
    lets imagine, the trip was 1s before but user is trying to reserve it now
    here, we cover till the trip time, we can adjust it with business requirements
     * @param String $trip_date
     * @return bool
     */
    private function validateDateOfReservation(String $trip_date){
        $trip_date = new DateTime($trip_date);
        $date_now = new DateTime();

        //imagine someone wants to book a trip which has been done already!
        if($date_now >= $trip_date ) return false;

        return true;
    }
}