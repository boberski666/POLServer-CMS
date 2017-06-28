<?php

class Config {

    const CacheFileDir = 'cache/';
    const CacheFile = 'config.map';
    const ConfigFile = '/../config.ini';

    public static function load() {
        self::getMap();
    }

    private static function getMap() {
        if (file_exists(self::CacheFileDir . self::CacheFile)) {
            include(self::CacheFileDir . self::CacheFile);
        } else {
            /** Jeśli plik nie istnieje to generujemy nowy */
            self::generateMap();
        }
    }

    private static function generateMap() {
        $str = "<?php\n";
        foreach (parse_ini_file(__DIR__ . '/..' . self::ConfigFile) as $k => $v) {
            define($k, $v);
            $str .= 'define(\'' . $k . "'," . (is_numeric($v) ? $v : '\'' . $v . '\'') . ');';
        }

        if (!defined(ROOT_ADMIN_DIR)) {
            $ROOT_ADMIN_DIR = realpath("./") . '/';
            define('ROOT_ADMIN_DIR', $ROOT_ADMIN_DIR);
            $str .= "define('ROOT_ADMIN_DIR','$ROOT_ADMIN_DIR');";
        }

        if (!defined('DB_PORT')) {
            define('DB_PORT', 3306);
            $str .= "define('DB_PORT',3306);";
        }

        file_put_contents(self::CacheFileDir . self::CacheFile, $str);
    }

}
