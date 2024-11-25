<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;

class CancelButton extends BaseLink
{
    protected Icon $linkContent;
    protected ?string $id = null;
    protected ?string $name = null;
    protected ?string $href = "/";
    protected string $class = 'btn btn-danger';
    protected string $buttonText = 'Cancelar';
    protected ?string $iconClass = 'fa fa-times-circle';
    protected ?string $iconPosition = 'left';

    public function __construct(string $href)
    {
        $hrerf = $href ?? $this->href;
        $linkContent = (new Icon($this->iconClass, $this->buttonText, $this->iconPosition))->render();
        $linkClient = new LinkClient($href, $linkContent);
        parent::__construct($linkClient);
        $this->addClass($this->class);
    }
}
