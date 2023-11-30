<?php

namespace MiniSpeed;

class Uri {

    public static array $segment = [];

    public static function trimUrl(string $url):string{
        return rtrim($url,'/');
    }

    public static function parseUrlParams(string $routeUrl, string $baseUrl):void {

        $routeUrl = self::trimUrl($routeUrl);
        $routeUrl = explode("/",$routeUrl);
        $baseUrl = self::trimUrl($baseUrl);
        $baseUrl = filter_var($baseUrl,FILTER_SANITIZE_URL);
        $baseUrl = explode("/",$baseUrl);
        $keyIndex = array_filter($routeUrl,function ($value) {
            $str = strpos($value,":");
            if ($str !== false) {
                return $value;
            }
        });
        
        $getName = substr(implode("",array_values($keyIndex)),1);
        $getValue = $baseUrl[(int) implode("",array_keys($keyIndex))] ?? null;
        $_GET[$getName] = $getValue;
    }
    
    public static function getSegment(int $index): mixed {
        return isset(self::$segment[$index]) ? self::$segment[$index] : null;
    }

    private static function sanitizeParam(string $paramValue): string {
        return $paramValue;
    }
}
