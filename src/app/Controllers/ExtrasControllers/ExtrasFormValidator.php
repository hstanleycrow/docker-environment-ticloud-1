<?php

namespace App\Controllers\ExtrasControllers;

class ExtrasFormValidator
{
    public function getRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:5|max:250',
            'price' => 'required|decimal:2|greaterThanZero',
        ];
    }

    public function getMessages(): array
    {
        return [
            'name.required' => 'El campo "Nombre" es obligatorio',
            'name.min' => 'El campo "Nombre" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Nombre" debe tener un máximo de 50 caracteres',
            'price.required' => 'El campo "Precio" es obligatorio',
            'price.decimal' => 'El campo "Precio" debe tener 2 decimales como máximo',
            'price.greaterThanZero' => 'El campo "Precio" debe ser mayor que 0',
            'description.required' => 'El campo "Descripción" es obligatorio',
            'description.min' => 'El campo "Descripción" debe tener un minimo de 3 caracteres: ',
            'description.max' => 'El campo "Descripción" debe tener un máximo de 250 caracteres',
        ];
    }
}
