<?php

namespace App\Controllers\ProductExtrasControllers;

use App\Core\Template;
use Models\ProductExtra;
use App\Controllers\Controller;

class ProductExtrasAjaxController extends Controller
{
    private static $title = "Administrador de Productos | " . BUSINESS_NAME;
    private static $h1 = "Administrador de Productos";
    protected ProductExtra $model;

    public function index()
    {
        $data = [
            "title" => self::$title,
            "h1" => self::$h1
        ];

        echo Template::render('sections/ProductExtras/product_extras_processing', $data);
    }

    public function processRequest()
    {
        $action = $this->request->get('action');
        $product_id = $this->request->get('product_id');
        $extra_id = $this->request->get('extra_id');
        switch ($action) {
            case 'add':
                $this->add($product_id, $extra_id);
                break;
            case 'remove':
                $this->remove($product_id, $extra_id);
                break;
            default:
                break;
        }
        // Establecer el encabezado de contenido como JSON
        header('Content-Type: application/json');

        // Devolver la respuesta en formato JSON
        echo json_encode('yes');
    }

    private function add(int $product_id, int $extra_id): void
    {
        $this->model = new ProductExtra($this->connection);
        $this->model->create([
            'product_id' => $product_id,
            'extra_id' => $extra_id,
        ]);
    }

    private function remove(int $product_id, int $extra_id): void
    {
        $this->model = new ProductExtra($this->connection);
        $this->model->delete([
            'product_id' => $product_id,
            'extra_id' => $extra_id,
        ]);
    }
}
