<?php

namespace App\Components\Buttons;

class CancelButton extends BaseLink
{
    protected array $attributes  = [
        'class' => 'btn btn-danger',
    ];
    protected ?string $redirectTo = "/";
    protected string $buttonText = 'Cancelar';
    protected ?string $iconClass = 'fa fa-times-circle';
    protected ?string $iconPosition = 'left';
    public function __construct()
    {
        parent::__construct($this->buttonText, $this->iconClass, $this->iconPosition);
    }
}
