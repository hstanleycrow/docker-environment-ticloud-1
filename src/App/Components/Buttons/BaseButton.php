<?php

namespace App\Components\Buttons;

class BaseButton
{

    public function __construct(private ButtonClient $buttonClient)
    {
    }

    public function render(): string
    {
        return $this->buttonClient->render();
    }

    public function addClass(string $class): self
    {
        $this->buttonClient->addClass($class);
        return $this;
    }

    public function setId(string $id): self
    {
        $this->buttonClient->setId($id);
        return $this;
    }
    public function setDisabled(bool $disabled): self
    {
        $this->buttonClient->setDisabled($disabled);
        return $this;
    }
}
