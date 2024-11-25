<?php

namespace App\Controllers\UsersControllers;

use Models\User;
use App\Core\Template;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;
use App\Components\Dropdowns\Dropdown;
use App\Components\Dropdowns\DropdownClient;

class UsersUpdateController extends Controller
{
    private $title = "Administrador de Usuarios | " . BUSINESS_NAME;
    private $h1 = "Editar Usuario";
    protected string $DTDefinition = 'user';
    protected CrudController $crudController;
    protected User $model;
    public string $currentRoute;


    public function showForm($id)
    {
        $this->model = new User($this->connection);
        $record = $this->model->getById($id);
        $record['id'] = $id;
        $isAdmin = $this->getIsAdminDropdown($record['isAdmin']);
        $active = $this->getActiveDropdown($record['active']);
        $record['password'] = "";
        $data = [
            "action" => "edit",
            "formAction" => "/user/editar/$id/",
            "h1" => $this->h1,
            "record" => $record,
            "title" => $this->title,
            "isAdmin" => $isAdmin,
            "active" => $active
        ];
        unset($_SESSION['formData']);
        echo Template::render('Sections/Users/UserForm.tpl', $data);
    }

    public function save(): void
    {
        $password = $this->request->get('password') ?? null;
        $validator = new UsersFormValidator();
        $this->validate($validator->getRules("update", $password), $validator->getMessages());
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $username = $this->request->get('username');

        $isAdmin = $this->request->get('isAdmin');
        $isAdmin = $isAdmin === '0' ? 'S' : 'N';
        $active = $this->request->get('active');
        $active = $active === '0' ? 'S' : 'N';

        $this->model = new User($this->connection);
        $this->model->update(
            [
                'name' => $name,
                'username' => $username,
                'active' => $active,
                'isAdmin' => $isAdmin,
                'active' => $active,
            ],
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El usuario se ha editado correctamente');
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

    private function getActiveDropdown(string $selected): string
    {
        $selected = $selected == 'S' ? 0 : 1;
        $dropdownClient = new DropdownClient(['S', 'N'],  $selected);
        return (new Dropdown($dropdownClient))
            ->setName('active')
            ->addClass('form-select form-control')
            ->render();
    }
}
