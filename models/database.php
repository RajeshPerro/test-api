<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/20/22
 * Time: 9:18 PM
 */

class DB
{
    private $host;
    private $dbName;
    private $dbUser;
    private $dbPass;

    public $dbConnect;

    public function __construct()
    {
        $config = new Config();
        $dbConfig = $config->getConfig();
        $this->host = $dbConfig['host'];
        $this->dbName = $dbConfig['db_name'];
        $this->dbUser = $dbConfig['db_user'];
        $this->dbPass = $dbConfig['db_password'];

        try {
            $this->dbConnect = new PDO("mysql: host=$this->host;dbname=$this->dbName", $this->dbUser, $this->dbPass);
            $this->dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbConnect->setAttribute(PDO::ATTR_PERSISTENT, true);
            $this->dbConnect->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        } catch (\Exception $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $this->dbConnect;

    }
}