<?php

namespace App\Components\Buttons;

class EditButton extends BaseLink
{
    protected array $attributes  = [
        'class' => 'btn btn-outline-warning',
    ];
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $buttonText = 'Editar';
    protected ?string $iconClass = 'fa-solid fa-pen-to-square';
    protected ?string $iconPosition = 'left';
    public function __construct()
    {
        parent::__construct($this->buttonText, $this->iconClass, $this->iconPosition);
    }
}
