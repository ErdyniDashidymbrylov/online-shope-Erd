<?php

class GetData
{
    protected PDO $pdo;
    public function __construct()
    {
        $this->pdo= new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
    }

}