<?php

namespace App\Controllers\BranchesControllers;

use Models\Branch;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class BranchesDeleteController extends Controller
{
    private $title = "Administrador de Sucursales | " . BUSINESS_NAME;
    private $h1 = "Editar Sucursal";
    protected string $DTDefinition = 'branch';
    protected CrudController $crudController;
    protected Branch $branchModel;
    public string $currentRoute;


    public function delete($id)
    {
        $this->branchModel = new Branch($this->connection);
        $this->branchModel->delete(
            ['id' => $id,]
        );
        FlashMessages::set('success', 'La sucursal se ha eliminado correctamente');
        $this->route('branchesList');
    }
}
