<?php

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