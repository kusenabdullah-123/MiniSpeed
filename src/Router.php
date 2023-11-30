<?php

namespace MiniSpeed;
use MiniSpeed\Factory;

class Router {
    protected static array $routes = [];

    public static function get(string $uri, array $controller): void {
        self::$routes['GET'][$uri] = $controller;
    }

    public static function post(string $uri, array $controller): void {
        self::$routes['POST'][$uri] = $controller;
    }

    public static function dispatch(string $method, string $uri): mixed {
        Uri::parseUrlParams($uri);
        var_dump(Uri::getSegment(0));
        var_dump(self::$routes[$method]);
        die;

        if ($uri !== '/') Uri::trimUrl($uri);
        if (isset(self::$routes[$method][$uri])) {
            [$controllerClass, $action] = self::$routes[$method][$uri];
            $controller = Factory::create($controllerClass);
            return $controller->$action();
        } else {
            return \MiniSpeed\ResponseJson::send("404 Route Not Found",404);
        }
    }
}
