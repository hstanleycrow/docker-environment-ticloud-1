<?php

namespace App\Controllers\ProductsControllers;

use Models\Product;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\DBDropdown;
use App\Core\ImageUploader\ImageUploader;
use App\Core\ImageUploader\ImageUploaderClient;

class ProductsCreateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/products/';
    private string $title = "Administrador de Productos | " . BUSINESS_NAME;
    private string $h1 = "Agregar Producto";
    protected string $DTDefinition = 'product';
    protected CrudController $crudController;
    protected Product $model;
    public string $currentRoute;

    public function showForm(): void
    {
        $categories = $this->getCategoriesDropdown();
        $data = [
            "action" => "add",
            "formAction" => "/product/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
            'categories' => $categories,
            'active' => 'S',
        ];
        echo Template::render('sections/Products/ProductForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new ProductsFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');
        $description = $this->request->get('description');
        $price = $this->request->get('price');
        $category_id = $this->request->get('category_id');

        $productImageUploaderClient = new ImageUploaderClient(new ImageUploader(self::UPLOADS_FOLDER), 'image');
        $imagePath = $productImageUploaderClient->upload();
        if (empty($imagePath)) :
            $_SESSION['errors']['image'] = 'Debe seleccionar una imagen';
            $this->route($this->currentRoute);
        endif;

        $last_updated_by = $_SESSION['userdat']['id'];

        #$categories = $this->getCategoriesDropdown($category_id);

        $this->model = new Product($this->connection);
        $this->model->create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
            'image' => $imagePath,
            'last_updated_by' => $last_updated_by,
        ]);
        FlashMessages::set('success', 'Producto creado correctamente');
        unset($_SESSION['formData']);
        $this->route('productsList');
    }

    private function getCategoriesDropdown(): string
    {
        $selected = isset($_SESSION['formData']['category_id']) ? $_SESSION['formData']['category_id'] : 0;
        $classes = 'form-select form-control';
        if (isset($_SESSION['errors']) && isset($_SESSION['errors']['category_id'])) {
            $classes .= ' is-invalid';
        }

        return (new DBDropdown(
            $this->connection,
            'Models\Category',
            'getForDropdownOptions',
            $selected
        ))
            ->setName('category_id')
            ->addClass($classes)
            ->render();
    }
}
