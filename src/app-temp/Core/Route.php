<?php

namespace App\Core;

use Exception;
use AltoRouter;
use App\Core\DBConnection\IConfig;
use App\Core\DBConnection\MySQLEnvConfig;
use App\Core\DBConnection\MySQLPDOConnection;
use Symfony\Component\HttpFoundation\Request;
use App\Core\DBConnection\MySQLEnvCharsetConfig;

class Route
{
    private static $router = null;
    private static $currentRoute = null;
    private static $middlewares = [];

    private static function getRouter()
    {
        if (self::$router === null) {
            self::$router = new AltoRouter();
        }
        return self::$router;
    }
    public static function get(string $uri, string $controller, ?string $name = null)
    {
        /* echo "<pre>$uri" . PHP_EOL . "</pre>";
        $uri = preg_replace('/\{[a-z]+\}/', '([a-zA-Z0-9_\-\s]+)', $uri);
        echo "<pre>$uri" . PHP_EOL . "</pre>"; */

        $router = self::getRouter();
        $name = $name ?? $uri;
        $router->map('GET', $uri, $controller, $name);
        self::$currentRoute = $name;
        return new static;
    }
    public static function post(string $uri, string $controller, ?string $name = null)
    {

        $router = self::getRouter();
        $name = $name ?? $uri;
        $router->map('POST', $uri, $controller, $name);
        self::$currentRoute = $name;
        return new static;
    }

    public static function put(string $uri, string $controller, ?string $name = null)
    {

        $router = self::getRouter();
        $name = $name ?? $uri;
        $router->map('PUT', $uri, $controller, $name);
        self::$currentRoute = $name;
        return new static;
    }

    public static function dispatch(): void
    {
        $router = self::getRouter();
        $match = $router->match();
        if ($match) :
            $route = $match['name'];
            self::$currentRoute = $match['name'];
            if (isset(self::$middlewares[$route])) :
                $middleware = self::$middlewares[$route];
                foreach ($middleware as $mw) :
                    // Aplica los middleware antes de llamar al controlador
                    $mw = 'App\\Middlewares\\' . $mw . 'Middleware';
                    if (class_exists($mw)) :
                        $middlewareInstance = new $mw();
                        if (!$middlewareInstance->handle()) :
                            $middlewareInstance->handleFailure();
                            exit;
                        endif;
                    else :
                        throw new Exception('Middleware no válido');
                    endif;
                endforeach;
            endif;
            // La ruta es válida, llama al controlador y método correspondientes
            list($controller, $method) = explode('#', $match['target']);
            $controller = str_replace('/', '\\', $controller);
            $controller = 'App\\Controllers\\' . $controller;
            if (class_exists($controller) && method_exists($controller, $method)) :
                $request = Request::createFromGlobals();
                $connection = (new MySQLPDOConnection(
                    new MySQLEnvConfig($_ENV),
                    new MySQLEnvCharsetConfig($_ENV),
                    $_SERVER['SCRIPT_NAME']
                ));

                $uri = $router->generate($match['name']);
                $controllerInstance = new $controller($request, $connection, $uri);
                $controllerInstance->currentRoute = self::replacePlaceholders($match['params']);
                $controllerInstance->$method(...array_values($match['params']));
            else :
                throw new Exception('Controlador o método no válido');
            endif;
        else :
            $route = self::$currentRoute ?? '';
            throw new Exception('Ruta no válida: ' . ($route));
        #redirect('/404'); //TODO: hacer pagina de error 404 y luego quitar la excepcion para redirigir.
        endif;
    }

    public function middleware(...$middlewares): static
    {
        $route = self::$currentRoute;
        foreach ($middlewares as $middleware) :
            self::$middlewares[$route][] = $middleware;
        endforeach;
        return $this;
    }

    private static function replacePlaceholders($params)
    {
        $route = self::$currentRoute;
        foreach ($params as $key => $value) {
            // Reemplaza tanto los parámetros enteros como los de cadena
            $route = str_replace(['[i:' . $key . ']', '[*:' . $key . ']'], $value, $route);
        }
        return $route;
    }

    public static function getUrlFromName(string $name, array $params = []): string
    {
        $router = self::getRouter();
        return $router->generate($name, $params);
    }
}
