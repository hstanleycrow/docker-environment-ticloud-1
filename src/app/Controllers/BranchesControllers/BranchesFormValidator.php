<?php

namespace App\Controllers\BranchesControllers;

class BranchesFormValidator
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
            'name.required' => 'El campo "Sucursal" es obligatorio',
            'name.min' => 'El campo "Sucursal" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Sucursal" debe tener un máximo de 50 caracteres',
        ];
    }
}
