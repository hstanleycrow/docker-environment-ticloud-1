<?php

namespace App\DatatablesDefinitions;

class Sauce
{
    public string $dbTable = 'sauces';
    public string $model = 'sauce';
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
                'view_name' => 'Nombre',
                'db_name' => '`a`.`name`',
                'field' => 'name',
                'format' => 'text',
            ],
            [
                'view_name' => 'Imagen',
                'db_name' => '`a`.`image`',
                'field' => 'image',
                'format' => 'image',
            ],
            [
                'view_name' => 'Activo',
                'db_name' => '`a`.`active`',
                'field' => 'active',
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
            ],
            [
                'button_id' => 'delete',
                'view_name' => 'Borrar',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'path' => 'borrar',
                'buttonText' => 'Borrar',
                'buttonClass' => \App\Components\Buttons\DeleteButton::class,
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
