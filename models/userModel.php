<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/21/22
 * Time: 1:08 PM
 */
class UserModel extends Model{

    protected static $tableName = "users";

    public function __construct(){
        parent::__construct(self::$tableName);
    }

    public function getUsers(int $id = null){
        $model = new Model(self::$tableName);
        return $model->read($id);
    }
}