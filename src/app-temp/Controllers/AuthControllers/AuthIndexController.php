<?php

namespace App\Controllers\AuthControllers;

use App\Core\Csrf;
use App\Core\Template;
use App\Controllers\Controller;
use App\Components\Dropdowns\BranchesDropdown;

class AuthIndexController extends Controller
{
    private static $title = "Ingreso | " . BUSINESS_NAME;
    private static $h1 = "Inicio de Sesión";
    private static $tokenCSRF = '';

    public function showForm()
    {
        $branches = (new BranchesDropdown($this->connection))->getBranchesDropdown();

        #self::$tokenCSRF = (new Csrf())->getToken();
        $csrf = (new Csrf())->initToken();
        $data = [
            "title" => self::$title,
            'h1' => self::$h1,
            'tokenCSRF' => $csrf->getToken(),
            'branches' => $branches
        ];

        echo Template::render('sections/Login/login.tpl', $data);
    }
}
