<?php

namespace App\Controllers\ProductsControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class ProductsIndexController extends Controller
{
    private $title = "Administrador de Productos | " . BUSINESS_NAME;
    private $h1 = "Listado de Productos";
    protected string $DTDefinition = 'product';
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

        echo Template::render('sections/Products/ProductList.tpl', $data);
    }
}
