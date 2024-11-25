<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Branch extends Model
{
    protected ?string $table = 'branches';
    protected string $scriptName;

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
        return $this->getRecords();
    }
}
