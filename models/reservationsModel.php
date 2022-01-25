<?php

class ReservationDetailsModel extends Model
{

    protected static $tableName = "reservation_details";

    public function __construct()
    {
        parent::__construct(self::$tableName);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function createReservation(Array $params):bool{
        try{

            if(!isset($params['total_spot'])) return false;

            $trip_params['total_spot'] = $params['total_spot'] - (int)$params['number_of_spots'];
            unset($params['total_spot']);

            $this->dbConnect->beginTransaction();

            $this->create($params);

            $trip_model = new TripsModel();
            $trip_model->updateTrip((int)$params['trip_id'], $trip_params);

            $this->dbConnect->commit();
            return true;

        }catch (Exception $e){
            if($e->getMessage()){
                $this->dbConnect->rollBack();
                return false;
            }
        }
    }

    public function getReservationDetails():array{
        $query = "SELECT * FROM ".self::$tableName.
            " WHERE `is_active` = 1 ORDER BY `modified_at` DESC";
        return $this->runCustomQuery($query);
    }

    /**
     * @param int $id
     * @param array $params
     * @return int
     */
    public function updateReservation(int $id, Array $params):int{
        if(!$id) return 0;

        $spot_to_cancel = (int)$params['number_of_spots'];

        $reservation_details = $this->getById($id);

        if(!$reservation_details || !$reservation_details['is_active']) {
            return 0;
        }

        $reservation_details['cancel_reason'] = $params['cancel_reason'];
        try{
            if($reservation_details && $spot_to_cancel){
                if( $spot_to_cancel && ($spot_to_cancel > (int)$reservation_details['number_of_spots']))
                {
                    //we have invalid 'number_of_spots' as an input

                    return 0;
                }
                else{
                    //True then we proceed flexible cancel
                    return $this->cancelReservation($reservation_details,$spot_to_cancel);
                }
            }
            else{
                /*
                 * we have reservation details but no flexible cancel
                 * So, now we cancel all spots!
                */
                return $this->cancelReservation($reservation_details,
                    (int)$reservation_details['number_of_spots']);
            }
        }catch(Exception $e){
            if($e->getMessage()){
                return 0;
            }
        }
    }

    /**
     * @param array $reservation_details
     * @param int $spot_to_cancel
     * @return int
     */
    private function cancelReservation(Array $reservation_details, int $spot_to_cancel):int{

        try{
            /*
             * if user fully cancel the reservation we just inactive that reservation
             * and add back all the spots to Trip => total_spots
            */
            $available_spots = (int)$reservation_details['number_of_spots'];
            if($available_spots === $spot_to_cancel)
            {
                $reservation_details['is_active'] = 0;
                unset($reservation_details['number_of_spots']);
            }
            //else we deduct amount of spot and add that back to Trip => total_spots
            else{
                $available_spots -= $spot_to_cancel;
                $reservation_details['number_of_spots'] = $available_spots;
            }

            $this->dbConnect->beginTransaction();

            //update the reservation with the updated data
            $this->update((int)$reservation_details['id'],$reservation_details);

           // update Trip
            $trip_model = new TripsModel();
            $trip = $trip_model->getById((int)$reservation_details['trip_id']);

            //if by any chance trip doesn't exists
            if(!$trip) return 0;

            //else : add back those spots
            $trip['total_spot'] = $trip['total_spot'] + $spot_to_cancel;
            $trip_model->updateTrip((int)$trip['id'], $trip);

           //finally if everything goes well commit and return
            $this->dbConnect->commit();
            return $spot_to_cancel;

        }catch (Exception $e){
            if($e->getMessage()){
                $this->dbConnect->rollBack();
                return 0;
            }
        }
    }

    public function getDates(int $id){
        $query = "SELECT trip_date FROM trips WHERE id =
                  (SELECT trip_id FROM reservation_details WHERE id = ".$id.")";
        return $this->runCustomQuery($query);

    }
}