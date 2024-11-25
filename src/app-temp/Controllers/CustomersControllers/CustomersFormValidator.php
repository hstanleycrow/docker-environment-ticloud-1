<?php

namespace App\Controllers\CustomersControllers;

class CustomersFormValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'phone_number' => 'required|phone|min:8|max:8',
            'address' => 'required|string|min:10',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => 'El campo "Nombre" es obligatorio',
            'name.min' => 'El campo "Nombre" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Nombre" debe tener un máximo de 50 caracteres',
            'phone_number.required' => 'El campo "Teléfono" es obligatorio',
            'phone_number.min' => 'El campo "Teléfono" debe tener un minimo de 8 caracteres: ',
            'phone_number.max' => 'El campo "Teléfono" debe tener un máximo de 8 caracteres',
            'address.required' => 'El campo "Dirección" es obligatorio',
            'address.min' => 'El campo "Dirección" debe tener un minimo de 10 caracteres: ',
        ];
    }
}
