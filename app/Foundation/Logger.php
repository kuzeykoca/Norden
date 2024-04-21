<?php

namespace Norden\Foundation;

class Logger
{
    protected static string $logFile;

    public static function setLogFile(): void
    {
        self::$logFile = APP_ROOT . "Logs/application.log";
    }

    public static function log(string $message): void
    {
        if(!isset(self::$logFile)) {
            self::setLogFile();
        }

        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }
}