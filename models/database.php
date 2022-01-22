<?php

 class DB
{
    use Tools;

    private static $instance = null;
    private static $dbConnect;

    private $host;
    private $dbName;
    private $dbUser;
    private $dbPass;

    private function __construct()
    {
        $config = new Config();
        $dbConfig = $config->getConfig();
        $this->host = $dbConfig['host'];
        $this->dbName = $dbConfig['db_name'];
        $this->dbUser = $dbConfig['db_user'];
        $this->dbPass = $dbConfig['db_password'];

        try {
            self::$dbConnect = new PDO("mysql: host=$this->host;dbname=$this->dbName", $this->dbUser, $this->dbPass);
            self::$dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbConnect->setAttribute(PDO::ATTR_PERSISTENT, true);
            self::$dbConnect->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        } catch (Exception $e) {
           $this->serverError($e->getMessage());
        }

    }

     public static function getInstance()
     {
         if(!self::$instance)
         {
             self::$instance = new DB();
         }

         return self::$instance;
     }

     public function getConnection(){
         return self::$dbConnect;

     }
}