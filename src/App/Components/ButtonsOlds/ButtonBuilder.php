<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Icon;
use hstanleycrow\EasyPHPWebComponents\Button;

class ButtonBuilder
{
    protected array $attributes = [];
    protected ?string $id = null;
    protected ?string $name = null;
    protected string $buttonText = '';
    protected string $iconClass = '';
    protected string $iconPosition = 'left';

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
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
    public function setButtonText(string $buttonText): self
    {
        $this->buttonText = $buttonText;
        return $this;
    }

    public function setIconClass(string $iconClass): self
    {
        $this->iconClass = $iconClass;
        return $this;
    }
    public function setIconPosition(string $iconPosition): self
    {
        $this->iconPosition = $iconPosition;
        return $this;
    }
    public function buildButton(): string
    {
        $this->attributes['id'] = $this->id ?? uniqid();
        $this->attributes['name'] = $this->name ?? $this->attributes['id'];
        return (new Button((new Icon($this->iconClass, $this->buttonText))->render()))->render($this->attributes);
        #return new Button($this->buttonText, $this->iconClass, $this->attributes);
    }
}
