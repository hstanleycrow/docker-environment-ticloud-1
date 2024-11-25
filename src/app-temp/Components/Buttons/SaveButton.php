<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class SaveButton extends BaseButton
{
    protected ?string $id = "btn-save";
    protected ?string $name = "btn-save";
    protected string $buttonText = 'Guardar';
    protected string $class = 'btn btn-success';
    protected ?string $iconClass = 'fa-solid fa-floppy-disk';
    protected ?string $iconPosition = 'left';

    public function __construct()
    {
        $buttonText = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $buttonClient = new ButtonClient($buttonText, 'submit');
        parent::__construct($buttonClient);
        $this->addClass($this->class);
    }
}
