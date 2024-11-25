<?php

namespace App\Controllers\UsersControllers;

class UsersFormValidator
{
    public function getRules(string $action = "add", $password = null): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:50',
            'username' => 'required|string|min:6|max:20',
        ];

        if ($action === 'add' || ($action === 'update' && !empty($password)))
            $rules['password'] = 'required|string|min:8|max:30|confirmed:password';

        return $rules;

        /* return [
            'name' => 'required|string|min:3|max:50',
            'username' => 'required|string|min:6|max:20',
            'password' => 'required|string|min:8|max:30|confirmed:password',
        ]; */
    }

    public function getMessages(): array
    {
        return [
            'name.required' => 'El campo "Nombre" es obligatorio',
            'name.min' => 'El campo "Nombre" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Nombre" debe tener un máximo de 50 caracteres',
            'username.required' => 'El campo "Username" es obligatorio',
            'username.min' => 'El campo "Username" debe tener un minimo de 6 caracteres: ',
            'username.max' => 'El campo "Username" debe tener un máximo de 20 caracteres',
            'password.required' => 'El campo "Password" es obligatorio',
            'password.confirmed' => 'Los passwords no coinciden',
            'password.min' => 'El campo "Password" debe tener un minimo de 8 caracteres: ',
            'password.max' => 'El campo "Password" debe tener un máximo de 20 caracteres',
            'password_confirmation.required' => 'El campo "Confirmar Password" es obligatorio',
            'password_confirmation.min' => 'El campo "Confirmar Password" debe tener un minimo de 8 caracteres: ',
            'password_confirmation.max' => 'El campo "Confirmar Password" debe tener un máximo de 20 caracteres',
            'password_confirmation.confirmed' => 'Los passwords no coinciden',
        ];
    }
}
