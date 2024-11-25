<?php

namespace App\Controllers\AuthControllers;

use App\Core\Route;
use App\Core\Template;
use App\Controllers\Controller;

class AuthAccessDeniedController extends Controller
{
    private static $title = "Acceso Denegado | " . BUSINESS_NAME;
    private static $h1 = "Acceso Denegado";

    public function showMessage()
    {
        $message = "No tienes permisos para acceder a esta sección.";
        $redirectURL = Route::getUrlFromName('OrdersList');

        $data = [
            "title" => self::$title,
            'h1' => self::$h1,
            'message' => $message,
            'redirectURL' => $redirectURL
        ];

        echo Template::render('sections/Login/accessDenied.tpl', $data);
    }
}
