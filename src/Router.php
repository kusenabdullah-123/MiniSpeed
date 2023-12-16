<?php

namespace MiniSpeed;
use MiniSpeed\ResponseJson;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType ;

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

        public static function extractNameParam(string $route) {
            preg_match_all('/:([^\/]+)/', $route, $matches);
            return array_map(function($param) {
                return substr($param, 1);
            }, $matches[0]);
        }

        public static function routesMatch(string $url, array $routes){
        foreach ($routes as $route =>$data) {
            $pattern = str_replace('/', '\/', $route);
            $pattern = preg_replace('/:([^\/]+)/', '([^\/]+)', $pattern);
            if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                $params = self::extractNameParam($route);
                array_shift($matches);
                $param = array_combine($params,$matches);
                return [$param,$data];
            }
        }

        return null;
    }

    public static function dispatch(string $method, string $uri): mixed {
        $matches = self::routesMatch($uri,self::$routes[$method]);
        if ($uri !== '/') Uri::trimUrl($uri);
        if (isset($matches)) {
            [$parameter,$actionControl] = $matches;
            [$classController,$methodController] = $actionControl;
            $reflectionMethod = new ReflectionMethod($classController, $methodController);
            $paramMethod = $reflectionMethod->getParameters();
            $parameteAction = [];
            
            foreach ($paramMethod as $param) {
                $type = $param->getType() ? $param->getType() : null;
                assert($type instanceof ReflectionNamedType);
                $className = $type->getName();
                if ($type) {
                    $class = new ReflectionClass($className);
                    $parameteAction[] = $class->newInstanceArgs();
                }
            }
            Uri::parseGetParams($parameter);
            return $reflectionMethod->invokeArgs(new $classController(), $parameteAction);
        } else {
            $response = new ResponseJson();
            return $response->send("404 Route Not Found",404);
        }
    }
}
