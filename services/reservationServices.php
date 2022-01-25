<?php

trait ReservationUtility {


    /**
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

    protected function validateCancelRequest(Array $data = null):bool{

        if(isset($data['number_of_spots']) && (int)$data['number_of_spots'] <= 0)
            return false;
        return true;
    }

    protected function validateDateOfCancel(int $id){
        $reserve_model = new ReservationDetailsModel();
        $data = $reserve_model->getDates($id);

        $trip_date = new DateTime($data[0]['trip_date']);
        $date_now = new DateTime();

        //imagine someone wants to cancel a reservation which has been done already!
        if($date_now >= $trip_date ) return false;

        return true;
    }
}