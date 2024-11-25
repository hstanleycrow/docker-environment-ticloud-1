<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class AddButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $class = 'btn btn-primary';
    protected string $buttonText = 'Agregar';
    protected ?string $iconClass = 'fa-solid fa-plus';
    protected ?string $iconPosition = 'left';
    protected ?string $href = "agregar";

    public function __construct(?string $DTDefinition)
    {
        $this->href = $href ?? $this->href;
        $this->href = $DTDefinition . '/' . $this->href;

        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($this->href, $linkContent);
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
