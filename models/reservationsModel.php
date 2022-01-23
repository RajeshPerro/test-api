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
}