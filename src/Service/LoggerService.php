<?php

namespace Service;

class LoggerService
{
    public function logException(\Exception $exception)
    {
        $time = date('Y-m-d H:i:s');
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $logMessage = "{$time} | Message: {$message} | File: {$file} | Line: {$line}\n";
        file_put_contents('../Storage/Log/errors.txt', $logMessage, FILE_APPEND);
    }
}