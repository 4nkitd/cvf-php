<?php

namespace CVF;

class Config
{
    private static $config;

    public static function get($key, $default = null)
    {
        if (is_null(self::$config)) {
            self::$config = require_once(APP_DIR. 'env.php');
        }

        return !empty(self::$config[$key]) ? self::$config[$key] : $default;
    }
}
