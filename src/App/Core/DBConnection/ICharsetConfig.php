<?php

namespace App\Core\DBConnection;

interface ICharsetConfig
{
    public function getCharset(): string;
}
