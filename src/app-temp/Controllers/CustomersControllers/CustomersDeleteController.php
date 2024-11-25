<?php

namespace App\Controllers\CustomersControllers;

use Models\Customer;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class CustomersDeleteController extends Controller
{
    private $title = "Administrador de Sucursales | " . BUSINESS_NAME;
    private $h1 = "Editar Sucursal";
    protected string $DTDefinition = 'customer';
    protected CrudController $crudController;
    protected Customer $customerModel;
    public string $currentRoute;


    public function delete($id)
    {
        $this->customerModel = new Customer($this->connection);
        $this->customerModel->delete(
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El cliente se ha eliminado correctamente');
        $this->route('customersList');
    }
}
