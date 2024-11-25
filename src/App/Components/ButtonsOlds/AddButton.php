<?php

namespace App\Components\Buttons;

class AddButton extends BaseLink
{
    protected array $attributes  = [
        'type' => 'submit',
        'class' => 'btn btn-info btn-labeled',
    ];
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $buttonText = 'Agregar';
    protected ?string $iconClass = 'fa-solid fa-plus';
    protected ?string $iconPosition = 'left';
    public function __construct()
    {
        $this->addClass("btn-lg");
        parent::__construct($this->buttonText, $this->iconClass, $this->iconPosition);
    }
}
