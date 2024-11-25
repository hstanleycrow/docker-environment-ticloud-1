<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class LoginButton extends BaseButton
{
    protected ?string $id = "btn-login";
    protected ?string $name = "btn-login";
    protected string $buttonText = 'Iniciar sesión';
    protected string $class = 'btn btn-primary';
    protected ?string $iconClass = 'fa fa-right-to-bracket';
    protected ?string $iconPosition = 'right';

    public function __construct()
    {
        $buttonText = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $buttonClient = new ButtonClient($buttonText, 'submit');
        parent::__construct($buttonClient);
        $this->addClass($this->class);
    }
}
