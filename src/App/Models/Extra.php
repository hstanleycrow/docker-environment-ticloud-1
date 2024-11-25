<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Extra extends Model
{
    protected ?string $table = 'extras';

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                name,
                price,
                description,
                image,
                active
            FROM 
                $this->table
            WHERE 
                id = $id
        ";
        return $this->getRecords()[0];
    }

    public function getAll(): ?array
    {
        $this->query = "
            SELECT 
                id,
                name,
                description,
                image
            FROM 
                $this->table
            WHERE
                active = 'S'
            ORDER BY id ASC
        ";
        return parent::getRecords();
    }
}
