<?php

namespace App\Controllers\CategoriesControllers;

use Models\Category;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Core\ImageUploader\ImageUploader;
use App\Core\ImageUploader\ImageUploaderClient;

class CategoriesCreateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/categories/';
    private $title = "Administrador de Categorias | " . BUSINESS_NAME;
    private $h1 = "Agregar Categoria";
    protected string $DTDefinition = 'category';
    protected CrudController $crudController;
    protected Category $model;
    protected ImageUploader $categoryImageUpload;
    public string $currentRoute;

    public function showForm(): void
    {
        $data = [
            "action" => "add",
            "formAction" => "/category/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
        ];

        echo Template::render('sections/Categories/CategoryForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new CategoriesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');

        $categoryImageUploaderClient = new ImageUploaderClient(new ImageUploader(self::UPLOADS_FOLDER), 'image');
        $imagePath = $categoryImageUploaderClient->upload();
        if (empty($imagePath)) :
            $_SESSION['errors']['image'] = 'Debe seleccionar una imagen';
            $this->route($this->currentRoute);
        endif;
        $last_updated_by = $_SESSION['userdat']['id'];

        $this->model = new Category($this->connection);
        $this->model->create([
            'name' => $name,
            'image' => $imagePath,
            'last_updated_by' => $last_updated_by,
        ]);
        FlashMessages::set('success', 'Categoria creada correctamente');
        unset($_SESSION['formData']);
        $this->route('categoriesList');
    }
}
