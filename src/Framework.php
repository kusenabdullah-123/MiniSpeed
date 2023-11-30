<?php

namespace MiniSpeed;

use MiniSpeed\Router;

class Framework {

    public static function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        Router::dispatch($method,$uri);
    }
}
