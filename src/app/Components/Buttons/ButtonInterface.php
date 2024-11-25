<?php

namespace App\Components\Buttons;

interface ButtonInterface
{
    public function addClass(string $class): self;
    public function setId(string $rel): self;
    public function setDisabled(bool $disabled): self;
    public function render(): string;
}
