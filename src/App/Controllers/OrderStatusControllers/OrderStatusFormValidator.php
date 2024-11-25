<?php

namespace App\Controllers\OrderStatusControllers;

class OrderStatusFormValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => 'El campo "Nombre" es obligatorio',
            'name.min' => 'El campo "Nombre" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Nombre" debe tener un máximo de 50 caracteres',
        ];
    }
}
