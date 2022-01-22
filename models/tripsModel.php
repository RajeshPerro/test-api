<?php

class TripsModel extends Model{

    protected static $tableName = "trips";

    public function __construct(){
        parent::__construct(self::$tableName);
    }

    /**
     * @param int|null $id
     * @return array
     */
    public function getTrips(int $id = null){
        return $this->read($id);
    }

    /**
     * @param array $params
     * @return int
     */
    public function createTrip(Array $params):int{
        return $this->create($params);
    }

    /**
     * @param array $params
     * @return int
     */
    public function updateTrip(int $id = 0, Array $params):int{
        if(!$id) return 0;
        return $this->update($id, $params);
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteTrip(int $id = 0){
        return $this->delete($id);
    }
}