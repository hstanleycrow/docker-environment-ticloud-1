<?php

namespace App\Controllers;

use App\Components\DatatableUIBuilder\Datatable;

class CrudController
{

    public function generateDatatable(string $DTDefinition)
    {
        return (new Datatable(DTDefinition: $DTDefinition, dtDisabledIdButtons: []))
            ->setAddButtonClass(\App\Components\Buttons\AddButton::class);
    }
}
