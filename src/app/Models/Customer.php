<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Customer extends Model
{
    protected ?string $table = 'customers';
    protected string $scriptName;

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getById(int $id): ?array
    {
        $this->query = "
            SELECT 
                name,
                email,
                password,
                notes
            FROM 
                $this->table
            WHERE 
                id = $id
        ";
        return $this->getRecords()[0];
    }

    public function getCustomerWithContactsById(int $id): ?array
    {
        $this->query = "
            SELECT
                a.id,
                a.name,
                a.email,
                a.password,
                a.notes,
                b.phone_number,
                c.address,
                c.reference_point
            FROM 
                $this->table a INNER JOIN phone_numbers b ON a.id = b.customer_id
                INNER JOIN addresses c ON a.id = c.customer_id
            WHERE 
                a.id = $id
                and b.is_main = 'S'
                and c.is_main = 'S'
        ";
        return $this->getRecords()[0];
    }
}
