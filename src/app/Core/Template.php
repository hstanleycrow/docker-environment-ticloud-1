<?php

namespace App\Core;

use Exception;
use League\Plates\Engine;

class Template
{
    private static $template = null;
    private static function getTemplate()
    {
        if (self::$template === null) {
            self::$template = new Engine('../resources/views');
        }
        return self::$template;
    }
    public static function render(string $view, array $data = [])
    {
        $template = self::getTemplate();
        echo $template->render($view, $data);
    }
}
