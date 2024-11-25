<?php

namespace App\Components\Buttons;

use hstanleycrow\EasyPHPWebComponents\Link;

class LinkClient implements LinkInterface
{
    protected Link $link;

    public function __construct(string $href, string $linkContent)
    {
        $this->link = new Link($href, $linkContent);
    }

    public function addClass(string $class): self
    {
        $this->link->addClass($class);
        return $this;
    }

    public function render(): string
    {
        return $this->link->render();
    }

    public function setRel($rel): self
    {
        $this->link->setRel($rel);
        return $this;
    }
    public function setTarget($target): self
    {
        $this->link->setTarget($target);
        return $this;
    }
    public function setDownload($download): self
    {
        $this->link->setDownload($download);
        return $this;
    }
}
