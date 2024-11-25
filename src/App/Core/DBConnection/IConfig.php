<?php

namespace App\Core\DBConnection;

interface IConfig
{
    public function getUser(): string;
    public function getPassword(): string;
    public function getDatabaseName(): string;
    public function getPort(): string;
    public function getHost(): string;
}
