<?php

namespace App\Controllers\OrdersControllers;

use App\Core\Route;
use Models\Customer;
use App\Core\Template;
use Models\PaymentMethod;
use App\Controllers\Controller;
use Models\Category as CategoryModel;

class OrdersIndexController extends Controller
{
    private $title = "Registro de ordenes | " . BUSINESS_NAME;
    private $h1 = "Ingrese la orden";
    protected string $DTDefinition = 'transaction';
    protected Customer $customerModel;
    protected CategoryModel $categoryModel;
    protected PaymentMethod $paymentMethodsModel;
    public string $currentRoute;

    public function index(?int $customer_id = null): void
    {
        $this->customerModel = new Customer($this->connection);
        $customerWithContactsData = $this->customerModel->getCustomerWithContactsById($customer_id);

        $categories = $this->getCategoriesList();
        $paymentMethods = $this->getPaymentMethodsList();

        $userName = $_SESSION['userdat']['name'];

        $closeRoute = Route::getUrlFromName('close');

        $data = [
            'branchName' => $_SESSION['branch']['name'],
            'closeRoute' => $closeRoute,
            "customerWithContactsData" => $customerWithContactsData,
            "categories" => $categories,
            "h1" => $this->h1,
            "paymentMethods" => $paymentMethods,
            "title" => $this->title,
            "userName" => $userName,
        ];

        echo Template::render('sections/Orders/OrdersIndex.tpl', $data);
    }

    private function getCategoriesList(): array
    {
        $this->categoryModel = new CategoryModel($this->connection);
        return $this->categoryModel->getAll();
    }

    private function getPaymentMethodsList(): array
    {
        $this->paymentMethodsModel = new PaymentMethod($this->connection);
        return $this->paymentMethodsModel->getForDropdownOptions();
    }

    /* private function getSaucesList(): array
    {
        $this->sauceModel = new Sauce($this->connection);
        return $this->sauceModel->getAll();
    }

    private function getExtrasList(): array
    {
        $this->extraModel = new Extra($this->connection);
        return $this->extraModel->getAll();
    } */
}
