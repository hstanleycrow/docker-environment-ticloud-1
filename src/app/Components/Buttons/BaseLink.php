<?php

namespace App\Components\Buttons;

class BaseLink
{
    private LinkClient $linkClient;
    protected ?string $DTDefinition;

    public function __construct(LinkClient $linkClient)
    {
        $this->linkClient = $linkClient;
    }
    public function addClass(string $class): self
    {
        $this->linkClient->addClass($class);
        return $this;
    }

    public function setDTDefinition(string $DTDefinition): self
    {
        $this->DTDefinition = $DTDefinition;
        return $this;
    }

    public function render(): string
    {
        return $this->linkClient->render();
    }

    /*public function setId(string $id): self{
        $this->link->setId($id);
        return $this;
    }*/
}
