<?php

namespace App\Controllers\SaucesControllers;

class SaucesFormValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:5|max:500',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => 'El campo "Nombre" es obligatorio',
            'name.min' => 'El campo "Nombre" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Nombre" debe tener un máximo de 50 caracteres',
            'description.required' => 'El campo "Descripción" es obligatorio',
            'description.min' => 'El campo "Descripción" debe tener un minimo de 3 caracteres: ',
            'description.max' => 'El campo "Descripción" debe tener un máximo de 500 caracteres',
        ];
    }
}
