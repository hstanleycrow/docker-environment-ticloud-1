<?php

namespace App\Controllers\ProductExtrasControllers;

use Models\ProductExtra;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\DBDropdown;

class ProductExtrasCreateController extends Controller
{
    private string $title = "Administrar extras de productos | " . BUSINESS_NAME;
    private string $h1 = "Combinar productos con extras";
    protected string $DTDefinition = 'productExtra';
    protected CrudController $crudController;
    protected ProductExtra $model;
    public string $currentRoute;

    public function showForm(int $product_id): void
    {
        $products = $this->getProductsDropdown($product_id);
        $availableExtras = $this->getAvailableExtrasDropdown($product_id);
        $selectedExtras = $this->getSelectedExtrasDropdown($product_id);
        $data = [
            "action" => "add",
            "formAction" => "/product/extras/[i:id]/",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
            'products' => $products,
            'availableExtras' => $availableExtras,
            'selectedExtras' => $selectedExtras,
        ];
        unset($_SESSION['formData']);
        echo Template::render('sections/ProductExtras/ProductExtraForm.tpl', $data);
    }

    public function create(): void
    {
        /* $validator = new ProductSaucesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages()); */
        $product_id = $this->request->get('product_id');
        $extra_id = $this->request->get('extra_id');


        $this->model = new ProductExtra($this->connection);
        $this->model->create([
            'product_id' => $product_id,
            'extra_id' => $extra_id,
        ]);
        FlashMessages::set('success', 'Extra agregada al producto correctamente');
        $this->route('productExtrasList');
    }

    private function getProductsDropdown(?int $selected = 0): string
    {
        $classes = 'form-select form-control';
        if (isset($_SESSION['errors']) && $_SESSION['errors']['product_id']) {
            $classes .= ' is-invalid';
        }

        return (new DBDropdown(
            $this->connection,
            'Models\Product',
            'getForDropdownOptions',
            $selected
        ))
            ->setName('product_id')
            ->setId('product_id')
            ->addClass($classes)
            ->setDisabled(true)
            ->render();
    }

    private function getAvailableExtrasDropdown(int $product_id, ?int $selected = 0): string
    {
        $classes = 'form-select form-control';
        if (isset($_SESSION['errors']) && $_SESSION['errors']['product_id']) {
            $classes .= ' is-invalid';
        }

        return (new DBDropdown(
            $this->connection,
            'Models\ProductExtra',
            'getAvailableExtrasForDropdownOptions',
            $selected,
            true,
            [$product_id]
        ))
            ->setName('available_extra_id')
            ->setId('available_extra_id')
            ->setMultiple(true)
            ->addClass($classes)
            ->render();
    }

    private function getSelectedExtrasDropdown(int $product_id, ?int $selected = 0): string
    {
        $classes = 'form-select form-control';
        if (isset($_SESSION['errors']) && $_SESSION['errors']['product_id']) {
            $classes .= ' is-invalid';
        }

        return (new DBDropdown(
            $this->connection,
            'Models\ProductExtra',
            'getSelectedExtrasForDropdownOptions',
            $selected,
            true,
            [$product_id]
        ))
            ->setName('selected_extra_id')
            ->setId('selected_extra_id')
            ->setMultiple(true)
            ->addClass($classes)
            ->render();
    }
}
