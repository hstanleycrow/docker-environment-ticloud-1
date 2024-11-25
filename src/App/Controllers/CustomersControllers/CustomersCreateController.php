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

class CustomersCreateController extends Controller
{
    private $title = "Administrador de Clientes | " . BUSINESS_NAME;
    private $h1 = "Agregar Cliente";
    protected string $DTDefinition = 'customer';
    protected CrudController $crudController;
    protected Customer $customerModel;
    protected PhoneNumbers $phoneNumberModel;
    protected Address $addressModel;
    public string $currentRoute;

    public function showForm(): void
    {
        $phoneType = $this->getPhoneTypeDropdown('Movil');
        $addressType = $this->getAddressTypeDropdown('Casa');
        $data = [
            "action" => "add",
            "formAction" => "/customer/agregar",
            "h1" => $this->h1,
            "customerRecord" => [],
            "phoneNumberRecord" => [],
            "addressRecord" => [],
            "phoneType" => $phoneType,
            "addressType" => $addressType,
            "title" => $this->title,
        ];

        echo Template::render('sections/Customers/CustomerForm.tpl', $data);
    }


    public function create(): void
    {
        $validator = new CustomersFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());

        $name = $this->request->get('name');
        $phone_number = $this->request->get('phone_number');
        $phoneType = $this->request->get('phoneType');
        $phoneType = ($phoneType == 0) ? 'Movil' : (($phoneType == 1) ? 'Casa' : 'Trabajo');

        $address = $this->request->get('address');
        $addressType = $this->request->get('addressType');
        $addressType = ($addressType == 0) ? 'Casa' : 'Trabajo';
        $reference_point = $this->request->get('reference_point');
        $notes = $this->request->get('notes');

        try {
            $this->customerModel = new Customer($this->connection);
            $this->customerModel->beginTransaction();

            $this->customerModel->create([
                'name' => $name,
                'notes' => $notes,
            ]);
            $customerId = $this->customerModel->lastInsertId();

            $this->phoneNumberModel = new PhoneNumbers($this->connection);
            $this->phoneNumberModel->create([
                'customer_id' => $customerId,
                'phone_number' => $phone_number,
                'type' => $phoneType,
                'is_main' => 'S',
            ]);

            $this->addressModel = new Address($this->connection);
            $this->addressModel->create([
                'customer_id' => $customerId,
                'address' => $address,
                'reference_point' => $reference_point,
                'type' => $addressType,
            ]);

            $this->customerModel->commit();
            FlashMessages::set('success', 'El cliente se ha creado correctamente');
            unset($_SESSION['formData']);
            $this->route('customersList');
        } catch (\PDOException $e) {
            $this->customerModel->rollback();
            #vdd($e);
            if ($e->getCode() == 23000) {
                $errors['phone_number'] = 'No se puede crear el cliente, el número de teléfono ya existe';
            } else {
                $errors['phone_number'] = 'No se pudo crear el cliente, intente nuevamente';
            }

            $_SESSION['errors'] = $errors;

            $data = $this->request->request->all(); // Obtiene los datos de la solicitud
            $_SESSION['formData'] = $data;

            $this->route($this->currentRoute, $data);
        }
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
