<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class ConfirmButton extends BaseButton
{
    protected string $class = 'btn btn-success';

    public function __construct(
        protected string $buttonText = 'Guardar',
        protected ?string $iconClass = 'fa-solid fa-floppy-disk',
        protected ?string $iconPosition = 'left'
    ) {
        $buttonText = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();

        $buttonClient = new ButtonClient($buttonText, 'submit');

        parent::__construct($buttonClient);
        $this->addClass($this->class);
    }
}
