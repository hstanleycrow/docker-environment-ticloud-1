<?php

namespace App\Controllers\OrdersControllers;

use Models\ProductExtra;
use Models\ProductSauce;
use App\Controllers\Controller;
use Models\Product;

class FilterProductsByCategoryController extends Controller
{
    private Product $productModel;
    protected ProductSauce $sauceModel;
    protected ProductExtra $extraModel;

    public function index(): void
    {
        $category_id = $this->request->get('category_id');

        $products = $this->getProductList($category_id);

        $response = [
            'products' => $products,
        ];

        echo json_encode($response);
    }

    private function getProductList(int $category_id): array
    {
        $this->productModel = new Product($this->connection);
        return $this->productModel->getByCategoryId($category_id);
    }

    public function filterSaucesAndExtras(): void
    {
        $product_id = $this->request->get('product_id');

        $sauces = $this->getSaucesList($product_id);
        $extras = $this->getExtrasList($product_id);

        $response = [
            'sauces' => $sauces,
            'extras' => $extras,
        ];

        echo json_encode($response);
    }

    private function getSaucesList(int $product_id): array
    {
        $this->sauceModel = new ProductSauce($this->connection);
        return $this->sauceModel->getSelectedSaucesForDropdownOptions($product_id);
    }

    private function getExtrasList(int $product_id): array
    {
        $this->extraModel = new ProductExtra($this->connection);
        return $this->extraModel->getSelectedExtrasForDropdownOptions($product_id);
    }
}
