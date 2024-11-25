<?php

namespace Models;

use App\Core\Model;
#use App\Core\ReadRecords;
use App\Core\DbConnection;
use App\Core\DBConnection\IConnection;

class Category extends Model
{
    protected ?string $table = 'categories';

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getForDropdownOptions(): ?array
    {
        $this->query = "
            SELECT 
                id,
                name
            FROM 
                $this->table
            ORDER BY id ASC
        ";
        return parent::getRecords();
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                name,
                image
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
                image
            FROM 
                $this->table
            ORDER BY id ASC
        ";
        return parent::getRecords();
    }
}
