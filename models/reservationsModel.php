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
     * @return int
     */
    public function createReservation(Array $params):int{
        return $this->create($params);
    }
}