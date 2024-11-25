<?php

namespace App\Core\DBConnection;

use PDO;
use PDOException;
use App\Core\DBConfig;

interface IConnection
{
    public function isConnected(): bool;
    public function getConnection();
}
