<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 1/21/22
 * Time: 11:56 AM
 * This class is responsible to hold all the abstract methods we will use for our
 * Database operations.
 */

abstract class DBOperations {

    abstract function create($params = []);
    abstract function read(int $id = null);
    abstract function update(string $query ="");
    abstract function delete(int $id = null);

}