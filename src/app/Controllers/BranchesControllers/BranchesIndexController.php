<?php

namespace App\Controllers\BranchesControllers;

use App\Core\Template;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class BranchesIndexController extends Controller
{
    private $title = "Administrador de Sucursales | " . BUSINESS_NAME;
    private $h1 = "Listado de sucursales";
    protected string $DTDefinition = 'branch';
    protected CrudController $crudController;
    #protected Branch $branchModel;
    public string $currentRoute;

    public function index(): void
    {
        $datatable = (new CrudController())->generateDatatable($this->DTDefinition);
        $data = [
            "title" => $this->title,
            "h1" => $this->h1,
            "datatable" => $datatable,
        ];

        echo Template::render('sections/Branches/branchList.tpl', $data);
    }
}
