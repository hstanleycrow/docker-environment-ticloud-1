<?php

namespace App\Controllers;

use App\Core\Template;

class DatatableController extends Controller
{
    private static $title = "Administrador de Productos | " . BUSINESS_NAME;
    private static $h1 = "Administrador de Productos";
    public function index()
    {
        $data = [
            "title" => self::$title,
            "h1" => self::$h1
        ];

        echo Template::render('sections/HomeView/serverProcessing', $data);
    }
}
