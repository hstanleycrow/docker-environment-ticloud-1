<?php

namespace App\Core\Logger;

interface ILogger
{
    public function getLogHandler();
    public function setLevel(string $level): void;
    public function sendLog(string $message): void;
}
