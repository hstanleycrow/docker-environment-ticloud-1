<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Button;

class ButtonClient implements ButtonInterface
{
    protected Button $button;

    public function __construct(string $buttonText, ?string $type = 'button')
    {
        $this->button = new Button($buttonText, $type);
    }

    public function addClass(string $class): self
    {
        $this->button->addClass($class);
        return $this;
    }

    public function render(): string
    {
        return $this->button->render();
    }

    public function setId(string $id): self
    {
        $this->button->setId($id);
        return $this;
    }
    public function setDisabled(bool $disabled): self
    {
        $this->button->setDisabled($disabled);
        return $this;
    }
}
