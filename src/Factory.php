<?php

namespace MiniSpeed;

class Factory
{

    private static $object = [];

    public static function create($className, $params = [])
    {
        $name = $className;
        if (!isset(self::$object[$name])) {
            self::$object[$name] = new $name(...(is_array($params) ? $params : []));
        }
        return self::$object[$name];
    }
}
