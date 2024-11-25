<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class SaucesButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $class = 'btn btn-info';
    protected string $buttonText = 'Salsas';
    protected ?string $iconClass = 'fa-solid fa-bowl-food';
    protected ?string $iconPosition = 'left';
    protected ?string $href = "sauces";

    public function __construct(string $href)
    {
        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($href, $linkContent);
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
