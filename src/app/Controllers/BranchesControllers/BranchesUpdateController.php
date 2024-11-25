<?php

namespace App\Controllers\BranchesControllers;

use Models\Branch;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class BranchesUpdateController extends Controller
{
    private $title = "Administrador de Sucursales | " . BUSINESS_NAME;
    private $h1 = "Editar Sucursal";
    protected string $DTDefinition = 'branch';
    protected CrudController $crudController;
    protected Branch $branchModel;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->branchModel = new Branch($this->connection);
        $record = $this->branchModel->getById($id);
        $record['id'] = $id;
        $data = [
            "action" => "edit",
            "formAction" => "/branch/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
        ];
        unset($_SESSION['formData']);
        echo Template::render('sections/Branches/BranchForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new BranchesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');

        $this->branchModel = new Branch($this->connection);
        $this->branchModel->update(
            ['name' => $name,],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'La sucursal se ha editado correctamente');
        $this->route('branchesList');
    }
}
