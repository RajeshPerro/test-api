<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/21/22
 * Time: 11:43 AM
 */
class Model extends DBOperations {

    protected static $tableName;
    protected $dbConnect = null;

    /**
     * @param String $table
     */
    public function __construct(string $table){
        self::$tableName = $table;

        $db = new DB();
        $this->dbConnect = $db->getConnection();
    }

    function create($params = [])
    {
        // TODO: Implement create() method.
    }

    /**
     * @param array $params
     * @return array
     */
    function read( int $id = null)
    {
        if(is_null($id))
        {
            $query = $this->dbConnect->prepare("SELECT * FROM `".self::$tableName."`");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
        else
        {

            $query = $this->dbConnect->prepare("SELECT * FROM `".self::$tableName."` WHERE `id` = ".$id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

    }

    function update(string $query = "")
    {
        // TODO: Implement update() method.
    }

    function delete(int $id = null)
    {
        // TODO: Implement delete() method.
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