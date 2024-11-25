<?php

namespace App\DatatablesDefinitions;

class User
{
    public string $dbTable = 'users';
    public string $model = 'user';
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
                'field' => 'user_name', 'as' => 'user_name',
                'format' => 'text',
            ],
            [
                'view_name' => 'Usuario',
                'db_name' => '`a`.`username`',
                'field' => 'username',
                'format' => 'text',
            ],
            [
                'view_name' => 'Activo',
                'db_name' => '`a`.`active`',
                'field' => 'active',
                'format' => 'text',
            ],
            [
                'view_name' => 'Created at',
                'db_name' => '`a`.`created_at`',
                'field' => 'created_at',
                'format' => 'date',
            ],
            [
                'view_name' => 'Estado',
                'db_name' => '`b`.`name`',
                'field' => 'status_name', 'as' => 'status_name',
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
        return "FROM `{$this->dbTable}` AS `a` INNER JOIN `user_status` AS `b` ON (`a`.`status_id` = `b`.`id`)";
    }
    public function getExtraCondition(): string
    {
        return "";
    }
}
