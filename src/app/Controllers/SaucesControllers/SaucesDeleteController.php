<?php

namespace App\Controllers\ProductsControllers;

use Models\Product;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class ProductsDeleteController extends Controller
{
    private $title = "Administrador de Productos | " . BUSINESS_NAME;
    private $h1 = "Eliminar Producto";
    protected string $DTDefinition = 'product';
    protected CrudController $crudController;
    protected Product $model;
    public string $currentRoute;


    public function delete($id)
    {
        $this->model = new Product($this->connection);
        $record = $this->model->getById($id);
        $image = $record['image'];
        $this->model->delete(
            ['id' => $id,]
        );
        if (file_exists($image)) :
            unlink($image);
        endif;
        FlashMessages::set('success', 'El producto se ha eliminado correctamente');
        $this->route('productsList');
    }
}
