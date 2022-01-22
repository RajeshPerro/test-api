<?php

class UserModel extends Model{

    protected static $tableName = "users";

    public function __construct(){
        parent::__construct(self::$tableName);
    }

    /**
     * @param int|null $id
     * @return array
     */
    public function getUsers(int $id = null){
        return $this->read($id);
    }

    /**
     * @param array $params
     * @return int
     */
    public function createUser(Array $params):int{
        return $this->create($params);
    }

    /**
     * @param array $params
     * @return int
     */
    public function updateUser(int $id = 0, Array $params):int{
        if(!$id) return 0;
        return $this->update($id, $params);
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteUser(int $id = 0){
        return $this->delete($id);
    }
}