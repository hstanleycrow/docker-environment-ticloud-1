<?php

namespace App\Controllers\AuthControllers;

class AuthFormValidator
{
    public function getRules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'csrf_token' => 'required'
        ];
    }

    public function getMessages(): array
    {
        return [
            'username.required' => 'El campo "Usuario" es obligatorio',
            'password.required' => 'El campo "Contraseña" es obligatorio',
            'csrf_token' => 'Existe un problema de seguridad con su petición, y no será posible iniciar sesión ...'
        ];
    }
}
