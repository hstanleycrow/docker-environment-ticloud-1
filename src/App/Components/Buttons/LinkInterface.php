<?php

namespace App\Components\Buttons;

interface LinkInterface
{
    public function addClass(string $class): self;
    public function setRel(string $rel): self;
    public function setTarget(string $target): self;
    public function setDownload(string $download): self;
    public function render(): string;
}
