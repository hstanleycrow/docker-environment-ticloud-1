<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;
use hstanleycrow\EasyPHPWebComponents\Button;

class BaseButton
{
    protected array $attributes  = [
        'type' => 'submit',
        'class' => 'btn',
    ];
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $buttonText = 'Click Me';
    protected ?string $icon = null;
    protected ?string $iconPosition = 'left';
    public function __construct(string $text, ?string $icon = null, ?string $iconPosition = null)
    {
        $this->buttonText = $text ?? $this->buttonText;
        $this->icon = $icon ?? $this->icon;
        $this->iconPosition = $iconPosition ?? $this->iconPosition;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    public function addClass(string $class): self
    {
        $this->attributes['class'] .= " $class";
        return $this;
    }

    public function render(): string
    {
        $this->attributes['id'] = $this->id ?? uniqid();
        $this->attributes['name'] = $this->name ?? $this->attributes['id'];
        return (new Button((new Icon($this->icon, $this->buttonText, $this->iconPosition))->render()))->render($this->attributes);
    }
}
