<?php

namespace App\Controllers\AuthControllers;

class AuthCloseSessionController
{
    public $currentRoute;

    public function closeSession()
    {
        session_unset();
        session_destroy();
        redirect('/login');
    }
}
