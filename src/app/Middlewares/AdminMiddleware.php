<?php

namespace App\Middlewares;

class AdminMiddleware
{
    public function handle(): bool
    {
        return isset($_SESSION['userdat']['isAdmin']) && $_SESSION['userdat']['isAdmin'] === 'S';
    }

    public function handleFailure(): void
    {
        redirect('/access_denied');
        exit;
    }
}
