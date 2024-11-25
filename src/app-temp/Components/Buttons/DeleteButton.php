<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class DeleteButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $class = 'btn btn-danger';
    protected string $buttonText = 'Borrar';
    protected ?string $iconClass = 'fa-solid fa-trash';
    protected ?string $iconPosition = 'left';
    protected ?string $href = "eliminar";

    public function __construct(string $href)
    {
        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($href, $linkContent);
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
