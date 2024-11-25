<?php

namespace App\Core\DBConnection;

class ConnectionClient
{
    private IConnection $connection;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection->getConnection();
    }

    public function isConnected(): bool
    {
        return $this->connection->isConnected();
    }
}
