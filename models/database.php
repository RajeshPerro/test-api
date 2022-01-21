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

    private static $dbConnect;

    public function __construct()
    {
        $config = new Config();
        $dbConfig = $config->getConfig();
        $this->host = $dbConfig['host'];
        $this->dbName = $dbConfig['db_name'];
        $this->dbUser = $dbConfig['db_user'];
        $this->dbPass = $dbConfig['db_password'];
    }

     public function getConnection(){
         if(is_null(self::$dbConnect)){
             try {
                 self::$dbConnect = new PDO("mysql: host=$this->host;dbname=$this->dbName", $this->dbUser, $this->dbPass);
                 self::$dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 self::$dbConnect->setAttribute(PDO::ATTR_PERSISTENT, true);
                 self::$dbConnect->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
             } catch (\Exception $e) {
                 print "Error!: " . $e->getMessage() . "<br/>";
                 die();
             }
             return self::$dbConnect;
         }
         else{
             return null;
         }

     }
}