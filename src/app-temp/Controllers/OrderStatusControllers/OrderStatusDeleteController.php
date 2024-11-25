<?php

namespace App\Controllers\OrderStatusControllers;

use Models\OrderStatus;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class OrderStatusDeleteController extends Controller
{
    private $title = "Administrador de Sucursales | " . BUSINESS_NAME;
    private $h1 = "Editar Sucursal";
    protected string $DTDefinition = 'orderStatus';
    protected CrudController $crudController;
    protected OrderStatus $orderStatusModel;
    public string $currentRoute;


    public function delete($id)
    {
        $this->orderStatusModel = new OrderStatus($this->connection);
        $this->orderStatusModel->delete(
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El estado se ha eliminado correctamente');
        $this->route('orderStatusList');
    }
}
