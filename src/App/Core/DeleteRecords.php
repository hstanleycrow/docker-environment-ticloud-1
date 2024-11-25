<?php

namespace App\Core;

use App\Core\DBConnection\IConnection;


class DeleteRecords
{
    private mixed $statement;
    private string $scriptName;
    private DBError $dbError;
    protected $errorCode;
    protected $errorMessage;

    public function __construct(protected IConnection $connection, protected string $table)
    {
        $this->table = $table;
        $this->dbError = new DBError();
        $this->scriptName = $_SERVER['SCRIPT_NAME'];
        $this->connection = $connection;
    }

    public function execute(array $whereConditions): bool|\PDOException
    {
        try {
            if ($this->statement = $this->prepareStatement($whereConditions))
                $this->runDelete($whereConditions);
            else
                throw new \PDOException("Error preparando el statement");
        } catch (\PDOException $e) {

            $this->dbError->saveInLog(
                "error",
                "Query error. Metodo: " . __METHOD__ . ". Query: " . $this->statement->queryString . ". Where Conditions: " . print_r($whereConditions, 1) . ". Source Error Message:" . $e->getMessage() . ". ScriptName: " . $this->scriptName
            );

            $this->dbError->setError(
                $this->connection->getConnection()->errorInfo()[1],
                $this->connection->getConnection()->errorInfo()[2]
            );

            throw new \PDOException($e->getMessage());
        }
        return true;
    }

    private function prepareStatement(array $whereConditions): mixed
    {
        return $this->connection->getConnection()->prepare($this->configQuery($whereConditions));
    }

    private function configQuery(array $whereConditions): string
    {
        $whereString = implode(' AND ', array_map(function ($field) {
            return "$field = ?";
        }, array_keys($whereConditions)));

        return "DELETE FROM {$this->table} WHERE $whereString";
    }

    private function runDelete(array $whereConditions): void
    {
        if ($this->statement->execute($this->getDataFromFieldsList($whereConditions)))
            $this->setSuccess();
    }

    private function getDataFromFieldsList(array $fieldsList): array
    {
        $values = array();
        foreach ($fieldsList as $data) :
            array_push($values, $data);
        endforeach;
        return $values;
    }

    private function setSuccess(): void
    {
        // Implement any success-related logic if needed.
    }

    // Rest of the methods...
}
