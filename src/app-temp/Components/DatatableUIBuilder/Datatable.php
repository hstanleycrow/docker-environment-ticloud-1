<?php

namespace App\Components\DatatableUIBuilder;


class Datatable extends DatatableBase
{

    public function __construct(private string $DTDefinition, private ?array $dtDisabledIdButtons = [])
    {
        $databaseClient = new DatatableClient($DTDefinition, $dtDisabledIdButtons);
        parent::__construct($databaseClient);
    }
}
