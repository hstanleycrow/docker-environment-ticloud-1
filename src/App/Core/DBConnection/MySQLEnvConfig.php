<?php

namespace App\Core\DBConnection;

class MySQLEnvConfig implements IConfig
{

    public function __construct(private array $env)
    {
    }

    public function getUser(): string
    {
        return $this->env['DATABASE_USERNAME'];
    }

    public function getPassword(): string
    {
        return $this->env['DATABASE_PASSWORD'];
    }

    public function getDatabaseName(): string
    {
        return $this->env['DATABASE_NAME'];
    }

    public function getPort(): string
    {
        return $this->env['DATABASE_PORT'];
    }

    public function getHost(): string
    {
        return $this->env['DATABASE_HOST'];
    }
}
