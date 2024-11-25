<?php

namespace Models;

use App\Core\Model;
#use App\Core\ReadRecords;
use App\Core\DbConnection;
use App\Core\DBConnection\IConnection;

class PaymentMethod extends Model
{
    protected ?string $table = 'payment_methods';

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
}
