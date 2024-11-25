<?php

namespace App\Core;

use AltoRouter;
use App\Core\Csrf;
use Dotenv\Dotenv;
use App\Core\Router\Router;

class Initialize
{
    private static bool $mapRoutes = true;
    private Dotenv $dotEnv;

    function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        // Todos los métodos que queremos ejecutar consecutivamente
        $this->sessionStart();
        $this->callAutoload();
        $this->initDotEnv();
        $this->loadConfig();
        if (self::$mapRoutes)
            $this->mapRoutes();
        #$this->initCsrf();
        #$this->initPlates();
    }

    private function sessionStart(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    private function callAutoload(): void
    {
        #require_once '../vendor/autoload.php';
        require_once '/var/www/html/vendor/autoload.php';
        return;
    }

    private function initDotEnv(): void
    {
        #$this->dotEnv = Dotenv::createImmutable('../');
        $this->dotEnv = Dotenv::createImmutable('/var/www/html');
        $this->dotEnv->load();
    }

    private function mapRoutes(): void
    {
        $file = '/var/www/html/routes/web.php';
        if (!is_file($file)) {
            die(sprintf('El archivo %s no se encuentra, y es requerido para el funcionamiento del sistema', $file));
        }

        require_once $file;
        Route::dispatch();
    }



    private function loadConfig(): void
    {
        $file = '/var/www/html/config/App.php';
        if (!is_file($file)) {
            die(sprintf('El archivo %s no se encuentra, y es requerido para el funcionamiento del sistema', $file));
        }

        require_once $file;
    }



    private function initCsrf(): void
    {
        $csrf = new Csrf();
    }

    public static function start(bool $mapRoutes = true): static
    {
        self::$mapRoutes = $mapRoutes;

        return new self();
    }
}
