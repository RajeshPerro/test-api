<?php

class Model extends DBOperations {

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

    function create(string $query):int
    {
        $statement = $this->dbConnect->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    /**
     * @param int $id
     * @return array
     */
    function read( int $id = 0)
    {
        if($id == 0)
        {
            $query = $this->dbConnect->prepare("SELECT * FROM `".self::$tableName."`");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->dbConnect = null;
            return $results;
        }
        else
        {

            $query = $this->dbConnect->prepare("SELECT * FROM `".self::$tableName."` WHERE `id` = ".$id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->dbConnect = null;
            return $result;
        }

    }

    function update(string $query = "", Array $params)
    {
        $statement = $this->dbConnect->prepare($query);
        $statement->execute($params);
        return $statement->rowCount();
    }

    function delete(int $id = 0)
    {
        if($id === 0){
            return 0;
        }
        $x = "DELETE FROM `".self::$tableName."` WHERE id = ".$id;
        $query = $this->dbConnect->prepare($x);
        $query->execute();
        return $query->rowCount();
    }


    /**
     * @param String $table_name
     * @return mixed
     */
    private function getColumns(String $table_name):array{
        $columns = [];

        $query = $this->dbConnect->prepare("SHOW COLUMNS FROM`".$table_name."`");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $res){
            $columns[] = $res['Field'];
        }
    return $columns;
    }
}