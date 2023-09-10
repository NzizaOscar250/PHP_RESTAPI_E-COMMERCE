<?php

// namespace Model;

class Db 
{
    public function __construct(private string $host,
                            private string $user,
                            private string $password,
                            private string $dbname )
    { }
    public function getConnection():PDO
    {
        $strconn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";

        return new PDO($strconn,$this->user,$this->password,[
            PDO::ATTR_EMULATE_PREPARES=>false,
            PDO::ATTR_STRINGIFY_FETCHES=>false
        ]);
        
    }
}






?>