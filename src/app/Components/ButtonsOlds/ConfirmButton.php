<?php

namespace App\Components\Buttons;

class ConfirmButton extends BaseButton
{
    protected array $attributes  = [
        'type' => 'submit',
        'class' => 'btn btn-success',
    ];
    protected string $buttonText = 'Guardar';
    protected ?string $iconClass = 'fa-solid fa-floppy-disk';
    public function __construct()
    {
        parent::__construct($this->buttonText, $this->iconClass, $this->iconPosition);
    }
}
