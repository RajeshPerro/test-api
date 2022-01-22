<?php

abstract class DBOperations {

    //to create new record in a table
    abstract function create(string $query):int;

    //to read 1 or all the records from a table
    abstract function read(int $id = 0);

    //to update 1 record in a table
    abstract function update(string $query ="", Array $params);

    //to delete 1 record from a table
    abstract function delete(int $id = 0);

}