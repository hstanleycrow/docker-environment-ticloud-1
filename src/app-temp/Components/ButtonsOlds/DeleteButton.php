<?php

namespace App\Components\Buttons;

class DeleteButton extends BaseLink
{
    protected array $attributes  = [
        'type' => 'button',
        'class' => 'btn btn-outline-danger',
    ];
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $buttonText = 'Eliminar';
    protected ?string $iconClass = 'fa-solid fa-trash';
    protected ?string $iconPosition = 'left';
    public function __construct()
    {
        parent::__construct($this->buttonText, $this->iconClass, $this->iconPosition);
    }
}
