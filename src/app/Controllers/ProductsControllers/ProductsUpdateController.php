<?php

namespace App\Controllers\ProductsControllers;

use Models\Product;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\Dropdown;
use App\Components\Dropdowns\DBDropdown;
use App\Core\ImageUploader\ImageUploader;
use App\Components\Dropdowns\DropdownClient;
use App\Core\ImageUploader\ImageUploaderClient;

class ProductsUpdateController extends Controller
{
    const UPLOADS_FOLDER = 'uploads/products/';
    private string $title = "Administrador de Productos | " . BUSINESS_NAME;
    private string $h1 = "Editar Producto";
    protected string $DTDefinition = 'product';
    protected CrudController $crudController;
    protected Product $model;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->model = new Product($this->connection);
        $record = $this->model->getById($id);
        $record['id'] = $id;
        $active = $this->getActiveDropdown($record['active']);
        $_SESSION['formData']['category_id'] = $record['category_id'];
        $categories = $this->getCategoriesDropdown();
        $data = [
            "action" => "edit",
            "formAction" => "/product/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
            "active" => $active,
            'categories' => $categories,
        ];
        echo Template::render('sections/Products/ProductForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new ProductsFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $description = $this->request->get('description');
        $price = $this->request->get('price');
        $category_id = $this->request->get('category_id');
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

        $this->model = new Product($this->connection);
        $this->model->update(
            [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'image' => $imagePath,
                'active' => $active,
                'last_updated_by' => $last_updated_by,
            ],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El producto se ha editado correctamente');
        unset($_SESSION['formData']);

        $this->route('productsList');
    }

    private function getActiveDropdown(string $selected): string
    {
        $selected = $selected == 'S' ? 0 : 1;
        $dropdownClient = new DropdownClient(['S', 'N'],  $selected);
        return (new Dropdown($dropdownClient))
            ->setName('active')
            ->setId('active')
            ->addClass('form-select form-control')
            ->render();
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
