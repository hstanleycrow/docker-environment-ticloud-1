<?php

namespace App\Controllers\SaucesControllers;

use Models\Sauce;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\DBDropdown;
use App\Core\ImageUploader\ImageUploader;
use App\Core\ImageUploader\ImageUploaderClient;

class SaucesCreateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/sauces/';
    private $title = "Administrador de Salsas | " . BUSINESS_NAME;
    private $h1 = "Agregar Salsa";
    protected string $DTDefinition = 'sauce';
    protected CrudController $crudController;
    protected Sauce $model;
    public string $currentRoute;

    public function showForm(): void
    {
        $data = [
            "action" => "add",
            "formAction" => "/sauce/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
        ];

        echo Template::render('sections/Sauces/SauceForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new SaucesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');
        $description = $this->request->get('description');

        $productImageUploaderClient = new ImageUploaderClient(new ImageUploader(self::UPLOADS_FOLDER), 'image');
        $imagePath = $productImageUploaderClient->upload();
        if (empty($imagePath)) :
            $_SESSION['errors']['image'] = 'Debe seleccionar una imagen';
            $this->route($this->currentRoute);
        endif;

        $last_updated_by = $_SESSION['userdat']['id'];

        $this->model = new Sauce($this->connection);
        $this->model->create([
            'name' => $name,
            'description' => $description,
            'image' => $imagePath,
            'last_updated_by' => $last_updated_by,
        ]);
        FlashMessages::set('success', 'Salsa creada correctamente');
        unset($_SESSION['formData']);
        $this->route('saucesList');
    }
}
