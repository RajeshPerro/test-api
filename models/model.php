<?php

class Model extends DBOperations {

    use Tools;

    protected static $tableName;
    protected $dbConnect;

    /**
     * @param String $table
     */
    public function __construct(string $table){
        self::$tableName = $table;
        $db = DB::getInstance();
        $this->dbConnect = $db->getConnection();
    }

    function create(Array $params):int
    {
        $columns = $this->getColumns(self::$tableName);
        $insert_statement = "INSERT INTO ".self::$tableName;
        $field_name = "(";
        $field_value = " VALUES (";
        while(list($name,$value) = each($params)) {

            if(in_array($name, $columns)){
                if(is_bool($value)) {
                    $field_name .= "$name,";
                    $field_value .= ($value ? "true":"false") . ",";
                    continue;
                };

                if(is_string($value)) {
                    $field_name .= "$name,";
                    $field_value .= "'$value',";
                    continue;
                }
                if (!is_null($value) and ($value != "")) {
                    $field_name .= "$name,";
                    $field_value .= "$value,";
                    continue;
                }
            }
        }
        $field_name[strlen($field_name)-1] = ')';
        $field_value[strlen($field_value)-1] = ')';
        $insert_statement .= $field_name . $field_value;
        try{
            $statement = $this->dbConnect->prepare($insert_statement);
            $statement->execute();
            return $statement->rowCount();
        }catch (Exception $e){
            $this->serverError($e->getMessage());
        }
    }

    /**
     * @return array
     */
    function getAll()
    {
        $query = $this->dbConnect->prepare("SELECT * FROM `".self::$tableName."`");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->dbConnect = null;
        return $results;
    }

    /**
     * @param int $id
     * @return int|mixed
     */
    function getById(int $id = 0){

        if($id == 0) return 0;

        $query = $this->dbConnect->prepare("SELECT * FROM `".self::$tableName."` WHERE `id` = ".$id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $this->dbConnect = null;
        return $result;
    }

    function update(int $id , Array $params)
    {
        $allowed_columns = $this->getColumns(self::$tableName);
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
        $query = "UPDATE `".self::$tableName."` SET $set_statement WHERE id = :id";
        try {
            $statement = $this->dbConnect->prepare($query);
            $statement->execute($update_data);
            return $statement->rowCount();
        }catch (Exception $e){
            $this->serverError($e->getMessage());
        }
    }

    function delete(int $id = 0)
    {
        if($id === 0){
            return 0;
        }
        $x = "DELETE FROM `".self::$tableName."` WHERE id = ".$id;
        $query = $this->dbConnect->prepare($x);
        $query->execute();
        $this->dbConnect = null;
        return $query->rowCount();
    }


    /**
     * @param String $table_name
     * @return mixed
     */
    protected function getColumns(String $table_name):array{
        $columns = [];
        $unnecessary_columns = ['id','created_at','modified_at'];
        $query = $this->dbConnect->prepare("SHOW COLUMNS FROM`".$table_name."`");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $res){
            if(!in_array($res['Field'], $unnecessary_columns)) {
                $columns[] = $res['Field'];
            }
        }
    return $columns;
    }

}