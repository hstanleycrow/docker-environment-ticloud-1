<?php

namespace App\Core;

use App\Core\DBConnection\IConnection;

class Model
{
    protected CreateRecords $createRecords;
    protected ReadRecords $readRecords;
    protected ?string $table;
    protected string $query;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $perPage = 15;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    private mixed $statement;
    protected ?int $lastInsertId;
    protected string $scriptName;
    protected $errorCode;
    protected $errorMessage;


    public function __construct(protected IConnection $connection)
    {
        $this->scriptName = $_SERVER['SCRIPT_NAME'];
    }

    public function create(array $fieldsList): self
    {
        try {
            $this->createRecords = new CreateRecords($this->connection, $this->table, $this->scriptName);
            $this->lastInsertId = $this->createRecords->execute($fieldsList);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode(), $e);
        }
        return $this;
    }

    public function lastInsertId(): ?int
    {
        return $this->lastInsertId;
    }

    public function getRecords(): ?array
    {
        $readRecords = new ReadRecords($this->connection, $this->scriptName, $this->query);
        $records = $readRecords->execute();
        return (count($records) > 0) ? $records : [];
    }

    public function update(array $updateFields, array $whereConditions): self
    {
        $updateRecords = new UpdateRecords($this->connection, $this->table, $this->scriptName);
        $updateRecords->execute($updateFields, $whereConditions);
        return $this;
    }

    public function delete(array $whereConditions): self
    {
        $deleteRecords = new DeleteRecords($this->connection, $this->table);
        $deleteRecords->execute($whereConditions);
        return $this;
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                name
            FROM 
                $this->table
            WHERE 
                id = $id
        ";
        return $this->getRecords()[0];
    }

    public function beginTransaction(): void
    {
        $this->connection->getConnection()->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->getConnection()->commit();
    }

    public function rollback(): void
    {
        $this->connection->getConnection()->rollback();
    }

    public function query(string $query): self
    {
        $this->query = $query;
        return $this;
    }
}
