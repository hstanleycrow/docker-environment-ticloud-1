<?php

use App\Controllers\ProductSaucesControllers\ProductSaucesAjaxController;

function getPathToVendorFolder(): string
{
    $autoloadPaths = [
        __DIR__ . '/../../../../../vendor/autoload.php',
        __DIR__ . '/../../../../vendor/autoload.php',
        __DIR__ . '/../../../vendor/autoload.php',
        __DIR__ . '/../../vendor/autoload.php',
        __DIR__ . '/../vendor/autoload.php',
    ];

    $autoloadFound = false;

    foreach ($autoloadPaths as $autoloadPath) {
        if (file_exists($autoloadPath)) {
            return $autoloadPath;
        }
    }

    return "";
}

require_once getPathToVendorFolder();
