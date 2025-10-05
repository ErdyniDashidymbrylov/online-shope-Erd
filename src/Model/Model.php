<?php
namespace Model;
use \PDO;
abstract class Model
{
    protected static PDO $pdo;
    public static function getPDO():PDO
    {
        static::$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
        return static::$pdo;
    }

    abstract static protected function getTableName(): string;

}