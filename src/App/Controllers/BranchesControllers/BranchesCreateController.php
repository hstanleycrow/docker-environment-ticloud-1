<?php

namespace App\Controllers\BranchesControllers;

use Models\Branch;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class BranchesCreateController extends Controller
{
    private $title = "Administrador de Sucursales | " . BUSINESS_NAME;
    private $h1 = "Agregar Sucursal";
    protected string $DTDefinition = 'branch';
    protected CrudController $crudController;
    protected Branch $branchModel;
    public string $currentRoute;

    public function showForm(): void
    {
        $data = [
            "action" => "add",
            "formAction" => "/branch/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
        ];

        echo Template::render('sections/Branches/BranchForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new BranchesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');

        $this->branchModel = new Branch($this->connection);
        $this->branchModel->create([
            'name' => $name,
        ]);
        FlashMessages::set('success', 'La sucursal se ha creado correctamente');
        unset($_SESSION['formData']);
        $this->route('branchesList');
    }
}
