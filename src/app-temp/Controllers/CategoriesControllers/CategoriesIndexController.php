<?php

namespace App\Controllers\CategoriesControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class CategoriesIndexController extends Controller
{
    private $title = "Administrador de Categorias | " . BUSINESS_NAME;
    private $h1 = "Listado de Categorias";
    protected string $DTDefinition = 'category';
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

        echo Template::render('sections/Categories/CategoryList.tpl', $data);
    }
}
