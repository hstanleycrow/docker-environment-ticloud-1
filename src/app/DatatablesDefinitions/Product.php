<?php

namespace App\DatatablesDefinitions;

class Product
{
    public string $dbTable = 'products';
    public string $model = 'product';
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
                'view_name' => 'Categoría',
                'db_name' => '`b`.`name`',
                'field' => 'category_name', 'as' => 'category_name',
                'format' => 'text',
            ],
            [
                'view_name' => 'Nombre',
                'db_name' => '`a`.`name`',
                'field' => 'name',
                'format' => 'text',
            ],
            [
                'view_name' => 'Precio',
                'db_name' => '`a`.`price`',
                'field' => 'price',
                'format' => 'money',
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
            [
                'button_id' => 'sauces',
                'view_name' => 'Salsas',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'path' => 'sauces',
                'buttonText' => 'Salsas',
                'buttonClass' => \App\Components\Buttons\SaucesButton::class,
            ],
            [
                'button_id' => 'extras',
                'view_name' => 'Extras',
                'db_name' => '`a`.`id`',
                'field' => 'id',
                'path' => 'extras',
                'buttonText' => 'SaExtraslsas',
                'buttonClass' => \App\Components\Buttons\ExtrasButton::class,
            ],
        ];
    }
    public function getJoinQuery(): string
    {
        return "FROM `{$this->dbTable}` AS `a` INNER JOIN `categories` AS `b` ON (`a`.`category_id` = `b`.`id`)";
    }
    public function getExtraCondition(): string
    {
        return "";
    }
}
