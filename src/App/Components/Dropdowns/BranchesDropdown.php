<?php

namespace App\Components\Dropdowns;

use App\Core\DBConnection\IConnection;

class BranchesDropdown extends Dropdown
{
    const DEFAULT_BRANCH = 1;

    public function __construct(protected IConnection $connection)
    {
    }

    public function getBranchesDropdown(): string
    {
        return (new DBDropdown(
            $this->connection,
            'Models\Branch',
            'getForDropdownOptions',
            self::DEFAULT_BRANCH
        ))
            ->addClass('form-control form-select')
            ->setName('branch_id')
            ->render();
    }
}
