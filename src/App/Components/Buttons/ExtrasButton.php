<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class ExtrasButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $class = 'btn btn-success';
    protected string $buttonText = 'Extras';
    protected ?string $iconClass = 'fa-solid fa-bacon';
    protected ?string $iconPosition = 'left';
    protected ?string $href = "extras";

    public function __construct(string $href)
    {
        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($href, $linkContent);
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
