<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Template;

class HomeController extends Controller
{

    private static $title = "Dashboard | " . BUSINESS_NAME;
    private static $h1 = "Dashboard";

    public function index(): void
    {
        $data = [
            "title" => self::$title,
            'h1' => self::$h1,
        ];

        echo Template::render("sections/HomeView/home.tpl", $data);
    }
}
