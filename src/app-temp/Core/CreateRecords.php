<?php

namespace App\Core;

use App\Core\Logger\ILogger;
use App\Core\Logger\LoggerRec;
use App\Core\DBConnection\DBError;
use App\Core\DBConnection\IConnection;

class CreateRecords
{
    private mixed $statement;
    private int $lastInsertId = 0;
    private DBError $dbError;
    private ILogger $logger;
    protected $errorCode;
    protected $errorMessage;

    public function __construct(
        protected IConnection $connection,
        protected string $table,
        protected string $scriptName
    ) {
        $this->logger = new LoggerRec("ReadRecordsError", DIR_BASE_LOGS);
        $this->dbError = new DBError($this->logger, $this->scriptName);
    }

    public function execute(array $fieldsList): int|\PDOException
    {
        try {
            if ($this->statement = $this->prepareStatement($fieldsList))
                $this->runInsert($fieldsList);
            else
                throw new \PDOException("Error preparando el statement");
        } catch (\PDOException $e) {
            $this->sendLog("error", "Query error. Metodo: " . __METHOD__ . ". Query: " . $this->statement->queryString . ". Values to insert: " . print_r($this->getDataFromFieldsList($fieldsList), 1) . ". Source Error Message:" . $e->getMessage() . ". ScriptName: " . $this->scriptName);
            $this->setError();
            throw new \PDOException($e->getMessage(), (int)$e->getCode(), $e);
        }
        return $this->lastInsertId;
    }

    private function prepareStatement(array $fieldsList): mixed
    {
        return $this->connection->getConnection()->prepare($this->configQuery($fieldsList));
    }

    private function configQuery(array $fieldsList): string
    {
        return "INSERT INTO {$this->table} (" . implode(",", array_keys($fieldsList)) . ") VALUES " . $this->prepareFieldListAsString($fieldsList);
    }

    private function prepareFieldListAsString(array $fieldsList): string
    {
        $placeholders = array_fill(0, count($fieldsList), '?');
        return '(' . implode(',', $placeholders) . ')';
    }

    private function runInsert(array $fieldsList): void
    {
        if ($this->statement->execute($this->getDataFromFieldsList($fieldsList)))
            $this->lastInsertId = $this->connection->getConnection()->lastInsertId();
    }
    private function getDataFromFieldsList(array $fieldsList): array
    {
        return array_values($fieldsList);
    }

    public function sendLog(string $level, string $message): void
    {
        $this->logger->setLevel($level);
        $this->logger->sendLog($message);
    }

    private function setError(): void
    {
        $this->errorCode = $this->statement->errorInfo()[1];
        $this->errorMessage = $this->statement->errorInfo()[2];
    }

    public function getLastError(): array
    {
        return array("errorCode" => $this->errorCode, "errorMessage" => $this->errorMessage, "scriptName" => $this->scriptName);
    }
}
