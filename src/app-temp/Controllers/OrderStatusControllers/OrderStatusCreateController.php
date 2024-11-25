<?php

namespace App\Controllers\OrderStatusControllers;

use Models\OrderStatus;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class OrderStatusCreateController extends Controller
{
    private $title = "Administrador de Estados de las ordenes | " . BUSINESS_NAME;
    private $h1 = "Agregar Estado";
    protected string $DTDefinition = 'orderStatus';
    protected CrudController $crudController;
    protected OrderStatus $orderStatusModel;
    public string $currentRoute;

    public function showForm(): void
    {
        $data = [
            "action" => "add",
            "formAction" => "/orderStatus/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
        ];

        echo Template::render('sections/OrderStatus/OrderStatusForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new OrderStatusFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');

        $this->orderStatusModel = new OrderStatus($this->connection);
        $this->orderStatusModel->create([
            'name' => $name,
        ]);
        FlashMessages::set('success', 'El estado se ha creado correctamente');
        unset($_SESSION['formData']);
        $this->route('orderStatusList');
    }
}
