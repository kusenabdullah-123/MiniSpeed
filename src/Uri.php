<?php

namespace MiniSpeed;

class Uri {

    public static array $segment = [];
    public static function trimUrl($url){
        return rtrim($url,'/');
    }
    
    public static function parseUrlParams(string $url): array {
        $url = self::trimUrl($url);
        $urlSegments = explode('/', $url);
        $params = [];
        self::$segment = $urlSegments;
        foreach ($urlSegments as $segment) {
            if (strpos($segment, ':') === 0) {
                $paramName = substr($segment, 1);
                $params[$paramName] = self::sanitizeParam($paramName);
            }
        }

        return $params;
    }
    
    public static function getSegment(int $index): mixed {
        return isset(self::$segment[$index -1]) ? self::$segment[$index -1] : null;
    }

    private static function sanitizeParam(string $paramValue): string {
        return $paramValue;
    }
}
