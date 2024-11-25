<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Address extends Model
{
    protected ?string $table = 'addresses';
    protected string $scriptName;

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getMainAddressByCustomerId(int $customerId): ?array
    {
        $this->query = "
            SELECT 
                id,
                address,
                reference_point,
                type
            FROM 
                $this->table 
            WHERE 
                customer_id = {$customerId} 
                AND is_main = 'S'
        ";

        $data = array();
        $data = $this->getRecords();
        return (count($data) > 0) ? $data[0] : false;
    }
}
