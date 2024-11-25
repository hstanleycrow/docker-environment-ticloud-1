<?php

namespace App\Components\Dropdowns;

interface DropdownInterface
{
    public function addClass(string $class): self;
    public function setId(string $rel): self;
    public function setName(string $name): self;
    public function setDisabled(bool $disabled): self;
    public function setMultiple(bool $multiple): self;
    public function render(): string;
}
