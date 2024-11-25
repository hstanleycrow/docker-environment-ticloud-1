<?php

namespace App\Controllers\ExtrasControllers;

use Models\Extra;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\Dropdown;
use App\Core\ImageUploader\ImageUploader;
use App\Components\Dropdowns\DropdownClient;
use App\Core\ImageUploader\ImageUploaderClient;

class ExtrasUpdateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/extras/';
    private $title = "Administrador de Extras | " . BUSINESS_NAME;
    private $h1 = "Editar Extra";
    protected string $DTDefinition = 'extra';
    protected CrudController $crudController;
    protected Extra $model;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->model = new Extra($this->connection);
        $record = $this->model->getById($id);
        $record['id'] = $id;
        $active = $this->getActiveDropdown($record['active']);
        $data = [
            "action" => "edit",
            "formAction" => "/extra/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
            "active" => $active,
        ];
        unset($_SESSION['formData']);
        echo Template::render('sections/Extras/ExtraForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new ExtrasFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $price = $this->request->get('price');
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

        $this->model = new Extra($this->connection);
        $this->model->update(
            [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'image' => $imagePath,
                'active' => $active,
                'last_updated_by' => $last_updated_by,
            ],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El extra se ha editado correctamente');
        $this->route('extrasList');
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
