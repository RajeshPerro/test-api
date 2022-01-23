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

    /**
     * @param int $require_spots
     * @param $available_spots
     * @return bool
     */
    protected function validateSpots(int $require_spots, $available_spots):bool{
        if($require_spots > $available_spots) return false;
        return true;
    }
}