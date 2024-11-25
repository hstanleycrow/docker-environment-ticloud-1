<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class ProductExtra extends Model
{
    protected ?string $table = 'product_extras';

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                product_id,
                extra_id
            FROM 
                $this->table
            WHERE 
                id = $id
        ";
        return $this->getRecords()[0];
    }

    public function getAvailableExtrasForDropdownOptions(int $product_id): array
    {
        $this->query = "
        SELECT 
            id,
            name,
            image
        FROM 
            extras
        WHERE
            id not in (select extra_id from product_extras where product_id = {$product_id})
            AND ACTIVE = 'S'
        ";
        return $this->getRecords();
    }

    public function getSelectedExtrasForDropdownOptions(int $product_id): array
    {
        $this->query = "
        SELECT 
            id,
            name,
            image
        FROM 
            extras
        WHERE
            id in (select extra_id from product_extras where product_id = {$product_id})
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
