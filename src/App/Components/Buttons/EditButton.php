<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class EditButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $class = 'btn btn-warning';
    protected string $buttonText = 'Editar';
    protected ?string $iconClass = 'fa-solid fa-pen-to-square';
    protected ?string $iconPosition = 'left';
    protected ?string $href = "editar";

    public function __construct(string $href)
    {
        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($href, $linkContent);
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
