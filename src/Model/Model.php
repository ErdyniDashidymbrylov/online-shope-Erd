<?php
namespace Model;
use \PDO;
abstract class Model
{
    protected PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
    }

    abstract protected function getTableName(): string;

}