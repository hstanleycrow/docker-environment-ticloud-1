<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class AddOrderButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $class = 'btn btn-success';
    protected string $buttonText = 'Ordenar';
    protected ?string $iconClass = 'fa-solid fa-burger';
    protected ?string $iconPosition = 'left';
    protected ?string $href = "orders";

    public function __construct(string $href)
    {
        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($href, $linkContent);
        $linkClient->setTarget("_blank");
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
