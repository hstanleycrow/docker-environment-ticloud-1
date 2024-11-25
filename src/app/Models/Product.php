<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Product extends Model
{
    protected ?string $table = 'products';

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                name,
                description,
                price,
                image,
                active,
                category_id
            FROM 
                $this->table
            WHERE 
                id = $id
        ";
        return $this->getRecords()[0];
    }

    public function getByCategoryId(int $id): ?array
    {
        $this->query = "
            SELECT 
                id,
                name,
                description,
                price,
                image
            FROM 
                $this->table
            WHERE 
                category_id = $id
                AND active = 'S'
        ";
        return $this->getRecords();
    }

    public function getForDropdownOptions(): ?array
    {
        $this->query = "
            SELECT 
                id,
                name
            FROM 
                $this->table
            WHERE
                active = 'S'
            ORDER BY id ASC
        ";
        return parent::getRecords();
    }
}
