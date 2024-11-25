<?php

namespace App\Core\Logger;

use Monolog;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class LoggerRec implements ILogger
{
    private Monolog\Logger $log;
    private string $level;

    /**
     * @param string $channelName: Name of the channel to be used in the log.
     */
    public function __construct(string $channelName, string $logDirectory)
    {
        $output = "[%datetime%] %channel%.%level_name%: %message%\n";
        $formatter = new LineFormatter($output);
        $logHandler = new StreamHandler($logDirectory . '/error.log');
        $logHandler->setFormatter($formatter);
        $this->log = new Monolog\Logger($channelName);
        $this->log->pushHandler($logHandler);
    }

    public function getLogHandler(): Monolog\Logger
    {
        return $this->log;
    }

    public function setLevel(string $level): void
    {
        $this->level = $level;
    }

    public function sendLog(string $message): void
    {
        $this->log->{$this->level}($message);
    }
}
