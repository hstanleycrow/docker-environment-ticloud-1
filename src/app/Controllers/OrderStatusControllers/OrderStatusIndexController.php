<?php

namespace App\Controllers\OrderStatusControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class OrderStatusIndexController extends Controller
{
    private $title = "Administrador de Estados de las ordenes | " . BUSINESS_NAME;
    private $h1 = "Listado de estados de las ordenes";
    protected string $DTDefinition = 'orderStatus';
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

        echo Template::render('sections/OrderStatus/orderStatusList.tpl', $data);
    }
}
