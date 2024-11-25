<?php

namespace App\Controllers\ProductSaucesControllers;

use App\Core\Template;
use Models\ProductSauce;
use App\Core\FlashMessages;
use App\Controllers\Controller;

class ProductSaucesAjaxController extends Controller
{
    private static $title = "Administrador de Productos | " . BUSINESS_NAME;
    private static $h1 = "Administrador de Productos";
    protected ProductSauce $model;

    public function index()
    {
        $data = [
            "title" => self::$title,
            "h1" => self::$h1
        ];

        echo Template::render('sections/ProductSauces/product_sauces_processing', $data);
    }

    public function processRequest()
    {
        $action = $this->request->get('action');
        $product_id = $this->request->get('product_id');
        $sauce_id = $this->request->get('sauce_id');
        switch ($action) {
            case 'add':
                $this->add($product_id, $sauce_id);
                break;
            case 'remove':
                $this->remove($product_id, $sauce_id);
                break;
            default:
                break;
        }
        // Establecer el encabezado de contenido como JSON
        header('Content-Type: application/json');

        // Devolver la respuesta en formato JSON
        echo json_encode('yes');
    }

    private function add(int $product_id, int $sauce_id): void
    {
        $this->model = new ProductSauce($this->connection);
        $this->model->create([
            'product_id' => $product_id,
            'sauce_id' => $sauce_id,
        ]);
    }

    private function remove(int $product_id, int $sauce_id): void
    {
        $this->model = new ProductSauce($this->connection);
        $this->model->delete([
            'product_id' => $product_id,
            'sauce_id' => $sauce_id,
        ]);
    }
}
