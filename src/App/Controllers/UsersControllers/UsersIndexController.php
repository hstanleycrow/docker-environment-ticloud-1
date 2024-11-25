<?php

namespace App\Controllers\UsersControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class UsersIndexController extends Controller
{
    private $title = "Administrador de Usuarios | " . BUSINESS_NAME;
    private $h1 = "Listado de usuarios";
    protected string $DTDefinition = 'user';
    protected CrudController $crudController;
    public string $currentRoute;

    public function index(): void
    {
        $datatable = (new CrudController())->generateDatatable($this->DTDefinition);
        $data = [
            "title" => $this->title,
            "h1" => $this->h1,
            "datatable" => $datatable,
        ];

        echo Template::render('Sections/Users/userList.tpl', $data);
    }
}
