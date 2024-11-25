<?php

namespace App\Controllers\CategoriesControllers;

use Models\Category;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class CategoriesDeleteController extends Controller
{
    private $title = "Administrador de Categorias | " . BUSINESS_NAME;
    private $h1 = "Eliminar Categoría";
    protected string $DTDefinition = 'category';
    protected CrudController $crudController;
    protected Category $model;
    public string $currentRoute;


    public function delete($id)
    {
        $this->model = new Category($this->connection);
        $record = $this->model->getById($id);
        $image = $record['image'];

        $this->model->delete(
            ['id' => $id,]
        );
        if (file_exists($image)) :
            unlink($image);
        endif;
        FlashMessages::set('success', 'La categoría se ha eliminado correctamente');
        $this->route('categoriesList');
    }
}
