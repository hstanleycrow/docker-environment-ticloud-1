<?php

namespace App\DatatablesDefinitions;

class Customer
{
    public string $dbTable = 'customers';
    public string $model = 'customer';
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
                'view_name' => 'Telefono Principal',
                'db_name' => '`b`.`phone_number`',
                'field' => 'phone_number', 'as' => 'phone_number',
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
            [
                'button_id' => 'addOrder',
                'view_name' => 'addOrder',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'path' => 'orders',
                'buttonText' => 'Orden',
                'buttonClass' => \App\Components\Buttons\AddOrderButton::class,
            ],
        ];
    }
    public function getJoinQuery(): string
    {
        return "FROM `{$this->dbTable}` AS `a` INNER JOIN `phone_numbers` AS `b` ON (`a`.`id` = `b`.`customer_id`)";
    }
    public function getExtraCondition(): string
    {
        return "`b`.`is_main` = 'S'";
    }
}
