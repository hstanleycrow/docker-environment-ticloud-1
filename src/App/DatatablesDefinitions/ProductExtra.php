<?php

namespace App\DatatablesDefinitions;

class ProductExtra
{
    public string $dbTable = 'product_extras';
    public string $model = 'product_extra';
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
                'view_name' => 'Producto',
                'db_name' => '`b`.`name`',
                'field' => 'product_name', 'as' => 'product_name',
                'format' => 'text',
            ],
            [
                'view_name' => 'Extra',
                'db_name' => '`c`.`name`',
                'field' => 'extra_name', 'as' => 'extra_name',
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
        return "
            FROM `{$this->dbTable}` AS `a` 
            INNER JOIN `products` AS `b` ON (`a`.`product_id` = `b`.`id`)
            INNER JOIN `extras` AS `c` ON (`a`.`extra_id` = `c`.`id`)
        ";
        #return "FROM `{$this->dbTable}` AS `a`";
    }
    public function getExtraCondition(): string
    {
        return "";
    }
}
