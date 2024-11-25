<?php

namespace App\Controllers\ProductsControllers;

class ProductsFormValidator
{
    public function getRules(): array
    {
        return [
            'category_id' => 'required|greaterThanZero',
            'name' => 'required|string|min:3|max:50',
            'price' => 'required|decimal:2|greaterThanZero',
        ];
    }

    public function getMessages(): array
    {
        return [
            'category_id.required' => 'El campo "Categoría" es obligatorio',
            'category_id.greaterThanZero' => 'Debe seleccionar una categoría válida',
            'name.required' => 'El campo "Nombre" es obligatorio',
            'name.min' => 'El campo "Nombre" debe tener un minimo de 3 caracteres: ',
            'name.max' => 'El campo "Nombre" debe tener un máximo de 50 caracteres',
            'price.required' => 'El campo "Precio" es obligatorio',
            'price.decimal' => 'El campo "Precio" debe tener 2 decimales como máximo',
            'price.greaterThanZero' => 'El campo "Precio" debe ser mayor que 0',
        ];
    }
}
