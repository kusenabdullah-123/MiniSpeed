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

    public static function patch(string $uri, array $controller): void {
        self::$routes['PATCH'][$uri] = $controller;
    }

    public static function delete(string $uri, array $controller): void {
        self::$routes['DELETE'][$uri] = $controller;
    }
    
    public static function matchRoute(string $url, array $routes):mixed {
        $urlParams = '';
        foreach ($routes as $pattern => $data) {
            $urlParams = $pattern;
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = preg_replace('/:[^\/]+/', '([^\/]+)', $pattern);
            if (preg_match('/^' . $pattern . '$/', $url)) {
                return [$urlParams,$data];
            }
        }

        return null; 
    }

    public static function dispatch(string $method, string $uri): mixed {
        $match = self::matchRoute($uri,self::$routes[$method]);
        if ($uri !== '/') Uri::trimUrl($uri);
        if (isset($match)) {
            Uri::parseUrlParams($match[0],$uri);
            [$controllerClass, $action] = $match[1];
            $controller = Factory::create($controllerClass);
            return $controller->$action();
        } else {
            return \MiniSpeed\ResponseJson::send("404 Route Not Found",404);
        }
    }
}
