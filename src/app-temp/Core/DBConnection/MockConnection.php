<?php

namespace App\Core\DBConnection;

class MockConnection implements IConnection
{
    public function isConnected(): bool
    {
        return true; // Simula siempre estar conectado
    }

    public function getConnection()
    {
        return null; // No hay una conexión real, así que devuelve null
    }
}
