<?php

namespace App\Controllers\SaucesControllers;

use Models\Sauce;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\Dropdown;
use App\Components\Dropdowns\DBDropdown;
use App\Core\ImageUploader\ImageUploader;
use App\Components\Dropdowns\DropdownClient;
use App\Core\ImageUploader\ImageUploaderClient;

class SaucesUpdateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/sauces/';
    private $title = "Administrador de Salsas | " . BUSINESS_NAME;
    private $h1 = "Editar Salsa";
    protected string $DTDefinition = 'sauce';
    protected CrudController $crudController;
    protected Sauce $model;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->model = new Sauce($this->connection);
        $record = $this->model->getById($id);
        $record['id'] = $id;
        $active = $this->getActiveDropdown($record['active']);
        $data = [
            "action" => "edit",
            "formAction" => "/sauce/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
            "active" => $active,
        ];
        unset($_SESSION['formData']);
        echo Template::render('sections/Sauces/SauceForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new SaucesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $description = $this->request->get('description');
        $active = $this->request->get('active');
        $active = $active === '0' ? 'S' : 'N';
        $actual_image = $this->request->get('actual_image');
        $imagePath = $actual_image;
        $productImageUploaderClient = new ImageUploaderClient(new ImageUploader(self::UPLOADS_FOLDER), 'image');
        if ($productImageUploaderClient->isUploading()) :
            $imagePath = $productImageUploaderClient->upload();
            if (empty($imagePath)) :
                $_SESSION['errors']['image'] = 'Debe seleccionar una imagen';
                $this->route($this->currentRoute);
            endif;
        endif;
        $last_updated_by = $_SESSION['userdat']['id'];

        $this->model = new Sauce($this->connection);
        $this->model->update(
            [
                'name' => $name,
                'description' => $description,
                'image' => $imagePath,
                'active' => $active,
                'last_updated_by' => $last_updated_by,
            ],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'La salsa se ha editado correctamente');
        $this->route('saucesList');
    }

    private function getActiveDropdown(string $selected): string
    {
        $selected = $selected == 'S' ? 0 : 1;
        $dropdownClient = new DropdownClient(['S', 'N'],  $selected);
        return (new Dropdown($dropdownClient))
            ->setName('active')
            ->addClass('form-select form-control')
            ->render();
    }
}
