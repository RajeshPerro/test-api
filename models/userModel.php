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
        $user_name = $params['username'] ?? '';
        $user_email = $params['user_email'] ?? '';
        $user_status = $params['user_status']?? 0;
        $query = null;
        if(count($params) && !empty($user_name) && !empty($user_email) && $user_status !==0){
            $query = "INSERT INTO `".self::$tableName.
                "` (`username`, `user_email`, `user_status`) VALUES ('"
                .$user_name."','".$user_email."',".$user_status.")";
        }
        return $this->create($query);
    }

    /**
     * @param array $params
     * @return int
     */
    public function updateUser(int $id = 0, Array $params):int{
        if(!$id) return 0;
        $allowed_columns = ["username","user_status"];
        $update_data = [];
        $set_statement = "";
        foreach ($allowed_columns as $key)
        {
            if (isset($params[$key]) && $key != "id")
            {
                $set_statement .= "`$key` = :$key,";
                $update_data[$key] = $params[$key];
            }
        }
        $set_statement = rtrim($set_statement, ",");
        $update_data['id'] = $id;
        $query = "UPDATE users SET $set_statement WHERE id = :id";

        return $this->update($query, $update_data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteUser(int $id = 0){
        return $this->delete($id);
    }
}