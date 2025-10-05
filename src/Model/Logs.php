<?php

namespace Model;
use \PDO;

class Logs extends Model
{
    protected static function getTableName(): string
    {
        return 'logs';
    }
    public static function insertLogs(string $message, string $file, int $line, string $date): void
    {
        $tableName = static::getTableName();
        $stmtInsert = static::getPDO()->prepare("INSERT INTO $tableName (message, file, line,date) VALUES (:message, :file, :line, :date)");
        $stmtInsert->execute([':message' => $message, ':file' => $file, ':line' => $line, ':date' => $date]);

    }


}