<?php

namespace App\Controllers\CategoriesControllers;

use Models\Category;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Core\ImageUploader\ImageUploader;
use App\Core\ImageUploader\ImageUploaderClient;

class CategoriesUpdateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/categories/';

    private $title = "Administrador de Categorias | " . BUSINESS_NAME;
    private $h1 = "Editar Categoría";
    protected string $DTDefinition = 'category';
    protected CrudController $crudController;
    protected Category $model;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->model = new Category($this->connection);
        $record = $this->model->getById($id);
        $record['id'] = $id;
        $data = [
            "action" => "edit",
            "formAction" => "/category/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
        ];
        unset($_SESSION['formData']);
        echo Template::render('sections/Categories/CategoryForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new CategoriesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $actual_image = $this->request->get('actual_image');
        $imagePath = $actual_image;
        $categoryImageUploaderClient = new ImageUploaderClient(new ImageUploader(self::UPLOADS_FOLDER), 'image');
        if ($categoryImageUploaderClient->isUploading()) :
            $imagePath = $categoryImageUploaderClient->upload();
            if (empty($imagePath)) :
                $_SESSION['errors']['image'] = 'Debe seleccionar una imagen';
                $this->route($this->currentRoute);
            endif;
        endif;

        $last_updated_by = $_SESSION['userdat']['id'];

        $this->model = new Category($this->connection);
        $this->model->update(
            [
                'name' => $name,
                'image' => $imagePath,
                'last_updated_by' => $last_updated_by,
            ],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'La categoría se ha editado correctamente');
        $this->route('categoriesList');
    }
}
