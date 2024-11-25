<?php

namespace App\Components\Buttons;

class LoginButton extends BaseButton
{
    protected array $attributes  = [
        'type' => 'submit',
        'class' => 'btn btn-primary btn-lg',
    ];
    protected ?string $id = "btn-login";
    protected ?string $name = "btn-login";
    protected string $buttonText = 'Iniciar sesión';
    protected ?string $iconClass = 'fa fa-right-to-bracket';
    protected ?string $iconPosition = 'right';
    public function __construct()
    {
        parent::__construct($this->buttonText, $this->iconClass, $this->iconPosition);
    }
}
