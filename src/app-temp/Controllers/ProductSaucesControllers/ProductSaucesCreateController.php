<?php

namespace App\Controllers\ProductSaucesControllers;

use Models\ProductSauce;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\DBDropdown;

class ProductSaucesCreateController extends Controller
{
    private string $title = "Administrar salsas de productos | " . BUSINESS_NAME;
    private string $h1 = "Combinar productos con salsas";
    protected string $DTDefinition = 'productSauce';
    protected CrudController $crudController;
    protected ProductSauce $model;
    public string $currentRoute;

    public function showForm(int $product_id): void
    {
        $products = $this->getProductsDropdown($product_id);
        $availableSauces = $this->getAvailableSaucesDropdown($product_id);
        $selectedSauces = $this->getSelectedSaucesDropdown($product_id);
        $data = [
            "action" => "add",
            "formAction" => "/product/sauces/[i:id]/",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
            'products' => $products,
            'availableSauces' => $availableSauces,
            'selectedSauces' => $selectedSauces,
        ];
        unset($_SESSION['formData']);
        echo Template::render('sections/ProductSauces/ProductSauceForm.tpl', $data);
    }

    public function create(): void
    {
        /* $validator = new ProductSaucesFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages()); */
        $product_id = $this->request->get('product_id');
        $sauce_id = $this->request->get('sauce_id');


        $this->model = new ProductSauce($this->connection);
        $this->model->create([
            'product_id' => $product_id,
            'sauce_id' => $sauce_id,
        ]);
        FlashMessages::set('success', 'Salsa agregada al producto correctamente');
        $this->route('productSaucesList');
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

    private function getAvailableSaucesDropdown(int $product_id, ?int $selected = 0): string
    {
        $classes = 'form-select form-control';
        if (isset($_SESSION['errors']) && $_SESSION['errors']['product_id']) {
            $classes .= ' is-invalid';
        }

        return (new DBDropdown(
            $this->connection,
            'Models\ProductSauce',
            'getAvailableSaucesForDropdownOptions',
            $selected,
            true,
            [$product_id]
        ))
            ->setName('available_sauce_id')
            ->setId('available_sauce_id')
            ->setMultiple(true)
            ->addClass($classes)
            ->render();
    }

    private function getSelectedSaucesDropdown(int $product_id, ?int $selected = 0): string
    {
        $classes = 'form-select form-control';
        if (isset($_SESSION['errors']) && $_SESSION['errors']['product_id']) {
            $classes .= ' is-invalid';
        }

        return (new DBDropdown(
            $this->connection,
            'Models\ProductSauce',
            'getSelectedSaucesForDropdownOptions',
            $selected,
            true,
            [$product_id]
        ))
            ->setName('selected_sauce_id')
            ->setId('selected_sauce_id')
            ->setMultiple(true)
            ->addClass($classes)
            ->render();
    }
}
