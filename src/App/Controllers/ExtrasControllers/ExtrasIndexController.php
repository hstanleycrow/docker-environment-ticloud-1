<?php

namespace App\Controllers\ExtrasControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class ExtrasIndexController extends Controller
{
    private $title = "Administrador de Extras | " . BUSINESS_NAME;
    private $h1 = "Listado de Extras";
    protected string $DTDefinition = 'extra';
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

        echo Template::render('sections/Extras/ExtraList.tpl', $data);
    }
}
