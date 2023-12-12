<?php

namespace MiniSpeed;

class Uri {

    public static array $segment = [];

    public static function trimUrl(string $url):string{
        return rtrim($url,'/');
    }


    public static function parseGetParams(array $params):void {
        foreach ($params as $key => $value) {
            $_GET[$key] =$value;
        }
    }
    
    public static function getSegment(int $index): mixed {
        return isset(self::$segment[$index]) ? self::$segment[$index] : null;
    }
}
