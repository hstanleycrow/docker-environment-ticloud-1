<?php

namespace App\DatatablesDefinitions;

class Branch
{
    public string $dbTable = 'branches';
    public string $model = 'branch';
    public string $primaryKey = 'id';
    public function getColumns(): array
    {
        return [
            [
                'view_name' => 'Id',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'format' => 'text',
            ],
            [
                'view_name' => 'Sucursal',
                'db_name' => '`a`.`name`',
                'field' => 'name',
                'format' => 'text',
            ],

        ];
    }
    public function getButtons(): array
    {
        return [
            [
                'button_id' => 'edit',
                'view_name' => 'Editar',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'path' => 'editar',
                'buttonText' => 'Editar',
                'buttonClass' => \App\Components\Buttons\EditButton::class,
                #'buttonClass' => \hstanleycrow\EasyPHPDatatableCRUD\Buttons\EditButton::class,
            ],
            [
                'button_id' => 'delete',
                'view_name' => 'Borrar',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'path' => 'borrar',
                'buttonText' => 'Borrar',
                'buttonClass' => \App\Components\Buttons\DeleteButton::class,
                #'buttonClass' => \hstanleycrow\EasyPHPDatatableCRUD\Buttons\DeleteButton::class,
            ],
        ];
    }
    public function getJoinQuery(): string
    {
        return "FROM `{$this->dbTable}` AS `a`";
    }
    public function getExtraCondition(): string
    {
        return "";
    }
}
