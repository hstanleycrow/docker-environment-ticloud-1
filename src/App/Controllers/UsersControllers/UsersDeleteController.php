<?php

namespace App\Controllers\UsersControllers;

use Models\User;
use App\Core\FlashMessages;
use App\Controllers\Controller;
use App\Controllers\CrudController;

class UsersDeleteController extends Controller
{
    private $title = "Administrador de Usuarios | " . BUSINESS_NAME;
    private $h1 = "Editar Usuario";
    protected string $DTDefinition = 'user';
    protected CrudController $crudController;
    protected User $userModel;
    public string $currentRoute;


    public function delete($id)
    {
        $this->userModel = new User($this->connection);
        $this->userModel->delete(
            ['id' => $id,]
        );
        FlashMessages::set('success', 'El usuario se ha eliminado correctamente');
        $this->route('usersList');
    }
}
