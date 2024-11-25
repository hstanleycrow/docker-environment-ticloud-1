<?php

namespace App\Controllers\OrderStatusControllers;

use Models\OrderStatus;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class OrderStatusUpdateController extends Controller
{
    private $title = "Administrador de Estados de las ordenes | " . BUSINESS_NAME;
    private $h1 = "Editar Estado de la orden";
    protected string $DTDefinition = 'orderStatus';
    protected CrudController $crudController;
    protected OrderStatus $orderStatusModel;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->orderStatusModel = new OrderStatus($this->connection);
        $record = $this->orderStatusModel->getById($id);
        $record['id'] = $id;
        $data = [
            "action" => "edit",
            "formAction" => "/orderStatus/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
        ];
        echo Template::render('sections/OrderStatus/OrderStatusForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new OrderStatusFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');

        $this->orderStatusModel = new OrderStatus($this->connection);
        $this->orderStatusModel->update(
            ['name' => $name,],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El estado se ha editado correctamente');
        unset($_SESSION['formData']);
        $this->route('orderStatusList');
    }
}
