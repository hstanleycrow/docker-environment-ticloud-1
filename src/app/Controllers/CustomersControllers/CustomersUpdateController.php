<?php

namespace App\Controllers\CustomersControllers;

use Models\Address;
use Models\Customer;
use App\Core\Template;
use Models\PhoneNumbers;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\Dropdown;
use App\Components\Dropdowns\DropdownClient;

class CustomersUpdateController extends Controller
{
    private $title = "Administrador de Clientes | " . BUSINESS_NAME;
    private $h1 = "Editar Cliente";
    protected string $DTDefinition = 'customer';
    protected CrudController $crudController;
    protected Customer $customerModel;
    public string $currentRoute;
    protected PhoneNumbers $phoneNumberModel;
    protected Address $addressModel;


    public function showForm($id)
    {
        $phoneType = $this->getPhoneTypeDropdown('Movil');
        $addressType = $this->getAddressTypeDropdown('Casa');

        $this->customerModel = new Customer($this->connection);
        $customerRecord = $this->customerModel->getById($id);
        $customerRecord['id'] = $id;

        $this->phoneNumberModel = new PhoneNumbers($this->connection);
        $phoneNumberRecord = $this->phoneNumberModel->getMainPhoneByCustomerId($id);

        $this->addressModel = new Address($this->connection);
        $addressRecord = $this->addressModel->getMainAddressByCustomerId($id);


        $data = [
            "action" => "edit",
            "formAction" => "/customer/editar/$id/",
            "h1" => $this->h1,
            "customerRecord" => $customerRecord,
            "phoneNumberRecord" => $phoneNumberRecord,
            "addressRecord" => $addressRecord,
            "phoneType" => $phoneType,
            "addressType" => $addressType,
            "title" => $this->title,
        ];
        echo Template::render('sections/Customers/CustomerForm.tpl', $data);
    }

    public function save(): void
    {
        $validator = new CustomersFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $notes = $this->request->get('notes');

        $this->customerModel = new Customer($this->connection);
        $this->customerModel->update(
            ['name' => $name,],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El cliente se ha editado correctamente');
        unset($_SESSION['formData']);
        $this->route('customersList');
    }

    private function getPhoneTypeDropdown(string $selected): string
    {
        $selected = ($selected == 'Movil') ? 0 : (($selected == 'Casa') ? 1 : 2);
        $dropdownClient = new DropdownClient(['Movil', 'Casa', 'Trabajo'],  $selected);
        return (new Dropdown($dropdownClient))
            ->setName('phoneType')
            ->setId('phoneType')
            ->addClass('form-select form-control')
            ->render();
    }

    private function getAddressTypeDropdown(string $selected): string
    {
        $selected = ($selected == 'Casa') ? 0 : (($selected == 'Trabajo') ? 1 : 2);
        $dropdownClient = new DropdownClient(['Casa', 'Trabajo', 'Otro'],  $selected);
        return (new Dropdown($dropdownClient))
            ->setName('addressType')
            ->setId('addressType')
            ->addClass('form-select form-control')
            ->render();
    }
}
