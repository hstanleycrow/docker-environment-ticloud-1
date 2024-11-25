<?php

namespace App\Core;

interface RouterInterface
{
    public function map($method, $route, $target, $name = null);
    public function match();
    public function generate($routeName, $params = array(), $addBasePath = true);
}
