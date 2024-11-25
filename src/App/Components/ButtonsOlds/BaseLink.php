<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;
use hstanleycrow\EasyPHPWebComponents\Link;

class BaseLink
{
    protected array $attributes  = [
        'class' => 'btn',
    ];
    protected ?string $redirectTo = "/";
    protected string $buttonText = 'Click me';
    protected ?string $icon = null;
    protected ?string $iconPosition = null;
    public function __construct(string $text, ?string $icon = null, ?string $iconPosition = null)
    {
        $this->buttonText = $text ?? $this->buttonText;
        $this->icon = $icon ?? $this->icon;
        $this->iconPosition = $iconPosition ?? $this->iconPosition;
    }
    public function route(string $redirectTo): self
    {
        $this->redirectTo = $redirectTo;
        return $this;
    }
    public function addClass(string $class): self
    {
        $this->attributes['class'] .= " $class";
        return $this;
    }

    public function render(): string
    {
        $this->attributes['href'] = $this->redirectTo;
        return (new Link((new Icon($this->icon, $this->buttonText))->render()))->render($this->attributes);
    }
}
