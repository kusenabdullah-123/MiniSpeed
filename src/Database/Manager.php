<?php

namespace MiniSpeed\Database;
use MiniSpeed\Database\Database;

class Manager {

    protected static $conn = [];

    public static function add($config, $name = 'default') {
        if(!isset(self::$conn[$name])) {
            self::$conn[$name] = new Database($config);
        }
        return self::$conn[$name];
    }

    public static function get($name = 'default') {
        return isset(self::$conn[$name]) ? self::$conn[$name] : NULL;
    }

}