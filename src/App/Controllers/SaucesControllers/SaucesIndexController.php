<?php

namespace App\Controllers\SaucesControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class SaucesIndexController extends Controller
{
    private $title = "Administrador de Salsas | " . BUSINESS_NAME;
    private $h1 = "Listado de Salsas";
    protected string $DTDefinition = 'sauce';
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

        echo Template::render('sections/Sauces/SauceList.tpl', $data);
    }
}
