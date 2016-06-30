<?php

namespace App;

class DB
{
    use Singleton;
    protected $conn;
    
    function __construct()
    {
        $this->conn = new \PDO('mysql:host=127.0.0.1;dbname=profit', 'root', 'root', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    }

    public function execute($sql, $prop = [])
    {
        $statement = $this->conn->prepare($sql);
        $result = $statement->execute($prop);
        return $result;
    }

    public function query($sql, $prop = [], $class)
    {
        $statement = $this->conn->prepare($sql);
        $result = $statement->execute($prop);
        if ($result !== null) {
            return $statement->fetchAll(\PDO::FETCH_CLASS, $class);
        }
        
        return[];
    }
    
}