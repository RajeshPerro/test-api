<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/20/22
 * Time: 9:16 PM
 */
class Config {

    private $config;

    public function __construct()
    {
        $this->config = parse_ini_file('app.ini');
    }

    public function getConfig()
    {
        return $this->config;
    }
}