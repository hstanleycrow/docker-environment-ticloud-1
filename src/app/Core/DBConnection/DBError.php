<?php

namespace App\Core\DBConnection;

use App\Core\Logger\ILogger;


class DBError
{
    private $errorCode;
    private $errorMessage;
    private $scriptName;
    private ILogger $log;

    public function __construct(ILogger $log, string $scriptName)
    {
        $this->log = $log;
        $this->scriptName = $scriptName;
    }

    public function saveInLog(string $level, string $message): void
    {
        $this->log->setLevel($level);
        $this->log->sendLog($message);
    }

    public function setError(string $code, string $message): void
    {
        $this->errorCode = $code;
        $this->errorMessage = $message;
    }

    public function getLastError(): array
    {
        return array("errorCode" => $this->errorCode, "errorMessage" => $this->errorMessage, "scriptName" => $this->scriptName);
    }

    public function getLastErrorString(): string
    {
        return "errorCode: " . $this->errorCode . "\nerrorMessage: " . $this->errorMessage .  "\nscriptName: " . $this->scriptName;
    }
}
