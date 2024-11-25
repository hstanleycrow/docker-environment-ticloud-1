<?php

namespace App\Core;

class DBError
{
    private $errorCode;
    private $errorMessage;

    public function __construct()
    {
    }

    public function saveInLog(string $level, string $message): void
    {
        $log = new LoggerRec(__NAMESPACE__);
        $log->setLevel($level);
        $log->sendLog($message);
    }

    public function setError(string $code, string $message): void
    {
        $this->errorCode = $code;
        $this->errorMessage = $message;
    }

    public function getLastError(): array
    {
        return array("errorCode" => $this->errorCode, "errorMessage" => $this->errorMessage, "scriptName" => $_SERVER['SCRIPT_NAME']);
    }
    public function getLastErrorString(): string
    {
        return "errorCode: " . $this->errorCode . "\nerrorMessage: " . $this->errorMessage .  "\nscriptName: " . $_SERVER['SCRIPT_NAME'];
    }
}
