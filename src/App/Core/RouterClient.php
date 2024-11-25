<?php

namespace App\Core;

use AltoRouter;

class RouterClient implements RouterInterface
{
    #    private $router;

    public function __construct(private RouterInterface $router)
    {
        $this->router = new AltoRouter();
    }

    public function map($method, $route, $target, $name = null)
    {
        $this->router->map($method, $route, $target, $name);
    }

    public function match()
    {
        return $this->router->match();
    }

    public function generate($routeName, $params = array(), $addBasePath = true)
    {
        return $this->router->generate($routeName, $params, $addBasePath);
    }
}
