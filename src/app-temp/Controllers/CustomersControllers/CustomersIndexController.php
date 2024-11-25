<?php

namespace App\Controllers\CustomersControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class CustomersIndexController extends Controller
{
    private $title = "Administrador de Clientes | " . BUSINESS_NAME;
    private $h1 = "Listado de clientes";
    protected string $DTDefinition = 'customer';
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

        echo Template::render('sections/Customers/customerList.tpl', $data);
    }
}
