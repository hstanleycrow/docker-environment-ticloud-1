<?php

namespace App\Core\DBConnection;

class MySQLEnvCharsetConfig implements ICharsetConfig
{

    public function __construct(private array $env)
    {
    }


    public function getCharset(): string
    {
        return $this->env['DATABASE_CHARSET'];
    }
}
