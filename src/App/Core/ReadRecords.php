<?php

namespace App\Core;

use App\Core\Logger\ILogger;
use App\Core\Logger\LoggerRec;
use App\Core\DBConnection\DBError;
use App\Core\DBConnection\IConnection;

class ReadRecords
{
    private mixed $recordSet;
    private int $affectedRows;
    private DBError $dbError;
    private ILogger $logger;

    public function __construct(
        protected IConnection $connection,
        protected string $scriptName,
        protected ?string $query = "",
    ) {
        $this->logger = new LoggerRec("ReadRecordsError", DIR_BASE_LOGS);
        $this->dbError = new DBError($this->logger, $this->scriptName);
        $this->recordSet = false;
        $this->affectedRows = 0;
    }
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    public function execute(): mixed
    {
        assert(!empty($this->query), "Debe declarar el query a ejecutar primero");
        try {
            $this->runQuery();
            $this->setNoError();
        } catch (\PDOException $e) {
            $this->recordError($e);
        }
        return $this->returnRows();
    }
    private function runQuery(): void
    {
        $this->recordSet = $this->connection->getConnection()->query($this->query);
        if ($this->isRecorsetOk()) :
            $this->recordSet->setFetchMode(\PDO::FETCH_ASSOC);
            $this->setAffectedRows();
        endif;
    }

    private function isRecorsetOk(): bool
    {
        return ($this->recordSet !== false) ? true : false;
    }

    private function setAffectedRows(): void
    {
        $this->affectedRows = $this->recordSet->rowCount();
    }

    private function setNoError()
    {
        $this->dbError->setError(0, "Ok");
    }

    private function recordError(mixed $e): void
    {
        $this->dbError->saveInLog("error", "Error con query. Metodo: " . __METHOD__ . ", query: {$this->query}. Mensaje original:" . $e->getMessage() . ". Scriptname: " . $_SERVER['SCRIPT_NAME']);
        $this->dbError->setError($this->connection->getConnection()->errorInfo()[1], $this->connection->getConnection()->errorInfo()[2]);
    }

    private function returnRows(): array
    {
        $rows = array();
        if ($this->isRecorsetOk()) {
            while ($row = $this->recordSet->fetch()) :
                $rows[] = $row;
            endwhile;
        }
        return $rows;
    }
    public function getAffectedRows(): int
    {
        return $this->affectedRows;
    }
    public function isAffectedRows(): bool
    {
        if ($this->affectedRows >= 0)
            return true;
        return false;
    }
    public function getErrors(): DBError
    {
        return $this->dbError;
    }
}
