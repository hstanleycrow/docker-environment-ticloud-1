<?php

namespace App\Core\DBConnection;

use PDO;
use PDOException;
use App\Core\Logger\ILogger;
use App\Core\Logger\LoggerRec;

class MySQLPDOConnection implements IConnection
{
    private PDO $connection;
    private bool $connectionStatus;
    private ILogger $logger;

    public function __construct(
        private IConfig $config,
        private ICharsetConfig $charsetConfig,
        private string $scriptName
    ) {
        $this->scriptName = $scriptName;
        $this->config = $config;
        $this->logger = new LoggerRec("DBConnectionError", DIR_BASE_LOGS);
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->connection = new PDO(
                $this->buildDSN(),
                $this->config->getUser(),
                $this->config->getPassword(),
                $this->getOptions()
            );
            $this->setConnectionStatus(TRUE);
        } catch (PDOException $e) {
            $dbError = new DBError($this->logger, $this->scriptName);
            $dbError->saveInLog("error", "Error conectándose a la BD. Método: " . __METHOD__ . ". Mensaje original:" . $e->getMessage() . ". Scriptname: " . $_SERVER['SCRIPT_NAME']);
            $this->setConnectionStatus(FALSE);
            throw new PDOException($e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function isConnected(): bool
    {
        return $this->connectionStatus;
    }

    private function buildDSN(): string
    {
        return "mysql:dbname=" . $this->config->getDatabaseName() . ";port=" . $this->config->getPort() . ";host=" . $this->config->getHost();
    }

    private function getOptions(): array
    {
        return array(
            PDO::MYSQL_ATTR_INIT_COMMAND => $this->charsetConfig->getCharset(),
            PDO::ATTR_PERSISTENT => FALSE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_LOCAL_INFILE => TRUE
        );
    }

    private function setConnectionStatus(bool $newStatus): void
    {
        $this->connectionStatus = $newStatus;
    }
}
