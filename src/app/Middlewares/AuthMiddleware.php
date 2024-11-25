<?php

namespace App\Middlewares;

class AuthMiddleware
{
    public function handle(): bool
    {
        return isset($_SESSION['isLogged']) && $_SESSION['isLogged'];
    }

    public function handleFailure(): void
    {
        redirect('/login');
        exit;
    }
}
