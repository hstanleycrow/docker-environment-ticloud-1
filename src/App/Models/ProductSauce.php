<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class ProductSauce extends Model
{
    protected ?string $table = 'product_sauces';

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                product_id,
                sauce_id
            FROM 
                $this->table
            WHERE 
                id = $id
        ";
        return $this->getRecords()[0];
    }

    public function getAvailableSaucesForDropdownOptions(int $product_id): array
    {
        $this->query = "
        SELECT 
            id,
            name,
            image
        FROM 
            sauces
        WHERE
            id not in (select sauce_id from product_sauces where product_id = {$product_id})
            AND ACTIVE = 'S'
        ";
        return $this->getRecords();
    }

    public function getSelectedSaucesForDropdownOptions(int $product_id): array
    {
        $this->query = "
        SELECT 
            id,
            name,
            image
        FROM 
            sauces
        WHERE
            id in (select sauce_id from product_sauces where product_id = {$product_id})
            AND ACTIVE = 'S'
        ";
        return $this->getRecords();
    }

    public function getAll(): array
    {
        $this->query = "
            SELECT 
                id,
                product_id,
                sauce_id
            FROM 
                $this->table
        ";
        return $this->getRecords();
    }
}
