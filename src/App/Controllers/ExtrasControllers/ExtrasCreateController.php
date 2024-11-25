<?php

namespace App\Controllers\ExtrasControllers;

use Models\Extra;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\DBDropdown;
use App\Core\ImageUploader\ImageUploader;
use App\Core\ImageUploader\ImageUploaderClient;

class ExtrasCreateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/extras/';
    private $title = "Administrador de Extras | " . BUSINESS_NAME;
    private $h1 = "Agregar Extra";
    protected string $DTDefinition = 'extra';
    protected CrudController $crudController;
    protected Extra $model;
    public string $currentRoute;

    public function showForm(): void
    {
        $data = [
            "action" => "add",
            "formAction" => "/extra/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
        ];

        echo Template::render('sections/Extras/ExtraForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new ExtrasFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');
        $price = $this->request->get('price');
        $description = $this->request->get('description');

        $productImageUploaderClient = new ImageUploaderClient(new ImageUploader(self::UPLOADS_FOLDER), 'image');
        $imagePath = $productImageUploaderClient->upload();
        if (empty($imagePath)) :
            $_SESSION['errors']['image'] = 'Debe seleccionar una imagen';
            $this->route($this->currentRoute);
        endif;

        $last_updated_by = $_SESSION['userdat']['id'];

        $this->model = new Extra($this->connection);
        $this->model->create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $imagePath,
            'last_updated_by' => $last_updated_by,
        ]);
        FlashMessages::set('success', 'Extra creado correctamente');
        unset($_SESSION['formData']);
        $this->route('extrasList');
    }
}
