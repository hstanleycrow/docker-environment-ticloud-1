<?php

namespace App\Controllers\UsersControllers;

use Models\User;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\Dropdown;
use App\Components\Dropdowns\DropdownClient;

class UsersCreateController extends Controller
{
    private $title = "Administrador de Usuarios | " . BUSINESS_NAME;
    private $h1 = "Agregar Usuario";
    protected string $DTDefinition = 'user';
    protected CrudController $crudController;
    protected User $model;
    public string $currentRoute;

    public function showForm(): void
    {
        $isAdmin = $this->getIsAdminDropdown("N");
        $data = [
            "action" => "add",
            "formAction" => "/user/agregar",
            "h1" => $this->h1,
            "record" => [],
            "title" => $this->title,
            "isAdmin" => $isAdmin,
        ];
        #unset($_SESSION['formData']);
        echo Template::render('Sections/Users/UserForm.tpl', $data);
    }

    public function create(): void
    {
        $validator = new UsersFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());
        $name = $this->request->get('name');
        $username = $this->request->get('username');
        $password = $this->request->get('password');
        $isAdmin = $this->request->get('isAdmin');
        $isAdmin = $isAdmin === '0' ? 'S' : 'N';
        $active = 'S';

        $this->model = new User($this->connection);
        $this->model->create([
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'active' => $active,
            'isAdmin' => $isAdmin,
        ]);
        FlashMessages::set('success', 'El usuario se ha creado correctamente');
        $this->route('usersList');
    }

    private function getIsAdminDropdown(string $selected): string
    {
        $selected = $selected == 'S' ? 0 : 1;
        $dropdownClient = new DropdownClient(['S', 'N'],  $selected);
        return (new Dropdown($dropdownClient))
            ->setName('isAdmin')
            ->addClass('form-select form-control')
            ->render();
    }
}
